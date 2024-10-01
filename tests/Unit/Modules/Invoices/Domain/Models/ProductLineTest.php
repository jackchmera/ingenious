<?php

namespace Tests\Unit\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Exceptions\InvoiceInvalidValueException;
use App\Modules\Invoices\Domain\Models\Money;
use App\Modules\Invoices\Domain\Models\Product;
use App\Modules\Invoices\Domain\Models\ProductLine;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProductLineTest extends TestCase
{
    private Product $product;
    private ProductLine $productLine;
    private int $quantity;

    protected function setUp(): void
    {
        $this->product = new Product(Uuid::uuid4(), 'Product A', new Money(1000, 'USD'));
        $this->quantity = 2;
        $this->productLine = new ProductLine($this->product, $this->quantity);
    }

    public function testProductIsReturnedCorrectly(): void
    {
        $this->assertEquals($this->product, $this->productLine->getProduct());
    }

    public function testQuantityIsReturnedCorrectly(): void
    {
        $this->assertEquals($this->quantity, $this->productLine->getQuantity());
    }

    public function testTotalIsCalculatedCorrectly(): void
    {
        $this->assertEquals(new Money(2000, 'USD'), $this->productLine->getTotal());
    }

    public function testProductLineWithZeroQuantityThrowsException(): void
    {
        $this->expectException(InvoiceInvalidValueException::class);
        new ProductLine($this->product, 0);
    }

    public function testProductLineWithNegativeQuantityThrowsException(): void
    {
        $this->expectException(InvoiceInvalidValueException::class);
        new ProductLine($this->product, -1);
    }
}
