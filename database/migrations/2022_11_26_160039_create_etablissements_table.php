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
        Schema::create('etablissements', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement();
            $table->string('sigle',100);
            $table->string('description',150);
            $table->string('adresse',200);
            $table->string('telephone',20);
            $table->string('dirigeant',150);
            $table->string('dirigeant_two',200)->nullable();
            $table->string('ifu',13); 
            $table->unsignedBigInteger('statutjuridique_id');
            $table->unsignedBigInteger('statut_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable(); 
            $table->foreign('statutjuridique_id')->references('id')->on('statutjuridiques');
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
        Schema::dropIfExists('etablissements');
    }
};
