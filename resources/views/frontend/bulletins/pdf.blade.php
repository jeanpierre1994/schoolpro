<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Bulletin Code : {{ $examen->code_examen }} </title>
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
        <h1 class="text-lg font-extrabold ">Relevé de Note : {{ $examen->libelle }}</h1>
        <p class="text-md font-extralight "></p>
    </div>
    <div class="student-info">
        <p><strong>Nom de l'étudiant:</strong>
            {{ $personne->nom . ' ' . $personne->prenoms . ' ' . $personne->surnom ?? '' }}</p>
        <p><strong>Matricule de l'étudiant:</strong> {{ $etudiant->matricule }}</p>
        <p><strong>Groupe pédagogique:</strong> {{ $etudiant->getGp->libelle_classe }} |
            {{ $etudiant->getGp->libelle_secondaire ?? '' }}</p>
        <p><strong>Année scolaire:</strong> {{ $examen->annee_academique }} - {{ $examen->annee_academique + 1 }}</p>
        <p><strong>Date de l'Examen:</strong> Du {{ gmdate('d M Y', strtotime($examen->date_debut)) }}
            Au {{ gmdate('d M Y', strtotime($examen->date_fin)) }}</p>
    </div>
    @php
        $totalNoteFr = 0;
        $totalCoefFr = 0;
        $moyFr = 0;
        $totalNoteEn = 0;
        $totalCoefEn = 0;
        $moyEn = 0;
    @endphp
    <table class="exam-details">
        <thead>

            <tr>
                <th>Matière</th>
                <th>Notes / 20</th>
                <th>Coef</th>
                <th>Notes Coefficiées</th>
                <th>Commentaire</th>
            </tr>
        </thead>
        <tbody>
            @if ($notesSectionEng)
                <tr>
                    <th colspan="5">
                        Section : Anglais

                    </th>
                </tr>
            @endif
            @foreach ($notesSectionEng as $note)
                <tr>
                    <td>{{ $note->getExamenprog->getMatiere->libelle }}</td>
                    <td>{{ $note->note }}</td>
                    <td>{{ $note->getExamenprog->getMatiere->coef }}</td>
                    <td>{{ $note->note * $note->getExamenprog->getMatiere->coef }}</td>
                    <td>{{ $note->commentaire ?? '' }}</td>
                </tr>
                @php
                    $totalCoefEn += $note->getExamenprog->getMatiere->coef;
                    $totalNoteEn += $note->note * $note->getExamenprog->getMatiere->coef;
                    $moyEn = $totalNoteEn / $totalCoefEn;
                @endphp
            @endforeach
            <tr>
                <td><strong>Moyenne </strong></td>
                <td colspan="4"><strong>{{ $moyEn }}</strong></td>
            </tr>
            @if ($notesSectionFrench)
                <tr>
                    <th colspan="5">
                        Section : Français

                    </th>
                </tr>
            @endif
            @foreach ($notesSectionFrench as $note)
                <tr>
                    <td>{{ $note->getExamenprog->getMatiere->libelle }}</td>
                    <td>{{ $note->note }}</td>
                    <td>{{ $note->getExamenprog->getMatiere->coef }}</td>
                    <td>{{ $note->note * $note->getExamenprog->getMatiere->coef }}</td>
                    <td>{{ $note->commentaire ?? '' }}</td>
                </tr>
                @php
                    $totalCoefFr += $note->getExamenprog->getMatiere->coef;
                    $totalNoteFr += $note->note * $note->getExamenprog->getMatiere->coef;
                    $moyFr = $totalNoteFr / $totalCoefFr;
                @endphp
            @endforeach

            <tr>
                <td><strong>Moyenne </strong></td>
                <td colspan="4"><strong>{{ $moyFr }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Total Coeffient: {{ $totalCoefFr + $totalCoefEn }} </p>
        <p>Moyenne Coefficiée: {{ $totalNoteFr + $totalNoteEn  }} </p>
        <p>Moyenne Générale: {{ ($moyFr + $moyEn)/2 }} </p>
    </div>
</body>

</html>
