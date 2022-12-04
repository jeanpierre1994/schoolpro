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
        Schema::create('tb_profils', function (Blueprint $table) {
            $table->unsignedBigInteger("prf_id")->autoIncrement();
            $table->string('prf_libelle',20)->unique();
            $table->string('prf_description')->nullable(); 
            $table->unsignedBigInteger('prf_statut_id'); 
            $table->foreign('prf_statut_id')->references('stat_id')->on('tb_statuts');
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
