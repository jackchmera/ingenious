<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Exceptions\InvoiceInvalidValueException;

class PhoneNumber
{
    private string $number;

    /**
     * @throws InvoiceInvalidValueException
     */
    public function __construct(string $number)
    {
        if (!$this->isValid($number)) {
            throw new InvoiceInvalidValueException('Invalid phone number format.');
        }

        $this->number = $number;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    private function isValid(string $number): bool
    {
        return 1 === preg_match('/^[0-9\-\(\)\/\+\s]*$/', $number);
    }

    public function __toString(): string
    {
        return $this->number;
    }
}
