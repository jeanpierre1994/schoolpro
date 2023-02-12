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
        Schema::create('sites', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement();
            $table->string('sigle',100)->unique();
            $table->unsignedBigInteger('ets');
            $table->string('adresse',100);
            $table->string('telephone',20);
            $table->string('email',100)->nullable();
            $table->string('manager',200)->nullable(); 
            $table->unsignedBigInteger('statut_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable(); 
            $table->foreign('ets')->references('id')->on('etablissements');
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
        Schema::dropIfExists('sites');
    }
};
