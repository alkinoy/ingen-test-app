<?php

declare(strict_types=1);

namespace Tests\unit\Domain\Roots;

use App\Domain\Enums\StatusEnum;
use App\Domain\Exception\InvoiceStatusChangeException;
use PHPUnit\Framework\TestCase;
use Tests\unit\helpers\TestInvoiceFactory;

class InvoiceTest extends TestCase
{
    /**
     * @dataProvider invoiceTransitionDataProvider
     */
    public function testInvoiceTransition(StatusEnum $state): void
    {
        $invoice = TestInvoiceFactory::createInvoice();
        if (StatusEnum::APPROVED === $state) {
            $invoice->approve();
        } else {
            $invoice->reject('reason');
        }


        self::assertEquals($state, $invoice->getStatus());
        self::assertGreaterThanOrEqual(1, \count($invoice->pullDomainEvents()));
    }

    protected function invoiceTransitionDataProvider(): array
    {
        return [
            [StatusEnum::APPROVED],
            [StatusEnum::REJECTED],
        ];
    }

    public function testInvoiceAllowSetStatusOnce(): void
    {
        self::expectException(InvoiceStatusChangeException::class);

        $invoice = TestInvoiceFactory::createInvoice();
        $invoice->approve();

        $invoice->reject('reason');
    }
}
