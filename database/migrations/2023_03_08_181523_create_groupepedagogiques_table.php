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
        Schema::create('groupepedagogiques', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement(); 
            $table->unsignedBigInteger('site_id');  
            $table->unsignedBigInteger('pole_id');  
            $table->unsignedBigInteger('filiere_id');  
            $table->unsignedBigInteger('cycle_id');   
            $table->unsignedBigInteger('niveau_id');
            $table->string('libelle_classe',20);    
            $table->string('description_classe',100)->nullable();   
            $table->integer('effectif')->default(0);  
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();  
            $table->foreign('site_id')->references('id')->on('sites'); 
            $table->foreign('pole_id')->references('id')->on('poles'); 
            $table->foreign('filiere_id')->references('id')->on('filieres'); 
            $table->foreign('cycle_id')->references('id')->on('cycles');  
            $table->foreign('niveau_id')->references('id')->on('niveaux');   
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
        Schema::dropIfExists('groupepedagogiques');
    }
};
