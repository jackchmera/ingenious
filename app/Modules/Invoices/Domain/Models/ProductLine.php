<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Exceptions\InvoiceInvalidValueException;

class ProductLine
{
    /**
     * @throws InvoiceInvalidValueException
     */
    public function __construct(
        private Product $product,
        private int $quantity,
    ) {
        if ($quantity < 1) {
            throw new InvoiceInvalidValueException('Quantity must be at least 1.');
        }
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotal(): Money
    {
        return $this->product->getUnitPrice()->multiply($this->quantity);
    }
}
