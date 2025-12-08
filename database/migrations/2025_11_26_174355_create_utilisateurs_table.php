<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id('id_utilisateur');
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email')->unique();
            $table->string('mot_de_passe');
            $table->enum('sexe', ['M', 'F']);
            $table->date('date_naissance');
            $table->timestamp('date_inscription')->useCurrent();
            $table->enum('statut', ['actif', 'inactif', 'suspendu'])->default('actif');
            $table->string('photo')->nullable();
            
            // Clés étrangères
            $table->foreignId('id_role')->constrained('roles', 'id_role');
            $table->foreignId('id_langue')->constrained('langues', 'id_langue');
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('utilisateurs');
    }
};