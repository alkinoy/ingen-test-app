<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Mapper;

use App\Domain\VO\InvoiceLine;
use App\Modules\Invoices\Infrastructure\Mapper\ProductMapper;
use App\Modules\Invoices\Infrastructure\Model\InvoiceLineModel;
use Ramsey\Uuid\Uuid;

class InvoiceLineMapper
{
    public static function toDomainEntity(InvoiceLineModel $model): InvoiceLine
    {
        $product = ProductMapper::toDomainEntity($model->product);

        return new InvoiceLine(
            product: $product,
            quantity: $model->quantity
        );
    }

    public static function toEloquentModel(InvoiceLine $invoiceLine): InvoiceLineModel
    {
        $model = new InvoiceLineModel();

        $model->id = Uuid::uuid4()->toString();
        $model->quantity = $invoiceLine->quantity;

        $productModel = ProductMapper::toEloquentModel($invoiceLine->product);
        $model->product_id = $productModel->id;

        return $model;
    }
}
