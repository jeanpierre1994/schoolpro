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
            $table->unsignedBigInteger('etablissement_id')->nullable()->after("id"); 
            $table->foreign('etablissement_id')->references('id')->on('etablissements');
            $table->unsignedBigInteger('site_id')->nullable()->after("id"); 
            $table->foreign('site_id')->references('id')->on('sites');
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
