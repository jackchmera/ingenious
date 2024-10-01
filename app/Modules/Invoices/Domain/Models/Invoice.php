<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use App\Domain\Enums\StatusEnum;
use DateTimeImmutable;
use InvalidArgumentException;
use Ramsey\Uuid\UuidInterface;

class Invoice
{
    private Money $totalPrice;

    public function __construct(
        private readonly UuidInterface $id,
        private readonly InvoiceNumber $invoiceNumber,
        private readonly DateTimeImmutable $invoiceDate,
        private readonly DateTimeImmutable $dueDate,
        private readonly Company $company,
        private readonly BilledCompany $billedCompany,
        /** @var ProductLine[] $productLines */
        private readonly array $productLines,
        private StatusEnum $status,
    ) {
        $this->totalPrice = $this->calculateTotalPrice();
    }

    public function setStatus(StatusEnum $status): void
    {
        $this->status = $status;
    }

    public function approve(): void
    {
        if ($this->status->isProcessed()) {
            throw new InvalidArgumentException('Cannot approve processed invoice.');
        }

        $this->setStatus(StatusEnum::APPROVED);
    }

    public function reject(): void
    {
        if ($this->status->isProcessed()) {
            throw new InvalidArgumentException('Cannot approve processed invoice.');
        }

        $this->setStatus(StatusEnum::REJECTED);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getInvoiceNumber(): InvoiceNumber
    {
        return $this->invoiceNumber;
    }

    public function getInvoiceDate(): DateTimeImmutable
    {
        return $this->invoiceDate;
    }

    public function getDueDate(): DateTimeImmutable
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

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getTotalPrice(): Money
    {
        return $this->totalPrice;
    }

    private function calculateTotalPrice(): Money
    {
        return array_reduce($this->productLines, function (Money $sum, ProductLine $productLine) {
            return $sum->add($productLine->getProduct()->getUnitPrice()->multiply($productLine->getQuantity()));
        }, new Money(0));
    }
}
