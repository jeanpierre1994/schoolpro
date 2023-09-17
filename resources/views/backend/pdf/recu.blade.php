<!DOCTYPE HTML>
<html>

<head>
    <!-- Basic Page Needs
 ================================================== -->
    <title>RECU DE PAIEMENT</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!-- Script
        ==============-->

    <!-- CSS
 ================================================== -->

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.3;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3.5cm;
        }

        @page {
            size: 21cm 32.7cm;
            margin-left: 1.8cm;
            margin-right: 1.7cm;
            margin-top: 1.5cm;
            margin-bottom: 1.5cm;
        }

        /* Define the footer rules*/
        footer {
            position: fixed;
            display: block;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            min-height: 2.5cm;
            width: 100%;
            font-family: Arial, sans-serif;
            font-size: 8pt;
        }

        .nav {
            padding: 0;
            display: block;
            margin: 0;
        }

        .nav .nav-left {
            float: left;
            text-align: center;
            max-width: 50%;
            padding: 5px 10px 5px 0;
        }

        .nav .nav-right {
            text-align: center;
            left: 30%;
            font-size: 90%;
            line-height: 1.1;
        }

        .nav .nav-left1 {
            /*float: left;*/
            text-align: center;
            width: 100%;
            padding: 5px 10px 5px 0;
            font-size: 90%;
            line-height: 1.1;
        }

        .nav .nav-right1 {

            text-align: center;
            left: 35%;
            font-size: 90%;
            line-height: 1.1;
        }

        .contenu {
            clear: both;
            display: block;
            margin: 10px 0 0 0;
            width: 100%;
            padding: 10px 0 0 0;
            left: 0;
        }

        .bloc-titre {
            clear: both;
            display: block;
            background-color: #eff5ef;
            padding: 5px 10px;
            margin: 5px 0;
            font-size: 110%;
            font-weight: bold;
            text-transform: uppercase;
        }

        .bloc-texte {
            display: block;
            padding: 5px;
            margin: 0;
            line-height: 1.6;
        }

        .bloc-texte .image {
            float: right;
            top: 0;
            text-align: center;
            max-width: 30%;
            padding: 0;
            margin: 0;
        }

        .bloc-texte .qrcode {
            float: left;
            top: 0;
            text-align: center;
            width: 35%;
            padding: 0;
            margin: 2px;
            border-right: 1px solid #cacaca;
        }

        .bloc-texte .qrtexte {
            top: 0;
            text-align: left;
            margin: 2px 2px 2px 40%;
            padding: 0;
            padding-bottom: 10px;
        }

        .bloc-texte .doc {
            text-align: center;
            max-width: 30%;
            padding: 5px;
            margin: 0 1% 20px 0;
            border: 1px solid #aaa;
        }

        h3,
        h4 {
            font-weight: bold;
            text-transform: uppercase;
            margin: 5px;

        }

        h3 {
            font-size: 125%;
            margin-bottom: 10px;
        }

        h4 {
            font-size: 110%;
            margin-top: 5px;
        }


        /*table {
      border-collapse: collapse;
      width: 100%;
      margin: 5px 0 0 0;
      padding: 0;
      left: 0;

    }*/

        td,
        th {
            border: 0.4px solid #767373;
            text-align: left;
            padding: 4px 8px;
        }

        tr:nth-child(even) {
            background-color: ;
            #f0f3f4;
        }

        .pagenum:before {
            content: counter(page);
        }

        #table_one,
        #table_two {
            background: url('logo.png');
            opacity: 0.1;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            100px bottom 10px;
            z-index: -1;
        }
    </style>


</head>

