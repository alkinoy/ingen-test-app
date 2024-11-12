<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use JsonSerializable;

readonly class AddressDto implements JsonSerializable
{
    public function __construct(
        public string $streetAddress,
        public string $city,
        public string $zipCode,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'streetAddress' => $this->streetAddress,
            'city' => $this->city,
            'zipCode' => $this->zipCode,
        ];
    }
}
