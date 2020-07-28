<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Exception;
use DB;
use App\View;
use App\ViewDaily;
use App\BatchJob;

class ViewAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:analytics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process View Analytics';

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
        try {
            
            // STAGE 1
            $this->info(now() . ' Stage1: Create Temporary table to process Views dataset');
            
            $start_view_id = collect(DB::select(DB::raw('
                select end_view_id as view_id from batch_jobs 
                where id in ( 
                    select max(id) from batch_jobs 
                    where batch_name = \'process_views_analytics_table\'
                    and status = \'success\'
                    and end_view_id is not null
                )'
            )))->first();
            $start_view_id = $start_view_id->view_id;

            
            $batchjob = new BatchJob([
                'batch_date' => now(),
                'batch_name' => 'process_views_analytics_table',
                'start_datetime' => now(),
                'end_datetime' => null,
                'start_view_id' => $start_view_id,
                'end_view_id' => null,
                'status' => 'started',
            ]);
            $batchjob->save();

            if (Schema::hasTable('views_staging')) {
                DB::statement('drop table views_staging');
            }
            
            if (env('DB_CONNECTION') == 'mysql') {
                DB::statement('
                    create table views_staging 
                    select * from views 
                    where id > ' . $start_view_id . 
                    ' and FROM_UNIXTIME(at) < CURDATE()'
                );
            } else if (env('DB_CONNECTION') == 'pgsql') {
                DB::statement('
                    create table views_staging as
                    select * from views 
                    where id > ' . $start_view_id . 
                    ' and TO_TIMESTAMP(at) < CURRENT_DATE'
                );
            }

            $this->info(now() . ' Stage1: Views staging table creation completed');



            // STAGE 2
            $this->info(now() . ' Stage2: Load View Analytics Tables');
            
            $end_view_id = collect(DB::select(DB::raw('
                select max(id) as view_id from views_staging'
            )))->first();
            $end_view_id = $end_view_id->view_id;

            DB::transaction(function () use($batchjob, $end_view_id) {
                
                // If it's second day of month truncate views_daily & views_monthly_staging
                if (now()->subDay()->format('d') == '02') {
                    DB::table('views_daily')->delete();
                    DB::table('views_monthly_staging')->delete();
                }
                
                if (env('DB_CONNECTION') == 'mysql') {
                    $date_key = 'DATE_FORMAT(FROM_UNIXTIME(at), \'%Y%m%d\')';
                    $date_format = 'DATE(FROM_UNIXTIME(at))';
                    $month_key = 'DATE_FORMAT(viewed_at, \'%Y%m\')';
                } else if (env('DB_CONNECTION') == 'pgsql') {
                    $date_key = 'CAST(TO_CHAR(TO_TIMESTAMP(at), \'YYYYMMDD\') AS INTEGER)';
                    $date_format = 'TO_TIMESTAMP(at)::date';
                    $month_key = 'CAST(TO_CHAR(viewed_at, \'YYYYMM\') AS INTEGER)';
                }

                // Load table views_daily
                DB::statement('
                    insert into views_daily ( 
                        date_key, 
                        viewed_at, 
                        total_views, 
                        unique_vistors, 
                        content_type, 
                        content_id, 
                        platform, 
                        browser, 
                        referrer_domain, 
                        country, 
                        city 
                    ) select 
                        ' . $date_key . ',
                        ' . $date_format . ',
                        count(1),
                        count(distinct ip),
                        content_type, 
                        content_id, 
                        platform, 
                        browser, 
                        referrer_domain, 
                        country, 
                        city 
                    from views_staging
                    group by 
                    ' . $date_key . ',
                    ' . $date_format . ',
                    created_at,
                    content_type, 
                    content_id, 
                    platform, 
                    browser, 
                    referrer_domain, 
                    country, 
                    city 
                ');
                
                // Load table views_monthly_staging
                DB::statement('
                    insert into views_monthly_staging ( 
                        ip, 
                        viewed_at, 
                        content_type, 
                        content_id, 
                        platform, 
                        browser, 
                        referrer_domain, 
                        session_id,
                        country, 
                        city 
                    ) select 
                        ip,
                        ' . $date_format . ', 
                        content_type, 
                        content_id, 
                        platform, 
                        browser, 
                        referrer_domain, 
                        session_id,
                        country, 
                        city 
                    from views_staging
                ');

                
                DB::table('views_monthly')->delete();

                // Load table views_monthly
                DB::statement('
                    insert into views_monthly ( 
                        month_key, 
                        total_views, 
                        unique_vistors, 
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
                    group by 
                    ' . $month_key . ',
                    created_at,
                    content_type, 
                    content_id, 
                    platform, 
                    browser, 
                    referrer_domain, 
                    country, 
                    city 
                ');
                

            });

            // Mark entry in batch table
            $batchjob->end_datetime = now();
            $batchjob->end_view_id = $end_view_id;
            $batchjob->status = 'success';
            $batchjob->save();

            $this->info(now() . ' Stage2: View Analytics tables processing completed');

            return 0;
        } catch (Exception $e) {
            \Log::info($e);
            $this->error('Something went wrong!');
            return 1;
        }
    }
}
