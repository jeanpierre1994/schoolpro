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
        Schema::create('historiquepaiementecheanciers', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement(); 
            $table->string('code',100)->nullable();   
            $table->unsignedBigInteger('echeancier_id');    
            $table->integer('montant_payer')->default(0); 
            $table->integer('montant_restant')->default(0); 
            $table->date('date_paiement')->nullable();   
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();  
            $table->foreign('echeancier_id')->references('id')->on('echeanciers');   
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
        Schema::dropIfExists('historiquepaiementecheanciers');
    }
};
