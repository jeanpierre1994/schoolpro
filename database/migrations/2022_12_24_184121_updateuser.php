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
        Schema::table('users', function (Blueprint $table) {   
            $table->unsignedBigInteger('profil_id')->nullable()->after("name"); 
            $table->foreign('profil_id')->references('id')->on('profils');
            $table->string('code_email')->nullable()->after("profil_id");  
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
