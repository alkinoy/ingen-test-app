<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Repository;

use App\Domain\Roots\Invoice;
use App\Modules\Invoices\Application\Repository\InvoiceRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Model\InvoiceModel;
use Ramsey\Uuid\UuidInterface;

class DbInvoiceRepository implements InvoiceRepositoryInterface
{
    public function save(InvoiceModel $invoice): void
    {
        $invoice->save();
    }

    public function findById(UuidInterface $id): ?InvoiceModel
    {
        return InvoiceModel::find($id);
    }
}
