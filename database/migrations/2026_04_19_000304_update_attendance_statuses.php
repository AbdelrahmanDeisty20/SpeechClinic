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
        // First, update any existing 'on_time' to 'present' to avoid truncation issues
        \DB::table('attendances')->where('status', 'on_time')->update(['status' => 'present']);

        Schema::table('attendances', function (Blueprint $table) {
            $table->enum('status', ['present', 'absent', 'late', 'excused'])->default('present')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->enum('status', ['on_time', 'late', 'absent'])->default('on_time')->change();
        });
    }
};
