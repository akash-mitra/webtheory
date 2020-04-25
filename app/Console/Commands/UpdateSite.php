<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:site {commit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Webtheory Site';

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
        $this->info('Site update started');

        try {
            $commitId = $this->argument('commit');
            $this->info('Commit Id: ' . $commitId);
            
            /*
            composer install
            composer dump-autoload
            Artisan::call('down');
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('event:clear');
	        Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('migrate');
            Artisan::call('db:seed', ['--class' => 'PermissionsTableSeeder', '--force' => true]);
            Artisan::call('up');
            */
            
            exec("cd " . base_path() . " && php artisan down");
            $this->info('Application is now in maintenance mode.');

            exec("cd " . base_path() . " && git pull");
            exec("cd " . base_path() . " && git checkout " . $commitId);
            $this->info('Git command success.');
            
            exec("composer install -d " . base_path());
            exec("composer dump-autoload -d " . base_path());
            $this->info('Composer command success.');

            exec("cd " . base_path() . " && php artisan config:clear");
            exec("cd " . base_path() . " && php artisan cache:clear");
            exec("cd " . base_path() . " && php artisan event:clear");
            exec("cd " . base_path() . " && php artisan view:clear");
            exec("cd " . base_path() . " && php artisan route:clear");
            $this->info('Artisan clear success.');

            exec("cd " . base_path() . " && php artisan migrate");
            exec("cd " . base_path() . " && php artisan db:seed --class PermissionsTableSeeder --force");
            $this->info('Migration success.');

            exec("cd " . base_path() . " && php artisan up");
            $this->info('Application is now live.');

        } catch(\Exception $e) {
            \Log::info($e);
            exec("cd " . base_path() . " && php artisan up");
            $this->error('Something went wrong!');
        }

        $this->info('Site updated successfully');
    }
}
