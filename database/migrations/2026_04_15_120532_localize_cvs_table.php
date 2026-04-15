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
        // 1. Handle renaming 'name' to 'name_ar' first to ensure subsequent 'after' clauses work
        if (Schema::hasColumn('cvs', 'name') && !Schema::hasColumn('cvs', 'name_ar')) {
            Schema::table('cvs', function (Blueprint $table) {
                $table->renameColumn('name', 'name_ar');
            });
        }

        // 2. Add 'name_en' column if it doesn't exist
        if (!Schema::hasColumn('cvs', 'name_en')) {
            Schema::table('cvs', function (Blueprint $table) {
                $table->string('name_en')->nullable()->after(Schema::hasColumn('cvs', 'name_ar') ? 'name_ar' : 'id');
            });
        }

        // 3. Add other localized columns if they don't exist
        Schema::table('cvs', function (Blueprint $table) {
            if (!Schema::hasColumn('cvs', 'title_ar')) {
                $table->string('title_ar')->nullable()->after('name_en');
            }
            if (!Schema::hasColumn('cvs', 'title_en')) {
                $table->string('title_en')->nullable()->after('title_ar');
            }
            if (!Schema::hasColumn('cvs', 'description_ar')) {
                $table->text('description_ar')->nullable()->after('title_en');
            }
            if (!Schema::hasColumn('cvs', 'description_en')) {
                $table->text('description_en')->nullable()->after('description_ar');
            }
        });

        // 4. Drop old columns only if they exist
        $columnsToDrop = array_filter(['email', 'phone', 'cv'], function($column) {
            return Schema::hasColumn('cvs', $column);
        });

        if (!empty($columnsToDrop)) {
            Schema::table('cvs', function (Blueprint $table) use ($columnsToDrop) {
                $table->dropColumn($columnsToDrop);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            // Restore 'name' from 'name_ar' if possible
            if (Schema::hasColumn('cvs', 'name_ar') && !Schema::hasColumn('cvs', 'name')) {
                $table->renameColumn('name_ar', 'name');
            }

            // Drop localized columns only if they exist
            $columnsToDrop = array_filter([
                'name_en',
                'title_ar',
                'title_en',
                'description_ar',
                'description_en',
            ], function($column) {
                return Schema::hasColumn('cvs', $column);
            });

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }

            // Restore dropped columns only if they don't exist
            if (!Schema::hasColumn('cvs', 'email')) {
                $table->string('email')->after(Schema::hasColumn('cvs', 'name') ? 'name' : 'id');
            }
            if (!Schema::hasColumn('cvs', 'phone')) {
                $table->string('phone')->after('email');
            }
            if (!Schema::hasColumn('cvs', 'cv')) {
                $table->text('cv')->after('phone');
            }
        });
    }
};
