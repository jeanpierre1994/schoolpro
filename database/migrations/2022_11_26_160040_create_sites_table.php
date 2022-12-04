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
        Schema::create('tb_sites', function (Blueprint $table) {
            $table->unsignedBigInteger("sit_id")->autoIncrement();
            $table->string('sit_sigle',100)->unique();
            $table->unsignedBigInteger('sit_ets');
            $table->string('sit_adresse',100);
            $table->string('sit_telephone',20);
            $table->string('sit_email',100)->nullable();
            $table->string('sit_manager',200)->nullable(); 
            $table->unsignedBigInteger('sit_statut_id');
            $table->unsignedBigInteger('sit_created_by');
            $table->unsignedBigInteger('sit_updated_by')->nullable(); 
            $table->foreign('sit_ets')->references('ets_id')->on('tb_etablissements');
            $table->foreign('sit_statut_id')->references('stat_id')->on('tb_statuts');
            $table->foreign('sit_created_by')->references('id')->on('users');
            $table->foreign('sit_updated_by')->references('id')->on('users'); 
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
        Schema::dropIfExists('sites');
    }
};
