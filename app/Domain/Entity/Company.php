<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\VO\Address;
use Ramsey\Uuid\UuidInterface;

readonly class Company
{
    public function __construct(
        public UuidInterface $id,
        public string $name,
        public Address $address,
        public ?string $phone,
        public ?string $email,
    ) {
    }
}
