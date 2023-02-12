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
        Schema::table('personnes', function (Blueprint $table) {   
            $table->unsignedBigInteger('lien_parental')->nullable()->after("statut_id"); 
            $table->foreign('lien_parental')->references('id')->on('lienparentals'); 
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
