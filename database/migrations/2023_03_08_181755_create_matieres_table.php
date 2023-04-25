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
        Schema::create('matieres', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement();
            $table->unsignedBigInteger('groupepedagogique_id');   
            $table->unsignedBigInteger('section_id')->nullable();  
            $table->unsignedBigInteger('categorie_id')->nullable();  
            $table->string('sigle',100);  
            $table->string('libelle',100); 
            $table->integer('note_max')->default(0); 
            $table->integer('moyenne')->default(0); 
            $table->integer('coef')->default(0);  
            $table->unsignedBigInteger('statut_id');   
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable(); 
            $table->foreign('groupepedagogique_id')->references('id')->on('groupepedagogiques'); 
            $table->foreign('section_id')->references('id')->on('sections'); 
            $table->foreign('categorie_id')->references('id')->on('categories'); 
            $table->foreign('statut_id')->references('id')->on('statuts'); 
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
        Schema::dropIfExists('matieres');
    }
};
