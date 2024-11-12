<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application;

use App\Domain\Enums\StatusEnum;
use App\Domain\Roots\Invoice;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use App\Modules\Invoices\Application\Service\InvoiceDtoFactory;
use App\Modules\Invoices\Application\Service\InvoiceService;
use Ramsey\Uuid\UuidInterface;

class InvoiceFacade implements InvoiceFacadeInterface
{
    public function __construct(
        private readonly ApprovalFacadeInterface $approvalFacade,
        private readonly InvoiceService $invoiceService,
        private readonly InvoiceDtoFactory $invoiceDtoFactory,
    ) {
    }

    public function listInvoice(UuidInterface $invoiceId): InvoiceDto
    {
        $invoice = $this->invoiceService->getInvoice($invoiceId);
        $invoiceDto = $this->invoiceDtoFactory->createFromInvoice($invoice);

        return $invoiceDto;
    }

    public function approveInvoice(UuidInterface $invoiceId): bool
    {
        //to be sure invoice exists
        $this->invoiceService->getInvoice($invoiceId);

        $this->approvalFacade->approve(
            new ApprovalDto(
                id: $invoiceId,
                status: StatusEnum::APPROVED,
                entity: Invoice::class
            )
        );
    }

    public function rejectInvoice(UuidInterface $invoiceId, ?string $reason): bool
    {
        //to be sure invoice exists
        $this->invoiceService->getInvoice($invoiceId);

        $this->approvalFacade->approve(
            new ApprovalDto(
                id: $invoiceId,
                status: StatusEnum::APPROVED,
                entity: Invoice::class
            )
        );
    }
}
