<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

readonly class Product
{
    public function __construct(
        public UuidInterface $id,
        public string $name,
        public Money $price,
    ) {
    }
}
