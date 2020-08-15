<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use Illuminate\Support\Facades\Http;
use App\View;

class UpdateGeolocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:geolocation {processDateKey? : YYYYMMDD}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Geolocation';

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
        $this->info('Geolocation update started');

        if (is_null($this->argument('processDateKey'))) {
            $views = View::whereNull('country')->get();
        }
        else {
            $views = View::whereNull('country')->where('date_key', $this->argument('processDateKey'))->get();
        }

        foreach($views as $view) {
            $response = Http::get('https://freegeoip.app/json/' . $view->ip );
            $this->info($response);
            if ($response->successful()) {
                $geolocation = json_decode($response);
                $view->country = $geolocation->country_name;
                $view->city = $geolocation->city;
                $view->latitude = $geolocation->latitude;
                $view->longitude = $geolocation->longitude;
                
                $view->save();
            }
        }

        $this->info('Geolocation update successful');

        try {

            return 0;
        } catch(Exception $e) {
            $this->error('Something went wrong!');
            return 1;
        }
    }
}
