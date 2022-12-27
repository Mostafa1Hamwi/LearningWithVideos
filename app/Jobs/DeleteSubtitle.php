<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DeleteSubtitle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $subtitle;
    /**
     * Create a new job instance.
     * 
     *
     * @return void
     */
    public function __construct($subtitle)
    {
        $this->subtitle = $subtitle;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($subtitle)
    {
        Storage::disk("google")->delete($subtitle);
    }
}
