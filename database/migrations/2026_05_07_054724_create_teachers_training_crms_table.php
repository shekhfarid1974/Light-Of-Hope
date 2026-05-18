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
        Schema::create('teachers_training_crms', function (Blueprint $table) {
            $table->id();
            $table->string('trainee_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('data_source_id')->nullable()->constrained('data_sources')->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
            $table->string('profession')->nullable();
            $table->string('experience')->nullable();
            $table->string('trainee_age')->nullable();
            $table->string('course_title')->nullable();

            $table->string('calling_status')->nullable();
            $table->string('query_source')->nullable();
            $table->string('query_status')->nullable();
            $table->string('call_back')->nullable();
            $table->string('assigned_person')->nullable();
            $table->text('query_complaint')->nullable();
            $table->string('agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers_training_crms');
    }
};
