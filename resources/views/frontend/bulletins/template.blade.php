<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bulletin scolaire</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <header>

        <div class="banniere">
            <div style="display: flex">
                <h1 class="">
                    <span></span>British & French Academy
                </h1>
                <h6>Adresse:</h6>
                <div class="dataschool">
                    <h6>Email:</h6>
                </div>

            </div>
        </div>
    </header>
    <main>
        <section class="infos-generales">
            <div class="infos-gen">
                <h3>Student Transcription Report</h3>
            </div>
            <div class="student-infos">

                <div>
                    <p> <b>Nom de l'élève :</b>
                        {{ $personne->nom . ' ' . $personne->prenoms . ' ' . $personne->surnom }} <span
                            style=" display:flexbox; justify-content:end">
                            {{ ' ' }}<b>Department</b></span></p>
                    <p> <b>Classe :</b> {{ $etudiant->getGp->libelle_classe }} <span>
                            {{ ' ' }}
                            <b>
                                Registration:
                            </b>
                            {{ $etudiant->matricule }}
                        </span></p>
                </div>
            </div>
        </section>
        <section class="notes">
            <h3>English Programm</h3>
            <div class="data-table">
                <div class="details"></div>
                <table>
                    <thead>
                        <tr>
                            <th>Matière</th>
                            <th>Test1</th>
                            <th>Test2</th>
                            <th>EXAM</th>
                            <th>TOTAL_MARK</th>
                            <th>REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notesSectionEng as $data)
                            @php
                                $my = ceil((($data->note_first + $data->note_second) / 2 + $data->devoir * $data->getExamenprog->getMatiere->coef) / 2);
                            @endphp
                            <tr>
                                <td>{{ $data->getExamenprog->getMatiere->libelle }}</td>
                                <td>{{ $data->note_first }}/{{ $data->getExamenprog->getMatiere->note_max }}</td>
                                <td>{{ $data->note_second }}/{{ $data->getExamenprog->getMatiere->note_max }}</td>
                                <td>{{ $data->devoir }}/60</td>
                                <td>{{ $my }}</td>
                                <td>{{ $my < 70 ? 'AVERAGE' : 'GOOD' }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </section>
        <br><br>
        <section class="notes">
            <h3>Programme Français</h3>
            <table>
                <thead>
                    <tr>
                        <th>Matière</th>
                        <th>Test1</th>
                        <th>Test2</th>
                        <th>EXAM</th>
                        <th>TOTAL_MARK</th>
                        <th>REMARKS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notesSectionFrench as $data)
                        @php
                            $my = ceil((($data->note_first + $data->note_second) / 2 + $data->devoir * $data->getExamenprog->getMatiere->coef) / 2);
                        @endphp
                        <tr>
                            <td>{{ $data->getExamenprog->getMatiere->libelle }}</td>
                            <td>{{ $data->note_first }}/{{ $data->getExamenprog->getMatiere->note_max }}</td>
                            <td>{{ $data->note_second }}/{{ $data->getExamenprog->getMatiere->note_max }}</td>
                            <td>{{ $data->devoir }}/60</td>
                            <td>{{ $my }}</td>
                            <td>{{ $my < 70 ? 'BIEN' : 'TRES-BIEN' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
        {{-- <section class="comportement">
            <h3>Comportement</h3>
            <p>L'élève est un(e) élève sérieux(se) et travailleur(se). Il/Elle est respectueux(se) envers ses camarades
                et ses professeurs.</p>
        </section> --}}
    </main>
    <footer>
        <p>Copyright © 2024 École bilingue</p>
    </footer>
</body>
<style>
    body {
        font-family: sans-serif;
        margin: auto;
        padding: 0;
    }

    header {
        background-color: #000;
        color: #fff;
        padding: 10px;
    }

    .dataschool {
        display: flex;
        justify-content: space-between
    }

    .banniere {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        text-align: center;
    }

    .banniere img {
        width: 100px;
    }

    .banniere .infos {
        margin-left: 10px;
    }

    .details {
        width: 20em;
    }

    .data-table {
        display: flex;
    }

    h1,
    h2 {
        font-size: 2em;
        margin-top: 0;
    }

    main {
        padding: 20px;
    }

    section {
        margin-bottom: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 10px;
    }

    tr:nth-child(odd) {
        background-color: #eee;
    }

    footer {
        background-color: #000;
        color: #fff;
        padding: 20px;
        text-align: center;
    }

    .notes th {
        text-align: center;
    }

    .notes td {
        text-align: center;
    }

    .notes {
        margin-top: 20px;
    }

    .infos-gen {
        display: flex;
        justify-content: center;
        border: 2px solid #000;
        border-left: none;
        border-right: none;
        text-align: center;
    }

    .student-infos {
        display: flex;
        justify-content: space-evenly;
        justify-items: start;
    }
</style>

</html>
