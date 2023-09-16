<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Reçu Paiement </title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
    }

    .header {
        text-align: center;
        margin-bottom: 10px;
    }

    .student-info {
        margin-bottom: 20px;
    }

    .exam-details {
        border-collapse: collapse;
        width: 100%;
    }

    .exam-details th,
    .exam-details td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .exam-details th {
        background-color: #f2f2f2;
    }

    .footer {
        margin-top: 10px;
    }
</style>

<body class="h-full container mx-auto">
    <div class="header">
        <h1 class="text-lg font-extrabold ">Reçu de Paiement N° {{ $paiement->reference }}</h1>
        <p class="text-md font-extralight "></p>
    </div>
    <div class="student-info">
        <p><strong>Nom de l'étudiant:</strong> 
            {{ $oneDetail->getEcheancier->getDossier->getPersonne->nom . ' ' . $oneDetail->getEcheancier->getDossier->getPersonne->prenoms . ' ' . $oneDetail->getEcheancier->getDossier->getPersonne->surnom ?? '' }}</p>
        <p><strong>Matricule de l'étudiant:</strong> {{ $etudiant->matricule }}</p>
        <p><strong>Groupe pédagogique:</strong> {{ $etudiant->getGp->libelle_classe }} |
            {{ $etudiant->getGp->libelle_secondaire ?? '' }}</p>  
    </div> 
    <table class="exam-details">
        <thead>

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
            $total_payer =0;
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
                    <td>{{ number_format($item->getEcheancier->montant_restant, 0, ',', '.') }}</td> 
                    <td>{{ \Carbon\Carbon::parse($item->date_paiement)->format("d-m-Y") }} </td> 
                </tr>
            @endforeach
            <tr>
                <td colspan="2"><strong>Total </strong></td>
                <td ><strong>{{ number_format($total_payer, 0, ',', '.') }}</strong></td>
                <td ><strong>{{ number_format($total_restant, 0, ',', '.') }}</strong></td>
                <td></td>
            </tr> 
        </tbody>
    </table>

    <div class="footer">
        
    </div>
</body>

</html>
