<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Models\Address;
use App\Modules\Invoices\Domain\Models\Company;
use App\Modules\Invoices\Domain\Models\EmailAddress;
use App\Modules\Invoices\Domain\Models\PhoneNumber;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CompanyTest extends TestCase
{
    private Company $company;
    private UuidInterface $uuid;
    private Address $address;
    private PhoneNumber $phone;
    private EmailAddress $email;

    protected function setUp(): void
    {
        $this->uuid = Uuid::uuid4();
        $this->address = new Address('123 Main St', 'Springfield', '12345');
        $this->phone = new PhoneNumber('123-456-7890');
        $this->email = new EmailAddress('test@example.com');

        $this->company = new Company(
            $this->uuid,
            'Test Company',
            $this->address,
            $this->phone,
            $this->email
        );
    }

    public function testIdIsReturnedCorrectly(): void
    {
        $this->assertEquals($this->uuid, $this->company->getId());
    }

    public function testNameIsReturnedCorrectly(): void
    {
        $this->assertEquals('Test Company', $this->company->getName());
    }

    public function testAddressIsReturnedCorrectly(): void
    {
        $this->assertEquals($this->address, $this->company->getAddress());
    }

    public function testPhoneIsReturnedCorrectly(): void
    {
        $this->assertEquals($this->phone, $this->company->getPhone());
    }

    public function testEmailIsReturnedCorrectly(): void
    {
        $this->assertEquals($this->email, $this->company->getEmail());
    }
}
