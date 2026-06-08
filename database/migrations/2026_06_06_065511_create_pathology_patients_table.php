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
        Schema::create('pathology_patients', function (Blueprint $table) {
            $table->id();
            $table->boolean('type')->default(true)->comment('1=new/0=old');
            $table->string('name');
            $table->string('contact');
            $table->string('age');
            $table->string('address')->nullable();
            $table->integer('disease_id')->nullable();
            $table->integer('blood_group_id')->nullable();
            $table->integer('gender_id');
            $table->integer('religion_id')->nullable();
            $table->integer('doctor_id')->nullable();
            $table->integer('referal_id')->nullable();
            $table->date('visit_date');
            $table->string('total');
            $table->string('discount_amount');
            $table->string('discount_percent');
            $table->string('grand_total');
            $table->string('paid');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pathology_patients');
    }
};
