<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id('id_commentaire');
            $table->text('texte');
            $table->integer('note')->nullable()->check('note >= 1 AND note <= 5');
            $table->timestamp('date')->useCurrent();
            
            // Clés étrangères
            $table->foreignId('id_utilisateur')->constrained('utilisateurs', 'id_utilisateur');
            $table->foreignId('id_contenu')->constrained('contenus', 'id_contenu');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commentaires');
    }
};