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
        Schema::create('frame_purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('frame_purchase_id')->constrained('frame_purchases')->onDelete('cascade');
            $table->foreignId('frame_id')->constrained('frames')->onDelete('cascade');
            $table->string('qty');
            $table->string('bonus')->nullable();
            $table->string('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frame_purchase_items');
    }
};
