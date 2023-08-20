@extends('backend/include/layout')
<!-- title -->
@section('title')
    Paiement Express || {{ env('APP_NAME') }}
@endsection

  
@section('fil-arial')
    <div class="pagetitle">
        <h1>Paiement</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item active">Paiement </li>
            </ol>
        </nav>
    </div>
@endsection

@section('contenu') 
    <section >
      <div class="container" data-aos="fade-up">
<br>
        <div class="section-title"> 
         <h2>PAIEMENT DOSSIER N° {{$paiement->getEtudiant->getDossier->code}}</h2> 
        </div>
        <div class="row text-center">          
          <i class="fa fa-spinner fa-pulse fa-10x"></i>
          <div class="text-danger text-center mt-2">
            <b>Veuillez patienter pendant le chargement de la page</b> 
         </div>
        </div>
      </div>

    </section><!-- End About Us Section -->
  
  <script src="https://cdn.kkiapay.me/k.js"></script> 
  <script> 

$(document).ready(function() {
                var montant = parseInt('{{ $paiement->montant_paye}}') ;
                var nom_client = '{{ $paiement->getEtudiant->getDossier->getPersonne->nom}} {{ $paiement->getEtudiant->getDossier->getPersonne->prenoms}}';
                var reference = '{{ $paiement->reference}}';  
                  status_sandbox = "true";
                  var key = '{{env("KKIAPAY_SANDBOX_PUBLIC_KEY")}}';
               var mode ="";
                if (mode != "") {

                  openKkiapayWidget({
                    amount: montant,
                    position: "center",
                    data: reference,
                    name: nom_client,
                    callback: "{{route('paiement-express.kkiapay-store',$paiement->reference)}}",
                    theme: "blue",
                    sandbox: status_sandbox,
                    key: key,
                    //paymentmethod: mode
                });

                addPaymentEndListener(response => {
                  swal({
                                    title:"Merci de ne pas quitter cette page.", 
                                    text:"traitement des données...",
                                    icon: "https://www.boasnotas.com/img/loading2.gif",
                                    buttons: false,      
                                    closeOnClickOutside: false,
                                    //timer: 3000,
                                    //icon: "success"
                      });
                });


                addSuccessListener(response => {
                  /*swal({
                                    title:"Merci de ne pas quitter cette page.", 
                                    text:"traitement des données...",
                                    icon: "https://www.boasnotas.com/img/loading2.gif",
                                    buttons: false,      
                                    closeOnClickOutside: false,
                                    //timer: 3000,
                                    //icon: "success"
                      });*/

                });
                  
                } else {

                  openKkiapayWidget({
                    amount: montant,
                    position: "center",
                    data: reference,
                    name: nom_client,
                    callback: "{{route('paiement-express.kkiapay-store',$paiement->reference)}}",
                    theme: "blue",
                    sandbox: status_sandbox,
                    key: key,
                });

                addPaymentEndListener(response => {
                  swal({
                                    title:"Merci de ne pas quitter cette page.", 
                                    text:"traitement des données...",
                                    icon: "https://www.boasnotas.com/img/loading2.gif",
                                    buttons: false,      
                                    closeOnClickOutside: false,
                                    //timer: 3000,
                                    //icon: "success"
                      });
                });


                addSuccessListener(response => {
                  /*swal({
                                    title:"Merci de ne pas quitter cette page.", 
                                    text:"traitement des données...",
                                    icon: "https://www.boasnotas.com/img/loading2.gif",
                                    buttons: false,      
                                    closeOnClickOutside: false,
                                    //timer: 3000,
                                    //icon: "success"
                      });*/

                    });

                }      

});

</script>

     <!-- jquery -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
     <!-- include sweet alert -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
     <!-- end include sweet alert -->

@endsection 
