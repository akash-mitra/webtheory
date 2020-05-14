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
    protected $signature = 'update:site {commit=Latest : Update to the Commit ID}';

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
            
            
            $this->call('down');
            
            exec("cd " . base_path() . " && git stash");
            exec("cd " . base_path() . " && git pull");
            // exec("cd " . base_path() . " && git checkout " . $commitId);
            $this->info('Git command success.');
            
            exec("composer install -d " . base_path());
            exec("composer dump-autoload -d " . base_path());
            $this->info('Composer command success.');

            $this->call('config:clear');
            $this->call('cache:clear');
            $this->call('event:clear');
            $this->call('view:clear');
            $this->call('route:clear');
            $this->info('Artisan clear success.');

            $this->call('migrate', ['--force' => true]);
            $this->call('db:seed', ['--class' => 'PermissionsTableSeeder', '--force' => true]);
            $this->info('Migration success.');

            $this->call('up');

            $this->info('Site updated successfully');
        } catch(\Exception $e) {
            \Log::info($e);
            $this->call('up');
            $this->error('Something went wrong!');
        }
    }
}
