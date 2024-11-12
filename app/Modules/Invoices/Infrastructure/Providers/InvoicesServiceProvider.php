<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use App\Modules\Invoices\Application\InvoiceFacade;
use App\Modules\Invoices\Application\Repository\InvoiceRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Repository\DbInvoiceRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class InvoicesServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->scoped(InvoiceFacadeInterface::class, InvoiceFacade::class);
        $this->app->scoped(InvoiceRepositoryInterface::class, DbInvoiceRepository::class);
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [
            InvoiceFacadeInterface::class,
        ];
    }
}
