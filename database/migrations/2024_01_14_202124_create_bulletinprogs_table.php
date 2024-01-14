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
        Schema::create('bulletinprogs', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement(); 
            $table->string('annee',10);   
            $table->string('code',100)->unique();   
            $table->string('libelle_primaire',150);   
            $table->string('libelle_secondaire',150)->nullable();   
            $table->date('date_debut');  
            $table->date('date_fin'); 
            $table->string('type_bulletin',150);    
            $table->string('statut',10)->default("ACTIF");
            $table->unsignedBigInteger('pole_id')->nullable();  
            $table->unsignedBigInteger('filiere_id')->nullable();  
            $table->unsignedBigInteger('cycle_id')->nullable();   
            $table->unsignedBigInteger('groupepedagogique_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();   
            $table->foreign('pole_id')->references('id')->on('poles'); 
            $table->foreign('filiere_id')->references('id')->on('filieres'); 
            $table->foreign('cycle_id')->references('id')->on('cycles');  
            $table->foreign('groupepedagogique_id')->references('id')->on('groupepedagogiques');   
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
        Schema::dropIfExists('bulletinprogs');
    }
};
