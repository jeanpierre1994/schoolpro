<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Dossiers;
use App\Models\Etudiants;
use App\Models\Personnes;
use App\Actions\GenereCode;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Database\Factories\PersonneFactory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DossierImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $famille = User::firstOrCreate(
            [
                'name' => $row['last_name'] . ' Famille',
            ],[
            'email' => strtolower($row['famille'] . '@brif.com'),
            'password' => Hash::make('Inscription@2023') ,
            'profil_id' => 3,
            'enable' => 1,
        ]);

        $familePersonne = Personnes::firstOrCreate([
            'compte_id' => $famille->id,

        ],[
            'nom' => $row['last_name'],
            'prenoms' => 'Famille',
            'matricule' => $row['famille'],
            "genre" => 1,
            'statut_id' => 1,
            'tel' => 00000000,
            'email' => strtolower($row['famille'] . '@brif.com'),
            'famille' => 0,
            'created_by' => 1,
            'photo' => 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp'
        ]);

        $user = User::create([
            'name' => $row['last_name'] . ' ' . $row['first_name'],
            'email' => strtolower($row['register_num'] . '@brif.com'),
            'password' => Hash::make('Inscription@2023'),
            'profil_id' => 2,
            'enable' => 1,
        ]);

        $personne = Personnes::create([
            //
            'matricule' => $row['register_num'],
            'compte_id' => $user->id,
            'nom' => $row['last_name'],
            'prenoms' => $row['first_name'],
            'genre' => ($row['gender'] == 'male') ? 1 : 2,
            'tel' => 00000000,
            'email' => $user->email,
            'statut_id' => 1,
            'created_by' => $famille->id,
            'ddn' => date('Y-m-d', strtotime(str_replace('/', '-', $row['date_of_birth']))),
            'adresse' => $row['ville'],
            'nationalite' => $row['pays'],
            'photo' => 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp'

        ]);
     $dossier = new Dossiers([
            //

            'code' => (new GenereCode)->handle(Dossiers::class, 'DS'),
            'site_id' => 1,
            'pole_id' => $this->getPole($row), // FK
            'filiere_id' => $this->getFiliere($row), // FK
            'cycle_id' => 1,
            'niveau_id' => $this->getNiveau($row), // FK
            'typesponsor_id' => 2, // FK
            'annee' => 2023,
            'commentaire' => null,
            'parent_created' => 1,
            'statuttraitement_id' => 2,
            'date_traitement' => 2023,
            'validateur_id' => 1,
            'parent_id' => $famille->id,
            'created_by' => $famille->id, // FK
            'updated_by' => 1, // FK
        ]);

        $dossier->getPersonne()->associate($personne);
        $dossier->save();

        $etudiant = new Etudiants([
            'matricule' => $row['register_num'],
            'dossier_id' => $dossier->id,
            'groupepedagogique_id' => $this->getGp($row),
            'validateur_id' => 1,
            'commentaire' => 5,
            'statutvalidation_id' => NULL
        ]);
        //$personne->getCompte()->associate($user);

        return $etudiant;
    }

    public function getPole($row)
    {
        $pole = 1;
        if ($row['CLASSE 2023-2024 ENGLISH'] == 'Creche' || $row['CLASSE 2023-2024 ENGLISH'] == 'NURSERY 1' || $row['CLASSE 2023-2024 ENGLISH'] == 'NURSERY 2') {
            $pole = 1;
        }elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 1' || $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 2' || $row['CLASSE 2023-2024 ENGLISH']== 'YEAR 3' || $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 4' || $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 5' || $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 6')
        {
            $pole = 2;
        }
        else{
            $pole = 3;
        }
        return $pole;
    }

    public function getFiliere($row)
    {
        $filiere = 4;
        if ($row['CLASSE 2023-2024 ENGLISH'] == 'NURSERY 1' || $row['CLASSE 2023-2024 ENGLISH'] == 'NURSERY 2') {
            $filiere = 4;
        }elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 1' || $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 2' || $row['CLASSE 2023-2024 ENGLISH']== 'YEAR 3' || $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 4' || $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 5' || $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 6')
        {
            $filiere = 3;
        }else{
            $filiere = 2;
        }
        return $filiere;
    }

    public function getNiveau($row)
    {
        $niveau = 16;
        if ($row['CLASSE 2023-2024 ENGLISH'] == 'NURSERY 1' ) {
            $niveau = 15;
        }elseif( $row['CLASSE 2023-2024 ENGLISH'] == 'NURSERY 2')
        {
            $niveau = 14;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 1' )
        {
            $niveau = 13;
        }elseif( $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 2' )
        {
            $niveau = 12;
        }
        elseif( $row['CLASSE 2023-2024 ENGLISH']== 'YEAR 3' )
        {
            $niveau = 11;
        }
        elseif( $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 4' )
        {
            $niveau = 10;
        }
        elseif( $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 5' )
        {
            $niveau = 9;
        }
        elseif( $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 6')
        {
            $niveau = 8;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'Creche'){
            $niveau = 16;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 7' && $row['CLASSE 2023-2024 FRANÇAIS'] == 'Cambridge'){
            $niveau = 7;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 7' && $row['CLASSE 2023-2024 FRANÇAIS'] != 'Cambridge'){
            $niveau = 6;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 8' && $row['CLASSE 2023-2024 FRANÇAIS'] == 'Cambridge'){
            $niveau = 5;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 8' && $row['CLASSE 2023-2024 FRANÇAIS'] != 'Cambridge'){
            $niveau = 4;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 9' && $row['CLASSE 2023-2024 FRANÇAIS'] != 'Cambridge'){
            $niveau = 3;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 9' && $row['CLASSE 2023-2024 FRANÇAIS'] == 'Cambridge'){
            $niveau = 20;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 10' && $row['CLASSE 2023-2024 FRANÇAIS'] != 'Cambridge'){
            $niveau = 2;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 10' && $row['CLASSE 2023-2024 FRANÇAIS'] == 'Cambridge'){
            $niveau = 21;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 11' && $row['CLASSE 2023-2024 FRANÇAIS'] == 'Cambridge'){
            $niveau = 1;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 12' && $row['CLASSE 2023-2024 FRANÇAIS'] == 'Cambridge'){
            $niveau = 22;
        }
        else{
            $niveau = 2;
        }
        return $niveau;
    }

    public function getGp($row)
    {
        $gp = 16;
        if ($row['CLASSE 2023-2024 ENGLISH'] == 'NURSERY 1' ) {
            $gp = 16;
        }elseif( $row['CLASSE 2023-2024 ENGLISH'] == 'NURSERY 2')
        {
            $gp = 15;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 1' )
        {
            $gp = 14;
        }elseif( $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 2' )
        {
            $gp = 13;
        }
        elseif( $row['CLASSE 2023-2024 ENGLISH']== 'YEAR 3' )
        {
            $gp = 12;
        }
        elseif( $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 4' )
        {
            $gp = 10;
        }
        elseif( $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 5' )
        {
            $gp = 9;
        }
        elseif( $row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 6')
        {
            $gp = 8;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'Creche'){
            $gp = 17;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 7' && $row['CLASSE 2023-2024 FRANÇAIS'] == 'Cambridge'){
            $gp = 7;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 7' && $row['CLASSE 2023-2024 FRANÇAIS'] != 'Cambridge'){
            $gp = 6;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 8' && $row['CLASSE 2023-2024 FRANÇAIS'] == 'Cambridge'){
            $gp = 5;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 8' && $row['CLASSE 2023-2024 FRANÇAIS'] != 'Cambridge'){
            $gp = 4;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 9' && $row['CLASSE 2023-2024 FRANÇAIS'] != 'Cambridge'){
            $gp = 3;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 9' && $row['CLASSE 2023-2024 FRANÇAIS'] == 'Cambridge'){
            $gp = 18;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 10' && $row['CLASSE 2023-2024 FRANÇAIS'] != 'Cambridge'){
            $gp = 2;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 10' && $row['CLASSE 2023-2024 FRANÇAIS'] == 'Cambridge'){
            $gp = 19;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 11' && $row['CLASSE 2023-2024 FRANÇAIS'] == 'Cambridge'){
            $gp = 1;
        }
        elseif($row['CLASSE 2023-2024 ENGLISH'] == 'YEAR 12' && $row['CLASSE 2023-2024 FRANÇAIS'] == 'Cambridge'){
            $gp = 20;
        }
        else{
            $gp = 2;
        }
        return $gp;
    }


}
