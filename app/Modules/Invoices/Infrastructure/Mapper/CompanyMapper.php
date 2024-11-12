<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Mapper;

use App\Domain\Entity\Company;
use App\Domain\VO\Address;
use App\Modules\Invoices\Infrastructure\Model\CompanyModel;
use Ramsey\Uuid\Uuid;

class CompanyMapper
{
    public static function toDomainEntity(CompanyModel $model): Company
    {
        $address = new Address(
            streetAddress: $model->street,
            city: $model->city,
            zipCode: $model->zip
        );

        $id = Uuid::fromString($model->id);

        return new Company(
            id: $id,
            name: $model->name,
            address: $address,
            phone: $model->phone,
            email: $model->email
        );
    }

    public static function toEloquentModel(Company $company): CompanyModel
    {
        $model = new CompanyModel();

        $model->id = $company->id->toString();
        $model->name = $company->name;
        $model->street = $company->address->streetAddress;
        $model->city = $company->address->city;
        $model->zip = $company->address->zipCode;
        $model->phone = $company->phone;
        $model->email = $company->email;

        return $model;
    }
}
