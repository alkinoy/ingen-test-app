<?php

declare(strict_types=1);

namespace App\Domain\Events;

abstract class DomainEvent
{
    protected \DateTimeInterface $occurredOn;

    public function __construct()
    {
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function occurredOn(): \DateTimeInterface
    {
        return $this->occurredOn;
    }
}
