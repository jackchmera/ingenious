<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Mappers;

use App\Infrastructure\Models\Invoice as EloquentInvoice;
use App\Modules\Invoices\Domain\Models\Invoice;

final readonly class InvoiceMapper
{
    public function mapToEloquent(Invoice $invoice): EloquentInvoice
    {
        $eloquentInvoice = new EloquentInvoice();

        $eloquentInvoice->id = $invoice->getId()->toString();
        $eloquentInvoice->number = $invoice->getInvoiceNumber()->getValue()->toString();
        $eloquentInvoice->date = $invoice->getInvoiceDate();
        $eloquentInvoice->due_date = $invoice->getDueDate();
        $eloquentInvoice->company_id = $invoice->getCompany()->getId();
        $eloquentInvoice->status = $invoice->getStatus()->value;

        return $eloquentInvoice;
    }
}
