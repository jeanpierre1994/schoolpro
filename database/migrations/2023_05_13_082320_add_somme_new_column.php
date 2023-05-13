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
        Schema::table('poles', function (Blueprint $table) {  
            $table->string('libelle_secondaire')->nullable()->after("libelle"); 
        });
        Schema::table('filieres', function (Blueprint $table) {  
            $table->string('libelle_secondaire')->nullable()->after("libelle"); 
        });
        Schema::table('niveaux', function (Blueprint $table) {  
            $table->string('libelle_secondaire')->nullable()->after("libelle"); 
        });
        Schema::table('cycles', function (Blueprint $table) {  
            $table->string('libelle_secondaire')->nullable()->after("libelle"); 
        });
        Schema::table('sections', function (Blueprint $table) {  
            $table->string('libelle_secondaire')->nullable()->after("libelle"); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
