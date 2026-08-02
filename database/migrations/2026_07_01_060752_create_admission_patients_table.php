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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('reg_no');
            $table->string('name');
            $table->string('age');
            $table->string('contact');
            $table->string('guardian');
            $table->string('present_address');
            $table->string('permanent_address');
            $table->string('relative');
            $table->string('relative_address');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('gender_id')->constrained('genders')->onDelete('cascade');
            $table->float('admission_fee')->nullable();
            $table->boolean('bed_type')->comment('1=ward/0=cabin/null=no bade')->nullable();
            $table->foreignId('bed_id')->constrained('beds')->onDelete('cascade');
            $table->float('bed_fee')->nullable();
            $table->foreignId('operation_id')->constrained('operations')->onDelete('cascade');
            $table->float('ot_fee')->nullable();
            $table->string('lens_id')->nullable();
            $table->float('lens_fee')->nullable();
            $table->boolean('payment_status')->comment('1=paid/0=due')->default(false);
            $table->boolean('status')->comment('1=admitted /0=release/null=Cancel')->default(true)->nullable();
            $table->dateTime('released')->nullable();
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
