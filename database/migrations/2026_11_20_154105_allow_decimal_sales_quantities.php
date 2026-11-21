<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE products MODIFY shop_quantity DECIMAL(15,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE sales_products MODIFY quantity DECIMAL(15,2) NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE sales_products MODIFY quantity INTEGER NOT NULL');
        DB::statement('ALTER TABLE products MODIFY shop_quantity INTEGER NOT NULL DEFAULT 0');
    }
};
