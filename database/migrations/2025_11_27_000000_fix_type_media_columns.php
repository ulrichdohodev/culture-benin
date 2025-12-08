<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('type_media', function (Blueprint $table) {
            // Renommer nom_media en nom_type_media
            $table->renameColumn('nom_media', 'nom_type_media');
        });
        
        // Ajouter description si elle n'existe pas
        if (!Schema::hasColumn('type_media', 'description')) {
            Schema::table('type_media', function (Blueprint $table) {
                $table->text('description')->nullable();
            });
        }
    }

    public function down()
    {
        Schema::table('type_media', function (Blueprint $table) {
            $table->renameColumn('nom_type_media', 'nom_media');
            $table->dropColumn('description');
        });
    }
};
