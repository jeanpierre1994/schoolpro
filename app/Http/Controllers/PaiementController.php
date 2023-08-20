<?php

namespace App\Http\Controllers;

use App\Models\Paiements;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    //
    
    public function paiementKkiapay($reference)
    {
        $paiement = Paiements::where('reference', $reference)->get()->first(); 
        return view('backend.paiements.paiement_kkiapay', compact('paiement'));
    }

    public function paiementKkiapayStore(Request $request, $reference, $code = null)
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
        $paiement->setAttribute('updated_at', date('Y-m-d H:i:s'));
        $paiement->update(); 

        // redirection
        return redirect()->route("dossiers.en_attente")->with("success", "Opération effectuée avec succès.");


    }

    public function paiementKkiapayExpress($reference)
    {
        $paiement = Paiements::where('reference', $reference)->get()->first(); 
        return view('backend.paiements.paiement_express_kkiapay', compact('paiement'));
    }

    public function paiementKkiapayExpressStore(Request $request, $reference, $code = null)
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
        $paiement->setAttribute('updated_at', date('Y-m-d H:i:s'));
        $paiement->update(); 

        // redirection
        return redirect()->route("dossiers.valide")->with("success", "Opération effectuée avec succès.");


    }
}
