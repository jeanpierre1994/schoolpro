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
        Schema::create('echeanciers', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement(); 
            $table->string('code',100)->unique()->nullable();  
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('dossier_id'); 
            $table->unsignedBigInteger('lignetarif_id');  
            $table->integer('montant_rubrique')->default(0);   
            $table->integer('montant_payer')->default(0); 
            $table->integer('montant_restant')->default(0); 
            $table->integer('remise')->default(0); 
            $table->date('date_paiement')->nullable(); 
            $table->unsignedBigInteger('statutpaiement_id');   
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();  
            $table->foreign('dossier_id')->references('id')->on('dossiers'); 
            $table->foreign('lignetarif_id')->references('id')->on('lignetarifs');
            $table->foreign('statutpaiement_id')->references('id')->on('statutpaiements'); 
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
        Schema::dropIfExists('echeanciers');
    }
};
