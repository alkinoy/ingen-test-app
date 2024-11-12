<?php

declare(strict_types=1);

namespace App\Domain\VO;

/**
 * IteratorAggregate<InvoiceLine>
 */
class InvoiceLineCollection implements \IteratorAggregate
{
    /** @var InvoiceLine[] */
    private array $invoiceLines = [];

    public function __construct(InvoiceLine ...$invoiceLines)
    {
        $this->invoiceLines = $invoiceLines;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->invoiceLines);
    }
}
