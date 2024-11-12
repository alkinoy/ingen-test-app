<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use App\Domain\Enums\StatusEnum;
use Money\Money;
use Ramsey\Uuid\UuidInterface;

readonly class InvoiceDto implements \JsonSerializable
{
    //fully separate DTO instead of just domain objects allows us to have multiple representation of the same
    //domain structure
    public function __construct(
        public UuidInterface $invoiceId,
        public string $number,
        public \DateTimeInterface $invoiceDate,
        public \DateTimeInterface $dueDate,
        public StatusEnum $status,
        public CompanyDto $company,
        public CompanyDto $billedCompany,
        public InvoceLineCollectionDto $lines,
        public Money $total,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'invoiceId' => $this->invoiceId->toString(),
            'number' => $this->number,
            'invoiceDate' => $this->invoiceDate->format('Y-m-d'),
            'dueDate' => $this->dueDate->format('Y-m-d'),
            'status' => $this->status->value,
            'company' => $this->company->jsonSerialize(),
            'billedCompany' => $this->billedCompany->jsonSerialize(),
            'products' => $this->lines->jsonSerialize(),
            'total' => $this->total->jsonSerialize(),
        ];
    }
}
