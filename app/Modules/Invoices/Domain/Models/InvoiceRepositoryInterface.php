<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

interface InvoiceRepositoryInterface
{
    /**
     * @param string $invoiceId
     */
    public function find(string $invoiceId): Invoice;
}
