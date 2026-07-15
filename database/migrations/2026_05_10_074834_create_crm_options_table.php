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
        Schema::create('crm_options', function (Blueprint $table) {
            $table->id();
            $table->string('crm_type')->nullable(); // teachers_crm, kids_crm
            $table->string('type'); // e.g. interested_for, calling_status, etc.
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_options');
    }
};
