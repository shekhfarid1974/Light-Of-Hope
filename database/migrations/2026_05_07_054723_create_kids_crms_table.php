<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kids_crms', function (Blueprint $table) {
            $table->id();

            // === Main lead info ===
            $table->string('parents_name');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('profession')->nullable();

            // Foreign keys (ensure these tables exist, or make them string if not)
            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
            $table->foreignId('data_source_id')->nullable()->constrained('data_sources')->nullOnDelete();

            // Child details
            $table->string('child_name')->nullable();
            $table->string('child_gender')->nullable();
            $table->string('child_age')->nullable();   // store as string to handle mixed formats
            $table->string('class')->nullable();
            $table->string('interested_for')->nullable();

            // Dates
            $table->date('data_date')->nullable();     // from Excel "Data Date"
            $table->date('calling_date')->nullable();  // from Excel "Calling Date"

            // Status & assignment
            $table->string('calling_status')->nullable();
            $table->string('assigned_person')->nullable();

            // Notes
            $table->text('remarks')->nullable();

            // Extra fields (from your original migration, keep if needed)
            $table->string('query_source')->nullable();
            $table->string('query_status')->nullable();
            $table->string('call_back')->nullable();
            $table->string('agent')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kids_crms');
    }
};