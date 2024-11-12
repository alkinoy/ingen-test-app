<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use Money\Money;

readonly class InvoiceLineDto implements \JsonSerializable
{
    public function __construct(
        public ProductDto $product,
        public int $quantity,
        public Money $total,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'product' => $this->product->jsonSerialize(),
            'quantity' => $this->quantity,
            'total' => $this->total->jsonSerialize(),
        ];
    }
}
