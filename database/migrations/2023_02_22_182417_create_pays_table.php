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
        Schema::create('pays', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement();  
            $table->text('nom_pays');
            $table->text('code_iso');
            $table->string('indicatif', 50)->nullable();
            $table->text('nationalite')->nullable();
            $table->string('flag', 255)->nullable();
            $table->text('coordonnee_maps')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('pays');
    }
};
