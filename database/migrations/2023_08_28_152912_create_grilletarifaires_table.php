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
        Schema::create('grilletarifaires', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement(); 
            $table->string('code',100)->nullable(); 
            $table->integer('annee')->default(0);
            $table->boolean('choix')->default(true);
            $table->unsignedBigInteger('rubrique_id'); 
            $table->unsignedBigInteger('gp_id'); 
            $table->integer('montant_base')->default(0);   
            $table->integer('montant_condition')->default(0); 
            $table->date('echeance')->nullable(); 
            $table->unsignedBigInteger('statut_id');   
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();  
            $table->foreign('rubrique_id')->references('id')->on('rubriques'); 
            $table->foreign('gp_id')->references('id')->on('groupepedagogiques');
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
        Schema::dropIfExists('grilletarifaires');
    }
};
