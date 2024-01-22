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
        Schema::create('synthesebulletins', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->autoIncrement();    
            $table->unsignedBigInteger('groupepedagogique_id');  
            $table->unsignedBigInteger('etudiant_id');       
            $table->double('moyenne')->nullable();       
            $table->string('code_bulletin')->nullable(); 
            $table->string('appreciation_fr')->nullable(); 
            $table->string('appreciation_en')->nullable(); 
            $table->string('rang')->nullable();     
            $table->boolean('cloture')->default(false);     
            $table->foreign('groupepedagogique_id')->references('id')->on('groupepedagogiques');
            $table->foreign('etudiant_id')->references('id')->on('dossiers'); 
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
        Schema::dropIfExists('synthesebulletins');
    }
};
