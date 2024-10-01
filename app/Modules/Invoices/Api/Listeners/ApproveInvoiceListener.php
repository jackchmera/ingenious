<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Listeners;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Invoices\Domain\Models\InvoiceRepositoryInterface;

final class ApproveInvoiceListener
{
    public function __construct(private InvoiceRepositoryInterface $invoiceRepository)
    {
    }

    /**
     * Handle the event.
     *
     */
    public function handle(EntityApproved $event): void
    {
        $invoice = $this->invoiceRepository->find($event->approvalDto->id->toString());
        $invoice->approve();

        $this->invoiceRepository->save($invoice);
    }
}
