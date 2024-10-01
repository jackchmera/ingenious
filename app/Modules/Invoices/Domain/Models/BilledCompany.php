<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class BilledCompany
{
    public function getId(): UuidInterface
    {
        return Uuid::fromString('00000000-0000-0000-0000-000000000000');
    }

    public function getName(): string
    {
        return 'Ingenious';
    }

    public function getAddress(): Address
    {
        return new Address('1234 Main St', 'New York', '10001');
    }

    public function getPhone(): PhoneNumber
    {
        return new PhoneNumber('123456789');
    }

    public function getEmail(): EmailAddress
    {
        return new EmailAddress('bok@ingenious.us');
    }
}
