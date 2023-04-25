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
        Schema::table('dossiers', function (Blueprint $table) {  
            $table->unsignedBigInteger('groupepedagogique_id')->nullable()->after("filiere_id");    
            $table->foreign('groupepedagogique_id')->references('id')->on('groupepedagogiques'); 
        });

        Schema::table('etudiants', function (Blueprint $table) {  
            $table->unsignedBigInteger('groupepedagogique_id')->nullable()->after("dossier_id");    
            $table->foreign('dossier_id')->references('id')->on('dossiers'); 
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
