<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Exceptions\InvoiceInvalidValueException;
use Ramsey\Uuid\UuidInterface;

class Product
{
    /**
     * @throws InvoiceInvalidValueException
     */
    public function __construct(
        private UuidInterface $id,
        private string $name,
        private Money $unitPrice,
    ) {
        if (empty($name)) {
            throw new InvoiceInvalidValueException('Product name cannot be empty.');
        }

        if ($unitPrice->getAmount() < 0) {
            throw new InvoiceInvalidValueException('Product price cannot be negative.');
        }
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUnitPrice(): Money
    {
        return $this->unitPrice;
    }
}
