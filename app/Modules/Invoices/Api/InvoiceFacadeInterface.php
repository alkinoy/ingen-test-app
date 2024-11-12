<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api;

use App\Domain\Exception\InvoiceNotFoundException;
use App\Domain\Exception\InvoiceStatusChangeException;
use App\Modules\Invoices\Api\Dto\InvoiceDto;
use Ramsey\Uuid\UuidInterface;

interface InvoiceFacadeInterface
{
    /**
     * @throws InvoiceNotFoundException
     */
    public function listInvoice(UuidInterface $invoiceId): InvoiceDto;

    /**
     * @throws InvoiceNotFoundException
     * @throws InvoiceStatusChangeException
     */
    public function approveInvoice(UuidInterface $invoiceId): bool;

    /**
     * @throws InvoiceNotFoundException
     * @throws InvoiceStatusChangeException
     */
    public function rejectInvoice(UuidInterface $invoiceId, ?string $reason): bool;
}
