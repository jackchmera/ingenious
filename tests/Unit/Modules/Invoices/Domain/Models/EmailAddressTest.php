<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Exceptions\InvoiceInvalidValueException;
use App\Modules\Invoices\Domain\Models\EmailAddress;
use PHPUnit\Framework\TestCase;

class EmailAddressTest extends TestCase
{
    private EmailAddress $validEmail;

    protected function setUp(): void
    {
        $this->validEmail = new EmailAddress('test@example.com');
    }

    public function testValidEmailIsAccepted(): void
    {
        $this->assertEquals('test@example.com', $this->validEmail->getEmail());
    }

    public function testInvalidEmailThrowsException(): void
    {
        $this->expectException(InvoiceInvalidValueException::class);
        new EmailAddress('invalid-email');
    }

    public function testEmailIsReturnedAsString(): void
    {
        $this->assertEquals('test@example.com', (string)$this->validEmail);
    }
}
