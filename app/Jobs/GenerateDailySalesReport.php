<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\User;
use App\Mail\DailySalesReportMail;
use Illuminate\Support\Facades\Mail;


class GenerateDailySalesReport implements ShouldQueue
{
    use Queueable;

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
        Mail::to($admin->email)->send(new DailySalesReportMail());
    }
}
