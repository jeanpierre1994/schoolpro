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
        Schema::create('examenprogs', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement();   
            $table->unsignedBigInteger('examen_id');  
            $table->dateTime('date_debut');    
            $table->dateTime('date_fin');     
            $table->integer('annee_academique')->default(0);   
            $table->unsignedBigInteger('matiere_id');
            $table->string('commentaire',255)->nullable();  
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();  
            $table->foreign('examen_id')->references('id')->on('examens'); 
            $table->foreign('matiere_id')->references('id')->on('matieres');  
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
        Schema::dropIfExists('examenprogs');
    }
};
