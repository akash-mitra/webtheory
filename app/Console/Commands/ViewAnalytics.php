<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Cache;
use DB;
use Exception;
use App\BatchJob;
use App\View;
use App\ViewDaily;

class ViewAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:analytics {asOfDate? : YYYY-MM-DD} {processDate? : YYYY-MM-DD}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process View Analytics';

    public $now;
    public $asOfDate;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->now = is_null($this->argument('processDate'))
            ? \Carbon\Carbon::now()
            : \Carbon\Carbon::createFromFormat('Y-m-d', $this->argument('processDate'));
        $this->now = $this->now->toImmutable();

        $this->asOfDate = is_null($this->argument('asOfDate'))
            ? \Carbon\Carbon::yesterday()
            : \Carbon\Carbon::createFromFormat('Y-m-d', $this->argument('asOfDate'))->startOfDay();
        $this->asOfDate = $this->asOfDate->toImmutable();

        try {

            // STAGE 1
            $this->info($this->now . ' Stage1: Create Temporary table to process Views dataset');

            // Get Last Successful Batch Record
            $batch = DB::select(DB::raw('
                select end_view_id, batch_date from batch_jobs
                where id in (
                    select max(id) from batch_jobs
                    where batch_name = \'process_views_analytics_table\'
                    and status = \'success\'
                    and end_view_id is not null
                )'
            ))[0];

            $start_view_id = $batch->end_view_id;
            $batch_date = $batch->batch_date;

            // Mark Batch Job Start Entry
            $batchjob = new BatchJob([
                'batch_date' => $this->now,
                'batch_name' => 'process_views_analytics_table',
                'start_datetime' => $this->now,
                'end_datetime' => null,
                'start_view_id' => $start_view_id,
                'end_view_id' => null,
                'status' => 'started',
            ]);
            $batchjob->save();


            $this->loadViewsStaging($start_view_id);

            $this->info($this->now . ' Stage1: Views staging table creation completed');



            // STAGE 2
            $this->info($this->now . ' Stage2: Load View Analytics Tables');

            // Get the maximum view id number as in staging table
            $batch = DB::select(DB::raw('
                select max(id) as end_view_id from views_staging'
            ))[0];
            $batchjob->end_view_id = $batch->end_view_id;


            // Process All or no transaction batch
            DB::transaction(function () use ($batchjob, $batch_date ) {

                $this->loadViewsDaily();

                $this->purgeViewsDaily();


                $this->aggregateIncrementalViewContent();


                $this->aggregateIncrementalViewDimension('view_referrers', 'referrer_domain');

                $this->aggregateIncrementalViewDimension('view_platforms', 'platform');

                $this->aggregateIncrementalViewDimension('view_browsers', 'browser');

                $this->aggregateIncrementalViewDimension('view_countries', 'country');

                $this->aggregateIncrementalViewDimension('view_cities', 'city');


                $this->loadUniqueMonthly();

                $this->loadIpStaging($batchjob->id);

                $this->purgeIpStaging();


            });


            // Mark Batch Job Completion entry
            $batchjob->end_datetime = $this->now;
            $batchjob->status = 'success';
            $batchjob->save();

            $this->info($this->now . ' Stage2: View Analytics tables processing completed');

            // Invalidate Cache
            Cache::forget('dashboard.views');
            Cache::forget('dashboard.daily');
            Cache::forget('dashboard.content');
            Cache::forget('dashboard.referrer');
            Cache::forget('dashboard.platform');
            Cache::forget('dashboard.browser');
            Cache::forget('dashboard.country');
            Cache::forget('dashboard.city');


            return 0;
        } catch (Exception $e) {
            \Log::info($e);
            $this->error('Something went wrong!');
            return 1;
        }
    }


    private function loadViewsStaging($start_view_id)
    {
        // Create Staging Table As Select Records from View table where id greater than last processed id and at less than todays date
        if (Schema::hasTable('views_staging')) {
            DB::statement('drop table views_staging');
        }

        $ctAs = config('database.default') == 'pgsql' ? ' as ': ' ' ;
        DB::statement(
            'create table views_staging' . $ctAs .
            'select * from views
            where id > ' . $start_view_id .
            ' and at < \'' . $this->now->startOfDay() . '\''
        );
    }

    private function loadViewsDaily()
    {
        //max(at) - min(at) as duration
        $duration = config('database.default') == 'pgsql' ? ' EXTRACT(EPOCH FROM (max(at) - min(at))) ': ' TIME_TO_SEC(TIMEDIFF(max(at), min(at))) ';

        // Load table views_daily aggregated at date_key level from views_staging
        DB::statement('
            insert into views_daily (
                date_key,
                total_views,
                unique_visitors,
                bounce_rate,
                avg_visit_duration
            ) select
                x.date_key,
                sum(x.views) as total_views,
                count(distinct x.ip) as unique_visitors,
                sum(case when x.views = 1 then 1 else 0 end) * 100 / count(1) as bounce_rate,
                round( sum(case when x.views > 1 then duration / (x.views - 1) else 0 end) /
                    sum(case when x.views > 1 then 1 else null end) ) as avg_visit_duration
            from (
                select
                    date_key,
                    count(1) as views,
                    ip,
                    session_id,
                    ' . $duration . ' as duration
                from views_staging
                group by
                    date_key,
                    ip,
                    session_id
            ) x
            group by
                x.date_key
        ');
    }

    private function purgeViewsDaily()
    {
        // Delete from views_daily where date_key less than first date of previous month
        $purgeCutoffDate = $this->asOfDate;
        $purgeCutoffDate = $purgeCutoffDate->subDays(366)->format('Ymd');
        DB::table('views_daily')->where('date_key', '<', $purgeCutoffDate)->delete();
    }


    private function aggregateIncrementalViewContent()
    {
        // Content Monthly Update
        if (config('database.default') == 'mysql') {
            DB::statement('
                update view_contents,
                (
                    select
                        floor(date_key/100)  as month_key,
                        content_type,
                        content_id,
                        count(1) as total_views
                    from views_staging
                    group by
                        floor(date_key/100),
                        content_type,
                        content_id
                ) x
                set
                view_contents.total_views = view_contents.total_views + x.total_views
                where view_contents.month_key = x.month_key
                and view_contents.content_type = x.content_type
                and view_contents.content_id = x.content_id
            ');
        } else if (config('database.default') == 'pgsql') {
            DB::statement('
                update view_contents
                set
                total_views = view_contents.total_views + x.total_views
                from (
                    select
                        floor(date_key/100) as month_key,
                        content_type,
                        content_id,
                        count(1) as total_views
                    from views_staging
                    group by
                        floor(date_key/100),
                        content_type,
                        content_id
                ) x
                where view_contents.month_key = x.month_key
                and view_contents.content_type = x.content_type
                and view_contents.content_id = x.content_id
            ');
        }

        // Content Monthly Insert
        DB::statement('
            insert into view_contents (
                month_key,
                content_type,
                content_id,
                total_views
            ) select
                floor(date_key/100) as month_key,
                content_type,
                content_id,
                count(1) as total_views
            from views_staging
            where not exists ( select 1 from view_contents x
                where x.month_key = floor(views_staging.date_key/100)
                and x.content_type = views_staging.content_type
                and x.content_id = views_staging.content_id
            )
            group by
                floor(date_key/100),
                content_type,
                content_id
        ');
    }


    private function aggregateIncrementalViewDimension($table_name, $column_name)
    {
        // Dimension Monthly Update
        if (config('database.default') == 'mysql') {
            DB::statement('
                update ' . $table_name . ',
                (
                    select
                        count(1) as total_views,
                        floor(date_key/100) as month_key,
                        ' . $column_name . '
                    from views_staging
                    group by
                        floor(date_key/100),
                        ' . $column_name . '
                ) x
                set
                ' . $table_name . '.total_views = ' . $table_name . '.total_views + x.total_views
                where ' . $table_name . '.month_key = x.month_key
                and ' . $table_name . '.' . $column_name . ' = x.' . $column_name
            );
        } else if (config('database.default') == 'pgsql') {
            DB::statement('
                update ' . $table_name . '
                set
                total_views = ' . $table_name . '.total_views + x.total_views
                from (
                    select
                        count(1) as total_views,
                        floor(date_key/100) as month_key,
                        ' . $column_name . '
                    from views_staging
                    group by
                        floor(date_key/100),
                        ' . $column_name . '
                ) x
                where ' . $table_name . '.month_key = x.month_key
                and ' . $table_name . '.' . $column_name . ' = x.' . $column_name
            );
        }

        // Dimension Monthly Insert
        DB::statement('
            insert into ' . $table_name . ' (
                total_views,
                month_key,
                ' . $column_name . '
            ) select
                count(1) as total_views,
                floor(date_key/100) as month_key,
                ' . $column_name . '
            from views_staging
            where not exists ( select 1 from ' . $table_name . ' x
                where x.month_key = floor(views_staging.date_key/100)
                and x.' . $column_name . ' = views_staging.' . $column_name . '
            )
            group by
                floor(date_key/100),
                ' . $column_name
        );
    }


    private function loadUniqueMonthly()
    {
        if (config('database.default') == 'mysql') {
            DB::statement('
                update views_unique_monthly,
                (
                    select
                        month_key,
                        count(distinct ip) as unique_visitors
                    from (
                        select distinct
                            floor(date_key/100) as month_key,
                            ip
                        from views_staging
                        where not exists ( select 1 from views_ip_staging x
                            where x.month_key = floor(views_staging.date_key/100)
                            and x.ip = views_staging.ip
                        )
                    ) unique_views_staging
                    group by
                        month_key
                ) x
                set
                views_unique_monthly.unique_visitors = views_unique_monthly.unique_visitors + x.unique_visitors
                where views_unique_monthly.month_key = x.month_key
            ');
        } else if (config('database.default') == 'pgsql') {
            DB::statement('
                update views_unique_monthly
                set
                unique_visitors = views_unique_monthly.unique_visitors + x.unique_visitors
                from (
                    select
                        month_key,
                        count(distinct ip) as unique_visitors
                    from (
                        select distinct
                            floor(date_key/100) as month_key,
                            ip
                        from views_staging
                        where not exists ( select 1 from views_ip_staging x
                            where x.month_key = floor(views_staging.date_key/100)
                            and x.ip = views_staging.ip
                        )
                    ) unique_views_staging
                    group by
                        month_key
                ) x
                where views_unique_monthly.month_key = x.month_key
            ');
        }

        DB::statement('
            insert into views_unique_monthly (
                month_key,
                unique_visitors
            ) select
                floor(date_key/100) as month_key,
                count(distinct ip) as unique_visitors
            from views_staging
            where not exists ( select 1 from views_ip_staging x
                where x.month_key = floor(views_staging.date_key/100)
            )
            group by
                floor(date_key/100)
        ');
    }

    private function loadIpStaging($batch_id)
    {
        DB::statement('
            insert into views_ip_staging (
                month_key,
                ip,
                batch_id
            ) select distinct
                floor(date_key/100) as month_key,
                ip,
                ' . $batch_id . '
            from views_staging
            where not exists ( select 1 from views_ip_staging x
                where x.month_key = floor(views_staging.date_key/100)
                and x.ip = views_staging.ip
            )
        ');
    }

    private function purgeIpStaging()
    {
        // Delete from views_ip_staging tables where month_key less than previous month
        $purgeCutoffDate = $this->asOfDate;
        $purgeCutoffDate = $purgeCutoffDate->startOfMonth()->subMonth()->format('Ym');
        DB::table('views_ip_staging')->where('month_key', '<', $purgeCutoffDate)->delete();
    }


}
