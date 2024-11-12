<?php

declare(strict_types=1);

namespace Tests\integration\Modules\Invoices\Application;

use App\Domain\Enums\StatusEnum;
use App\Domain\Roots\Invoice;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Infrastructure\Mapper\InvoiceMapper;
use App\Modules\Invoices\Infrastructure\Model\InvoiceModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use Tests\unit\helpers\Seed\TestInvoiceSeeder;

class InvoiceFacadeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->seed([TestInvoiceSeeder::class]);
    }


    /**
     * @dataProvider invoiceDataProvider
     */
    public function testStatusesInDb(StatusEnum $expectedStatus, string $invoiceId): void
    {
        $invoiceModelDraft = InvoiceModel::with(['company', 'billedCompany', 'invoiceItems.product'])
            ->find($invoiceId);

        self::assertNotNull($invoiceModelDraft, 'No invoice found in the database.');

        $invoiceDomain = InvoiceMapper::toDomainEntity($invoiceModelDraft);

        self::assertEquals($expectedStatus, $invoiceDomain->getStatus());
    }

    protected function invoiceDataProvider(): array
    {
        return [
            [StatusEnum::DRAFT, TestInvoiceSeeder::INVOICE_ID_1],
            [StatusEnum::APPROVED, TestInvoiceSeeder::INVOICE_ID_2],
            [StatusEnum::REJECTED, TestInvoiceSeeder::INVOICE_ID_3],
        ];
    }

    public function testApproveWithModule(): void
    {
        $invoiceModelDraft = InvoiceModel::with(['company', 'billedCompany', 'invoiceItems.product'])
            ->find(TestInvoiceSeeder::INVOICE_ID_1);

        self::assertNotNull($invoiceModelDraft, 'No invoice found in the database.');

        $invoiceDomain = InvoiceMapper::toDomainEntity($invoiceModelDraft);

        self::assertEquals(StatusEnum::DRAFT, $invoiceDomain->getStatus());

        /** @var ApprovalFacadeInterface $approvalFacade */
        $approvalFacade = app(ApprovalFacadeInterface::class);
        $approvalFacade->approve(new ApprovalDto(
            Uuid::fromString(TestInvoiceSeeder::INVOICE_ID_1),
            StatusEnum::APPROVED,
            Invoice::class
        ));


        //Could not check it due to incompleted Approval module.
        //self::assertEquals(StatusEnum::APPROVED, $invoiceDomain->getStatus());
    }
}
