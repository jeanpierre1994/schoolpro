<?php

namespace App\Imports;

use App\Models\Dossiers;
use App\Models\Etudiants;
use App\Models\Personnes;
use App\Models\User;
use Database\Factories\PersonneFactory;
use Database\Factories\UserFactory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;

class DossierImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = User::create([
            'name' => $row['last_name'] . '' . $row['first_name'],
            'email' => strtolower($row['last_name'] . rand(1, 100) . '@mail.com'),
            'password' => strtolower($row['last_name'])
        ]);

        $personne = Personnes::create([
            //
            'matricule' => $row['register_num'],
            'nom' => $row['last_name'],
            'prenoms' => $row['first_name'],
            'genre' => ($row['gender'] == 'male') ? 1 : 2,
            'tel' => 00000000,
            'email' => $user->email,
            'statut_id' => 2,
            'created_by' => 1,
            'ddn' => date('Y-m-d', strtotime(str_replace('/', '-', $row['date_of_birth']))),
            'adresse' => $row['ville'],
            'nationalite' => $row['pays'],

        ]);
        $dossier = new Dossiers([
            //

            'code' => $row['register_num'],
            'site_id' => 1,
            'pole_id' => 1, // FK
            'filiere_id' => random_int(1, 6),
            'cycle_id' => 1,
            'niveau_id' => random_int(1, 12),
            'typesponsor_id' => 2, // FK
            'annee' => 2023,
            'commentaire' => null,
            'parent_created' => 1,
            'statuttraitement_id' => 2,
            'date_traitement' => 2023,
            'validateur_id' => 1,
            'created_by' => 1, // FK
            'updated_by' => 1, // FK
        ]);
        //##################### générer le code  ###########################
        // procédure d'incrémentation du code
        $annee_actuelle = date('y');
        $indicatif = "MT";
        $id_1 = "";
        // récupérer le dernier enregistrement
        $last_numero = Etudiants::orderBy('id', 'desc')->first();

        if ($last_numero == NULL) {
            $last_id = "";
        } else {
            $last_id = $last_numero->matricule;
        }

        if (!empty($last_id)) {
            $delete_bu = substr($last_id, -8);
            // delete YEAR
            $correct_code = substr($delete_bu, 0, 6);
            $id_1 = $correct_code;
        } else {
            $id_1 = '000000';
        }

        // récupérer le numéro à incrémenter sur la position 2 du tableau $id_1
        if (!empty($last_id)) {
            //vérifier si nous somme dans une nouvelle année pour réinitialiser le compteur
            $get_date = substr($last_id, -2);
            if ($annee_actuelle > $get_date) {
                # code...
                $numero = '000000';
            } else {
                # code...
                //$str = "BU111111122"; 
                // delete BU
                $delete_bu = substr($last_id, -8);
                // delete YEAR
                $correct_code = substr($delete_bu, 0, 6);
                $numero = $correct_code;
            }
        } else {
            $numero = '000000';
        }



        $numero_user = $numero + 1;

        $numero_user_formatted = str_pad($numero_user, 6, "0", STR_PAD_LEFT);
        $matricule = $indicatif . $numero_user_formatted . $annee_actuelle;

        //################################### end générer le code  ###################
        $etudiant = new Etudiants([
            'matricule' => $matricule,
            'groupepedagogique_id' => NULL,
            'validateur_id' => 1,
            'commentaire' => 5,
            'statutvalidation_id' => NULL
        ]);
        $personne->getCompte()->associate($user);
        $dossier->getPersonne()->associate($personne);
        $dossier->save();
        $etudiant->getDossier()->associate($dossier);
        $etudiant->save();
        return $etudiant;
    }
}
