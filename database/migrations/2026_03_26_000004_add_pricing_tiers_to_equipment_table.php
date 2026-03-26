<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->decimal('price_3_days', 10, 2)->nullable()->after('price_per_day');
            $table->decimal('price_7_days', 10, 2)->nullable()->after('price_3_days');
            $table->decimal('price_14_days', 10, 2)->nullable()->after('price_7_days');
        });
    }

    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn(['price_3_days', 'price_7_days', 'price_14_days']);
        });
    }
};
