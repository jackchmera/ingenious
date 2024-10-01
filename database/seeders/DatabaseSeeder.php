<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Modules\Invoices\Infrastructure\Database\Seeders\DatabaseSeeder as InvoiceDatabaseSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     */
    public function run(): void
    {
        $this->call(InvoiceDatabaseSeeder::class);
    }
}
