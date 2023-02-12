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
            $table->string('site_web',255)->nullable()->after("lien_parental"); 
            $table->string('lien_facebook',255)->nullable()->after("lien_parental"); 
            $table->string('lien_github',255)->nullable()->after("lien_facebook"); 
            $table->string('lien_linkedin',255)->nullable()->after("lien_github");  
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
