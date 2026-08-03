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
        Schema::create('frame_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('frame_supplier_id')->constrained('frame_suppliers')->onDelete('cascade');
            $table->string('chalan_no');
            $table->string('total_qty');
            $table->double('total_price');
            $table->double('shipping_cost')->nullable();
            $table->double('discount')->nullable();
            $table->double('grand_total');
            $table->double('paid_amount')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frame_purchases');
    }
};
