<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (! Schema::hasColumn('categories', 'name_ar')) {
                $table->string('name_ar')->nullable()->after('name');
            }

            if (! Schema::hasColumn('categories', 'description_ar')) {
                $table->text('description_ar')->nullable()->after('description');
            }
        });

        $catalogPath = base_path('lang/ar/catalog.php');

        if (! is_file($catalogPath)) {
            return;
        }

        $catalog = require $catalogPath;

        foreach (($catalog['categories'] ?? []) as $slug => $translation) {
            DB::table('categories')
                ->where('slug', $slug)
                ->update([
                    'name_ar' => $translation['name'] ?? null,
                    'description_ar' => $translation['description'] ?? null,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'description_ar')) {
                $table->dropColumn('description_ar');
            }

            if (Schema::hasColumn('categories', 'name_ar')) {
                $table->dropColumn('name_ar');
            }
        });
    }
};
