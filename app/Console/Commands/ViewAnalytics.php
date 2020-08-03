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


            // Create Staging Table As Select Records from View table where id greater than last processed id
            if (Schema::hasTable('views_staging')) {
                DB::statement('drop table views_staging');
            }
            
            if (env('DB_CONNECTION') == 'mysql') {
                DB::statement('
                    create table views_staging 
                    select * from views 
                    where id > ' . $start_view_id . 
                    ' and FROM_UNIXTIME(at) < \'' . $this->now->startOfDay() . '\''
                );
                // CURDATE()
            } else if (env('DB_CONNECTION') == 'pgsql') {
                DB::statement('
                    create table views_staging as
                    select * from views 
                    where id > ' . $start_view_id . 
                    ' and TO_TIMESTAMP(at) < \'' . $this->now->startOfDay() . '\''
                );
                // CURRENT_DATE
            }

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
                
                if (env('DB_CONNECTION') == 'mysql') {
                    $date_key = 'DATE_FORMAT(FROM_UNIXTIME(at), \'%Y%m%d\')';
                    $date_format = 'DATE(FROM_UNIXTIME(at))';
                    // $month_key = 'DATE_FORMAT(viewed_at, \'%Y%m\')';
                    $month_key = 'DATE_FORMAT(FROM_UNIXTIME(at), \'%Y%m\')';
                    $month_key_staging = 'DATE_FORMAT(FROM_UNIXTIME(views_staging.at), \'%Y%m\')';
                } else if (env('DB_CONNECTION') == 'pgsql') {
                    $date_key = 'CAST(TO_CHAR(TO_TIMESTAMP(at), \'YYYYMMDD\') AS INTEGER)';
                    $date_format = 'TO_TIMESTAMP(at)::date';
                    // $month_key = 'CAST(TO_CHAR(viewed_at, \'YYYYMM\') AS INTEGER)';
                    $month_key = 'CAST(TO_CHAR(TO_TIMESTAMP(at), \'YYYYMM\') AS INTEGER)';
                    $month_key_staging = 'CAST(TO_CHAR(TO_TIMESTAMP(views_staging.at), \'YYYYMM\') AS INTEGER)';
                }

                // Load table views_daily aggregated at date_key level from views_staging
                DB::statement('
                    insert into views_daily ( 
                        date_key, 
                        viewed_at, 
                        total_views, 
                        unique_visitors, 
                        bounce_rate, 
                        avg_visit_duration
                    ) select 
                        x.date_key,
                        x.date_format,
                        sum(x.views) as total_views,
                        count(distinct x.ip) as unique_visitors,
                        sum(case when x.views = 1 then 1 else 0 end) * 100 / count(1) as bounce_rate,
                        round( sum(case when x.views > 1 then duration / (x.views - 1) else 0 end) / 
                            sum(case when x.views > 1 then 1 else null end) ) as avg_visit_duration
                    from (
                        select 
                            ' . $date_key . ' as date_key,
                            ' . $date_format . ' as date_format,
                            count(1) as views,
                            ip,
                            session_id,
                            max(at) - min(at) as duration
                        from views_staging
                        group by 
                            ' . $date_key . ',
                            ' . $date_format .',
                            ip,
                            session_id
                    ) x
                    group by 
                        x.date_key,
                        x.date_format
                ');
                

                $this->purgeViewsDaily();

            
                $this->aggregateIncrementalViewContent($month_key, $month_key_staging);
                

                $this->aggregateIncrementalViewDimension($month_key, $month_key_staging, 'view_referrers', 'referrer');
                
                $this->aggregateIncrementalViewDimension($month_key, $month_key_staging, 'view_platforms', 'platform');

                $this->aggregateIncrementalViewDimension($month_key, $month_key_staging, 'view_browsers', 'browser');

                $this->aggregateIncrementalViewDimension($month_key, $month_key_staging, 'view_countries', 'country');

                

                // Load table views_monthly_staging from views_staging
                // DB::statement('
                //     insert into views_monthly_staging ( 
                //         ip, 
                //         date_key,
                //         viewed_at, 
                //         content_type, 
                //         content_id, 
                //         platform, 
                //         browser, 
                //         referrer_domain, 
                //         session_id,
                //         country, 
                //         city 
                //     ) select 
                //         ip,
                //         ' . $date_key . ',
                //         ' . $date_format . ', 
                //         content_type, 
                //         content_id, 
                //         platform, 
                //         browser, 
                //         referrer_domain, 
                //         session_id,
                //         country, 
                //         city 
                //     from views_staging
                // ');

                
                // $this->purgeViewsMonthlyStaging();
 

                // $this->purgeViewsMonthly();
                

                // Unprocessed previous month records 
                // if batch date is older than yesterday and batch month <> current month
                // if (\Carbon\Carbon::createFromFormat('Y-m-d', $batch_date)->startOfDay() < $this->asOfDate->startOfDay() 
                //         && substr($batch_date, 0, 7) <> $this->asOfDate->format('Y-m')) {
                //     // Previous Month Data Processing
                //     $this->aggregatePreviousMonth($month_key);
                // } else {
                //     // Current Month Data Processing
                //     $this->aggregateCurrentMonth($month_key);
                // }
                

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

    private function purgeViewsDaily()
    {
        // Delete from views_daily where date_key less than first date of previous month
        $purgeCutoffDate = $this->asOfDate;
        $purgeCutoffDate = $purgeCutoffDate->subDays(366)->format('Ymd');
        DB::table('views_daily')->where('date_key', '<', $purgeCutoffDate)->delete();
    }


    private function aggregateIncrementalViewContent($month_key, $month_key_staging)
    {
        // Content Monthly Update
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('
                update view_contents, 
                (
                    select  
                        ' . $month_key . ' as month_key,
                        content_type,
                        content_id,
                        count(1) as total_views             
                    from views_staging
                    group by 
                        ' . $month_key . ',
                        content_type,
                        content_id
                ) x
                set
                view_contents.total_views = view_contents.total_views + x.total_views
                where view_contents.month_key = x.month_key
                and view_contents.content_type = x.content_type
                and view_contents.content_id = x.content_id
            ');
        } else if (env('DB_CONNECTION') == 'pgsql') {
            DB::statement('
                update view_contents
                set
                total_views = view_contents.total_views + x.total_views
                from (
                    select  
                        ' . $month_key . ' as month_key,
                        content_type,
                        content_id,
                        count(1) as total_views             
                    from views_staging
                    group by 
                        ' . $month_key . ',
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
                ' . $month_key . ' as month_key,
                content_type,
                content_id,
                count(1) as total_views             
            from views_staging
            where not exists ( select 1 from view_contents x
                where x.month_key = ' . $month_key_staging . '
                and x.content_type = views_staging.content_type 
                and x.content_id = views_staging.content_id
            )
            group by 
                ' . $month_key . ',
                content_type,
                content_id
        ');
    }


    private function aggregateIncrementalViewDimension($month_key, $month_key_staging, $table_name, $column_name)
    {
        // Dimension Monthly Update
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('
                update ' . $table_name . ', 
                (
                    select  
                        count(1) as total_views,
                        ' . $month_key . ' as month_key,
                        ' . $column_name . '
                    from views_staging
                    group by 
                        ' . $month_key . ',
                        ' . $column_name . '
                ) x
                set
                ' . $table_name . '.total_views = ' . $table_name . '.total_views + x.total_views
                where ' . $table_name . '.month_key = x.month_key
                and ' . $table_name . '.' . $column_name . ' = x.' . $column_name
            );
        } else if (env('DB_CONNECTION') == 'pgsql') {
            DB::statement('
                update ' . $table_name . '
                set
                total_views = ' . $table_name . '.total_views + x.total_views
                from (
                    select  
                        count(1) as total_views,
                        ' . $month_key . ' as month_key,
                        ' . $column_name . '            
                    from views_staging
                    group by 
                        ' . $month_key . ',
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
                ' . $month_key . ' as month_key,
                ' . $column_name . '            
            from views_staging
            where not exists ( select 1 from ' . $table_name . ' x
                where x.month_key = ' . $month_key_staging . '
                and x.' . $column_name . ' = views_staging.' . $column_name . ' 
            )
            group by 
                ' . $month_key . ',
                ' . $column_name
        );
    }











    private function purgeViewsMonthlyStaging()
    {
        // Delete from views_monthly_staging tables where date_key less than first date of previous month
        $purgeCutoffDate = $this->asOfDate;
        $purgeCutoffDate = $purgeCutoffDate->startOfMonth()->subMonth()->format('Ymd');
        DB::table('views_monthly_staging')->where('date_key', '<', $purgeCutoffDate)->delete();
    }

    private function purgeViewsMonthly()
    {
        // Delete from views_monthly where month_key less than previous month
        $previousMonthKey = $this->asOfDate;
        $previousMonthKey = $previousMonthKey->startOfMonth()->subMonth()->format('Ym');
        DB::table('views_monthly')->where('month_key', '<', $previousMonthKey)->delete();
    }

    
    private function aggregatePreviousMonth($month_key)
    {
        DB::table('views_monthly')->delete();

        $previousMonthKey = $this->asOfDate;
        $previousMonthKey = $previousMonthKey->startOfMonth()->subMonth()->format('Ym');
        $select_date_key = $previousMonthKey . '01';

        $this->loadViewsMonthly($month_key, $select_date_key);
    }

    private function aggregateCurrentMonth($month_key)
    {
        $currentMonthKey = $this->asOfDate->format('Ym');
        $select_date_key = $currentMonthKey . '01';
        
        DB::table('views_monthly')->where('month_key', $currentMonthKey)->delete();

        $this->loadViewsMonthly($month_key, $select_date_key);
    }

    private function loadViewsMonthly($month_key, $select_date_key)
    {
        // Load table views_monthly
        DB::statement('
            insert into views_monthly ( 
                month_key, 
                total_views, 
                unique_visitors, 
                content_type, 
                content_id, 
                platform, 
                browser, 
                referrer_domain, 
                country, 
                city 
            ) select 
                ' . $month_key . ',
                count(1),
                count(distinct ip),
                content_type, 
                content_id, 
                platform, 
                browser, 
                referrer_domain, 
                country, 
                city 
            from views_monthly_staging
            where date_key >= ' . $select_date_key . ' 
            group by 
                ' . $month_key . ',
                content_type, 
                content_id, 
                platform, 
                browser, 
                referrer_domain, 
                country, 
                city 
        ');
    }
}
