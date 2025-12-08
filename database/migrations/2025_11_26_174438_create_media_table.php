<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id('id_media');
            $table->string('chemin');
            $table->text('description')->nullable();
            
            // Clés étrangères
            $table->foreignId('id_contenu')->constrained('contenus', 'id_contenu');
            $table->foreignId('id_type_media')->constrained('type_media', 'id_type_media');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('media');
    }
};