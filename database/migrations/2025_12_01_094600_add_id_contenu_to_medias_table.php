<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('medias', function (Blueprint $table) {
            // Ajouter la colonne id_contenu permettant de lier un media à un contenu
            $table->unsignedBigInteger('id_contenu')->nullable()->after('description');

            // Ajouter la contrainte FK si la table contenus existe
            if (Schema::hasTable('contenus')) {
                $table->foreign('id_contenu')->references('id_contenu')->on('contenus')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('medias', function (Blueprint $table) {
            if (Schema::hasColumn('medias', 'id_contenu')) {
                // Drop FK if exists (MySQL ignores if not exists)
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $foreignKeys = [];
                try {
                    $foreignKeys = $sm->listTableForeignKeys('medias');
                } catch (\Exception $e) {
                    // ignore
                }

                foreach ($foreignKeys as $fk) {
                    $localColumns = $fk->getLocalColumns();
                    if (in_array('id_contenu', $localColumns)) {
                        $table->dropForeign($fk->getName());
                    }
                }

                $table->dropColumn('id_contenu');
            }
        });
    }
};
