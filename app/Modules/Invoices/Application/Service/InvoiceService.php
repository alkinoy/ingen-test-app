<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Service;

use App\Domain\Exception\InvoiceNotFoundException;
use App\Domain\Roots\Invoice;
use App\Modules\Invoices\Application\Repository\InvoiceRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Mapper\InvoiceMapper;
use Ramsey\Uuid\UuidInterface;

class InvoiceService
{
    public function __construct(
        private readonly InvoiceRepositoryInterface $repository
    ) {
    }


    /**
     * @throws InvoiceNotFoundException
     */
    public function getInvoice(UuidInterface $invoiceId): Invoice
    {
        $invoiceModel = $this->repository->findById($invoiceId);
        if (null === $invoiceModel) {
            throw new InvoiceNotFoundException();
        }

        return InvoiceMapper::toDomainEntity($invoiceModel);
    }
}
