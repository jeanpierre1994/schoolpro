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
        Schema::create('tb_personnes', function (Blueprint $table) {
            $table->unsignedBigInteger("pers_id")->autoIncrement();
            $table->string('pers_matricule',20)->unique();
            $table->string('pers_nom',100); 
            $table->string('pers_prenoms',100); 
            $table->string('pers_surnom',100)->nullable();
            $table->string('pers_nomjeunefille',100)->nullable(); 
            $table->unsignedBigInteger('pers_genre'); 
            $table->date('pers_ddn')->nullable(); 
            $table->date('pers_lieunais')->nullable(); 
            $table->date('pers_nationalite')->nullable(); 
            $table->string('pers_tel',20);  
            $table->string('pers_linkedin',100)->nullable(); 
            $table->string('pers_email',100); 
            $table->string('pers_adresse',100)->nullable(); 
            $table->date('pers_photo')->nullable(); 
            $table->boolean('pers_famille')->default(false);  
            $table->unsignedBigInteger('pers_statut_id');
            $table->unsignedBigInteger('pers_created_by');
            $table->unsignedBigInteger('pers_updated_by')->nullable(); 
            $table->foreign('pers_genre')->references('gen_id')->on('tb_genres');
            $table->foreign('pers_statut_id')->references('stat_id')->on('tb_statuts');
            $table->foreign('pers_created_by')->references('id')->on('users');
            $table->foreign('pers_updated_by')->references('id')->on('users'); 
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
