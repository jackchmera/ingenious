<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Exceptions\InvoiceInvalidValueException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class InvoiceNumber
{
    private UuidInterface $value;

    /**
     * @throws InvoiceInvalidValueException
     */
    public function __construct(UuidInterface $value)
    {
        if (!$this->isValid($value)) {
            throw new InvoiceInvalidValueException('Invalid invoice number format.');
        }

        $this->value = $value;
    }

//    public function getValue(): string
    public function getValue(): UuidInterface
    {
        return $this->value;
    }

    private function isValid(UuidInterface $value): bool
    {
        return Uuid::isValid($value->toString());
    }

    public function __toString(): string
    {
        return $this->value->toString();
    }
}
