<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyModel extends Model
{
    public $incrementing = false;
    protected $table = 'companies';
    protected $keyType = 'string';
    protected $fillable = [
        'name',
        'street',
        'city',
        'zip',
        'phone',
        'email',
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(InvoiceModel::class, 'company_id', 'id');
    }
}
