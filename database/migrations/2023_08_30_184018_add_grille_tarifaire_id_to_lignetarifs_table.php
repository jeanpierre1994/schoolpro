<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lignetarifs', function (Blueprint $table) {
            $table->foreignId('grille_tarifaire_id')->references('id')->on('grilletarifaires');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lignetarifs', function (Blueprint $table) {
            //
        });
    }
};
