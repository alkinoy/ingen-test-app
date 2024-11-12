<?php

declare(strict_types=1);

namespace Tests\unit\Modules\Invoices\Application\Service;

use App\Modules\Invoices\Application\Service\InvoiceDtoFactory;
use PHPUnit\Framework\TestCase;
use Tests\unit\helpers\TestInvoiceFactory;

class InvoiceDtoFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $invoice = TestInvoiceFactory::createInvoice();
        $factory = new InvoiceDtoFactory();

        $invoiceDto = $factory->createFromInvoice($invoice);

        self::assertEquals($invoice->invoiceNumber, $invoiceDto->number);
        self::assertEquals($invoice->id, $invoiceDto->invoiceId);
        self::assertEquals($invoice->invoiceDate, $invoiceDto->invoiceDate);
        self::assertEquals($invoice->dueDate, $invoiceDto->dueDate);
        self::assertEquals($invoice->getTotalPrice(), $invoiceDto->total);

        $expectedResult = [
            'invoiceId' => $invoice->id,
            'number' => '1234/1234',
            'invoiceDate' => $invoice->invoiceDate->format('Y-m-d'),
            'dueDate' => $invoice->dueDate->format('Y-m-d'),
            'status' => 'draft',
            'company' =>
                [
                    'name' => 'Test Company',
                    'address' =>
                        [
                            'streetAddress' => 'test streed addr',
                            'city' => 'Warsaw',
                            'zipCode' => '12-123',
                        ],
                    'phone' => '123-123-123',
                    'email' => 'test@test.com',
                ],
            'billedCompany' =>
                [
                    'name' => 'Test Billed Company',
                    'address' =>
                        [
                            'streetAddress' => 'test streed addr',
                            'city' => 'Warsaw',
                            'zipCode' => '12-123',
                        ],
                    'phone' => '123-123-123',
                    'email' => 'test@test.com',
                ],
            'products' =>
                [
                    'invoiceLines' =>
                    [
                        [
                            'product' =>
                                [
                                    'name' => 'Test Product',
                                    'price' =>
                                        [
                                            'amount' => '12',
                                            'currency' => 'USD',
                                        ],
                                ],
                            'quantity' => 5,
                            'total' =>
                                [
                                    'amount' => '60',
                                    'currency' => 'USD',
                                ],
                        ],
                        [
                            'product' =>
                                [
                                    'name' => 'Test Product',
                                    'price' =>
                                        [
                                            'amount' => '100',
                                            'currency' => 'USD',
                                        ],
                                ],
                            'quantity' => 1,
                            'total' =>
                                [
                                    'amount' => '100',
                                    'currency' => 'USD',
                                ],
                        ],
                    ],
                ],
            'total' =>
            [
                'amount' => '160',
                'currency' => 'USD',
            ],
        ];


        self::assertEquals($expectedResult, $invoiceDto->jsonSerialize());
    }
}
