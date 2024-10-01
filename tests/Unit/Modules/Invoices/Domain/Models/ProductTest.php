<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Exceptions\InvoiceInvalidValueException;
use App\Modules\Invoices\Domain\Models\Money;
use App\Modules\Invoices\Domain\Models\Product;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ProductTest extends TestCase
{
    private UuidInterface $uuid;
    private Money $unitPrice;
    private Product $product;

    protected function setUp(): void
    {
        // Inicjalizacja UUID i poprawnego ceny
        $this->uuid = Uuid::uuid4();
        $this->unitPrice = new Money(1000, 'USD');

        // Inicjalizacja poprawnego produktu
        $this->product = new Product($this->uuid, 'Test Product', $this->unitPrice);
    }

    public function testIdIsReturnedCorrectly(): void
    {
        $this->assertEquals($this->uuid, $this->product->getId());
    }

    public function testNameIsReturnedCorrectly(): void
    {
        $this->assertEquals('Test Product', $this->product->getName());
    }

    public function testUnitPriceIsReturnedCorrectly(): void
    {
        $this->assertEquals($this->unitPrice, $this->product->getUnitPrice());
    }

    public function testProductWithEmptyNameThrowsException(): void
    {
        $this->expectException(InvoiceInvalidValueException::class);
        new Product(Uuid::uuid4(), '', new Money(1000, 'USD'));
    }

    public function testProductWithNegativePriceThrowsException(): void
    {
        $this->expectException(InvoiceInvalidValueException::class);
        new Product(Uuid::uuid4(), 'Test Product', new Money(-1000, 'USD'));
    }
}
