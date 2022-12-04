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
        Schema::create('tb_statutjuridiques', function (Blueprint $table) {
            $table->unsignedBigInteger("sj_id")->autoIncrement();
            $table->string('sj_libelle',20)->unique();
            $table->string('sj_description')->nullable(); 
            $table->unsignedBigInteger('sj_statut_id');
            $table->unsignedBigInteger('sj_created_by');
            $table->unsignedBigInteger('sj_updated_by')->nullable(); 
            $table->foreign('sj_statut_id')->references('stat_id')->on('tb_statuts');
            $table->foreign('sj_created_by')->references('id')->on('users');
            $table->foreign('sj_updated_by')->references('id')->on('users'); 
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
        Schema::dropIfExists('statutjuridiques');
    }
};
