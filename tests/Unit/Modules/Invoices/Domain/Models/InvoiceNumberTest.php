<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Models\InvoiceNumber;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class InvoiceNumberTest extends TestCase
{
    private UuidInterface $uuid;
    private InvoiceNumber $invoiceNumber;

    protected function setUp(): void
    {
        $this->uuid = Uuid::uuid4();
        $this->invoiceNumber = new InvoiceNumber($this->uuid);
    }

    public function testValidInvoiceNumberIsAccepted(): void
    {
        $this->assertEquals($this->uuid, $this->invoiceNumber->getValue());
    }

    public function testInvalidInvoiceNumberThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new InvoiceNumber(Uuid::fromString('invalid-uuid'));
    }

    public function testInvoiceNumberIsReturnedAsString(): void
    {
        $this->assertEquals($this->uuid->toString(), (string)$this->invoiceNumber);
    }
}
