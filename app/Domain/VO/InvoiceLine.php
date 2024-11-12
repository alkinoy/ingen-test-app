<?php

declare(strict_types=1);

namespace App\Domain\VO;

use App\Domain\Entity\Product;
use Money\Money;

readonly class InvoiceLine
{
    public function __construct(
        public Product $product,
        public int $quantity,
    ) {
    }

    public function getTotalCost(): Money
    {
        return $this->product->price->multiply($this->quantity);
    }
}
