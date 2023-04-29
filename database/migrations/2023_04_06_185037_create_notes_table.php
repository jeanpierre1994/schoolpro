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
        Schema::create('notes', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement();     
            $table->unsignedBigInteger('sessioncorrection_id');     
            $table->unsignedBigInteger('examen_prog_id');        
            $table->unsignedBigInteger('groupepedagogique_id');  
            $table->unsignedBigInteger('etudiant_id');     
            $table->unsignedBigInteger('professeur_id');  
            $table->string('note_examen')->nullable();       
            $table->string('note')->nullable();     
            $table->string('commentaitaire')->nullable(); 
            $table->unsignedBigInteger('statutvalidation_id')->nullable();   
            $table->unsignedBigInteger('created_by');     
            $table->foreign('sessioncorrection_id')->references('id')->on('sessioncorrections');
            $table->foreign('examen_prog_id')->references('id')->on('examenprogs');
            $table->foreign('groupepedagogique_id')->references('id')->on('groupepedagogiques');
            $table->foreign('etudiant_id')->references('id')->on('dossiers');
            $table->foreign('professeur_id')->references('id')->on('users');
            $table->foreign('statutvalidation_id')->references('id')->on('statutvalidations');
            $table->foreign('created_by')->references('id')->on('users'); 
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
        Schema::dropIfExists('notes');
    }
};
