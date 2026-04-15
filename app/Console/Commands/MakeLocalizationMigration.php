<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('app:make-localization-migration {table}')]
#[Description('Create a localization migration (rename name to name_ar, add name_en, title_ar/en, description_ar/en)')]
class MakeLocalizationMigration extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->argument('table');
        $fileName = date('Y_m_d_His') . '_localize_' . $table . '_table.php';
        $path = database_path('migrations/' . $fileName);

        $stub = <<<'PHP'
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
        Schema::table('{{table}}', function (Blueprint $table) {
            if (Schema::hasColumn('{{table}}', 'name')) {
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
        Schema::table('{{table}}', function (Blueprint $table) {
            if (Schema::hasColumn('{{table}}', 'name_ar')) {
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
PHP;

        $content = str_replace('{{table}}', $table, $stub);

        file_put_contents($path, $content);

        $this->info("Migration created: {$fileName}");
    }
}
