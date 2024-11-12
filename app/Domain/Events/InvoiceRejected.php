<?php

declare(strict_types=1);

namespace App\Domain\Events;

class InvoiceRejected extends DomainEvent
{
    private string $invoiceNumber;
    private ?string $reason;

    //here also we can add a user who made this action
    public function __construct(string $invoiceNumber, ?string $reason)
    {
        parent::__construct();
        $this->invoiceNumber = $invoiceNumber;
        $this->reason = $reason;
    }

    public function invoiceNumber(): string
    {
        return $this->invoiceNumber;
    }
    public function reason(): ?string
    {
        return $this->reason;
    }
}
