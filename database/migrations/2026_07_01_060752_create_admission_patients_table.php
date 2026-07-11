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
        Schema::create('admission_patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('age');
            $table->string('contact');
            $table->string('guardian');
            $table->string('address');
            $table->string('surgone');
            $table->float('admission_fee');
            $table->boolean('bade_type')->comment('1=ward/0=cabin/null=no bade')->nullable();
            $table->float('bade_no');
            $table->float('bade_fee');
            $table->string('ot_type');
            $table->float('ot_fee');
            $table->string('lens');
            $table->float('lens_fee');
            $table->double('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_patients');
    }
};
