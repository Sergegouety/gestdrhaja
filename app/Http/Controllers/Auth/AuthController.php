<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Mews\Captcha\Captcha;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use DB;

class AuthController extends Controller
{


  public function index()
    {
          return view('Frontend.login');
    }

    public function firstConnexion()
    {
          $agent=getAgentFunctionById(Auth::id());
         // dd($agent);
          return view('Frontend.login_first')->with('agent',$agent);
    }

    public function home()
    {

         if(Auth::user()->state==1)
                                   {
                                    $agent=getAgentFunctionById(Auth::id());
                                    Session::put('function_key', $agent);
                                    return redirect()->route('super.dashboard');

                                    } else {
                                      # 2 pour les utilisateur simple
                                        $agent=getAgentFunctionById(Auth::id());
                                        Session::put('function_key', $agent);
                                       //return redirect()->route('agent.profil',Auth::id());
                                       return redirect()->route('view.comdash');
                                    }

    }

    public function showForm()
    {

          return view('Frontend.login');

    }


    public function showLoginForm()
    {


        if (Auth::check()){

            return redirect()->route('admin.dashboard');
        }
        else{
            return view('Frontend.login');
        }
    }

    public function doLocked()
    {
        if(Auth::user()){
            Session::put('_email', Auth::user()->email);
            Session::put('_firstname', Auth::user()->firstname);
            Session::put('_lastname', Auth::user()->lastname);
            Session::put('_avatar', Auth::user()->avatar);

            Session::forget('lastActivityTime');
            Session::flash('warning', 'Votre session a bien été vérouillé');
            Auth::logout();
        }
        return view('app.auth.locked')->with(['isActive'=>'']);
    }


    public function doLogin(Request $request,Captcha $captcha)
    {

      //dd($req);
        $data = $request->all();

        $captchaValue = $captcha->check($request->captcha);
        //dd($captchaValue);

    	$rules = array(
	        'email'	=> 'required',
	        'password'	=> 'required',
	    );

	     $messages=[
	        'email.required' => 'L adresse email est obligatoire',
	        'password.required'  => 'Le mot de passe est obligatoire',
	               ];

        if($captchaValue){

                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withErrors($validator);
                }
                else
                {
                   //dd($req);
                    $userdata = array(
                         'email' => $request->input('email'),
                         'password' => $request->input('password')
                    );
                    //$credentials = $request->only(['email', 'password']);

                    if (Auth::guard()->attempt($userdata)) {

                            $dt = Carbon::today();
                            //dd(Auth::user()->state);
                            $firstConnexion =Auth::user()->first_connexion;
                            //dd($firstConnexion);
                            if($firstConnexion){
                                if(Auth::user()->state==1)
                                {
                                 $agent=getAgentFunctionById(Auth::id());
                                 Session::put('function_key', $agent);
                                 return redirect()->route('super.dashboard');

                                 } else {
                                   # 2 pour les utilisateur simple
                                     $agent=getAgentFunctionById(Auth::id());
                                     Session::put('function_key', $agent);
                                    //return redirect()->route('agent.profil',Auth::id());
                                    return redirect()->route('view.comdash');
                                 }
                             }else{
                                return redirect()->route('first.connexion');
                             }

                     }else{
                          Session::flash('error','Email ou mot de passe incorrect');
                          return Redirect::back();
                        }
                }

        }else{

            Session::flash('error','Valeur du captcha incorrect');
            return Redirect::back();

        }

    }

    public function doLoginFromLocked(Request $req)
    {
        $rules = array(
            'password'  => 'required',
        );

         $messages=[
            'password.required'  => 'Le mot de passe est obligatoire',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('adminLocked')
                ->withErrors($validator);
        }
        else
        {
            $userdata = array(
                'email'     => Session::get('_email'),
                'password'  => Input::get('password')
            );

            if (Auth::attempt($userdata)) {
                return redirect()->intended();
            }
            else{
                Session::flash('error','Mot de passe incorrect');
                return redirect()->back();
            }
        }

    }






  public function doLoginFromNum(Request $req)
    {

      //dd($req);

      $session = activeSessionId();
        //dd($session);

        $rules = array(
            'number' => 'required',
            'password'  => 'required',
        );

         $messages=[
            'number.required' => 'Le numero etudiant est obligatoire',
            'password.required'  => 'Le mot de passe est obligatoire',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to('verif.show')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }
        else
        {
           $userdata = array(
                'numero'    => Input::get('number'),
                'password'  => Input::get('password'),
                'status'    => 1
            );

            if (Auth::attempt($userdata, Input::get('remember'))) {

                    $student = Student::where('user_id',Auth::id())->first();
                  //$a=Payment::check_payment($student->student_id_n,$session=$session);

                  if(Payment::check_payment($student->student_id_n,$session=7))
                  {
                     //dd($a);
                     return redirect()->route('reinscription.one');
                  }
                  else
                 {
                     return redirect()->route('deja.show');
                 }

            }
            else{

                Session::flash('error','Numéro étudiant ou mot de passe incorrect');
                return Redirect::back()->withInput(Input::except('password'));
            }
        }

    }

    public function doLogout()
	{
	   Auth::logout();
       Session::flush();
       Session::flash('success','Vous avez bien été déconnecté !');

        return redirect()->route('showLog');
	}

    public function newpassword(Request $request)
	{
       //dd($request,$request->password,$request->password_confirmation);
       $password = $request->password;
       $password_confirmation = $request->password_confirmation ;
       $user_id = $request->user_id;
       if($password == $password_confirmation){

         $password = Hash::make($password);
         $affected = DB::table('users')
                                        ->where('id', $user_id)
                                        ->update(['password' => $password,
                                                  'first_connexion' => 1,
                                                ]);

                                                if(Auth::user()->state==1)
                                                {
                                                 $agent=getAgentFunctionById(Auth::id());
                                                 Session::put('function_key', $agent);
                                                 return redirect()->route('super.dashboard');

                                                 } else {
                                                   # 2 pour les utilisateur simple
                                                     $agent=getAgentFunctionById(Auth::id());
                                                     Session::put('function_key', $agent);
                                                    //return redirect()->route('agent.profil',Auth::id());
                                                    return redirect()->route('view.comdash');
                                                 }


       }else{
        Session::flash('error','Les mots de passe ne sont pas identiques');
            return Redirect::back();
       }
	}

    public function updatefirst($email)
	{

        $affected = DB::table('users')
                                        ->where('email', $email)
                                        ->update([
                                                  'first_connexion' => 1
                                                ]);

	}
}
