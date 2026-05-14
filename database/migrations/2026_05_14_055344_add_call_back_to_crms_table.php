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
            $table->string('call_back')->nullable()->after('query_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crms', function (Blueprint $table) {
            $table->dropColumn('call_back');
        });
    }
};
