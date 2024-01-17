<?php

namespace App\Jobs;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Company $company)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // send email notification
        mail(
            config('app.notifiction-recipient', 'test@example.com'),
            'New Company Created',
            'A new company have been created: ' . $this->company->name
        );
    }
}
