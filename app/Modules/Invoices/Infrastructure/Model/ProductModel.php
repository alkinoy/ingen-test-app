<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductModel extends Model
{
    public $incrementing = false;
    protected $table = 'products';
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'price',
        'currency',
    ];

    public function invoiceLines(): HasMany
    {
        return $this->hasMany(InvoiceLineModel::class, 'product_id');
    }
}
