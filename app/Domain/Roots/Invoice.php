<?php

declare(strict_types=1);

namespace App\Domain\Roots;

use App\Domain\Entity\Company;
use App\Domain\Enums\StatusEnum;
use App\Domain\Events\DomainEvent;
use App\Domain\Events\InvoiceApproved;
use App\Domain\Events\InvoiceRejected;
use App\Domain\Exception\InvoiceStatusChangeException;
use App\Domain\VO\InvoiceLineCollection;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\UuidInterface;

class Invoice
{
    private StatusEnum $status;
    /** @var DomainEvent[] */
    private array $domainEvents = [];

    public function __construct(
        //seem that we shouldn't bring this id here. This id looks like came from DB level and shouldn't appears on
        //the domain level. But approval module is made with this id as base id (instead of invoice number), so
        //i've added it here and used it in all my interfaces. But sure we should eliminate it and use
        //the Invoice Number instead
        public readonly UuidInterface $id,
        public readonly string $invoiceNumber,
        public readonly \DateTimeInterface $invoiceDate,
        public readonly \DateTimeInterface $dueDate,
        public readonly Company $company,
        public readonly Company $billedCompany,
        public readonly InvoiceLineCollection $invoiceLineCollection,
        StatusEnum $status = StatusEnum::DRAFT,
    ) {

        $this->status = $status;
    }

    public function getTotalPrice(): Money
    {
        $total = new Money(0, new Currency('USD')); //as assumed USD is the only currency in the system
        foreach ($this->invoiceLineCollection as $invoiceLine) {
            $total = $total->add($invoiceLine->getTotalCost());
        }

        return $total;
    }

    public function approve(): void
    {
        if (StatusEnum::DRAFT !== $this->status) {
            throw new InvoiceStatusChangeException('Invoice cannot be approved as it is not in the draft');
        }

        $this->status = StatusEnum::APPROVED;
        $this->recordDomainEvent(new InvoiceApproved($this->invoiceNumber));
    }

    public function reject(?string $reason): void
    {
        if (StatusEnum::DRAFT !== $this->status) {
            throw new InvoiceStatusChangeException('Invoice cannot be rejected as it is not in the draft');
        }

        $this->status = StatusEnum::REJECTED;
        $this->recordDomainEvent(new InvoiceRejected($this->invoiceNumber, $reason));
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function pullDomainEvents(): \Traversable
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];

        return new \ArrayIterator($events);
    }



    private function recordDomainEvent(DomainEvent $event): void
    {
        $this->domainEvents[] = $event;
    }//this method should be executed in Approval module after any status change. It will allow us to know
//when this approval was made. Also we could add a link to the used who made this action.
}
