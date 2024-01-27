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
        <table style="width: 100%; border:none; background: transparent">
            <tr style="background: transparent">
                <td style="width: 30%; border:none;">
                    <img src="nice/assets/img/british.png" alt="logo" class="img-responsive" width="auto" height="50px"
                         style="width: auto; height:150px;">
                    <p style="color: #6d4c41;font-family: 'Poppins'; font-weight: bold; font-size: 12px; margin-top: 5px ; margin-bottom: 0">
                        Born on {{ \Illuminate\Support\Facades\Date::make($personne->ddn)->format(" d F Y ") }}</p>
                    <p style="color: #6d4c41;font-family: 'Poppins'; font-weight: bold; font-size: 12px; margin-top: 5px ; margin-bottom: 0">
                        {{ $personne->genre == 1 ? "BOY" : "GIRL" }} <span
                            style="font-size: 20px; font-weight: bolder; margin-left: 40px;">{{$etudiant->getGp->libelle_classe . ' | ' . $etudiant->getGp->libelle_secondaire}}</span>
                    </p>
                </td>
                <td style="text-align: center; font-size:130%; width:40%; border:none; ">
                    <p style="color: #6d4c41;font-family: 'Poppins'; font-weight: inherit; font-size: 10px; margin-top: 0 ; margin-bottom: 0">
                        Quartier JAK, Lot 209 A | 06 BP 129 COTONOU | Tel. 97 20 95 88 | 97 46 45 70</p>

                    <p style="font-weight: bold; margin-top: 0">BRITISH <span style="color: red">&</span> FRENCH ACADEMY
                        Int'l</p>
                    <p style="color: #6d4c41;font-family: 'Poppins'; font-weight: bold; font-size: 30px ; margin-bottom: 0">
                        REPORT CARD</p>
                    <p style="color: orangered;font-family: 'Poppins'; font-weight: lighter; font-size: 25px; margin-top: 0; margin-bottom: 5px ">
                        BULLETIN</p>
                    <p style="font-family: 'Poppins'; font-weight: bold; font-size: 17px; margin-top: 0 ">
                        fbritishacademy@gmail.com</p>

                </td>
                <td style="width: 30%; border:none; text-align:center;">
                    <div class="col-12" style="font-weight: lighter; margin-bottom: 10px ">
                        <a style="font-size: 15px; padding-bottom: 50px"> {{ $personne->nom . ' ' . $personne->prenoms . ' ' . $personne->surnom }}</a>
                    </div>
                    <div class="col-12" style="background: #6d4c41">
                        <b style="color: white; font-size: 20px; font-family: 'Work Sans', sans-serif;"> ACADEMIC YEAR
                            2023-2024</b>
                    </div>
                    <div class="col-12" style="border: 2px solid; margin-top: 20px; height: 100px">
                        <b style="font-size: 10px"> AVERAGE MARK %</b>
                        <div style=" display: inline; flex: content">
                            <table style="max-width: 10px; border: none;">
                                <tr style="background: transparent; ">
                                    <td style=" width: 10px; border: none ">
                                        <p style="font-size: 10px;">
                                            <span style="color: red;font-weight: bold">A</span>=100-90%, Excellent
                                        </p>
                                        <p style="font-size: 10px; ">
                                            <span style="color: red;font-weight: bold">C</span>=79-70%, Good
                                        </p>
                                        <p style="font-size: 10px; ">
                                            <span style="color: red;font-weight: bold">E</span>=59-50%, Average
                                        </p>
                                    </td>
                                    <td style="border: none; width: 10px; ">
                                        <p style="font-size: 10px; ">
                                            <span style="color: red;font-weight: bold">B</span>=89-80%, Very Good
                                        </p>
                                        <p style="font-size: 10px; ">
                                            <span style="color: red;font-weight: bold">D</span>=69-60%, Satisfactory
                                        </p>
                                        <p style="font-size: 10px; ">
                                            <span style="color: red;font-weight: bold">F</span>=49-0%, Fail
                                        </p>
                                    </td>
                                </tr>


                            </table>

                        </div>
                    </div>
                </td>
            </tr>
        </table>

    </div>
</header>
<main>
    <section class="infos-generales">
        <div class="infos-gen">
            <h3 style="font-family: 'Poppins'">Student Transcription Report</h3>
        </div>
    </section>
    <section class="notes">
        <h3>English Programm</h3>
        <div class="data-table">
            <div class="details"></div>
            <table style="font-family: 'Poppins'">
                <thead>
                <tr>
                    <th>Subject</th>
                    <th>TEST1 (20)</th>
                    <th>TEST2 (20)</th>
                    <th>EXAMS / 60</th>
                    <th>TOTAL MARKS / 100</th>
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
                            @if ($my < 50)
                                FAIL
                            @elseif ($my < 60)
                                AVERAGE
                            @elseif ($my < 70)
                                SATISFACTORY
                            @elseif ($my < 80)
                                GOOD
                            @elseif ($my <90)
                                VERY GOOD
                            @elseif ($my <= 100)
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
                    <td colspan="5"><b>{{$synt_bulletin->appreciation_en ? $synt_bulletin->appreciation_en : ''}}</b>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </section>
    <br><br>
    @if($notesSectionFrench != null)
        <section class="notes">
            <h3>Programme Français</h3>
            <table style="font-family: 'Poppins'">
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
    @endif

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
