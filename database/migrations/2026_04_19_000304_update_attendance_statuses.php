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
        // 1. Temporarily allow both old and new values to prevent truncation during update
        Schema::table('attendances', function (Blueprint $table) {
            $table->enum('status', ['on_time', 'present', 'absent', 'late', 'excused'])->default('on_time')->change();
        });

        // 2. Now update the data safely
        \DB::table('attendances')->where('status', 'on_time')->update(['status' => 'present']);

        // 3. Finalize the enum to only allow the new desired values
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
