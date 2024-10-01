<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Dto;

use App\Modules\Invoices\Domain\Models\BilledCompany;
use App\Modules\Invoices\Domain\Models\Company;
use App\Modules\Invoices\Domain\Models\InvoiceNumber;
use App\Modules\Invoices\Domain\Models\Money;
use App\Modules\Invoices\Domain\Models\ProductLine;
use JsonSerializable;

final readonly class InvoiceDto implements JsonSerializable
{
    public function __construct(
        private InvoiceNumber $invoiceNumber,
        private string $invoiceDate,
        private string $dueDate,
        private Company $company,
        private BilledCompany $billedCompany,
        private array $productLines,
        private int $totalAmount
    ) {
    }

    public function getInvoiceNumber(): InvoiceNumber
    {
        return $this->invoiceNumber;
    }

    public function getInvoiceDate(): string
    {
        return $this->invoiceDate;
    }

    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function getBilledCompany(): BilledCompany
    {
        return $this->billedCompany;
    }

    /**
     * @return ProductLine[]
     */
    public function getProductLines(): array
    {
        return $this->productLines;
    }

    public function getTotalAmount(): int
    {
        return $this->totalAmount;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'invoice_number' => (string) $this->getInvoiceNumber(),
            'invoice_date' => $this->getInvoiceDate(),
            'due_date' => $this->getDueDate(),
            'company' => [
                'name' => $this->getCompany()->getName(),
                'address' => (string) $this->getCompany()->getAddress(),
                'email' => (string) $this->getCompany()->getEmail(),
                'phone' => (string) $this->getCompany()->getPhone(),
            ],
            'billed_company' => [
                'name' => $this->getBilledCompany()->getName(),
                'address' => (string) $this->getBilledCompany()->getAddress(),
                'email' => (string) $this->getBilledCompany()->getEmail(),
                'phone' => (string) $this->getBilledCompany()->getPhone(),
            ],
            'product_lines' => array_map(function ($productLine) {
                return [
                    'product_name' => $productLine->getProduct()->getName(),
                    'quantity' => $productLine->getQuantity(),
                    'unitPrice' => (string) $productLine->getProduct()->getUnitPrice(),
                    'totalPrice' => (string) $productLine->getTotal(),
                ];
            }, $this->getProductLines()),
            'total_price' => (string) (new Money($this->getTotalAmount())),
        ];
    }
}
