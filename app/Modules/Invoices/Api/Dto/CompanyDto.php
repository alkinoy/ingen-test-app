<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use JsonSerializable;

readonly class CompanyDto implements JsonSerializable
{
    public function __construct(
        public string $name,
        public AddressDto $address,
        public ?string $phone,
        public ?string $email,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name,
            'address' => $this->address->jsonSerialize(),
            'phone' => $this->phone ?? 'N/A',
            'email' => $this->email ?? 'N/A',
        ];
    }
}
