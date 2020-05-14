<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class UpdateSite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $commitId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($commitId)
    {
        $this->commitId = $commitId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $exitCode = Artisan::call('update:site', [
            'commit' => $this->commitId
        ]);

        // \Log::info($exitCode);
        return true;
    }
}
