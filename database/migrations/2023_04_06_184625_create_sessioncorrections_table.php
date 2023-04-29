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
        Schema::create('sessioncorrections', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement();     
            $table->unsignedBigInteger('examen_prog_id');    
            $table->unsignedBigInteger('professeur_id');   
            $table->unsignedBigInteger('statutvalidation_id')->nullable();    
            $table->unsignedBigInteger('created_by');    
            $table->unsignedBigInteger('updated_by')->nullable();   
            $table->foreign('examen_prog_id')->references('id')->on('examenprogs');
            $table->foreign('professeur_id')->references('id')->on('users');
            $table->foreign('statutvalidation_id')->references('id')->on('statutvalidations');
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
        Schema::dropIfExists('sessioncorrections');
    }
};
