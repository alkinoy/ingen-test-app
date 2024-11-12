<?php

declare(strict_types=1);

namespace App\Domain\Events;

class InvoiceApproved extends DomainEvent
{
    private string $invoiceNumber;

    //here also we can add a user who made this action
    public function __construct(string $invoiceNumber)
    {
        parent::__construct();
        $this->invoiceNumber = $invoiceNumber;
    }

    public function invoiceNumber(): string
    {
        return $this->invoiceNumber;
    }
}
