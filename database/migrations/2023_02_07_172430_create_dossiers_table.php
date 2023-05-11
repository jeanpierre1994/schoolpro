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
        Schema::create('dossiers', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement(); 
            $table->string('code',20)->nullable()->unique(); 
            $table->unsignedBigInteger('personne_id');  
            $table->unsignedBigInteger('site_id');  
            $table->unsignedBigInteger('pole_id');  
            $table->unsignedBigInteger('filiere_id');  
            $table->unsignedBigInteger('cycle_id');   
            $table->unsignedBigInteger('niveau_id');  
            $table->string('annee',4); 
            $table->unsignedBigInteger('typesponsor_id');  
            $table->string('sponsor',255)->nullable(); 
            $table->boolean('parent_created')->default(false);  
            $table->unsignedBigInteger('statuttraitement_id')->nullable();    
            $table->string('commentaire',255)->nullable();     
            $table->string('date_traitement',255)->nullable();
            $table->unsignedBigInteger('validateur_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable(); 
            $table->foreign('personne_id')->references('id')->on('personnes')->onDelete('cascade'); 
            $table->foreign('site_id')->references('id')->on('sites'); 
            $table->foreign('pole_id')->references('id')->on('poles'); 
            $table->foreign('filiere_id')->references('id')->on('filieres'); 
            $table->foreign('cycle_id')->references('id')->on('cycles');  
            $table->foreign('niveau_id')->references('id')->on('niveaux'); 
            $table->foreign('typesponsor_id')->references('id')->on('typesponsors'); 
            $table->foreign('validateur_id')->references('id')->on('users'); 
            $table->foreign('statuttraitement_id')->references('id')->on('statuttraitements'); 
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
        Schema::dropIfExists('dossiers');
    }
};
