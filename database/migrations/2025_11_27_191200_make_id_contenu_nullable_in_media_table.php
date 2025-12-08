<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop existing foreign key/column if present, then recreate as nullable
        Schema::table('media', function (Blueprint $table) {
            try {
                $table->dropForeign(['id_contenu']);
            } catch (\Exception $e) {
                // ignore if foreign key doesn't exist
            }

            try {
                if (Schema::hasColumn('media', 'id_contenu')) {
                    $table->dropColumn('id_contenu');
                }
            } catch (\Exception $e) {
                // ignore if drop fails
            }
        });

        Schema::table('media', function (Blueprint $table) {
            $table->foreignId('id_contenu')->nullable()->constrained('contenus', 'id_contenu')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            try { $table->dropForeign(['id_contenu']); } catch (\Exception $e) { /* ignore */ }
            try { if (Schema::hasColumn('media', 'id_contenu')) { $table->dropColumn('id_contenu'); } } catch (\Exception $e) { /* ignore */ }
        });

        Schema::table('media', function (Blueprint $table) {
            $table->foreignId('id_contenu')->constrained('contenus', 'id_contenu');
        });
    }
};
