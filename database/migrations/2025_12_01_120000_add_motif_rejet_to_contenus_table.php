<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contenus', function (Blueprint $table) {
            if (!Schema::hasColumn('contenus', 'motif_rejet')) {
                $table->text('motif_rejet')->nullable()->after('statut');
            }
        });
    }

    public function down()
    {
        Schema::table('contenus', function (Blueprint $table) {
            if (Schema::hasColumn('contenus', 'motif_rejet')) {
                $table->dropColumn('motif_rejet');
            }
        });
    }
};
