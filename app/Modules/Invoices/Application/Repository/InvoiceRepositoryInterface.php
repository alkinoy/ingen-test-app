<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Repository;

use App\Modules\Invoices\Infrastructure\Model\InvoiceModel;
use Ramsey\Uuid\UuidInterface;

interface InvoiceRepositoryInterface
{
    public function save(InvoiceModel $invoice): void;

    public function findById(UuidInterface $id): ?InvoiceModel;
}
