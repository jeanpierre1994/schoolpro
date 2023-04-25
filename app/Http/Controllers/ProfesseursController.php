<?php

namespace App\Http\Controllers;

use App\Models\Groupepedagogiques;
use App\Models\Matiereprofesseurs;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class ProfesseursController extends Controller
{
    //
    public function index(Request $request){
        $profil_professeur = Profil::where("libelle","PROFESSEUR")->first();
        if ($profil_professeur) {
            # code...
            $professeurs = User::where("profil_id",$profil_professeur->id)->orderBy("id","desc")->get();
        } else {
            # code...
            $professeurs = null;
        } 
        return view("backend.administrations.professeurs.index", compact("professeurs"));
    }

    public function create(Request $request){ 
        return view("backend.administrations.professeurs.create");
    }

    public function store(Request $request){ 
        $profil_professeur = Profil::where("libelle","PROFESSEUR")->first();
        $request->validate([
            'nom' => 'required',
            'prenoms' => 'required',
            'telephone' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required',
           // 'g-recaptcha-response' => 'required|recaptcha'
        ]);

        $input = $request->all();  
        $password = $input['password'];
        $password_ok = Hash::make($input['password']);
        $code_email =  sha1(time()); 

        $user = new User();
        $user->setAttribute('name', $input['nom']." ".$input['prenoms']);
        $user->setAttribute('nom', $input['nom']);
        $user->setAttribute('prenoms', $input['prenoms']);
        $user->setAttribute('telephone', $input['telephone']);
        $user->setAttribute('email',  $input['email']);
        $user->setAttribute('code_email', $code_email);
        $user->setAttribute('password', $password_ok);
        $user->setAttribute('enable', true);
        $user->setAttribute('profil_id',$profil_professeur->id); 
        $user->save(); 
        return redirect()->route("professeurs.index")->with("success","Enregistrement effectué avec succès.");
     } 

    public function edit(Request $request,$id){ 
        $id = Crypt::decrypt($id);
        $professeur = User::find($id);
        return view("backend.administrations.professeurs.edit", compact("professeur"));
    }

    public function update(Request $request,$id){ 
        $id = Crypt::decrypt($id);
        $professeur = User::find($id);
        $request->validate([
            'nom' => 'required|max:30',
            'prenoms' => 'required|max:30',
            'telephone' => 'required|max:20', 
            'email' => 'required|max:100',   
        ]);

        $check_user = User::where("id","!=",$professeur->id)->where("email",$request->email)->exists();

        if ($check_user) {
            # code...
            redirect()->back()->with("error","L'adresse e-mail existe déjà.");
        }

        $input = $request->all();   
        $professeur->setAttribute('name', $input['nom']." ".$input['prenoms']);
        $professeur->setAttribute('nom', $input['nom']);
        $professeur->setAttribute('prenoms', $input['prenoms']);
        $professeur->setAttribute('telephone', $input['telephone']);
        $professeur->setAttribute('email',  $input['email']); 
        if (!empty($input['password'])) {
            $password = Hash::make($input['password']);
            $professeur->setAttribute('password', $password);
        }
        $professeur->save(); 
        return redirect()->route("professeurs.index")->with("success","Enregistrement effectué avec succès.");
     }

    public function matieres(Request $request){ 
        $profil_professeur = Profil::where("libelle","PROFESSEUR")->first();
        $professeurs = User::where("profil_id",$profil_professeur->id)->get();
        $groupepedagogiques = Groupepedagogiques::orderBy("libelle_classe")->get(["id","libelle_classe"]);
        return view("backend.administrations.professeurs.matieres", compact("professeurs","groupepedagogiques"));
    }

 
    public function matiereStore(Request $request){  

        $request->validate([
            'nom' => 'required|max:30',
            'prenoms' => 'required|max:30',
            'professeur_id' => 'required', 
            'matiere_id' => 'required',   
        ]);

        $check_matiere = Matiereprofesseurs::where("matiere_id",$request->matiere_id)->where("professeur_id",$request->professeur_id)->exists();

        if ($check_matiere) {
            # code...
            redirect()->back()->with("error","La matière est déjà associée au professeur.");
        }

        $save_data = new Matiereprofesseurs();   
        $save_data->setAttribute('matiere_id', $request->matiere_id);
        $save_data->setAttribute('professeur_id', $request->professeur_id); 
        $save_data->setAttribute('statut_id', 1); 
        $save_data->setAttribute('created_by', auth()->user()->id); 
        $save_data->setAttribute('updated_by', auth()->user()->id); 
        $save_data->save(); 
        return redirect()->route("professeurs.matieres")->with("success","Enregistrement effectué avec succès.");
    }
}
