<?php

declare(strict_types=1);

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'unit_price',
        'description',
    ];

    public function invoiceProductLines(): HasMany
    {
        return $this->hasMany(InvoiceProductLine::class, 'product_id', 'id');
    }
}
