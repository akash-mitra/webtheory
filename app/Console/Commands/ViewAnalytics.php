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
            $this->info(now() . ' Stage1: Enrich Views data with Geolocation');

            $start_view_id = collect(DB::select(DB::raw('
                select end_view_id + 1 as view_id from batch_jobs 
                where batch_date in ( 
                    select max(batch_date) from batch_jobs 
                    where batch_name = \'enrich_geolocation_views_table\'
                    and status = \'success\'
                )'
            )))->first();
            $start_view_id = $start_view_id->view_id;

            
            $batchjob = new BatchJob([
                'batch_date' => now(),
                'batch_name' => 'enrich_geolocation_views_table',
                'start_datetime' => now(),
                'end_datetime' => null,
                'start_view_id' => $start_view_id,
                'end_view_id' => null,
                'status' => 'started',
            ]);
            $batchjob->save();


            

            $end_view_id = 0;
            // $views = View::where('id', '>=', $start_view_id)->take(5)->get();
            $views = View::where('id', '>=', $start_view_id)->get();
            foreach($views as $view) {
                $end_view_id = $end_view_id > $view->id ? $end_view_id : $view->id;
                
                // $geolocation = json_decode(Http::get('https://ip2.app/info.php?ip=' . $view->ip));
                // $view->country = $geolocation->country;
                // $view->city = $geolocation->city;
                // $view->latitude = $geolocation->lat;
                // $view->longitude = $geolocation->long;
                
                $geolocation = json_decode(Http::get('http://api.ipstack.com/' . $view->ip . '?access_key=' . env('ip_access_key')));
                $view->country = $geolocation->country_name;
                $view->city = $geolocation->city;
                $view->latitude = $geolocation->latitude;
                $view->longitude = $geolocation->longitude;
                
                $view->save();
            }


            $batchjob->end_datetime = now();
            $batchjob->end_view_id = $end_view_id;
            $batchjob->status = 'success';
            $batchjob->save();

            $this->info(now() . ' Stage1: Views table update completed');
            

            // STAGE 2
            $this->info(now() . ' Stage2: Create Temporary table to process Views dataset');
            
            $start_view_id = collect(DB::select(DB::raw('
                select end_view_id + 1 as view_id from batch_jobs 
                where batch_date in ( 
                    select max(batch_date) from batch_jobs 
                    where batch_name = \'process_views_analytics_table\'
                    and status = \'success\'
                )'
            )))->first();
            $start_view_id = $start_view_id->view_id;

            $end_view_id = collect(DB::select(DB::raw('
                select end_view_id as view_id from batch_jobs 
                where batch_date in ( 
                    select max(batch_date) from batch_jobs 
                    where batch_name = \'enrich_geolocation_views_table\'
                    and status = \'success\'
                )'
            )))->first();
            $end_view_id = $end_view_id->view_id;

            if (Schema::hasTable('views_staging')) {
                DB::statement('drop table views_staging');
            }
            
            if (env('DB_CONNECTION') == 'mysql') {
                DB::statement('
                    create table views_staging 
                    select * from views 
                    where id between ' . $start_view_id . ' and ' . $end_view_id
                );
            } else if (env('DB_CONNECTION') == 'pgsql') {
                DB::statement('
                    create table views_staging as
                    select * from views 
                    where id between ' . $start_view_id . ' and ' . $end_view_id
                );
            }
            

            $this->info(now() . ' Stage2: Views staging table creation completed');



            // STAGE 3
            $this->info(now() . ' Stage3: Load View Analytics Tables');

            

            $batchjob = new BatchJob([
                'batch_date' => now(),
                'batch_name' => 'process_views_analytics_table',
                'start_datetime' => now(),
                'end_datetime' => null,
                'start_view_id' => $start_view_id,
                'end_view_id' => $end_view_id,
                'status' => 'started',
            ]);
            $batchjob->save();

            
            DB::transaction(function () {
                
                
                // If it's second day of month truncate views_daily & views_monthly_staging
                if (now()->subDay()->format('d') == '02') {
                    DB::table('views_daily')->delete();
                    DB::table('views_monthly_staging')->delete();
                }
                
                if (env('DB_CONNECTION') == 'mysql') {
                    $date_key = 'DATE_FORMAT(created_at, \'%Y%m%d\')';
                    $month_key = 'DATE_FORMAT(created_at, \'%Y%m\')';
                } else if (env('DB_CONNECTION') == 'pgsql') {
                    $date_key = 'cast( to_char(created_at, \'YYYYMMDD\') AS INTEGER )';
                    $month_key = 'cast( to_char(created_at, \'YYYYMM\') AS INTEGER )';
                }

                DB::statement('
                    insert into views_daily ( 
                        date_key, 
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
                    created_at,
                    content_type, 
                    content_id, 
                    platform, 
                    browser, 
                    referrer_domain, 
                    country, 
                    city 
                ');
                

                DB::statement('
                    insert into views_monthly_staging ( 
                        ip, 
                        created_at, 
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
                        created_at, 
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

            $batchjob->end_datetime = now();
            $batchjob->status = 'success';
            $batchjob->save();

            $this->info(now() . ' Stage3: View Analytics tables processing completed');

            return 0;
        } catch (Exception $e) {
            \Log::info($e);
            $this->error('Something went wrong!');
            return 1;
        }
    }
}
