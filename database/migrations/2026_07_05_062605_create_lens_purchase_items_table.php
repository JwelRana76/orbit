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
        Schema::create('lens_purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lens_purchase_id')->constrained('lens_purchases')->onDelete('cascade');
            $table->foreignId('lens_id')->constrained('lenses')->onDelete('cascade');
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
        Schema::dropIfExists('lens_purchase_items');
    }
};
