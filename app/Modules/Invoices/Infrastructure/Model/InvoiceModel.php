<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvoiceModel extends Model
{
    public $incrementing = false;
    protected $table = 'invoices';
    protected $keyType = 'string';

    protected $fillable = [
        'number',
        'date',
        'due_date',
        'status',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceLineModel::class, 'invoice_id', 'id');
    }

    public function billedCompany(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'billed_company_id');
    }
}
