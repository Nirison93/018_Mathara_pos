<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $used = DB::table('categories')
            ->whereNotNull('category_code')
            ->pluck('category_code')
            ->map(fn ($code) => mb_strtoupper($code))
            ->all();

        $categories = DB::table('categories')
            ->whereNull('category_code')
            ->orderBy('id')
            ->get(['id', 'name']);

        foreach ($categories as $category) {
            $base = mb_strtoupper(mb_substr($category->name, 0, 3));
            $code = $base;
            $suffix = 1;

            while (in_array($code, $used, true)) {
                $code = $base . $suffix;
                $suffix++;
            }

            $used[] = $code;

            DB::table('categories')->where('id', $category->id)->update(['category_code' => $code]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Data backfill — not reversible.
    }
};
