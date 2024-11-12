<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvoiceLineModel extends Model
{
    public $incrementing = false;
    protected $table = 'invoice_product_lines';
    protected $keyType = 'string';

    protected $fillable = [
        'quantity',
    ];

    public function product(): HasOne
    {
        return $this->hasOne(ProductModel::class, 'id', 'product_id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(InvoiceModel::class, 'id', 'invoice_id');
    }
}
