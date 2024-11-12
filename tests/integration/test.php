<?php

declare(strict_types=1);

namespace Tests\integration;

use App\Modules\Invoices\Infrastructure\Mapper\InvoiceMapper;
use App\Modules\Invoices\Infrastructure\Model\InvoiceModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class test extends TestCase
{
    use RefreshDatabase;

    public function testSmallTest(): void
    {
        $this->seed();
        $this->assertDatabaseCount('companies', 10);

        // Fetch an invoice from the database
        $invoiceModel = InvoiceModel::with(['company', 'billedCompany', 'invoiceItems.product'])->first();

        // Check that an invoice was retrieved
        $this->assertNotNull($invoiceModel, 'No invoice found in the database.');

        // Use the InvoiceMapper to convert to a domain entity
        $invoiceDomain = InvoiceMapper::toDomainEntity($invoiceModel);

        echo $invoiceDomain->getStatus()->value;
        $invoiceDomain->approve();
    }
}
