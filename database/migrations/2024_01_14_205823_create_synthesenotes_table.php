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
        Schema::create('synthesenotes', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement();      
            $table->unsignedBigInteger('examen_prog_id');        
            $table->unsignedBigInteger('groupepedagogique_id');  
            $table->unsignedBigInteger('etudiant_id');      
            $table->string('note_first')->nullable();     
            $table->string('note_second')->nullable();     
            $table->string('code_bulletin')->nullable();     
            $table->string('rang')->nullable();      
            $table->foreign('examen_prog_id')->references('id')->on('examenprogs');
            $table->foreign('groupepedagogique_id')->references('id')->on('groupepedagogiques');
            $table->foreign('etudiant_id')->references('id')->on('dossiers'); 
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
        Schema::dropIfExists('synthesenotes');
    }
};
