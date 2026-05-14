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
        Schema::table('available_times', function (Blueprint $table) {
            $table->time('from')->nullable()->after('day_id');
            $table->time('to')->nullable()->after('from');
            $table->foreignId('date_id')->nullable()->after('to')->constrained('available_dates')->nullOnDelete();
            $table->dropColumn('time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('available_times', function (Blueprint $table) {
            $table->time('time')->nullable()->after('day_id');
            $table->dropColumn(['from', 'to', 'date_id']);
        });
    }
};
