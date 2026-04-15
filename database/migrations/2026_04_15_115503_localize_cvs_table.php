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
        Schema::table('cvs', function (Blueprint $table) {
            if (Schema::hasColumn('cvs', 'name')) {
                $table->renameColumn('name', 'name_ar');
            }
            
            $table->string('name_en')->nullable()->after('name_ar');
            $table->string('title_ar')->nullable()->after('name_en');
            $table->string('title_en')->nullable()->after('title_ar');
            $table->text('description_ar')->nullable()->after('title_en');
            $table->text('description_en')->nullable()->after('description_ar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            if (Schema::hasColumn('cvs', 'name_ar')) {
                $table->renameColumn('name_ar', 'name');
            }
            
            $table->dropColumn([
                'name_en',
                'title_ar',
                'title_en',
                'description_ar',
                'description_en',
            ]);
        });
    }
};