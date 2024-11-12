<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

class InvoceLineCollectionDto implements \JsonSerializable
{
    /** @var InvoiceLineDto[] */
    private array $invoiceLines = [];

    public function __construct(InvoiceLineDto ...$invoiceLines)
    {
        $this->invoiceLines = $invoiceLines;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'invoiceLines' => array_map(fn(InvoiceLineDto $line) => $line->jsonSerialize(), $this->invoiceLines),
        ];
    }
}
