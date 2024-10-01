<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Exceptions\InvoiceInvalidValueException;

class Money
{
    public function __construct(
        private int $amount,
        private string $currency = 'USD'
    ) {
    }

    /**
     * @throws InvoiceInvalidValueException
     */
    public function add(Money $money): Money
    {
        if ($this->currency !== $money->currency) {
            throw new InvoiceInvalidValueException('Currency mismatch.');
        }

        return new Money($this->amount + $money->amount, $this->currency);
    }

    public function multiply(int $multiplier): Money
    {
        return new Money($this->amount * $multiplier, $this->currency);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function __toString(): string
    {
        return number_format($this->amount / 100, 2) . ' ' . $this->currency;
    }
}
