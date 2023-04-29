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
        Schema::create('etudiants', function (Blueprint $table) { 
                $table->unsignedBigInteger("id")->autoIncrement();        
                $table->string('matricule',20); 
                $table->unsignedBigInteger('dossier_id');        
                $table->unsignedBigInteger('validateur_id');     
                $table->string('commentaitaire')->nullable(); 
                $table->unsignedBigInteger('statutvalidation_id')->nullable();    
                $table->foreign('statutvalidation_id')->references('id')->on('statutvalidations');
                $table->foreign('validateur_id')->references('id')->on('users'); 
                $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
};
