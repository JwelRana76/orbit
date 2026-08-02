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
        Schema::create('len_provide_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lens_provider_id')->constrained('lens_providers')->onDelete('cascade');
            $table->foreignId('lens_id')->constrained('lenses')->onDelete('cascade');
            $table->string('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('len_provide_items');
    }
};
