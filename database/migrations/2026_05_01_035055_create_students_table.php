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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('roll');
            $table->string('reg_no')->nullable();
            $table->string('unique_id')->unique();
            $table->string('phone')->nullable();
            $table->string('class_id');
            $table->string('religion_id');
            $table->string('gender_id');
            $table->string('blood_group_id');
            $table->string('date_of_birth');
            $table->string('photo')->nullable();
            $table->string('section_id')->nullable();
            $table->string('group_id')->nullable();
            $table->string('session_id');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('father_phone')->nullable();
            $table->string('guardian')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('birth_certificate_number');
            $table->text('present_address');
            $table->text('parmanent_address')->nullable();
            $table->boolean('status')->default(true)->comment('1=active/0=inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
