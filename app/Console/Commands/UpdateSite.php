<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Exception;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class UpdateSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:site';

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
            $this->call('down');

            $this->executeCmd('cd ' . base_path() . ' && git stash');
            $this->executeCmd('cd ' . base_path() . ' && git pull origin master');
            $this->info('Git command success.');

            $this->executeCmd(
                'composer install --prefer-dist --optimize-autoloader --no-interaction -d ' .
                    base_path()
            );
            $this->info('Composer command success.');

            $this->call('migrate', ['--force' => true]);
            $this->call('db:seed', ['--class' => 'IncrementalSeeder', '--force' => true]);
            $this->info('Migration success.');

            $this->executeCmd('composer dump-autoload -d ' . base_path());
            $this->info('Composer optimize success.');

            $this->call('config:clear');
            $this->call('cache:clear');
            $this->call('event:clear');
            $this->call('view:clear');
            $this->call('route:clear');
            $this->call('queue:restart');
            $this->call('route:cache');
            $this->info('Artisan commands success.');

            // $this->executeCmd("cd " . base_path() . " chown -R appuser:appuser * ");

            // $this->executeCmd("supervisorctl restart laravel-worker:*");

            $this->call('up');

            $this->info('Site updated successfully');
            return 0;
        } catch (Exception $e) {
            $this->call('up');
            $this->error('Something went wrong!');
            return 1;
        }
    }

    public function executeCmd($shell)
    {
        $process = Process::fromShellCommandline($shell);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->info($process->getOutput());
    }
}
