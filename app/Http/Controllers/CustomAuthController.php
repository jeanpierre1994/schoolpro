<?php

namespace App\Http\Controllers;

use App\Mail\NotificationNewCompte; 
use Illuminate\Http\Request;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; 
use App\Http\Controllers\BaseController as BaseController;
use RealRashid\SweetAlert\Facades\Alert as Alert;


class CustomAuthController extends BaseController
{
    
    public function login()
    {
        return view('auth.login');
    }  

    // login for api
    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

         // vérifier si le champs email est un email ou code identification
         $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
 
         if (preg_match($pattern, $request->get('email')) == 1) {
             //vérification email
             request()->merge(['email' => $request->get('email')]);
             $credentials = $request->only(['email', 'password']);
         }else{
             // vérification par identification
             request()->merge(['username' => $request->get('email')]);
             $credentials = $request->only(['username', 'password']);
         }   

         if (Auth::attempt($credentials)) { 

            $authUser = Auth::user(); 
            $success['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken; 
            $success['name'] =  $authUser->name;
   
            return $this->sendResponse($success, 'User signed in');
        }else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }  
        
    }

    public function signOutApi() {
        Session::flush();
        Auth::logout(); 
        $success['data'] = "success logout";
        return $this->sendResponse($success, 'User logout');   
     }

      

    
     public function customLogin(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

         // vérifier si le champs email est un email ou code identification
         $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
 
         if (preg_match($pattern, $request->get('email')) == 1) {
             //vérification email
             request()->merge(['email' => $request->get('email')]);
             $credentials = $request->only(['email', 'password']);
         }else{
             // vérification par identification
             /*request()->merge(['username' => $request->get('email')]);
             $credentials = $request->only(['username', 'password']);*/
         }   

         if (isset($credentials) && Auth::attempt($credentials)) { 
            $user = Auth()->user(); 
            // vérifier le profil de l'utilisateur


            if (!$user->enable) {
                # code... 
                Alert::toast("Votre compte est inactif.",'error');
                Session::flush();
                Auth::logout(); 
                return redirect()->route('authentification');
            }

            if ($user->profil_id == 2) { // étudiant
                # code...
                $update_user = User::find($user->id);
                if (!empty($user->first_connexion)) {
                    # code... 
                    $update_user->setAttribute("last_connexion",date("Y-m-d H:i:s"));
                    $update_user->setAttribute("login_count",1);
                    $update_user->update();
                } else {
                    # code...
                    $update_user->setAttribute("first_connexion",date("Y-m-d H:i:s"));
                    $update_user->setAttribute("last_connexion",date("Y-m-d H:i:s"));
                    $update_user->setAttribute("login_count",$user->login_count+1);
                    $update_user->update();
                }
                
                return redirect()->route('dashboard_etudiant'); 
            } elseif ($user->profil_id == 3) { // parent
                # code...
                $update_user = User::find($user->id);
                if (!empty($user->first_connexion)) {
                    # code... 
                    $update_user->setAttribute("last_connexion",date("Y-m-d H:i:s"));
                    $update_user->setAttribute("login_count",1);
                    $update_user->update();
                } else {
                    # code...
                    $update_user->setAttribute("first_connexion",date("Y-m-d H:i:s"));
                    $update_user->setAttribute("last_connexion",date("Y-m-d H:i:s"));
                    $update_user->setAttribute("login_count",$user->login_count+1);
                    $update_user->update();
                }
                return redirect()->route('dashboard_parent'); 
            } elseif ($user->profil_id == 1) { // admin
                # code...
                $update_user = User::find($user->id);
                if (!empty($user->first_connexion)) {
                    # code... 
                    $update_user->setAttribute("last_connexion",date("Y-m-d H:i:s"));
                    $update_user->setAttribute("login_count",1);
                    $update_user->update();
                } else {
                    # code...
                    $update_user->setAttribute("first_connexion",date("Y-m-d H:i:s"));
                    $update_user->setAttribute("last_connexion",date("Y-m-d H:i:s"));
                    $update_user->setAttribute("login_count",$user->login_count+1);
                    $update_user->update();
                }

                return redirect()->route('dashboard'); 
            }elseif ($user->profil_id == 4) { // professeur
                # code...
                $update_user = User::find($user->id);
                if (!empty($user->first_connexion)) {
                    # code... 
                    $update_user->setAttribute("last_connexion",date("Y-m-d H:i:s"));
                    $update_user->setAttribute("login_count",1);
                    $update_user->update();
                } else {
                    # code...
                    $update_user->setAttribute("first_connexion",date("Y-m-d H:i:s"));
                    $update_user->setAttribute("last_connexion",date("Y-m-d H:i:s"));
                    $update_user->setAttribute("login_count",$user->login_count+1);
                    $update_user->update();
                }

                return redirect()->route('dashboard'); 
            }
            
            else{
                # code...
                Alert::toast("Nom d'utilisateur ou mot de passe invalide.",'error');

                return redirect()->route('authentification');
            }
            
        }else{
            Alert::toast("Nom d'utilisateur ou mot de passe invalide.",'error');

            return redirect()->route('authentification');
        } 
    
    }
    
    public function customRegistration(Request $request)
    {  
        $request->validate([
            'nom' => 'required',
            'prenoms' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3', 
        ]);

        $input = $request->all();
 
       // $check = $this->create($data);
        $input = $request->all();
        $password = $input['password'];
        $input['password'] = Hash::make($input['password']); 
        $code_email =  sha1(time());

       // générer le code  au format : BJ2109301937POM (0123456789AZERTYUIOPQSDFGHJKLMNBVCXW)

       // end générer le code 

        $user = new User();  
        $user->setAttribute('nom', $input['nom']);
        $user->setAttribute('prenoms', $input['prenoms']); 
        $user->setAttribute('email',  $input['email']);  
        $user->setAttribute('code_email', $code_email);  
        $user->setAttribute('password', $input['password']);
        //$user->setAttribute('profil_id',2); // 1 pour le profil utilisateur par défaut
        //$user->setAttribute('first_connexion',  new \DateTime()); 
        //$user->setAttribute('last_connexion', new \DateTime());   
        $user->save(); 

        // envoie de mail 
        // send mail for user after registration
        // générer code activation de compte
       $name = $input['prenoms']." ".$input['nom'];
       $contenu = [
        'nom_prenoms' => $name,
        'email' => $user->email ,
        'mot_de_passe' => $password,
        'subject'=>'Nouveau compte',
        'code_activation' => $user->code_email,
        ]; 

        try {
            
            Mail::to($user->email)->queue(new NotificationNewCompte($contenu));  
                // si aucun des cas ci-dessus n'est vérifier alors on redirige l'utilisateur sur le dashboard
                return redirect()->route('index')->with('success', 'Enregistrement effectué avec succès. Un mail vous a été envoyé et contenant vos informations de connexion. Veuillez vous y rendre et cliquez sur le lien d\'activation');
        } catch(\Exception $e){
            
            return redirect()->route('index')->with('success', 'Enregistrement effectué avec succès. Echec d\'envoie de vos informations de connexion par mail. Bien vouloir contacter l\'administrateur plus tard.');

        }
          
    }
 
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    
     

    public function signOut() {
        Session::flush();
        Auth::logout(); 
        Alert::toast("Vous êtes déconnecté avec succès.",'success');
        return redirect()->route('authentification');
    }

    public function checkmailConfirmation($code_activation){ 
        // vérifier si l'utilisateur existe
        $user = User::where('code_email',$code_activation)->orderBy('id', 'desc')->first();
        if(!empty($user)){ // si l'utilisateur existe on vérifier si le compte est déjà actif
            if (!empty($user->enable) && $user->enable == 1 && !empty($user->email_verified_at)) { // si le compte est déjà actif on send un message avec redirection sur la page public
                # code...
                return redirect()->route('index')->with('success','Votre compte est déjà actif');
            }else{ // sinon on active le compte
                $enable = true; 
                $email_validation = date('Y-m-d H:i:s');
                $user->setAttribute('enable', $enable);
                $user->setAttribute('email_verified_at', $email_validation);
                $user->update();
                return view('emails.confirmation_email');
            }
        }else{
            return redirect()->route('index')->with('error','Echec lors de la validation de votre compte');
        }
 
    } 

    // check dashboard
    // login with email and password
    public function checkDashboard(Request $request)
    {  
        return redirect()->route('admin.dashboard'); 
    }
}