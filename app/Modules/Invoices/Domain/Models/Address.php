<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

class Address
{
    public function __construct(
        private string $street,
        private string $city,
        private string $zipCode,
    ) {
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function __toString(): string
    {
        return "{$this->street}, {$this->zipCode} {$this->city}";
    }
}
