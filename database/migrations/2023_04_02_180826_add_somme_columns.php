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
        Schema::table('examens', function (Blueprint $table) {  
            $table->unsignedBigInteger('statuttraitement_id')->nullable()->after("absent"); 
            $table->unsignedBigInteger('validateur_id')->nullable()->after("statuttraitement_id"); 
            $table->foreign('statuttraitement_id')->references('id')->on('statuttraitements');
            $table->foreign('validateur_id')->references('id')->on('users');
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
