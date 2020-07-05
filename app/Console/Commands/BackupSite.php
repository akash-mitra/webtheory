<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Exception;
use File;
use ZipArchive;

class BackupSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:site';

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
            
            // CREATE DIRECTORIES
            $backupdir = 'wt_backup_' . \Carbon\Carbon::parse(now())->format('Ymd');
            $backupfile = $backupdir . '.zip';

            $this->info('Backup Filename: ' . $backupfile);


            if (Storage::disk('backup')->exists($backupfile))
                Storage::disk('backup')->delete($backupfile);
            
            if (Storage::disk('backup')->exists($backupdir))
                Storage::disk('backup')->deleteDirectory($backupdir);

            Storage::disk('backup')->makeDirectory($backupdir);

            Storage::disk('backup')->makeDirectory($backupdir . '/media');
            Storage::disk('backup')->makeDirectory($backupdir . '/active');
            Storage::disk('backup')->makeDirectory($backupdir . '/templates');
            Storage::disk('backup')->makeDirectory($backupdir . '/database');



            // MEDIA
            $files = Storage::disk('local')->files('public/media');
            foreach ($files as $file) {
                $source = Storage::getDriver()->getAdapter()->applyPathPrefix($file);
                $target = Storage::disk('backup')->getDriver()->getAdapter()->applyPathPrefix($backupdir . '/media/' . basename($file));
                
                File::copy($source, $target);
            }
            $this->info('Media assets copied.');

            // PROFILES
            if (Storage::disk('local')->exists('public/media/profiles')) {
                Storage::disk('backup')->makeDirectory($backupdir . '/media/profiles');
                $files = Storage::disk('local')->files('public/media/profiles');
                foreach ($files as $file) {
                    $source = Storage::disk('local')->getDriver()->getAdapter()->applyPathPrefix($file);
                    $target = Storage::disk('backup')->getDriver()->getAdapter()->applyPathPrefix($backupdir . '/media/profiles/' . basename($file));
                    
                    File::copy($source, $target);
                }
            }
            $this->info('Profile assets copied.');

            // ACTIVE TEMPLATE
            $files = Storage::disk('active')->files('/');
            foreach ($files as $file) {
                $source = Storage::disk('active')->getDriver()->getAdapter()->applyPathPrefix($file);
                $target = Storage::disk('backup')->getDriver()->getAdapter()->applyPathPrefix($backupdir . '/active/' . basename($file));
                
                File::copy($source, $target);
            }
            $this->info('Active Template copied.');

            // ALL TEMPLATES
            $directories = Storage::disk('templates')->directories('/');
            foreach ($directories as $directory) {
                Storage::disk('backup')->makeDirectory($backupdir . '/templates/' . $directory);
                $files = Storage::disk('templates')->allFiles($directory);
                foreach ($files as $file) {
                    $source = Storage::disk('templates')->getDriver()->getAdapter()->applyPathPrefix($file);
                    $target = Storage::disk('backup')->getDriver()->getAdapter()->applyPathPrefix($backupdir . '/templates/' . $directory . '/' . basename($file));
                    
                    File::copy($source, $target);
                }
            }
            $this->info('All Templates copied.');



            // DATABASE BACKUP
            if (env('DB_CONNECTION') == 'mysql') {
                exec("mysqldump -u" . env('DB_USERNAME') . " -p" . env('DB_PASSWORD') . " " . env('DB_DATABASE') . " > " . base_path() . '/storage/backup/' . $backupdir . '/database/' . env('DB_DATABASE') . ".sql");
            } else if (env('DB_CONNECTION') == 'pgsql') {
                exec("PGPASSWORD=" . env('DB_PASSWORD') . " pg_dump -h " . env('DB_HOST') . " -p " . env('DB_PORT') . " -U " . env('DB_USERNAME') . " " . env('DB_DATABASE') . " > " . base_path() . '/storage/backup/' . $backupdir . '/database/' . env('DB_DATABASE') . ".sql");
            }
            
            

            // ZIP BACKUP
            $zipfile = Storage::disk('backup')->getDriver()->getAdapter()->applyPathPrefix($backupfile);
            $zipper = new ZipArchive();
            $zipper->open($zipfile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            // $directories = Storage::disk('backup')->directories($backupdir . '/templates');
            // foreach ($directories as $directory) {
            //     if ($handle = opendir(Storage::disk('backup')->getDriver()->getAdapter()->applyPathPrefix($directory . '/'))) {
            //         while (false !== ($entry = readdir($handle))) {
            //             if ($entry != "." && $entry != "..") {
            //                 $this->info(Storage::disk('backup')->getDriver()->getAdapter()->applyPathPrefix($directory . '/' . $entry));
            //                 $zip->addFile($entry);
            //                 // $this->info(Storage::disk('backup')->getDriver()->getAdapter()->applyPathPrefix($directory . '/' . $entry));
            //             }
            //         }
            //         closedir($handle);
            //     }
            // }
        
            
            
            array_map(function ($file) use ($zipper){

                return $zipper->addFile(
                    Storage::disk('backup')->path($file),
                    basename($file)
                );

            }, Storage::disk('backup')->allFiles($backupdir));

            $zipper->close();
            // Storage::disk('backup')->deleteDirectory($backupdir);
            $this->info('Backup Zipped.');


            $this->call('up');

            $this->info('Site backup complete');
            return 0;
        } catch(Exception $e) {
            \Log::info($e);
            $this->call('up');
            $this->error('Something went wrong!');
            return 1;
        }
    }
}
