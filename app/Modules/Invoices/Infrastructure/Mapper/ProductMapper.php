<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Mapper;

use App\Domain\Entity\Product;
use App\Modules\Invoices\Infrastructure\Model\ProductModel;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;

class ProductMapper
{
    public static function toDomainEntity(ProductModel $model): Product
    {
        $id = Uuid::fromString($model->id);

        // Convert decimal to integer (assuming price is stored as decimal in dollars)
        $amount = (int) round($model->price * 100);

        $price = new Money($amount, new Currency($model->currency));

        return new Product(
            id: $id,
            name: $model->name,
            price: $price
        );
    }

    public static function toEloquentModel(Product $product): ProductModel
    {
        $model = new ProductModel();

        $model->id = $product->id->toString();
        $model->name = $product->name;
        $model->price = $product->price->getAmount() / 100;
        $model->currency = $product->price->getCurrency()->getCode();

        return $model;
    }
}