<body>

    <div class="nav" style=" text-align:center;width:100%; margin-bottom:20px;">
        <div class="nav-leftx" style="text-align: center;padding:0 1px; margin-top:0px; ">
            <img src="logo.jpg" alt="" height="92px"><br>
        </div>
    </div>
    <div style="clear: both;"></div>
    <div class="nav" style=" text-align:center;width:100%; margin-top:10px;">
        <div class="nav-leftx" style="text-align: center;padding:0 10px; margin-top:-20px; font-size:2em; color: #2f4b97 ">
            <b style="margin-top:5px;">RECU DE PAIEMENT</b>
        </div>
    </div>
    <div style="clear: both;"></div>
    <div class="nav">
        <div class="nav-left" style="text-align: left;padding:0 10px; margin-top:-20px;">
            <div style="font-size: 100%; line-height:1.5;">
                <span><b></b></span><br>
                <span><b>N° {{ $paiement->reference }}</b></span> || <span><b>Date paiement :
                        {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d-m-Y') }}</b></span><br>
                <span>Nom de l'étudiant :
                    <b>{{ $oneDetail->getEcheancier->getDossier->getPersonne->nom . ' ' . $oneDetail->getEcheancier->getDossier->getPersonne->prenoms . ' ' . $oneDetail->getEcheancier->getDossier->getPersonne->surnom ?? '' }}</b></span><br>
                <span>Matricule de l'étudiant : <b>{{ $etudiant->matricule }}</b></span><br>
                <span>Groupe pédagogique : <b>{{ $etudiant->getGp->libelle_classe }} |
                        {{ $etudiant->getGp->libelle_secondaire ?? '' }}</b></span><br>

            </div>
        </div>
        <div class="nav-right" style="text-align: right;padding:0 10px; line-height:1.2; ">
            <div style="font-size: 100%; line-height:1.5;">
                <span><b>{{ env('APP_NAME') }}</b></span><br>
                ETABLISSEMENT : - - - <br>
                SITE : - - - <br>
                ANNEE SCOLAIRE : 2023 <br>
                TEL : - - - <br>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>

    <div style="clear:both; display:block;"> </div>
    <div style="clear:both; ">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div style="line-height: 1.3; margin:auto;">
                        <!-- titre --> <br><br>
                        <h3 style="color: #2f4b97">Liste des rubriques </h3>
                    </div>
                    <!-- General Form Elements -->

                    <!-- General Form Elements -->

                    <div class="table-responsive">
                        <table cellspacing="0" cellpadding="0"
                            style=" cellspacing : 0; cellpadding:0; border:0; width: 100%; z-index:1000;  padding: 1px 0 0 0; margin: 0 ;">
                            <thead style="margin:0; text-align: center; background-color:#2f4b97; color: #fff">
                                <tr>
                                    <th>Famille rubrique</th>
                                    <th>Rubrique</th>
                                    <th>Montant payé</th>
                                    <th>Montant restant</th>
                                    <th>Date paiement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_payer = 0;
                                    $total_restant = 0;
                                @endphp
                                @foreach ($details as $item)
                                    @php
                                        $total_payer += $item->montant_payer;
                                        $total_restant += $item->getEcheancier->montant_restant;
                                    @endphp
                                    <tr>
                                        <td>{{ $item->getEcheancier->getLignetarif->grilleTarifaire->libelle }}</td>
                                        <td>{{ $item->getEcheancier->getLignetarif->rubrique->libelle }}</td>
                                        <td>{{ number_format($item->montant_payer, 0, ',', '.') }}</td>
                                        <td>{{ number_format($item->getEcheancier->montant_restant, 0, ',', '.') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->date_paiement)->format('d-m-Y') }} </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2"><strong>Total </strong></td>
                                    <td><strong>{{ number_format($total_payer, 0, ',', '.') }}</strong></td>
                                    <td><strong>{{ number_format($total_restant, 0, ',', '.') }}</strong></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- End Bordered Table -->
                    </div>
                </div>
            </div>
        </div>



        <!-- ““““““““““““““ “““““““““““““““““““““ -->

        <div style="clear: both;"></div>
        <footer>
            <div style="display: block;border-top: 2px solid #474442; text-align:left;clear:both;">
                <b>{{ env('APP_NAME') }}</b> - RCCM : {{ env('RCCM') }} - IFU : 00000000000000 - CONTACT :
                00000000
            </div>
        </footer>
</body>

</html>
