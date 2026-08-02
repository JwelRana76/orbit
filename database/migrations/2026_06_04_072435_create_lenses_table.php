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
        Schema::create('lenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('power');
            $table->string('constant');
            $table->float('cost')->nullable();
            $table->float('price');
            $table->boolean('is_hospital_provider')->comment("1=Yes/0=No");
            $table->boolean('status')->comment("1=Active/0=Deactive")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lenses');
    }
};
