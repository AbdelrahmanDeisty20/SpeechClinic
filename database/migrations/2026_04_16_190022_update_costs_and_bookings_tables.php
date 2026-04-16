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
        Schema::table('costs', function (Blueprint $table) {
            $table->enum('type', ['assessment', 'monthly'])->default('assessment')->after('price');
            $table->unique(['branch_id', 'type']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('assessment_number')->nullable()->after('booking_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('costs', function (Blueprint $table) {
            $table->dropUnique(['branch_id', 'type']);
            $table->dropColumn('type');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('assessment_number');
        });
    }
};
