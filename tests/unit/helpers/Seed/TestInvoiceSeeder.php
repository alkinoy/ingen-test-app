<?php

declare(strict_types=1);

namespace Tests\unit\helpers\Seed;

use App\Domain\Enums\StatusEnum;
use Faker\Factory;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

class TestInvoiceSeeder extends Seeder
{
    public const INVOICE_ID_1 = '5ab68176-0a78-41bc-91ab-8ac24a70bf94';
    public const INVOICE_ID_2 = '3e96ac59-d190-4fba-b840-01c7781794bd';
    public const INVOICE_ID_3 = 'fcec95d9-b76e-4de5-94d9-105bf9c73aa7';

    public function __construct(
        private ConnectionInterface $db
    ) {
    }

    public function run(): void
    {
        $companies = $this->db->table('companies')->get();
        $products = $this->db->table('products')->get();

        $faker = Factory::create();

        $invoices = [];
        $invoices[] = [
            'id' => self::INVOICE_ID_1,
            'number' => $faker->uuid(),
            'date' => $faker->date(),
            'due_date' => $faker->date(),
            'company_id' => $companies->random()->id,
            'status' => StatusEnum::DRAFT,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $invoices[] = [
            'id' => self::INVOICE_ID_2,
            'number' => $faker->uuid(),
            'date' => $faker->date(),
            'due_date' => $faker->date(),
            'company_id' => $companies->random()->id,
            'status' => StatusEnum::APPROVED,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $invoices[] = [
            'id' => self::INVOICE_ID_3,
            'number' => $faker->uuid(),
            'date' => $faker->date(),
            'due_date' => $faker->date(),
            'company_id' => $companies->random()->id,
            'status' => StatusEnum::REJECTED,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $this->db->table('invoices')->insert($invoices);
        $this->addInvoiceProductLines($products, $invoices);
    }

    private function addInvoiceProductLines(Collection $products, array $invoices): void
    {

        $lines = [];

        foreach ($invoices ?? [] as $invoice) {
            $randomNumberOfProducts = rand(1, 5);
            $freshProducts = clone $products;

            for ($i = 0; $i < $randomNumberOfProducts; $i++) {
                $lines[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'invoice_id' => $invoice['id'],
                    'product_id' => $freshProducts->pop()->id,
                    'quantity' => rand(1, 100),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $this->db->table('invoice_product_lines')->insert($lines);
    }
}
