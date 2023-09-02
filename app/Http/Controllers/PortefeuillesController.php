<?php

namespace App\Http\Controllers;

use App\Models\Historiqueportefeuilles;
use App\Models\Paiements;
use App\Models\Portefeuilles;
use Illuminate\Http\Request;

class PortefeuillesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rechargePortefeuilleParent(Request $request,$id, $reference)
    {   
        $user = Auth()->user();
        $paiement = Paiements::where("reference",$reference)->first();
        $portefeuille = Portefeuilles::find($id);
        return view("frontend.paiements.recharge_portefeuille_parent", compact("portefeuille","paiement"));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rechargePortefeuilleEtudiant(Request $request,$id, $reference)
    {   
        $user = Auth()->user();
        $paiement = Paiements::where("reference",$reference)->first();
        $portefeuille = Portefeuilles::find($id);
        return view("frontend.paiements.recharge_portefeuille_etudiant", compact("portefeuille","paiement"));
    }



    public function rechargePortefeuilleParentStore(Request $request, $id, $reference, $code = null)
    {
        
        $code = $_GET['transaction_id'];
        $transactionId = $code;

        // $statut_sandbox = env("KKIAPAY_SANDBOX");

        //if ($statut_sandbox) {
        $public_key = env("KKIAPAY_SANDBOX_PUBLIC_KEY");
        $private_key = env("KKIAPAY_SANDBOX_PRIVATE_KEY");
        $secret = env("KKIAPAY_SANDBOX_SECRET_KEY");
        /*} else {

            $public_key = env("KKIAPAY_LIVE_PUBLIC_KEY");
            $private_key = env("KKIAPAY_LIVE_PRIVATE_KEY");
            $secret = env("KKIAPAY_LIVE_SECRET_KEY");
        }*/


        //$kkiapay = new \Kkiapay\Kkiapay($public_key, $private_key, $secret, $sandbox=true);
        /*$kkiapay = new \Kkiapay\Kkiapay(
            $public_key,
            $private_key,
            $secret,
            $statut_sandbox
        );

        $frais_transaction = 0;
        $statut_transaction = $kkiapay->verifyTransaction($transactionId)->status;
*/
        // mise à jour de la table paiement
        $paiement = Paiements::where('reference', $reference)->get()->first();
        $paiement->setAttribute('num_transaction', $code);
        $paiement->setAttribute('statut_transaction', $code);
        $paiement->setAttribute('statut_traitement', "VALIDE"); // à revoir
        $paiement->setAttribute('updated_at', date('Y-m-d H:i:s'));
        $paiement->update();
        
        $portefeuille = Portefeuilles::find($id);

        // enregistrement historique paiement 
        $user = auth()->user();
        $historique = new Historiqueportefeuilles();
        $historique->setAttribute("old_montant", $portefeuille->montant);
        $historique->setAttribute("new_montant", $paiement->montant_paye);
        $historique->setAttribute("type", "CREDIT"); // CREDIT ou DEBIT
        $historique->setAttribute("portefeuille_id", $portefeuille->id);
        $historique->setAttribute("created_by", $user->id);
        $historique->save();

          // update portefeuille
          $new_montant = $portefeuille->montant + $paiement->montant_paye;
          $portefeuille->setAttribute("montant", $new_montant);
          $portefeuille->setAttribute("updated_at", Date("Y-m-d H:i:s"));
          $portefeuille->update(); 

 
        // redirection
        return redirect()->route("parent.compte")->with("success", "Opération effectuée avec succès.");
    }

    
    public function rechargePortefeuilleEtudiantStore(Request $request, $id, $reference, $code = null)
    {
        
        $code = $_GET['transaction_id'];
        $transactionId = $code;

        // $statut_sandbox = env("KKIAPAY_SANDBOX");

        //if ($statut_sandbox) {
        $public_key = env("KKIAPAY_SANDBOX_PUBLIC_KEY");
        $private_key = env("KKIAPAY_SANDBOX_PRIVATE_KEY");
        $secret = env("KKIAPAY_SANDBOX_SECRET_KEY");
        /*} else {

            $public_key = env("KKIAPAY_LIVE_PUBLIC_KEY");
            $private_key = env("KKIAPAY_LIVE_PRIVATE_KEY");
            $secret = env("KKIAPAY_LIVE_SECRET_KEY");
        }*/


        //$kkiapay = new \Kkiapay\Kkiapay($public_key, $private_key, $secret, $sandbox=true);
        /*$kkiapay = new \Kkiapay\Kkiapay(
            $public_key,
            $private_key,
            $secret,
            $statut_sandbox
        );

        $frais_transaction = 0;
        $statut_transaction = $kkiapay->verifyTransaction($transactionId)->status;
*/
        // mise à jour de la table paiement
        $paiement = Paiements::where('reference', $reference)->get()->first();
        $paiement->setAttribute('num_transaction', $code);
        $paiement->setAttribute('statut_transaction', $code);
        $paiement->setAttribute('statut_traitement', "VALIDE"); // à revoir
        $paiement->setAttribute('updated_at', date('Y-m-d H:i:s'));
        $paiement->update();
        
        $portefeuille = Portefeuilles::find($id);

        // enregistrement historique paiement 
        $user = auth()->user();
        $historique = new Historiqueportefeuilles();
        $historique->setAttribute("old_montant", $portefeuille->montant);
        $historique->setAttribute("new_montant", $paiement->montant_paye);
        $historique->setAttribute("type", "CREDIT"); // CREDIT ou DEBIT
        $historique->setAttribute("portefeuille_id", $portefeuille->id);
        $historique->setAttribute("created_by", $user->id);
        $historique->save();

          // update portefeuille
          $new_montant = $portefeuille->montant + $paiement->montant_paye;
          $portefeuille->setAttribute("montant", $new_montant);
          $portefeuille->setAttribute("updated_at", Date("Y-m-d H:i:s"));
          $portefeuille->update(); 

 
        // redirection
        return redirect()->route("etudiant.compte")->with("success", "Opération effectuée avec succès.");
    }

    // 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Portefeuilles  $portefeuilles
     * @return \Illuminate\Http\Response
     */
    public function show(Portefeuilles $portefeuilles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portefeuilles  $portefeuilles
     * @return \Illuminate\Http\Response
     */
    public function edit(Portefeuilles $portefeuilles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portefeuilles  $portefeuilles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portefeuilles $portefeuilles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portefeuilles  $portefeuilles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portefeuilles $portefeuilles)
    {
        //
    }
}
