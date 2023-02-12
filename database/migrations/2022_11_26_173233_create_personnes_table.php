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
        Schema::create('personnes', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement();
            $table->string('matricule',20)->unique();
            $table->string('nom',100); 
            $table->string('prenoms',100); 
            $table->string('surnom',100)->nullable();
            $table->string('nomjeunefille',100)->nullable(); 
            $table->unsignedBigInteger('genre'); 
            $table->date('ddn')->nullable(); 
            $table->string('lieunais')->nullable(); 
            $table->string('nationalite')->nullable(); 
            $table->string('tel',20);  
            $table->string('linkedin',100)->nullable(); 
            $table->string('email',100); 
            $table->string('adresse',100)->nullable(); 
            $table->string('photo')->nullable(); 
            $table->boolean('famille')->default(false);  
            $table->unsignedBigInteger('statut_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable(); 
            $table->foreign('genre')->references('id')->on('genres');
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
        Schema::dropIfExists('personnes');
    }
};
