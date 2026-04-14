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
        Schema::table('branches', function (Blueprint $table) {
            $table->string('name_ar')->after('id');
            $table->string('name_en')->after('name_ar');
        });

        // Copy existing name to both columns
        \DB::table('branches')->update([
            'name_ar' => \DB::raw('name'),
            'name_en' => \DB::raw('name'),
        ]);

        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->string('name')->after('id');
        });

        \DB::table('branches')->update([
            'name' => \DB::raw('name_ar'),
        ]);

        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('name_ar');
            $table->dropColumn('name_en');
        });
    }
};
