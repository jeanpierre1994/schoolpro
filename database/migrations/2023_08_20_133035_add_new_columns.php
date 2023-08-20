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
        Schema::table('etudiants', function (Blueprint $table) {  
            $table->integer('compte')->default(0)->after("dossier_id"); 
        });

        // paiement

        Schema::create('paiements', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();  
            $table->string('reference',100);   
            $table->string('telephone',100)->nullable();   
            $table->string('email',100)->nullable();   
            $table->integer('montant_a_payer')->default(0);    
            $table->integer('montant_paye')->default(0);  
            $table->string('num_transaction',100)->nullable();   
            $table->string('statut_transaction')->nullable(); 
            $table->string('mod_paiement')->nullable();
            $table->unsignedBigInteger('enregistrer_par')->nullable();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->string('statut_traitement')->nullable();
            $table->dateTime('date_traitement')->nullable();
            $table->text('commentaire')->nullable();
            $table->unsignedBigInteger('agent_traiteur')->nullable();
            $table->foreign('agent_traiteur')->references('id')->on('users'); 
            $table->foreign('etudiant_id')->references('id')->on('etudiants'); 
            $table->foreign('enregistrer_par')->references('id')->on('users'); 
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
        //
    }
};
