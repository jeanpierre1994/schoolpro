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
        Schema::table('groupepedagogiques', function (Blueprint $table) {  
           // $table->unsignedBigInteger('grilletarifaire_id');   
           // $table->foreign('grilletarifaire_id')->references('id')->on('grilletarifaires');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
