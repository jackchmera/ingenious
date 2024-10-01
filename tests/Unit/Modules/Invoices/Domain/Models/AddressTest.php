<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Models\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    private Address $address;

    protected function setUp(): void
    {
        $this->address = new Address('123 Main St', 'Springfield', '12345');
    }

    public function testStreetIsReturnedCorrectly(): void
    {
        $this->assertEquals('123 Main St', $this->address->getStreet());
    }

    public function testCityIsReturnedCorrectly(): void
    {
        $this->assertEquals('Springfield', $this->address->getCity());
    }

    public function testZipCodeIsReturnedCorrectly(): void
    {
        $this->assertEquals('12345', $this->address->getZipCode());
    }

    public function testToStringReturnsFormattedString(): void
    {
        $this->assertEquals('123 Main St, 12345 Springfield', (string)$this->address);
    }
}
