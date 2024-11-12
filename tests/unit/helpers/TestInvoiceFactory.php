<?php

declare(strict_types=1);

namespace Tests\unit\helpers;

use App\Domain\Entity\Company;
use App\Domain\Entity\Product;
use App\Domain\Roots\Invoice;
use App\Domain\VO\Address;
use App\Domain\VO\InvoiceLine;
use App\Domain\VO\InvoiceLineCollection;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;

class TestInvoiceFactory
{
    public static function createInvoice(): Invoice
    {
        return new Invoice(
            id: Uuid::uuid4(),
            invoiceNumber: '1234/1234',
            invoiceDate: new \DateTimeImmutable(), //could be used some frosenClock approach
            dueDate: (new \DateTimeImmutable())->add(new \DateInterval('P1D')),
            company: new Company(
                id: Uuid::uuid4(),
                name: 'Test Company',
                address: new Address(
                    streetAddress: 'test streed addr',
                    city: 'Warsaw',
                    zipCode: '12-123'
                ),
                phone: '123-123-123',
                email: 'test@test.com'
            ),
            billedCompany: new Company(
                id: Uuid::uuid4(),
                name: 'Test Billed Company',
                address: new Address(
                    streetAddress: 'test streed addr',
                    city: 'Warsaw',
                    zipCode: '12-123'
                ),
                phone: '123-123-123',
                email: 'test@test.com'
            ),
            invoiceLineCollection: new InvoiceLineCollection(
                new InvoiceLine(
                    product: new Product(
                        id: Uuid::uuid4(),
                        name: 'Test Product',
                        price: new Money(12, new Currency('USD')),
                    ),
                    quantity: 5
                ),
                new InvoiceLine(
                    product: new Product(
                        id: Uuid::uuid4(),
                        name: 'Test Product',
                        price: new Money(100, new Currency('USD')),
                    ),
                    quantity: 1
                ),
            )
        );
    }
}
