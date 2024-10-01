<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use App\Modules\Invoices\Application\InvoiceFacade;
use App\Modules\Invoices\Domain\Models\InvoiceRepositoryInterface;
use App\Modules\Invoices\Infrastructure\InvoiceRepository;
use Illuminate\Support\ServiceProvider;

class InvoiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(InvoiceFacadeInterface::class, InvoiceFacade::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     */
    public function boot(): void
    {
    }
}
