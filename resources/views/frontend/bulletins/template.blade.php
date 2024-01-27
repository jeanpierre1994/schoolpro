<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bulletin scolaire</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <header style="background: none; color:#000;">
 
        <div class="row">
            <table style="width: 100%; border:none;">
                <tr>
                    <td style="width: 30%; border:none;">
                        <img src="{{asset('nice/assets/img/british.png')}}" alt="logo" class="img-responsive" width="auto" height="50px" style="width: auto; height:50px;">
                    </td>
                    <td style="text-align: center; font-size:130%; width:40%; border:none;">
                        BULLETIN BRITISH
                    </td>
                    <td style="width: 30%; border:none; text-align:center;">
                        <div class="col-12">
                            <b> {{ $personne->nom . ' ' . $personne->prenoms . ' ' . $personne->surnom }}</b>
                        </div> 
                            <div class="col-12">
                                <b> ACADEMIC YEAR 2022-2023</b>
                            </div> 
                            <div class="col-12">
                                <b> AVERAGE MARK/%</b>
                            </div>
                    </td>
                </tr>
            </table>
           
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
                            <th>Subject</th>
                            <th>TEST1 (20)</th>
                            <th>TEST2 (20)</th>
                            <th>EXAMS / 60</th>
                            <th>TOTAL.MARKS / 100</th>
                            <th>REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count_en = 0; $total_en = 0;
                            $somme_moyenne = 0; $somme_coef = 0;
                        @endphp
                        @foreach ($notesSectionEng as $data)
                            @php
                            $my_ok = round(($data->note_first*$data->getExamenprog->getMatiere->coef + $data->note_second*$data->getExamenprog->getMatiere->coef + $data->devoir*$data->getExamenprog->getMatiere->coef)/5/$data->getExamenprog->getMatiere->coef,2);
                            $somme_moyenne = $somme_moyenne + $my_ok;
                            $somme_coef = $somme_coef + $data->getExamenprog->getMatiere->coef;
                             $my = $data->note_first + $data->note_second + $data->devoir;
                             $count_en = $count_en + 1; $total_en = $total_en + $my;
                               // $my = ceil((($data->note_first + $data->note_second) / 2 + $data->devoir * $data->getExamenprog->getMatiere->coef) / 2);
                            @endphp
                            <tr>
                                <td style="text-align: left">{{ $data->getExamenprog->getMatiere->libelle }}</td>
                                <td>{{ $data->note_first }}/{{ $data->getExamenprog->getMatiere->note_max }}</td>
                                <td>{{ $data->note_second }}/{{ $data->getExamenprog->getMatiere->note_max }}</td>
                                <td>{{ $data->devoir }}/60</td>
                                <td>{{ $my }}</td>
                                <td>
                                    @if ($my < 70)
                                        SATISFACTORY

                                    @elseif ($my > 69 && $my < 80)
                                    GOOD
                                    @elseif ($my > 79 && $my < 90)
                                    VERY GOOD
                                    @else
                                        EXCELLENT
                                    @endif
                                    </td>
                            </tr>
                          

                        @endforeach
                        <tr>
                            <td>TOTAL MARK /(N):</td>
                            <td colspan="5" style="text-align: left"><b>{{$total_en}}</b></td>
                        </tr>
                        <tr>
                            <td>AVERAGE MARK (%):</td>
                            <td colspan="2" style="text-align: left"><b>{{ceil(($total_en*100)/(100*$count_en))}}%</b></td>
                            <td>SCORING KEY :</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>MARK /(20):</td>
                            <td colspan="5"><b>{{round($somme_moyenne/$somme_coef,2)}}</b></td>
                        </tr>
                        <tr>
                            <td>CLASS TEACHER'S REMARK(S):</td>
                            <td colspan="5"><b>{{$synt_bulletin->appreciation_en ? $synt_bulletin->appreciation_en : ''}}</b></td>
                        </tr>

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
                        <th>MATIERE</th>
                        <th>DEVOIRS_1 /20</th>
                        <th>DEVOIRS_2 /20</th>
                        <th>TOT.DEVOIRS /40</th>
                        <th>COMPOSITION /60</th>
                        <th>TOTAL /100</th>
                        <th>APPRECIATION</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $count_fr = 0; $total_fr = 0;
                            $somme_moyenne = 0; $somme_coef = 0;
                    
                @endphp
                @if ($notesSectionFrench)
                @foreach ($notesSectionFrench as $data)
                @php
                $my_ok = round(($data->note_first*$data->getExamenprog->getMatiere->coef + $data->note_second*$data->getExamenprog->getMatiere->coef + $data->devoir*$data->getExamenprog->getMatiere->coef)/5/$data->getExamenprog->getMatiere->coef,2);
                            $somme_moyenne = $somme_moyenne + $my_ok;
                            $somme_coef = $somme_coef + $data->getExamenprog->getMatiere->coef;

                    $my = $data->note_first + $data->note_second + $data->devoir;
                    $my_devoir = $data->note_first + $data->note_second; 
                     $count_fr = $count_fr + 1; $total_fr = $total_fr + $my;
                    //$my = ceil((($data->note_first + $data->note_second) / 2 + $data->devoir * $data->getExamenprog->getMatiere->coef) / 2);
                @endphp
                <tr>
                    <td style="text-align: left;">{{ $data->getExamenprog->getMatiere->libelle }}</td>
                    <td>{{ $data->note_first }}</td>
                    <td>{{ $data->note_second }}</td> 
                    <td>{{$my_devoir}}</td>
                    <td>{{ $data->devoir }}</td>
                    <td>{{ $my }}</td>
                    <td>
                        @if ($my < 50)
                        FAIBLE
                        @elseif ($my > 49 && $my < 79)
                        BIEN
                    @elseif ($my > 79 && $my < 90)
                    TRES BIEN 
                    @else
                        EXCELLENT
                    @endif
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>TOTAUX :</td>
                <td colspan="6" style="text-align: left"><b>{{$total_fr}}</b></td>
            </tr>
            <tr>
                <td>MOYENNE GENERALE (/20):</td>
                <td colspan="6" style="text-align: left"><b>{{round($somme_moyenne/$somme_coef,2)}} </b></td> 
            </tr>
                @endif
                    
                </tbody>
            </table>
        </section>
        <section class="comportement">
            <h3>Comportement</h3>
            <p>{{$synt_bulletin->appreciation_fr ? $synt_bulletin->appreciation_fr : ''}}</p>
        </section>
    </main>
    {{-- <footer>
        <p>Copyright © 2024 École bilingue</p>
    </footer> --}}
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
