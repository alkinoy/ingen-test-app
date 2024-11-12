<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use JsonSerializable;
use Money\Money;

readonly class ProductDto implements JsonSerializable
{
    public function __construct(
        public string $name,
        public Money $price,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name,
            'price' => $this->price->jsonSerialize(),
        ];
    }
}
