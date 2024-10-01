<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Api\Listeners\ApproveInvoiceListener;
use App\Modules\Invoices\Api\Listeners\RejectInvoiceListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class InvoiceEventServiceProvider extends ServiceProvider
{
    /**
    * The event to listener mappings for the application.
    *
    * @var array<class-string, array<int, class-string>>
    */
    protected $listen = [
        EntityApproved::class => [
            ApproveInvoiceListener::class,
        ],
        EntityRejected::class => [
            RejectInvoiceListener::class,
        ],
    ];

    /**
    * Register any events for your application.
    *
    */
    public function boot(): void
    {
    //
    }

    /**
    * Determine if events and listeners should be automatically discovered.
    *
    */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
