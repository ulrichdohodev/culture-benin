<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contenus', function (Blueprint $table) {
            $table->id('id_contenu');
            $table->string('titre', 255);
            $table->text('texte');
            $table->timestamp('date_creation')->useCurrent();
            $table->enum('statut', ['brouillon', 'en_attente', 'valide', 'rejete'])->default('brouillon');
            $table->timestamp('date_validation')->nullable();
            
            // Clé étrangère pour le contenu parent (hiérarchie)
            $table->foreignId('parent_id')->nullable()->constrained('contenus', 'id_contenu');
            
            // Autres clés étrangères
            $table->foreignId('id_region')->constrained('regions', 'id_region');
            $table->foreignId('id_langue')->constrained('langues', 'id_langue');
            $table->foreignId('id_type_contenu')->constrained('type_contenus', 'id_type_contenu');
            $table->foreignId('id_auteur')->constrained('utilisateurs', 'id_utilisateur');
            $table->foreignId('id_moderateur')->nullable()->constrained('utilisateurs', 'id_utilisateur');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contenus');
    }
};