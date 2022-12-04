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
        Schema::create('tb_etablissements', function (Blueprint $table) {
            $table->unsignedBigInteger("ets_id")->autoIncrement();
            $table->string('ets_sigle',100);
            $table->string('ets_description',150);
            $table->string('ets_adresse',200);
            $table->string('ets_telephone',20);
            $table->string('ets_dirigeant_one',150);
            $table->string('ets_dirigeant_two',200)->nullable();
            $table->string('ets_ifu',13); 
            $table->unsignedBigInteger('ets_statutjuridique_id');
            $table->unsignedBigInteger('ets_statut_id');
            $table->unsignedBigInteger('ets_created_by');
            $table->unsignedBigInteger('ets_updated_by')->nullable(); 
            $table->foreign('ets_statutjuridique_id')->references('sj_id')->on('tb_statutjuridiques');
            $table->foreign('ets_statut_id')->references('stat_id')->on('tb_statuts');
            $table->foreign('ets_created_by')->references('id')->on('users');
            $table->foreign('ets_updated_by')->references('id')->on('users'); 
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
        Schema::dropIfExists('etablissements');
    }
};
