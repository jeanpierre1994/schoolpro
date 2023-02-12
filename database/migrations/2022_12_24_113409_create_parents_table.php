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
        Schema::create('parents', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement(); 
            $table->string('nom',100); 
            $table->string('prenoms',100);  
            $table->unsignedBigInteger('genre');  
            $table->string('nationalite')->nullable(); 
            $table->string('tel',20);   
            $table->string('email',100); 
            $table->string('adresse',100)->nullable(); 
            $table->string('photo')->nullable();   
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable(); 
            $table->foreign('genre')->references('id')->on('genres'); 
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
        Schema::dropIfExists('parents');
    }
};
