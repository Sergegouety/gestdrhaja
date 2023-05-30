<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\typeRequest;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Exception;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Services\uploadFile;
use Carbon\Carbon;
use PDF;

use App\Repositories\UserRepository;
use App\Repositories\DemandeRepository;

use App\Exports\AgentExport;
use App\Exports\SearchAgentExport;

use App\Models\Direction;
use App\Models\Grade_sd;
use App\Models\SousDirection;
use App\Models\Service;
use App\Models\Materiel;
use App\Models\User;
use App\Models\Grade;
use App\Models\Fournisseur;
use App\Models\Stock;
use App\Models\Demande;
use App\Models\Group_materiel;
use App\Models\Documentation;
use App\Models\Fabricant;
use App\Models\Poste;
use App\Models\Niveauetude;
use App\Models\Fonction;
use App\Models\Diplome;
use App\Models\Categorie;
use Illuminate\Support\Facades\Crypt;


class UserController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function profil($id_,UserRepository $userRepository,DemandeRepository $demandeRepository)
  {

      $id =  Crypt::decrypt($id_);
  
      $directions=Direction::All();
      $sousdirections=SousDirection::All();
      $grade_sd=Grade_sd::All();
      $services=Service::All();
      $agents=User::All();
      $grades=Grade::All();
      $grade_sds=Grade_sd::All();
      $postes=Poste::All();
      $niveauetude=Niveauetude::All();
      $diplomes=Diplome::All();

    $agent=$userRepository->getAgentById($id);
    $doc_embauche=$userRepository->getAgentDocsById($id,1);
    $rel_travail=$userRepository->getAgentDocsById($id,2);
    $doc_santes=$userRepository->getAgentDocsById($id,3);
    $doc_formations=$userRepository->getAgentDocsById($id,4);
    $doc_banques=$userRepository->getAgentDocsById($id,5);
    $doc_autres=$userRepository->getAgentDocsById($id,6);
    $doc_disciplines=$userRepository->getAgentDocsById($id,7);
    $doc_postes=$userRepository->getAgentDocsById($id,8);
    
    $filiation=$userRepository->getAgentFiliationById($id);
    $demandes=$demandeRepository->getDemandesByUser($agent->direction_id,$agent->sousdirection_id,$agent->service_id,$id,'','','','','');
    $fonctions=$userRepository->getAgentFunctionById($id);
    //dd($agent,$fonctions);
    return view('Frontend.agent_profil')->with([
        'agent'=>$agent,
        'doc_embauches'=>$doc_embauche,
        'rel_travails'=>$rel_travail,
        'doc_santes'=>$doc_santes,
        'doc_formations'=>$doc_formations,
        'doc_banques'=>$doc_banques,
        'doc_autres'=>$doc_autres,
        'doc_disciplines'=>$doc_disciplines,
        'doc_postes'=>$doc_postes,
        'filiations'=>$filiation,
        'directions'=>$directions,
        'sousdirections'=>$sousdirections,
        'grade_sds'=>$grade_sd,
        'services'=>$services,
        'agents'=>$agents,
        'postes'=>$postes,
        'niveauetudes'=>$niveauetude,
        'grades'=>$grades,
        'diplomes'=>$diplomes,
        'demandes'=>$demandes,
        'fonctions'=>$fonctions
        
    ]);
  }

 
  public function create_form_agent()
  {

    $directions=Direction::All();
     $sousdirections=SousDirection::All();
     $grade_sd=Grade_sd::All();
      $services=Service::All();
      $agents=User::All();
      $grades=Grade::All();
      $grade_sds=Grade_sd::All();
      $postes=Poste::All();
      $niveauetude=Niveauetude::All();
      $diplomes=Diplome::All();

      return view('Frontend.agent_form')->with([
        'directions'=>$directions,
        'grade_sd'=>$grade_sd,
        'sousdirections'=>$sousdirections,
        'services'=>$services,
        'agents'=>$agents,
        'grades'=>$grades,
        'grade_sds'=>$grade_sds,
        'postes'=>$postes,
        'niveauetudes'=>$niveauetude,
        'diplomes'=>$diplomes
    ]);

  }

  public function store_agent(Request $request, UserRepository $userRepository)
  {

     DB::beginTransaction();
      try
      {
          $uid=$userRepository->addUser($request);
          $details=$userRepository->addUserFunction($request,$uid);
        
      }
      catch (Exception $e)
       {
                DB::rollback();
               Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
               return Redirect::back();
       }   
               DB::commit();
              //return Redirect::back()->with('success',"Attribution ajoutée avec succès");
              return redirect()->route('agent.profil',Crypt::encrypt($uid))->with('success',"Agent ajouté avec succès");
    
  }

  public function store_fonction(Request $request, UserRepository $userRepository)
  {

    $uid=$request->get('uid');

     DB::beginTransaction();
      try
      {
  
          $details=$userRepository->addUserFunction($request,$uid);
        
      }
      catch (Exception $e)
       {
                DB::rollback();
               Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
               return Redirect::back();
       }   
               DB::commit();
              //return Redirect::back()->with('success',"Attribution ajoutée avec succès");
              return redirect()->route('agent.profil', Crypt::encrypt($uid))->with('success',"Agent ajouté avec succès");
    
  }

  public function update_agent(Request $request, UserRepository $userRepository)
  {
       //dd($request);
    $actions = DB::table('action')->where('responsable' ,$request->get('nom'))->get();
    $c = count($actions);
    //dd($c);
     DB::beginTransaction();
      try
      {
          $userRepository->editUser($request);
          // $userRepository->editUserFunction($request);
          // if($c){ $userRepository->editUserPtab($request);}
        
      }
      catch (Exception $e)
       {
                DB::rollback();
               Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
               return Redirect::back();
       }   
               DB::commit();
              return Redirect::back()->with('success',"Agent modifié avec succès");
    
  }


  public function update_password(Request $request, UserRepository $userRepository)
  {
       //dd($request);
        $motdepasse=$request->get('motdepasse');
        $cmotdepasse=$request->get('cmotdepasse');

     
       if($motdepasse==$cmotdepasse){

        if(Auth::user()->state==1){

                    $userRepository->editpassword($request);
                    Session::flash('success','Mot de passe Modifié avec succès !');
                    return Redirect::back();

              }else{

                    $userRepository->editpassword($request);
                    Auth::logout(); 
                    Session::flush();
                    Session::flash('success','Mot de passe Modifié avec succès !');
                    return redirect()->route('showLog');
                  }

                
            } else{

               Session::flash('error',"Mot de passe Différent, Réessayer svp");
               return Redirect::back();

            }

    
  }



  public function exportAgent(Request $request){
     

    return Excel::download(new AgentExport($request), 'report-agent.xlsx');

  }


   public function searchAgent(Request $request, UserRepository $userRepository)
  {
             
              $directions=Direction::All();    $direction_id='';
              $sousdirections=SousDirection::All();   $sousdirection_id='';
              $services=Service::All();    $service_id='';
              $page=$request->get('page');
              $ob_param=$request->all();
              $postes=Poste::All();
              $niveauetude=Niveauetude::All();
              $fonction=Fonction::All();
              $diplomes=Diplome::All();
              $categorie=Categorie::All();
              //dd($request);

              if($ob_param==[] && $page==''){ 
                  Session::forget('ob_param'); 
                }elseif($ob_param && $page==''){
                       Session::put('ob_param', $ob_param);
                }else{
                      $ob_param=Session::get('ob_param');
                }

             $agents=$userRepository->getAgentBySearch($ob_param);
             $countagents=$userRepository->countAgentBySearch($ob_param);
             
              return view('Frontend.recherche_agent')->with([
                      'agents'=> $agents,
                      'countagents'=> $countagents,
                      'directions'=> $directions,
                      'sousdirections'=> $sousdirections,
                      'services'=> $services,
                      'postes'=>$postes,
                      'niveauetudes'=>$niveauetude,
                      'fonctions'=> $fonction,
                      'diplomes'=> $diplomes,
                      'categories'=> $categorie
              ]);
  }

  public function exportSearchAgent(Request $request){
    //dd($request);
    return Excel::download(new SearchAgentExport($request), 'report-agent.xlsx');
  }

   public function organigramme()
  {
       
              return view('Frontend.organigramme');
  }

  public function storefiliation(Request $request, UserRepository $userRepository, uploadFile $uploadFile)
  {

     //dd($request);
    $user_id=$request->get('user_id');
    if($request->file('cni')){
      $file_cni = $uploadFile->upload($request,'cni');
    }else{$file_cni='';}
    if($request->file('photo')){
      $file_photo = $uploadFile->upload($request,'photo');
    }else{$file_photo='';}
    if($request->file('acte_mariage')){
      $file_acte_mariage = $uploadFile->upload($request,'acte_mariage');
    }else{$file_acte_mariage='';}
    if($request->file('acte_naissance')){
      $file_acte_naissance = $uploadFile->upload($request,'acte_naissance');
    }else{$file_acte_naissance='';}

    //dd($file_cni,$file_photo,$file_acte_mariage,$file_acte_naissance);
     
     DB::beginTransaction();
      try
      {
          $uid=$userRepository->addFiliation($request,$file_cni,$file_photo,$file_acte_mariage,$file_acte_naissance);
      }
      catch (Exception $e)
       {
                DB::rollback();
               Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
               return Redirect::back();
       }   
               DB::commit();
              //return Redirect::back()->with('success',"Attribution ajoutée avec succès");
              return redirect()->route('agent.profil',Crypt::encrypt($user_id))->with('success',"Filiation ajoutée avec succès");
    
  }


  public function storeDocument(Request $request, UserRepository $userRepository, uploadFile $uploadFile)
  {

     //dd($request);
    $user_id=$request->get('user_id');
     
     DB::beginTransaction();
      try
      {

          if($request->file('doc')){
              $file_doc = $uploadFile->upload($request,'doc');
              $file_name=$request->get('file_name');
              $uid=$userRepository->addAgentDoc($request,$file_name,$file_doc,);
          }

          if($request->file('contrat_travail')){
          $file_doc = $uploadFile->upload($request,'contrat_travail');
          $uid=$userRepository->addAgentDoc($request,'Contrat de travail',$file_doc,);
          }

          if($request->file('prise_service')){
          $file_doc = $uploadFile->upload($request,'prise_service');
          $uid=$userRepository->addAgentDoc($request,'Prise de service',$file_doc,);
          }

          if($request->file('note_service')){
          $file_doc = $uploadFile->upload($request,'note_service');
          $uid=$userRepository->addAgentDoc($request,'Note de service',$file_doc,);
          }

          if($request->file('cv')){
          $file_doc = $uploadFile->upload($request,'cv');
          $uid=$userRepository->addAgentDoc($request,'Curiculum vitae',$file_doc,);
          }

          if($request->file('diplome')){
          $file_doc = $uploadFile->upload($request,'diplome');
          $uid=$userRepository->addAgentDoc($request,'Dipôme',$file_doc,);
          }

          if($request->file('photo')){
          $file_doc = $uploadFile->upload($request,'photo');
          $uid=$userRepository->addAgentDoc($request,'Photo',$file_doc,);
          }

          if($request->file('cni')){
          $file_doc = $uploadFile->upload($request,'cni');
          $uid=$userRepository->addAgentDoc($request,'Carte d\'Identité',$file_doc,);
          }

          if($request->file('passeport')){
          $file_doc = $uploadFile->upload($request,'passeport');
          $uid=$userRepository->addAgentDoc($request,'Passeport',$file_doc,);
          }

          if($request->file('extrait_naissance')){
          $file_doc = $uploadFile->upload($request,'extrait_naissance');
          $uid=$userRepository->addAgentDoc($request,'Extrait de naissance',$file_doc,);
          }

          if($request->file('certif_nationalite')){
          $file_doc = $uploadFile->upload($request,'certif_nationalite');
          $uid=$userRepository->addAgentDoc($request,'Certificat de nationalité',$file_doc,);
          }

          if($request->file('casier_judiciaire')){
          $file_doc = $uploadFile->upload($request,'casier_judiciaire');
          $uid=$userRepository->addAgentDoc($request,'Casier judiciaire',$file_doc,);
          }
         
      }
      catch (Exception $e)
       {
                DB::rollback();
               Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
               return Redirect::back();
       }   
               DB::commit();
              //return Redirect::back()->with('success',"Attribution ajoutée avec succès");
              return redirect()->route('agent.profil',Crypt::encrypt($user_id))->with('success',"Document(s) ajouté(s) avec succès");
    
  }


  public function updateprofilphoto(Request $request, UserRepository $userRepository, uploadFile $uploadFile)
  {

     //dd($request);
      $user_id=$request->get('user_id');
     
     DB::beginTransaction();
      try
      {

              $file_doc = $uploadFile->upload($request,'photo_identite');

              DB::table('users')
                        ->where('id', $user_id)
                        ->update(['photodeprofil' => $file_doc]);
              
      }
      catch (Exception $e)
       {
                DB::rollback();
               Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
               return Redirect::back();
       }   
               DB::commit();
              //return Redirect::back()->with('success',"Attribution ajoutée avec succès");
              //return redirect()->route('agent.profil',Crypt::encrypt($user_id))->with('success',"Document(s) ajouté(s) avec succès");
               return Redirect::back()->with('success',"Document(s) ajouté(s) avec succès");
    
    }


  public function showInterimByAgnetId($user_id)
  {

            
               $agent_function= getAgentById($user_id);
            
            $direction_id =$agent_function->direction_id;
            $sousdirection_id =$agent_function->sousdirection_id;
            $service_id =$agent_function->service_id;
            $level =$agent_function->level;
            if($level==2){$service_id ='';}
            if($level==3){$sousdirection_id ='';}
            if($level==4){$direction_id ='';}
            if($level==6){$direction_id ='';}
            if($level==5){$direction_id ='';}
            //dd($agent_function);
            $agents =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->select('users.id','users.nomprenoms','users.state')
             ->where('users.id', '<>', $user_id)
             ->where('agent_fonction.level', $level)
             ->when($direction_id, function ($query, $direction_id) 
                                    {return $query->where('agent_fonction.direction_id', $direction_id);}
                                        )
             ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                    {return $query->where('agent_fonction.sousdirection_id', $sousdirection_id);}
                                        )
             ->when($service_id, function ($query, $service_id) 
                                    {return $query->where('agent_fonction.service_id', $service_id);}
                                        )
            ->orderBy('users.nomprenoms', 'asc')
            ->get();
     //dd( $agents);

    $html_first = '<option value=""></option>';
    

      foreach ($agents as $agent)
      {
           $html_first = $html_first.'<option value="'.$agent->id.'">'.$agent->nomprenoms.'</option>';
      }


      $obj = new \stdClass;
      $obj->html_first = $html_first;
     
      return response()->json($obj);

  }


  public function showAgentByServiceID($service_id)
  {

     $agents =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->select('users.id','users.nomprenoms','users.state')
             ->where([
                       'agent_fonction.service_id' =>$service_id
                    ])
            ->orderBy('users.nomprenoms', 'asc')
            ->get();
     //dd( $agents);

    $html_first = '<option value=""></option>';
    

      foreach ($agents as $agent)
      {
           $html_first = $html_first.'<option value="'.$agent->id.'">'.$agent->nomprenoms.'</option>';
      }


      $obj = new \stdClass;
      $obj->html_first = $html_first;
     
      return response()->json($obj);

  }

  public function showAgentInterimaire($agent_id)
  {

      $agent=getAgentById($agent_id);
      $grade_id= $agent->level;
      $direction_id= $agent->direction_id;
      $sousdirection_id= $agent->sousdirection_id;
      $service_id= $agent->service_id;

     //si c'est l'dmininstrateur ==> administrateur adjoint
      if($grade_id==8){$agents =DB::table('users')->where([
                       'grade_id' =>7 ])
               ->get();

      }
      //si c'est l'dmininstrateur adjoint  ==> tous les directeurs
    if($grade_id==7){
        $agents =DB::table('users')
             ->where([
                       'grade_id' =>8
                    ])
               ->get();

      }

      if($grade_id==5){
        $agents =DB::table('users')
             ->where([
                       'grade_id' =>5,
                    ])
               ->get();

      }

      if($grade_id==4){
        $agents =DB::table('users')
             ->where([
                       'grade_id' =>4,
                       'direction_id'=>$direction_id
                    ])
               ->get();
      }

      if($grade_id==2){
        $agents =DB::table('users')
             ->where([
                       'grade_id' =>2,
                       'direction_id'=>$direction_id
                    ])
               ->get();
      }

      if($grade_id==1){
        $agents =DB::table('users')
             ->where('service_id',$service_id)
               ->get();
      }

      $html_first = '<option value=""></option>';

      foreach ($agents as $agent)
      {
           $html_first = $html_first.'<option value="'.$agent->id.'">'.$agent->nomprenoms.'</option>';
      }

      $obj = new \stdClass;
      $obj->html_first = $html_first;
     
      return response()->json($obj);


  }

  public function showAgentByID($id)
  {

     $agents =DB::table('users')
            ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->select('users.id','users.nomprenoms','users.state','users.badge','users.matricule','agent_fonction.service_id')
             ->where([
                       'users.id' =>$id
                    ])
              ->first();
     
      $obj = new \stdClass;
      $obj->responsable = $agents->nomprenoms;
      $obj->badge = $agents->badge;
      $obj->service = $agents->service_id;
     
      return response()->json($obj);

  }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    
  }
  
}

?>