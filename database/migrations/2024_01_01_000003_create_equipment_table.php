<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price_per_day', 10, 2)->nullable();
            $table->boolean('is_price_negotiable')->default(true);
            $table->enum('status', ['available', 'rented', 'hidden'])->default('available');
            $table->date('rented_until')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('brand')->nullable();
            $table->text('condition_notes')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
