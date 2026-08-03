<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('glass_sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('glasses_sale_id')->constrained('glasses_sales')->onDelete('cascade');
            $table->foreignId('glass_id')->constrained('glasses')->onDelete('cascade');
            $table->string('qty');
            $table->string('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glass_sale_items');
    }
};
