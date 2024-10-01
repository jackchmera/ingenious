<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use Ramsey\Uuid\UuidInterface;

class Company
{
    public function __construct(
        private UuidInterface $id,
        private string $name,
        private Address $address,
        private PhoneNumber $phone,
        private EmailAddress $email
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getPhone(): PhoneNumber
    {
        return $this->phone;
    }

    public function getEmail(): EmailAddress
    {
        return $this->email;
    }
}
