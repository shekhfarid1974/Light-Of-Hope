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
        Schema::create('call_backs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crm_id')->nullable();
            $table->string('crm_type')->nullable();
            $table->string('name')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->index(['crm_id', 'crm_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_backs');
    }
};
