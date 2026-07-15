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

            // Section 1: Basic Info
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('father_phone');
            $table->string('mother_phone');
            $table->string('whatsapp');
            $table->string('email');
            $table->string('profession');
            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
            $table->string('area')->nullable();
            $table->string('interest_for')->nullable(); // dropdown

            // Section 2: Child Info
            $table->string('child_name')->nullable();
            $table->string('child_gender')->nullable(); // dropdown
            $table->date('dob')->nullable(); // date of birth (Date)
            $table->integer('child_age')->nullable(); // age (Number)
            $table->string('class')->nullable();
            $table->string('school_name')->nullable();

            // Section 3: Interaction Summary
            // Communication History
            $table->date('calling_date')->nullable(); // calling date (Date)
            $table->string('calling_agent')->nullable(); // dropdown
            $table->string('calling_purpose')->nullable(); // dropdown
            $table->string('calling_status')->nullable(); // dropdown
            $table->text('discussion_note')->nullable();
            $table->date('next_follow_up_date')->nullable(); // date
            $table->string('call_back')->nullable(); // dropdown
            $table->date('call_back_date')->nullable();
            $table->time('call_back_time')->nullable();

            // Purchase History
            $table->string('course_name')->nullable(); // dropdown
            $table->date('date_of_purchase')->nullable();
            $table->string('branch')->nullable(); // dropdown

            $table->foreignId('data_source_id')->nullable()->constrained('data_sources')->nullOnDelete();
            $table->string('agent')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kids_crms');
    }
};