<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Service;

use App\Domain\Entity\Company;
use App\Domain\Entity\Product;
use App\Domain\Roots\Invoice;
use App\Domain\VO\Address;
use App\Domain\VO\InvoiceLineCollection;
use App\Modules\Invoices\Api\Dto\AddressDto;
use App\Modules\Invoices\Api\Dto\CompanyDto;
use App\Modules\Invoices\Api\Dto\InvoceLineCollectionDto;
use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Api\Dto\InvoiceLineDto;
use App\Modules\Invoices\Api\Dto\ProductDto;

class InvoiceDtoFactory
{
    public function createFromInvoice(Invoice $invoice): InvoiceDto
    {

        return new InvoiceDto(
            invoiceId: $invoice->id,
            number: $invoice->invoiceNumber,
            invoiceDate: $invoice->invoiceDate,
            dueDate: $invoice->dueDate,
            status: $invoice->getStatus(),
            company: $this->createCompanyDto($invoice->company),
            billedCompany: $this->createCompanyDto($invoice->billedCompany),
            lines: $this->createLines($invoice->invoiceLineCollection),
            total: $invoice->getTotalPrice()
        );
    }

    private function createAddressDto(Address $vo): AddressDto
    {
        return new AddressDto(
            streetAddress: $vo->streetAddress,
            city: $vo->city,
            zipCode: $vo->zipCode
        );
    }

    private function createCompanyDto(Company $company): CompanyDto
    {
        return new CompanyDto(
            name: $company->name,
            address: $this->createAddressDto($company->address),
            phone: $company->phone,
            email: $company->email,
        );
    }

    private function createProductDto(Product $vo): ProductDto
    {
        return new ProductDto(
            name: $vo->name,
            price: $vo->price,
        );
    }

    private function createLines(InvoiceLineCollection $lineCollection): InvoceLineCollectionDto
    {
        $lines = [];
        foreach ($lineCollection as $line) {
            $lines[] = new InvoiceLineDto(
                product: $this->createProductDto($line->product),
                quantity: $line->quantity,
                total: $line->getTotalCost()
            );
        }

        return new InvoceLineCollectionDto(...$lines);
    }
}
