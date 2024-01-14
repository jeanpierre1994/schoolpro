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
                    <p>Nom de l'élève : [NOM DE L'ÉLÈVE]</p>
                    <p>Classe : [CLASSE]</p>
                </div>
                <div>
                    <p>Department</p>
                    <p>Registration</p>
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
                        <tr>
                            <td>Mathématiques</td>
                            <td>18/20</td>
                            <td>17/20</td>
                            <td>19/20</td>
                            <td>64/60</td>
                            <td>Excellent</td>
                        </tr>
                        <tr>
                            <td>Français</td>
                            <td>17/20</td>
                            <td>16/20</td>
                            <td>18/20</td>
                            <td>51/60</td>
                            <td>Très bien</td>
                        </tr>
                        <tr>
                            <td>Anglais</td>
                            <td>16/20</td>
                            <td>15/20</td>
                            <td>17/20</td>
                            <td>48/60</td>
                            <td>Bien</td>
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
                        <th>Matière</th>
                        <th>Test1</th>
                        <th>Test2</th>
                        <th>EXAM</th>
                        <th>TOTAL_MARK</th>
                        <th>REMARKS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mathématiques</td>
                        <td>18/20</td>
                        <td>17/20</td>
                        <td>19/20</td>
                        <td>64/60</td>
                        <td>Excellent</td>
                    </tr>
                    <tr>
                        <td>Français</td>
                        <td>17/20</td>
                        <td>16/20</td>
                        <td>18/20</td>
                        <td>51/60</td>
                        <td>Très bien</td>
                    </tr>
                    <tr>
                        <td>Anglais</td>
                        <td>16/20</td>
                        <td>15/20</td>
                        <td>17/20</td>
                        <td>48/60</td>
                        <td>Bien</td>
                    </tr>
                </tbody>
            </table>
        </section>
        <section class="comportement">
            <h3>Comportement</h3>
            <p>L'élève est un(e) élève sérieux(se) et travailleur(se). Il/Elle est respectueux(se) envers ses camarades
                et ses professeurs.</p>
        </section>
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
        margin-bottom: 20px;
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
        margin-top: 50px;
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
