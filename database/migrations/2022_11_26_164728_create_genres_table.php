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
        Schema::create('tb_genres', function (Blueprint $table) {
            $table->unsignedBigInteger("gen_id")->autoIncrement();
            $table->string('gen_libelle',20)->unique();
            $table->string('gen_description')->nullable(); 
            $table->unsignedBigInteger('gen_statut_id'); 
            $table->foreign('gen_statut_id')->references('stat_id')->on('tb_statuts');
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
        Schema::dropIfExists('genres');
    }
};
