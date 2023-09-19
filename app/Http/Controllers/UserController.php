<?php

namespace App\Http\Controllers;

use App\Mail\NotificationNewCompte;
use App\Models\Genres;
use App\Models\Personnes;
use App\Models\Profil; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {         
        $users =  Personnes::
            leftjoin("users", "users.id", "=", "personnes.compte_id")
            ->leftjoin("genres", "genres.id", "=", "personnes.genre")
            ->leftjoin("profils", "profils.id", "=", "users.profil_id") 
            ->where("users.profil_id","!=",2)->where("users.profil_id","!=",3)->where("users.profil_id","!=",4)
            ->select(["personnes.nom", "personnes.prenoms", "personnes.tel", "personnes.email", "personnes.updated_at", "genres.id as id_genre", "genres.libelle as libelle_genre", "personnes.id","profils.libelle as libelle_profil"])
            ->get(); 
        return view("backend/users.index",compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genres::where("statut_id", 1)->get();
        $profils = Profil::where("id","!=",2)->where("id","!=",3)->where("id","!=",4)->get(); // statut actif
        return view("backend/users.create", compact("profils","genres"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenoms' => 'required',
            'telephone' => 'required',
            'profil_id' => 'required',
            'email' => 'required|email|unique:users', 
            'password' => 'required',
            'genre_id' => 'required',
           // 'g-recaptcha-response' => 'required|recaptcha'
        ]);

        $input = $request->all(); 
        // générateur de mot de passe complexe
        // $password = $this->genererCodeAlphaNumeric(8);
        $password = $input['password'];
        $password_ok = Hash::make($input['password']);
        $code_email =  sha1(time()); 

        $user = new User();
        $user->setAttribute('name', $input['nom'] . " " . $input['prenoms']);
        $user->setAttribute('email',  $input['email']);
        $user->setAttribute('code_email', $code_email);
        $user->setAttribute('password', $password_ok);
        $user->setAttribute('enable', true);
        $user->setAttribute('profil_id', $request->profil_id);
        $user->save();

        // save data in table personne
        $save_by = auth()->user();
        $save_by = auth()->user();
        $personne = new Personnes();
        $personne->setAttribute('nom', $input['nom']);
        $personne->setAttribute('prenoms', $input['prenoms']);
        $personne->setAttribute('tel', $input['telephone']);
        $personne->setAttribute('email', $input['email']);
        $personne->setAttribute('genre', $input['genre_id']);
        $personne->setAttribute('statut_id', 1);
        $personne->setAttribute('compte_id', $user->id);
        $personne->setAttribute('created_by', $save_by->id);
        $personne->setAttribute('updated_by', $save_by->id);
        $personne->save();
        return redirect()->route("users.index")->with("success", "Enregistrement effectué avec succès.");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        $user =   Personnes::join("users", "users.id", "=", "personnes.compte_id")
        ->join("genres", "genres.id", "=", "personnes.genre")
        ->leftjoin("profils", "profils.id", "=", "users.profil_id") 
        ->where("users.profil_id","!=",2)->where("users.profil_id","!=",3)->where("users.profil_id","!=",4)
        ->where("personnes.id", $id)  
        ->select(["personnes.nom", "personnes.prenoms", "personnes.tel", "personnes.email", "personnes.updated_at", "genres.id as id_genre", "genres.libelle as libelle_genre", "personnes.id","profils.id as profil_id" ,"profils.libelle as libelle_profil"])
        ->first(); 
 
        $genres = Genres::where("statut_id", 1)->get(); 
        $profils = Profil::where("id","!=",2)->where("id","!=",3)->where("id","!=",4)->get(); // statut actif
        return view("backend/users.edit", compact("user","profils","genres"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $request->validate([
            'nom' => 'required|max:30',
            'prenoms' => 'required|max:30',
            'telephone' => 'required|max:20',
            'email' => 'required|max:100',
            'genre_id' => 'required',
            'profil_id' => 'required',
        ]);
        $personne = Personnes::find($id);
        $utilisateur = User::find($personne->compte_id);

        $check_user = User::where("id", "!=", $utilisateur->id)->where("email", $request->email)->exists();

        if ($check_user) {
            # code...
            redirect()->back()->with("error", "L'adresse e-mail existe déjà.");
        }

        $input = $request->all();
        $utilisateur->setAttribute('email',  $input['email']);
        if (!empty($input['password'])) {
            $password = Hash::make($input['password']);
            $utilisateur->setAttribute('password', $password);
        }
        $utilisateur->setAttribute('profil_id', $input['profil_id']);
        $utilisateur->update();
        $update_by = Auth()->user()->id;
        // update data in table personne
       
        $personne->setAttribute('nom', $input['nom']);
        $personne->setAttribute('prenoms', $input['prenoms']);
        $personne->setAttribute('tel', $input['telephone']);
        $personne->setAttribute('email', $input['email']);
        $personne->setAttribute('genre', $input['genre_id']);
        $personne->setAttribute('updated_by', $update_by);
        $personne->setAttribute('updated_at', date("Y-m-d H:i:s"));
        $personne->update();

        return redirect()->route("users.index")->with("success", "Enregistrement effectué avec succès.");
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
