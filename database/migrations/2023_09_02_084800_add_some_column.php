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
        // add new column in table personne
        Schema::table('personnes', function (Blueprint $table) { 
            $table->unsignedBigInteger('parent_id')->nullable();  
            $table->foreign('parent_id')->references('id')->on('users');   
        });
        // add new column in table dossier and delete compte
        Schema::table('dossiers', function (Blueprint $table) { 
            $table->unsignedBigInteger('parent_id')->nullable();  
            $table->foreign('parent_id')->references('id')->on('users');   
            $table->unsignedBigInteger('portefeuille_id')->nullable();  
            $table->foreign('portefeuille_id')->references('id')->on('portefeuilles');  
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
