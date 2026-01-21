<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\User;
use App\Mail\LowStockNotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LowStockNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        Mail::to($admin->email)->send(new LowStockNotificationMail());
    }
}
