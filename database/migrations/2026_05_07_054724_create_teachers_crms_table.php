<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers_crms', function (Blueprint $table) {
            $table->id();
            // Section 1: Participants' Info
            $table->string('customer_name');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('gender')->nullable();
            $table->string('area')->nullable();
            $table->foreignId('district_id')->constrained('districts')->onDelete('cascade');
            $table->integer('age')->nullable();
            $table->string('educational_qualification')->nullable();
            $table->string('joining_as'); // Teacher / Parent / Other
            $table->string('course')->nullable();

            // Section 2: Professional Summary
            // Tab 1: Teacher
            $table->string('current_designation')->nullable();
            $table->string('years_of_experience')->nullable();
            $table->string('teaching_group')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('institution_address')->nullable();
            $table->string('institution_type')->nullable();

            // Tab 2: Parents
            $table->string('child_name')->nullable();
            $table->string('child_gender')->nullable();
            $table->integer('dob')->nullable(); // DOB (Number)

            // Tab 3: Others
            $table->string('other_type')->nullable();
            $table->string('organization')->nullable();

            // Section 3: Interaction Summary
            // Communication History
            $table->string('calling_agent')->nullable();
            $table->string('calling_purpose')->nullable();
            $table->string('calling_status')->nullable();
            $table->foreignId('data_source_id')->nullable()->constrained('data_sources')->nullOnDelete();
            $table->text('discussion_note')->nullable();
            $table->string('next_follow_up_date')->nullable(); // Next Follow-up Date (Number)
            $table->string('call_back')->nullable();
            $table->date('call_back_date')->nullable();
            $table->time('call_back_time')->nullable();

            // Product History
            $table->string('interested_course')->nullable();
            $table->date('date_of_purchase')->nullable();
            $table->string('branch')->nullable();

            $table->string('agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers_crms');
    }
};
