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
        // table statuts
        Schema::table('tb_statuts', function (Blueprint $table) {
            $table->unsignedBigInteger('stat_created_by');
            $table->unsignedBigInteger('stat_updated_by')->nullable(); 
            $table->foreign('stat_created_by')->references('id')->on('users');
            $table->foreign('stat_updated_by')->references('id')->on('users');        
         });

         // table statuts
        Schema::table('tb_profils', function (Blueprint $table) {
            $table->unsignedBigInteger('prf_created_by');
            $table->unsignedBigInteger('prf_updated_by')->nullable(); 
            $table->foreign('prf_created_by')->references('id')->on('users');
            $table->foreign('prf_updated_by')->references('id')->on('users');        
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
