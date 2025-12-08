<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('type_media', function (Blueprint $table) {
            $table->id('id_type_media');
            $table->string('nom_media', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('type_media');
    }
};