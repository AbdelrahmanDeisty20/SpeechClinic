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
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign keys if they exist
            $table->dropForeign(['nationality_id']);
            $table->dropForeign(['gender_id']);
            
            // Drop columns
            $table->dropColumn(['age', 'gender_id', 'nationality_id']);
        });

        Schema::dropIfExists('nationalities');
        Schema::dropIfExists('genders');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->timestamps();
        });

        Schema::create('nationalities', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('age')->nullable();
            $table->foreignId('gender_id')->nullable()->constrained();
            $table->foreignId('nationality_id')->nullable()->constrained();
        });
    }
};
