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
        Schema::create('course_crms', function (Blueprint $table) {
            $table->id();
            $table->string('parents_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('profession')->nullable();
            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
            $table->string('child_gender')->nullable();
            $table->string('child_age')->nullable();
            $table->string('child_name')->nullable();
            $table->string('class')->nullable();
            $table->string('interested_for')->nullable();
            $table->foreignId('data_source_id')->nullable()->constrained('data_sources')->nullOnDelete();
            
            $table->string('calling_status')->nullable();
            $table->string('query_source')->nullable();
            $table->string('query_status')->nullable();
            $table->string('call_back')->nullable();
            $table->string('assigned_person')->nullable();
            $table->text('remarks')->nullable();
            $table->string('agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_crms');
    }
};
