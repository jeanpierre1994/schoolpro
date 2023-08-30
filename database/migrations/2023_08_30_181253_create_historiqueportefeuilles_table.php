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
        Schema::create('historiqueportefeuilles', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement();  
            $table->string('old_montant');  
            $table->string('new_montant');  
            $table->string('type');  
            $table->unsignedBigInteger('portefeuille_id');   
            $table->unsignedBigInteger('created_by');  
            $table->foreign('portefeuille_id')->references('id')->on('portefeuilles'); 
            $table->foreign('created_by')->references('id')->on('users'); 
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
        Schema::dropIfExists('historiqueportefeuilles');
    }
};
