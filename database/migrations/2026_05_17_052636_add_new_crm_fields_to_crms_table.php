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
        Schema::table('crms', function (Blueprint $table) {
            $table->string('crm_type')->default('course_outbound')->after('id');
            $table->string('trainee_name')->nullable();
            $table->string('trainee_age')->nullable();
            $table->string('experience')->nullable();
            $table->string('course_title')->nullable();
            $table->text('query_complaint')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crms', function (Blueprint $table) {
            $table->dropColumn([
                'crm_type',
                'trainee_name',
                'trainee_age',
                'experience',
                'course_title',
                'query_complaint',
            ]);
        });
    }
};
