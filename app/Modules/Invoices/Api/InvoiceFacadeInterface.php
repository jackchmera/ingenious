<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api;

use App\Modules\Invoices\Application\Dto\InvoiceDto;
use Ramsey\Uuid\UuidInterface;

interface InvoiceFacadeInterface
{
    public function getInvoice(UuidInterface $id): InvoiceDto;
    public function approve(UuidInterface $id): void;
    public function reject(UuidInterface $id): void;
}
