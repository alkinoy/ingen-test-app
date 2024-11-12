<?php

declare(strict_types=1);

namespace App\Domain\VO;

readonly class Address
{
    public function __construct(
        public string $streetAddress,
        public string $city,
        public string $zipCode,
    ) {
    }
}
