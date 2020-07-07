<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Exception;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:site {--db} {--assets} {--templates}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup Webtheory Site';

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
        $this->info('Site backup started');

        try {
            $this->call('down');

            $shell = view('vendor.backup.script', [
                'db' => $this->option('db'),
                'assets' => $this->option('assets'),
                'templates' => $this->option('templates'),
            ]);
            $process = Process::fromShellCommandline($shell);
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $this->info($process->getOutput());

            $this->call('up');

            $this->info('Site backup complete');

            return 0;
        } catch (Exception $e) {
            \Log::info($e);
            $this->call('up');
            $this->error('Something went wrong!');
            return 1;
        }
    }
}
