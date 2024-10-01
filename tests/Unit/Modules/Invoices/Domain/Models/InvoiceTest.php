<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain\Models;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Models\Address;
use App\Modules\Invoices\Domain\Models\BilledCompany;
use App\Modules\Invoices\Domain\Models\Company;
use App\Modules\Invoices\Domain\Models\EmailAddress;
use App\Modules\Invoices\Domain\Models\Invoice;
use App\Modules\Invoices\Domain\Models\InvoiceNumber;
use App\Modules\Invoices\Domain\Models\Money;
use App\Modules\Invoices\Domain\Models\PhoneNumber;
use App\Modules\Invoices\Domain\Models\Product;
use App\Modules\Invoices\Domain\Models\ProductLine;
use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class InvoiceTest extends TestCase
{
    /**
     * @dataProvider invoiceStatusProvider
     */
    public function testInvoiceStatusTransitions($initialStatus, $method, $expectedStatus, $expectException): void
    {
        $invoice = $this->createInvoiceWithStatus($initialStatus);

        if ($expectException) {
            $this->expectException(InvalidArgumentException::class);
        }

        $invoice->$method();

        if (!$expectException) {
            $this->assertEquals($expectedStatus, $invoice->getStatus());
        }
    }

    private function createInvoiceWithStatus(StatusEnum $status): Invoice
    {
        return new Invoice(
            id: Uuid::uuid4(),
            invoiceNumber: new InvoiceNumber(Uuid::fromString('6f8da70b-edff-331e-b3ad-a97d387fad87')),
            invoiceDate: new DateTimeImmutable(),
            dueDate: new DateTimeImmutable('+30 days'),
            company: new Company(
                id: Uuid::fromString('0997e0c2-5d5a-4bdb-9387-bc6421641e59'),
                name: 'Test Company',
                address: new Address('Test Street', '123', '12345', 'Test City', 'Test Country'),
                phone: new PhoneNumber('123456789'),
                email: new EmailAddress('test@mail.com'),
            ),
            billedCompany: new BilledCompany(),
            productLines: [],
            status: $status,
        );
    }

    public function invoiceStatusProvider(): array
    {
        return [
            [StatusEnum::APPROVED, 'approve', StatusEnum::APPROVED, true],
            [StatusEnum::REJECTED, 'approve', StatusEnum::REJECTED, true],
            [StatusEnum::DRAFT, 'approve', StatusEnum::APPROVED, false],
            [StatusEnum::APPROVED, 'reject', StatusEnum::APPROVED, true],
            [StatusEnum::REJECTED, 'reject', StatusEnum::REJECTED, true],
            [StatusEnum::DRAFT, 'reject', StatusEnum::REJECTED, false],
        ];
    }

    public function testTotalPriceIsCalculatedCorrectly(): void
    {
        $productLines = [
            $this->createProductLine(100, 2),
            $this->createProductLine(50, 3),
        ];
        $invoice = $this->createInvoiceWithProductLines($productLines);
        $this->assertEquals(new Money(350), $invoice->getTotalPrice());
    }

    private function createProductLine(int $unitPrice, int $quantity): ProductLine
    {
        $product = $this->createMock(Product::class);
        $product->method('getUnitPrice')->willReturn(new Money($unitPrice));
        $productLine = $this->createMock(ProductLine::class);
        $productLine->method('getProduct')->willReturn($product);
        $productLine->method('getQuantity')->willReturn($quantity);
        return $productLine;
    }

    private function createInvoiceWithProductLines(array $productLines): Invoice
    {
        return new Invoice(
            id: Uuid::uuid4(),
            invoiceNumber: new InvoiceNumber(Uuid::fromString('6f8da70b-edff-331e-b3ad-a97d387fad87')),
            invoiceDate: new DateTimeImmutable(),
            dueDate: new DateTimeImmutable('+30 days'),
            company: new Company(
                id: Uuid::fromString('0997e0c2-5d5a-4bdb-9387-bc6421641e59'),
                name: 'Test Company',
                address: new Address('Test Street', '123', '12345', 'Test City', 'Test Country'),
                phone: new PhoneNumber('123456789'),
                email: new EmailAddress('test@mail.com'),
            ),
            billedCompany: new BilledCompany(),
            productLines: $productLines,
            status: StatusEnum::DRAFT,
        );
    }
}
