<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Mapper;

use App\Domain\Enums\StatusEnum;
use App\Domain\Roots\Invoice;
use App\Domain\VO\InvoiceLineCollection;
use App\Modules\Invoices\Infrastructure\Model\InvoiceModel;
use Ramsey\Uuid\Uuid;

class InvoiceMapper
{
    public static function toDomainEntity(InvoiceModel $model): Invoice
    {
        $id = Uuid::fromString($model->id);

        $company = CompanyMapper::toDomainEntity($model->company);
//        $billedCompany = CompanyMapper::toDomainEntity($model->billedCompany);
        $billedCompany = CompanyMapper::toDomainEntity($model->company);

        $invoiceLines = [];
        foreach ($model->invoiceItems as $invoiceLineModel) {
            $invoiceLine = InvoiceLineMapper::toDomainEntity($invoiceLineModel);
            $invoiceLines[] = $invoiceLine;
        }
        $invoiceLineCollection = new InvoiceLineCollection(...$invoiceLines);

        $status = StatusEnum::from($model->status);

        return new Invoice(
            id: $id,
            invoiceNumber: $model->number,
            invoiceDate: new \DateTimeImmutable($model->date),
            dueDate: new \DateTimeImmutable($model->due_date),
            company: $company,
            billedCompany: $billedCompany,
            invoiceLineCollection: $invoiceLineCollection,
            status: $status
        );
    }

    public static function toEloquentModel(Invoice $invoice): InvoiceModel
    {
        $model = new InvoiceModel();

        $model->id = $invoice->id->toString();
        $model->number = $invoice->invoiceNumber;
        $model->date = $invoice->invoiceDate->format('Y-m-d');
        $model->due_date = $invoice->dueDate->format('Y-m-d');
        $model->status = $invoice->getStatus()->value;

        $companyModel = CompanyMapper::toEloquentModel($invoice->company);
        $model->company_id = $companyModel->id;

        $billedCompanyModel = CompanyMapper::toEloquentModel($invoice->billedCompany);
        $model->billed_company_id = $billedCompanyModel->id;

        $invoiceItemModels = [];
        foreach ($invoice->invoiceLineCollection as $invoiceLine) {
            $invoiceLineModel = InvoiceLineMapper::toEloquentModel($invoiceLine);
            $invoiceLineModel->invoice_id = $model->id;
            $invoiceItemModels[] = $invoiceLineModel;
        }

        $model->setRelation('invoiceItems', collect($invoiceItemModels));

        return $model;
    }
}
