<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_page', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Nasze usługi');
            $table->text('content')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default record
        DB::table('service_page')->insert([
            'title' => 'Nasze usługi',
            'content' => '<h3>Oferujemy profesjonalne usługi</h3><p>Skontaktuj się z nami, aby dowiedzieć się więcej.</p>',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('service_page');
    }
};
