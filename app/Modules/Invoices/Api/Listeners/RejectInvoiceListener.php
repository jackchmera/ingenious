<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Listeners;

use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Domain\Models\InvoiceRepositoryInterface;

class RejectInvoiceListener
{
    public function __construct(private InvoiceRepositoryInterface $invoiceRepository)
    {
    }

    /**
     * Handle the event.
     *
     */
    public function handle(EntityRejected $event): void
    {
        $invoice = $this->invoiceRepository->find($event->approvalDto->id->toString());
        $invoice->reject();

        $this->invoiceRepository->save($invoice);
    }
}
