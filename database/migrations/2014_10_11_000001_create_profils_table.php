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
        Schema::create('profils', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement();
            $table->string('libelle',20)->unique();
            $table->string('description')->nullable(); 
            $table->unsignedBigInteger('statut_id'); 
            $table->foreign('statut_id')->references('id')->on('statuts');
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
        Schema::dropIfExists('profils');
    }
};
