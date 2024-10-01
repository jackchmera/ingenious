<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Exceptions\InvoiceInvalidValueException;
use App\Modules\Invoices\Domain\Models\PhoneNumber;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{
    private PhoneNumber $validPhoneNumber;

    protected function setUp(): void
    {
        $this->validPhoneNumber = new PhoneNumber('123-456-7890');
    }

    public function testValidPhoneNumberIsAccepted(): void
    {
        $this->assertEquals('123-456-7890', $this->validPhoneNumber->getNumber());
    }

    public function testInvalidPhoneNumberThrowsException(): void
    {
        $this->expectException(InvoiceInvalidValueException::class);
        new PhoneNumber('invalid-phone-number');
    }

    public function testPhoneNumberIsReturnedAsString(): void
    {
        $this->assertEquals('123-456-7890', (string)$this->validPhoneNumber);
    }

    public function testPhoneNumberWithSpacesIsAccepted(): void
    {
        $phoneNumber = new PhoneNumber('123 456 7890');
        $this->assertEquals('123 456 7890', $phoneNumber->getNumber());
    }

    public function testPhoneNumberWithPlusSignIsAccepted(): void
    {
        $phoneNumber = new PhoneNumber('+123-456-7890');
        $this->assertEquals('+123-456-7890', $phoneNumber->getNumber());
    }
}
