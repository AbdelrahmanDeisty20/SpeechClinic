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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->date('date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->enum('status', ['on_time', 'late', 'absent'])->default('on_time');
            $table->timestamps();

            // Ensure one record per day per user per branch (or just per user per day)
            // Usually, one check-in per day total is standard, but some clinics have multiple branches.
            // I'll stick to one record per user/date for simplicity unless they move between branches.
            $table->unique(['user_id', 'date', 'branch_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
