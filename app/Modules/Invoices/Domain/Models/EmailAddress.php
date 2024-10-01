<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Exceptions\InvoiceInvalidValueException;

class EmailAddress
{
    private string $email;

    /**
     * @throws InvoiceInvalidValueException
     */
    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvoiceInvalidValueException('Invalid email address.');
        }

        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
