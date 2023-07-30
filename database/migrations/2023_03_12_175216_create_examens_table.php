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
        Schema::create('examens', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement(); 
            $table->string('code_examen')->unique();    
            $table->date('date_debut');    
            $table->date('date_fin');        
            //$table->unsignedBigInteger('groupepedagogique_id');  
            $table->unsignedBigInteger('statut_id');  
            $table->unsignedBigInteger('examentype_id');  
            $table->string('libelle',150);  
            $table->string('commentaire',255)->nullable();
            $table->integer('annee_academique')->default(0);  
            $table->integer('min_moyenne')->default(0); 
            $table->integer('max_moyenne')->default(0); 
            $table->integer('ponderation')->default(0); 
            $table->integer('note_max')->default(0); 
            $table->integer('absent')->default(0);   
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();  
            $table->foreign('statut_id')->references('id')->on('statuts'); 
            $table->foreign('examentype_id')->references('id')->on('examentypes');  
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users'); 
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
        Schema::dropIfExists('examens');
    }
};
