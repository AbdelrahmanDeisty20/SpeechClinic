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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('key_ar')->after('id');
            $table->string('key_en')->after('key_ar');
            $table->string('value_ar')->after('key_en');
            $table->string('value_en')->after('value_ar');
        });

        // Copy existing data to new columns
        \DB::table('settings')->update([
            'key_ar'   => \DB::raw('`key`'),
            'key_en'   => \DB::raw('`key`'),
            'value_ar' => \DB::raw('`value`'),
            'value_en' => \DB::raw('`value`'),
        ]);

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['key', 'value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('key')->after('id');
            $table->string('value')->after('key');
        });

        \DB::table('settings')->update([
            'key'   => \DB::raw('key_ar'),
            'value' => \DB::raw('value_ar'),
        ]);

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['key_ar', 'key_en', 'value_ar', 'value_en']);
        });
    }
};
