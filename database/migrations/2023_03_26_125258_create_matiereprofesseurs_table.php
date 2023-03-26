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
        Schema::create('matiereprofesseurs', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement();   
            $table->unsignedBigInteger('matiere_id');    
            $table->unsignedBigInteger('professeur_id');   
            $table->unsignedBigInteger('statut_id');    
            $table->unsignedBigInteger('created_by');    
            $table->unsignedBigInteger('updated_by');    
            $table->foreign('matiere_id')->references('id')->on('matieres');
            $table->foreign('professeur_id')->references('id')->on('users');
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
        Schema::dropIfExists('matiereprofesseurs');
    }
};
