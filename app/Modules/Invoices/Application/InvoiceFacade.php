<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application;

use App\Infrastructure\Models\Invoice;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use App\Modules\Invoices\Application\Dto\InvoiceDto;
use App\Modules\Invoices\Domain\Models\InvoiceRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class InvoiceFacade implements InvoiceFacadeInterface
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository,
        private ApprovalFacadeInterface $approvalFacade,
    ) {
    }

    public function getInvoice(UuidInterface $id): InvoiceDto
    {
        $invoice = $this->invoiceRepository->find($id->toString());

        return new InvoiceDto(
            invoiceNumber: $invoice->getInvoiceNumber(),
            invoiceDate: $invoice->getInvoiceDate()->format('Y-m-d'),
            dueDate: $invoice->getDueDate()->format('Y-m-d'),
            company: $invoice->getCompany(),
            billedCompany: $invoice->getBilledCompany(),
            productLines: $invoice->getProductLines(),
            totalAmount: $invoice->getTotalPrice()->getAmount(),
        );
    }

    public function approve(UuidInterface $id): void
    {
        $invoice = $this->invoiceRepository->find($id->toString());

        $this->approvalFacade->approve(
            new ApprovalDto(
                id: $invoice->getId(),
                status: $invoice->getStatus(),
                entity: Invoice::class,
            )
        );
    }

    public function reject(UuidInterface $id): void
    {
        $invoice = $this->invoiceRepository->find($id->toString());

        $this->approvalFacade->reject(
            new ApprovalDto(
                id: $invoice->getId(),
                status: $invoice->getStatus(),
                entity: Invoice::class,
            )
        );
    }
}
