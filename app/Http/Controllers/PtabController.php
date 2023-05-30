<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Services\uploadFile;
use Carbon\Carbon;
use PDF;
use App\Imports\PtabImport;
use App\Exports\PtabExport;

use App\Repositories\PtabRepository;

use App\Models\Direction;
use App\Models\SousDirection;
use App\Models\Service;
use App\Models\Periode;
use App\Models\Agent_fonction;
use App\Models\Droit_ptab;
use App\Models\Droit_ptab_detail;
use App\Models\Axe_strategique;
use App\Models\Extrant;
use App\Models\Master_action;
use App\Models\Master_activite;
use App\Models\Master_tache;
use App\Models\Action;
use App\Models\Activite;
use App\Models\Archive_action;
use App\Models\Parametre_bouton;


class PtabController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function indexptab(Request $request,PtabRepository $ptabrepository)
  {

    $ob_param=$request->all();
    
    $function_key=Session::get('function_key');
    $is_admin=$function_key->isptabadmin;
    $is_ptabvue=$function_key->isptabvue;
    $level=$function_key->level;
    $agent_direction_id=$function_key->direction_id;
    $agent_sousdirection_id=$function_key->sousdirection_id;
    $agent_service_id=$function_key->service_id;
    $agent_nom=Auth::user()->nomprenoms;
    $user_id=Auth::id();
    $year=$ob_param['annee']?? 2023;
    $param_nom=$ob_param['nom'] ?? null;
    $param_service= $ob_param['service'] ?? null;
    $param_sousdirection=$ob_param['sousdirection'] ?? null;
    $param_direction=$ob_param['direction'] ?? null;

    $is_agence = @get_isagence($level, $agent_sousdirection_id);
    $iscipac = @$function_key->iscipac;

    //dd($ob_param,$param_sousdirection);


    $page=$request->get('page');
    $direction_id=$request->get('direction');
    $sousdirection_id=$request->get('sousdirection');
    $directions=Direction::All();
    $sousdirections=SousDirection::All();
    $services=Service::All();
     if($ob_param==[] && $page==''){ 
                  Session::forget('ob_param'); 
                }elseif($ob_param && $page==''){
                       Session::put('ob_param', $ob_param);
                }else{
                      $ob_param=Session::get('ob_param');
                }
     //dd($function_key);
     if ($is_admin || $is_ptabvue) {
       $direction_id=$ob_param['direction']?? '';
       $sousdirection_id=$ob_param['sousdirection']?? '';
       $service_id=$ob_param['service']?? '';;
       $agent_nom=$ob_param['nom']?? '';
       $user_id='';

       $actions= $ptabrepository->getActionlist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',1);

       if($direction_id){
        $actions= $ptabrepository->getActionlist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',1);
       }

       if($sousdirection_id){
        $actions= $ptabrepository->getActionlist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',1);
       }
       if($param_service){
        //dd($param_service);
        $actions= $ptabrepository->getActivitelist('',$direction_id,$sousdirection_id,$param_service,$agent_nom,$user_id,$year,'',2);
       }

       if($agent_nom){
//dd($agent_nom);
        $agent = getnamebyparam($agent_direction_id,$sousdirection_id,$service_id,$agent_nom);
        if(@$agent->level == 1){$actions= $ptabrepository->getTachelist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',3); }elseif(@$agent->level == 2){$actions= $ptabrepository->getActivitelist('',$direction_id,$sousdirection_id,$param_service,$agent_nom,$user_id,$year,'',2);}else{$actions= $ptabrepository->getActionlist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',1);}
        
       }
       
     }elseif($level==5){ //Directeur

       $direction_id=$agent_direction_id;
       $sousdirection_id=$param_sousdirection ?? null;
       $service_id=$param_service ?? null;
       $agent_nom=$ob_param['nom']?? null;
       $user_id='';

//dd($direction_id,$sousdirection_id,$service_id,$agent_nom);

       $actions= $ptabrepository->getActionlist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',1);

       if($sousdirection_id){
        //dd($sousdirection_id,$service_id);
        $actions= $ptabrepository->getActionlist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',1);
       }
       if($param_service){
        //dd($param_service);
        $actions= $ptabrepository->getActivitelist('',$direction_id,$sousdirection_id,$param_service,$agent_nom,$user_id,$year,'',2);
       }

       if($agent_nom){
        
        $agent = getnamebyparam($agent_direction_id,$sousdirection_id,$service_id,$agent_nom);
        
        if(@$agent->level == 1){$actions= $ptabrepository->getTachelist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',3); }elseif(@$agent->level == 2){$actions= $ptabrepository->getActivitelist('',$direction_id,$sousdirection_id,$param_service,$agent_nom,$user_id,$year,'',2);}else{$actions= $ptabrepository->getActionlist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',1);}
        
       }

       $sousdirections=SousDirection::where('direction_id',$direction_id)->get();
       $services=Service::where('direction_id',$direction_id)->get();
       
     }elseif($level==3){ //chef d'agence & Sous directeur
       $direction_id=$agent_direction_id;
       $sousdirection_id=$agent_sousdirection_id;
       $service_id=$param_service ?? null;
       $agent_nom=$ob_param['nom'] ?? null;
       $user_id='';

       $services=Service::where('sousdirection_id',$sousdirection_id)->get();
       $actions= $ptabrepository->getActionlist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',1);
       
       if($param_service){
        $actions= $ptabrepository->getActivitelist('',$direction_id,$sousdirection_id,$param_service,$agent_nom,$user_id,$year,'',2);
       }

       if($param_nom){

        $agent = getnamebyparam($agent_direction_id,$agent_sousdirection_id,$param_service,$param_nom);
        if(@$agent->level == 1){$actions= $ptabrepository->getTachelist('',$direction_id,$sousdirection_id,$service_id,$param_nom,$user_id,$year,'',3); }elseif(@$agent->level == 2){$actions= $ptabrepository->getActivitelist('',$direction_id,$sousdirection_id,$param_service,$agent_nom,$user_id,$year,'',2);}else{$actions= $ptabrepository->getActionlist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',1);}
        
       }

     }elseif($level==2 || $iscipac==2){ //chef de service && CIP
       
       $direction_id=$agent_direction_id;
       $sousdirection_id=$agent_sousdirection_id;
       $service_id=$agent_service_id;
       $agent_nom='';
       $user_id=Auth::id();
       $actions= $ptabrepository->getActivitelist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',2);
       //dd($direction_id,$sousdirection_id,$service_id,$actions);
       if($param_nom){
        $actions= $ptabrepository->getTachelist('',$direction_id,$sousdirection_id,$service_id,$param_nom,$user_id,$year,'',3);
       }
     }elseif($level==1){ //Agent
       $direction_id=$agent_direction_id;
       $sousdirection_id=$agent_sousdirection_id;
       $service_id=$agent_service_id;
       $agent_nom=$agent_nom;
       $user_id=Auth::id();
       $actions= $ptabrepository->getTachelist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',3);
       //dd($user_id,$direction_id,$sousdirection_id,$service_id,$agent_nom);
     }else{ //Administrateur & Administrateur Adjoint
       $direction_id=$ob_param['direction']?? '';
       $sousdirection_id=$ob_param['sousdirection']?? '';
       $service_id='';
       $agent_nom=$ob_param['nom']?? '';
       $user_id= '' ;
       $actions= $ptabrepository->getActionlist('',$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,'',1);
     }

    //dd($function_key,$direction_id,$sousdirection_id,$service_id,$agent_nom);
    //getActionlist($extrant_id,$direction_id,$sousdirection_id,$responsable,$state)
     

    //dd($actions);
    return view('Frontend.ptab')->with([
     'actions'=>$actions,
     'directions'=>$directions,
     'sousdirections'=>$sousdirections,
     'services'=>$services

    ]);
  }

   public function activiteavalider($id,$type,PtabRepository $ptabrepository)
  {

   $actions= $ptabrepository->getActivitelistByActionId($id,$type,null);
   $total_activites = count($actions);
   $total_activite_realises = count($ptabrepository->getActivitelistByActionId($id,$type,3));
   $total_activite_patrealises = count($ptabrepository->getActivitelistByActionId($id,$type,2));
   $total_activite_nonrealises = count($ptabrepository->getActivitelistByActionId($id,$type,1));

   //dd($actions);
    return view('Frontend.ptab_activite_avalider')->with([
     'actions'=>$actions,
     'total_activites'=>$total_activites,
     'total_activite_realises'=>$total_activite_realises,
     'total_activite_patrealises'=>$total_activite_patrealises,
     'total_activite_nonrealises'=>$total_activite_nonrealises,
    ]);

  }

   public function tacheavalider($id,$type,PtabRepository $ptabrepository)
  {

   $taches= $ptabrepository->getTachelistByActiviteId($id,$type,null);
   $total_taches = count($taches);
   $total_tache_realises = count($ptabrepository->getTachelistByActiviteId($id,$type,3));
   $total_tache_patrealises = count($ptabrepository->getTachelistByActiviteId($id,$type,2));
   $total_tache_nonrealises = count($ptabrepository->getTachelistByActiviteId($id,$type,1));

   //dd($actions);
    return view('Frontend.ptab_tache_avalider')->with([
     'taches'=>$taches,
     'total_taches'=>$total_taches,
     'total_tache_realises'=>$total_tache_realises,
     'total_tache_patrealises'=>$total_tache_patrealises,
     'total_tache_nonrealises'=>$total_tache_nonrealises,
    ]);

  }

  public function gestionptab(Request $request,PtabRepository $ptabrepository)
  {

    $ob_param=$request->all();
    
    $function_key=Session::get('function_key');
    $is_admin=$function_key->isptabadmin;
    $level=$function_key->level;
    
    $directions = ptab_gestion_direction(Auth::user()->id);
    $agences = ptab_gestion_agence(Auth::user()->id);
    //$sousdirections=SousDirection::All();
    $services=Service::All();
    
    $tab_dir =[];
      foreach($directions as $dir){
         array_push($tab_dir, $dir->structure);
      }

    $sousdirections = DB::table('sousdirection')->whereIn('direction_id',$tab_dir)->get();
    //dd($sousdirections);
      $tab_agence =[];
      foreach($agences as $agence){
         array_push($tab_agence, $agence->structure);
      }
      foreach($sousdirections as $sd){
         array_push($tab_agence, $sd->id);
      }


      $page=$request->get('page');
      $direction_id=$request->get('direction');
      $sousdirection_id=$request->get('sousdirection');
    
     if($ob_param==[] && $page==''){ 
                  Session::forget('ob_param'); 
                }elseif($ob_param && $page==''){
                  Session::put('ob_param', $ob_param);
                }else{
                  $ob_param=Session::get('ob_param');
                }
      
      if($request->get('direction')){
        $tab_dir =[];
        $tab_agence =[]; 
        array_push($tab_dir, $request->get('direction'));
        $sousdirections = DB::table('sousdirection')->whereIn('direction_id',$tab_dir)->get();
        foreach($sousdirections as $sd){
         array_push($tab_agence, $sd->id);
      }
        
      }
      if($request->get('sousdirection')){
        $tab_dir =[];
        $tab_agence =[]; 
        array_push($tab_agence, $request->get('sousdirection'));
      }

     //dd($function_key,$tab_dir,$tab_agence);
             if ($is_admin) {
                  if($request->get('direction') || $request->get('sousdirection')){
                    $sousdirection_id=$tab_agence;
                    $agent_nom=$ob_param['nom'];
                  }else{
                    $sousdirection_id= [];
                    $agent_nom='';
                  }
             }else{
                  $sousdirection_id=$tab_agence;
                  $agent_nom=$ob_param['nom'] ?? '';
             }


    $actions= $ptabrepository->getGestionActionlist($tab_agence,$agent_nom);

    return view('Frontend.gestion_ptab')->with([
     'actions'=>$actions,
     'directions'=>$directions,
     'sousdirections'=>$sousdirections,
     'agences'=>$agences,
     'services'=>$services
    ]);
  }

  public function validatePtab(Request $request)
  {
    $actions = $request->get('checkAction');
    foreach($actions as $action_id){

      $affected = DB::table('action')
                      ->where('id', $action_id)
                      ->update(['state' => 1,
                        'statut_final' => 3]);

    }

    return Redirect::back();

  }

  public function importptab()
  {
    $ptab='';
    $directions=Direction::All();
    $sousdirections=SousDirection::All();
    return view('Frontend.importptab')->with([
     'ptablist'=>$ptab,
     'directions'=>$directions,
     'sousdirections'=>$sousdirections
    ]);
  }

  public function parametreptab()
  {
    
    $periode=Periode::orderBy('id','desc')->get();
    return view('Frontend.ptab_reglage_tab')->with([
     'periodes'=>$periode
    ]);
  }

  public function parametrebouton()
  {
    
    $boutons=Parametre_bouton::orderBy('id','desc')->get();
    return view('Frontend.bouton_reglage_tab')->with([
     'boutons'=>$boutons
    ]);
  }

  public function parametreptab_form()
  {
    $ptab='';
    $directions=Direction::All();
    $sousdirections=SousDirection::All();
    return view('Frontend.ptab_reglage_form')->with([
     'ptablist'=>$ptab,
     'directions'=>$directions,
     'sousdirections'=>$sousdirections
    ]);
  }

  public function parametreptab_updateform($id)
  {
    
    $periode=Periode::where('id',$id)->first();
   // dd($periode);
    return view('Frontend.ptab_edit_form')->with([
     'periode' => $periode,
    ]);
  }

  public function parametredroit(PtabRepository $ptabrepository)
  {
    
    $agents= $ptabrepository->agentDroitptab(6);
    //dd($agents);
    $directions=Direction::All();
    $sousdirections=SousDirection::where('state',2)->get();
    return view('Frontend.ptab_droit')->with([
                                            'agents'=>$agents,
                                            'directions'=>$directions,
                                            'sousdirections'=>$sousdirections
                                           ]);

  }

    public function parametreadddroit(PtabRepository $ptabrepository,Request $request)
  {
    //dd($request);

    $agents= $ptabrepository->agentDroitptab(6);
    $directions=Direction::All();
    $sousdirections=SousDirection::where('state',2)->get();
    
    $user_id = $request->get('user_id');
    $admin  = $request->get('admin');
    $dr = $request->get('direction');
    $sd = $request->get('sd');

    ///admin 
    if($admin){
            $admin_val = $admin;
            $rep = Agent_fonction::where('user_id', $user_id)->update(['isptabadmin' =>$admin_val]);
              }else{ 
                $admin_val = NULL;
                $rep = Agent_fonction::where('user_id', $user_id)->update(['isptabadmin' =>$admin_val]);
              }
    
    //////direction ou agence
    if($dr || $sd){

      $droit_id = $ptabrepository->addPtabDroit($user_id);

      if($dr){foreach($dr as $d){$ptabrepository->addPtabStructure($droit_id,$d,1);} }
      if($sd){ foreach($sd as $s){$ptabrepository->addPtabStructure($droit_id,$s,2);} }

    }

    return redirect()->route('reglage.droit')->with([
                                            'agents'=>$agents,
                                            'directions'=>$directions,
                                            'sousdirections'=>$sousdirections
                                           ]);

  
  }

  public function deleteRigth($user_id)
  {
    
    $affected = DB::table('droit_ptab')
              ->where('user_id', $user_id)
              ->update(['state' => -1]);

    //return Redirect::back()->with('success',"Droit(s) supprimé(s) avec succès");
  }

  public function droitdelecture($id)
  {
    
    $affected = DB::table('agent_fonction')
              ->where('id', $id)
              ->update(['isptabvue' => 1]);

    return Redirect::back()->with('success',"Droit(s) ajouté(s) avec succès");
  }

  public function ptabimport_in(Request $request,PtabRepository $ptabrepository){
        
        $limit = ini_get('memory_limit');
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 300);
        //dd($request->all());

        DB::beginTransaction();
        try
        {
           Excel::import(new PtabImport($request->all()),request()->file('ptab_file') );

           if (session('error')){
             
              DB::table('action_bck')->truncate();
            
          }else{
              $ptabrepository->copyAction_bck();
              DB::table('action_bck')->truncate();
             return back()->with('success',"PTAB ajoutée avec succès");
          }
           
        }
        catch (Exception $e)
         {
                  return Redirect::back();
         }   
        

    }

  public function indexevaluation()
  {
    
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function createptab(Request $request, PtabRepository $ptabrepository)
  {

    $tid=$request->get('tid');
    $action_id=$request->get('action_id');
    $activite_id=$request->get('activite_id');
    $tache_id=$request->get('tache_id');
    //dd($request);


    DB::beginTransaction();
        try
        {
          
          if($action_id =='new'){ $action_id = $ptabrepository->addMasterAction($request); }
          if($activite_id =='new'){ $activite_id = $ptabrepository->addMasterActivite($request);}
          if($tache_id =='new'){ $tache_id = $ptabrepository->addMasterTache($request);}

          if($tid=='action'){$did=$ptabrepository->addaction($request,$action_id);}
          if($tid=='activite'){$did=$ptabrepository->addactivite($request,$activite_id);}
          if($tid=='tache'){$did=$ptabrepository->addtache($request,$tache_id);}

          //$did=$ptabrepository->addaction($request, $instance_id);
        }
        catch (Exception $e)
         {
                  DB::rollback();
                 Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                 return Redirect::back();
         }   
                 DB::commit();
                return Redirect::route('ptab')->with('success',"PTAB Ajouté avec succès");
    
  }

   public function createperiode(Request $request, PtabRepository $ptabrepository)
  {

   //dd($request);


    DB::beginTransaction();
        try
        {
         $periode = new Periode();

            $periode->grade = $request->get('grade');
            $periode->trimestre = $request->get('trimestre');
            $periode->date_debut = $request->get('datedebut');
            $periode->date_fin =$request->get('datedefin');
            $periode->observation = $request->get('observation');
            $periode->state =  0;
            
            $periode->save();
        }
        catch (Exception $e)
         {
                  DB::rollback();
                 Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                 return Redirect::back();
         }   
                 DB::commit();
                return Redirect::route('reglage.ptab')->with('success',"Periode Ajoutée avec succès");
    
  }

   public function updateperiode(Request $request, PtabRepository $ptabrepository)
  {

   //dd($request);


    DB::beginTransaction();
        try
        {
         
         $affected = DB::table('periode')
                      ->where('id', $request->get('periode_id'))
                      ->update(['grade' => $request->get('grade'),'trimestre' => $request->get('trimestre'),'date_debut' => $request->get('datedebut'),'date_fin' => $request->get('datedefin'),'observation' => $request->get('observation')]);
            
        }
        catch (Exception $e)
         {
                  DB::rollback();
                 Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                 return Redirect::back();
         }   
                 DB::commit();
                return Redirect::route('reglage.ptab')->with('success',"Periode Modifié avec succès");
    
  }

  public function periode_changestate($periode_id,$periode_state)
  {

            DB::beginTransaction();
        try
        {

            $affected = DB::table('periode')
                      ->where('id', $periode_id)
                      ->update(['state' => $periode_state]);
                  
        }
         catch (Exception $e)
       {
                DB::rollback();
               Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
               return Redirect::back();
       } 

                DB::commit();
                Session::flash('success','La période a été Modifié avec succès');
               return Redirect::back();
        }


        public function bouton_changestate($bouton_id,$bouton_state)
  {
    if($bouton_state==0){$bouton_state=null;}

            DB::beginTransaction();
        try
        {

            $affected = DB::table('parametre_bouton')
                      ->where('id', $bouton_id)
                      ->update(['state' => $bouton_state]);
                  
        }
         catch (Exception $e)
       {
                DB::rollback();
               Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
               return Redirect::back();
       } 

                DB::commit();
                Session::flash('success','Le bouton a été Modifié avec succès');
               return Redirect::back();
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
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function updateptab(Request $request, PtabRepository $ptabrepository,uploadFile $uploadFile)
  {


    DB::beginTransaction();
        try
        {
            $did=$ptabrepository->modifierptab($request,$uploadFile);
        }
        catch (Exception $e)
         {
                  DB::rollback();
                  Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                  return Redirect::back();
         }   
                  DB::commit();
                  return Redirect::back()->with('success',"PTAB modifié avec succès");
    
  }

  public function updateptabDetail(Request $request, PtabRepository $ptabrepository,uploadFile $uploadFile)
  {

     //dd($request);
    DB::beginTransaction();
        try
        {
            $did=$ptabrepository->modifierptabDetail($request);
        }
        catch (Exception $e)
         {
                  DB::rollback();
                  Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                  return Redirect::back();
         }   
                  DB::commit();
                  return Redirect::back()->with('success',"PTAB modifié avec succès");
    
  }

  public function updateptabTrimestre(Request $request, PtabRepository $ptabrepository,uploadFile $uploadFile)
  {


    DB::beginTransaction();
        try
        {
            $did=$ptabrepository->modifierptabTrimestre($request,$uploadFile);
        }
        catch (Exception $e)
         {
                  DB::rollback();
                  Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                  return Redirect::back();
         }   
                  DB::commit();
                  return Redirect::back()->with('success',"PTAB modifié avec succès");
    
  }


  public function updateptabCommentaire(Request $request, PtabRepository $ptabrepository)
  {

    DB::beginTransaction();
        try
        {
            $did=$ptabrepository->modifierptabCommentaire($request);
        }
        catch (Exception $e)
         {
                  DB::rollback();
                  Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                  return Redirect::back();
         }   
                  DB::commit();
                  return Redirect::back()->with('success',"PTAB modifié avec succès");
    
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

  public function actionDelete($action_id,$type_id,$val)
  {
//dd($action_id,$val);
          if($val == 0){$val = null;}
          $agent_function = Session::get('function_key');
            DB::beginTransaction();
        try
        {

          if($val == null){
                                    $archive_action = new Archive_action();
                                    $archive_action->type_id = $type_id;
                                    $archive_action->instance_id =  $action_id ;
                                    $archive_action->user_id = Auth::user()->id;
                                    $archive_action->user_level = $agent_function->fonction;
                                    $archive_action->commentaire =  '';
                                    $archive_action->trimestre1 =  '';
                                    $archive_action->trimestre2 =  '';
                                    $archive_action->trimestre3 =  '';
                                    $archive_action->trimestre4 =  '';
                                    $archive_action->fichier = '';
                                    $archive_action->state = $val;
                                    $archive_action->save();
          }

             $affected = DB::table('action')->where('id', $action_id)->update(['state'=>$val]);
            if($type_id== 1){ 
                      $affected = DB::table('action')->where(['action_id' => $action_id,'type_id'=> 2])->update(['state'=> $val]);
                      $affected = DB::table('action')->where(['action_id' => $action_id,'type_id'=> 3])->update(['state'=> $val]);
                    }

                    if($type_id == 2){ 
                      $affected = DB::table('action')->where(['activite_id' => $action_id,'type_id'=> 3])->update(['state'=> $val]);
                    }
                  
        }
         catch (Exception $e)
       {
                DB::rollback();
               Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
               return Redirect::back();
       } 
       //dd($action_id,$val);
                DB::commit();
                if($val == -1){Session::flash('success','Le PTAB  à été désactiver avec succès');}
                if($val == -2){Session::flash('success','Le PTAB  à été Supprimé avec succès');}
                
                //Session::flash('active','doc');
               return Redirect::back();
        
    }


  public function deleteState($table,$champ,$value, PtabRepository $ptabRepository)
  {

            DB::beginTransaction();
        try
        {

            $ptabRepository->action_delete($table,$champ,$value);
                  
        }
         catch (Exception $e)
       {
                DB::rollback();
               Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
               return Redirect::back();
       } 

                DB::commit();
                Session::flash('success','Le PTAB  à été Modifié avec succès');
                //Session::flash('active','doc');
               return redirect()->route('ptab');
        
        }

    public function actionDesactive(Request $request, uploadFile $uploadFile)
          {
            $instance_id = $request->get('instance_id');
            $agent_function = Session::get('function_key');

            $val= $request->get('val');

        //dd($request);
                    DB::beginTransaction();
                try
                {

                  if($request->file('justif_action')){$justif_action = $uploadFile->upload($request,'justif_action');}else{$justif_action='';}
                  
                  $archive_action = new Archive_action();
                      $archive_action->type_id = $request->get('type_id');
                      $archive_action->instance_id =  $instance_id ;
                      $archive_action->user_id = Auth::user()->id;
                      $archive_action->user_level = $agent_function->fonction;
                      $archive_action->commentaire =  $request->get('commentaire');
                      $archive_action->trimestre1 =  $request->get('arret1');
                      $archive_action->trimestre2 =  $request->get('arret2');
                      $archive_action->trimestre3 =  $request->get('arret3');
                      $archive_action->trimestre4 =  $request->get('arret4');
                      $archive_action->fichier = $justif_action;
                      $archive_action->state = $val;
                      $archive_action->save();

                    
                    if($request->get('type_id')== 1){ 
                      $affected = DB::table('action')->where('id', $instance_id)->update(['state'=> $val]);
                      $affected = DB::table('activite')->where(['action_id' => $instance_id,'type_id'=> 2])->update(['state'=> $val]);
                      $affected = DB::table('tache')->where(['action_id' => $instance_id,'type_id'=> 3])->update(['state'=> $val]);
                    }

                    elseif($request->get('type_id')== 2){ 
                      $affected = DB::table('activite')->where(['id' => $instance_id,'type_id'=> 2])->update(['state'=> $val]);
                      $affected = DB::table('tache')->where(['activite_id' => $instance_id,'type_id'=> 3])->update(['state'=> $val]);
                    }

                    elseif($request->get('type_id')== 3){ 
                      $affected = DB::table('tache')->where(['id' => $instance_id,'type_id'=> 3])->update(['state'=> $val]);
                    }
                          
                }
                 catch (Exception $e)
               {
                        DB::rollback();
                       Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                       return Redirect::back();
               } 
               //dd($action_id,$val);
                        DB::commit();
                        Session::flash('success','Le PTAB  à été désactiver avec succès');
                      
                        //Session::flash('active','doc');
                       return Redirect::back();
                
            }

            public function showInstanceAchive($instance,$typeid,$val)
                {

                  if($val = -2){ $state= -1;} if($val = -4){ $state= -3;}

                   $instanceVal = Archive_action::where(['instance_id'=>$instance,'state'=> $state])->orderBy('created_at','desc')->first();

                   //dd($instance,$typeid,$instanceVal);
                    $obj = new \stdClass;
                    $obj->commentaire = $instanceVal->commentaire;
                    $obj->fichier = $instanceVal->fichier;
                    $obj->trimestre1 = $instanceVal->trimestre1;
                    $obj->trimestre2 = $instanceVal->trimestre2;
                    $obj->trimestre3 = $instanceVal->trimestre3;
                    $obj->trimestre4 = $instanceVal->trimestre4;
                   
                    return response()->json($obj);
                }


  public function showPtabDetails($tid,$vid, PtabRepository $ptabRepository)
  {
        //dd($tid,$vid);
        $axes = Axe_strategique::All();
        
        //dd($ptab,$agents);
        if($tid=='action'){

      $ptab=$ptabRepository->getActionDetails($vid);
      $agents=$ptabRepository->agentByDirection($ptab->direction_id);
      $historiques = Archive_action::where(['instance_id'=>$vid,'type_id'=>1])->orderBy('created_at','desc')->get();

      $total_activites = count($ptabRepository->getActivitelistByActionId($vid,2,null));
      $total_activite_realises = count($ptabRepository->getActivitelistByActionId($vid,2,3));
      $total_activite_patrealises = count($ptabRepository->getActivitelistByActionId($vid,2,2));
      $total_activite_nonrealises = count($ptabRepository->getActivitelistByActionId($vid,2,1));

          return view('Frontend.ptab_detail')->with(['ptab'=>$ptab,'tid'=>$tid,'agents'=>$agents,'axes'=>$axes,'historiques'=>$historiques,'total_activites'=>$total_activites,'total_activite_realises'=>$total_activite_realises,'total_activite_patrealises'=>$total_activite_patrealises,'total_activite_nonrealises'=>$total_activite_nonrealises]);
        }
        if($tid=='activite'){
          $ptab=$ptabRepository->getActiviteDetails($vid);
          $agents=$ptabRepository->agentByDirection($ptab->direction_id);
          $historiques = Archive_action::where(['instance_id'=>$vid,'type_id'=>2])->orderBy('created_at','desc')->get();
          
          $total_taches = count($ptabRepository->getTachelistByActiviteId($vid,3,null));
          $total_tache_realises = count($ptabRepository->getTachelistByActiviteId($vid,3,3));
          $total_tache_patrealises = count($ptabRepository->getTachelistByActiviteId($vid,3,2));
          $total_tache_nonrealises = count($ptabRepository->getTachelistByActiviteId($vid,3,1));

          return view('Frontend.ptab_detail_activite')->with(['ptab'=>$ptab,'tid'=>$tid,'agents'=>$agents,'axes'=>$axes,'historiques'=>$historiques,'total_taches'=>$total_taches,'total_tache_realises'=>$total_tache_realises,'total_tache_patrealises'=>$total_tache_patrealises,'total_tache_nonrealises'=>$total_tache_nonrealises]);
        }
        if($tid=='tache'){
          $ptab=$ptabRepository->getTacheDetails($vid);
          $agents=$ptabRepository->agentByDirection($ptab->direction_id);
          $historiques = Archive_action::where(['instance_id'=>$vid,'type_id'=>3])->orderBy('created_at','desc')->get();

          return view('Frontend.ptab_detail_tache')->with(['ptab'=>$ptab,'tid'=>$tid,'agents'=>$agents,'axes'=>$axes,'historiques'=>$historiques]);
        }
      
    
  }

   public function showPtabEditForm($tid,$vid, PtabRepository $ptabRepository)
  {
        //dd($tid,$vid);
    if($tid=='action'){
        $axes = Axe_strategique::All();
        $ptab=$ptabRepository->getActionDetails($vid);

        $responsables=$ptabRepository->actionResponsable($ptab->direction_id);
        //dd($responsables);
        //$agents=$ptabRepository->agentByDirection($ptab->direction_id);
        $extrants = Extrant::where('axe_id',@$ptab->axeId)->get();
        $master_actions = Master_action::where('extrant_id',@$ptab->extrantId)->get();
        //dd($ptab->axeId,$ptab->extrantId,$ptab,$extrants,$master_actions);
      return view('Frontend.ptab_edit_action_form')->with([
                                            'ptab'=>$ptab,
                                            'tid'=>$tid,
                                            'agents'=>$responsables,
                                            'axes'=>$axes,
                                            'extrants'=>$extrants,
                                            'master_actions'=>$master_actions
                                        ]);
    }elseif($tid=='activite'){
      $ptab=$ptabRepository->getActiviteDetails($vid);

      $sd = $ptab->sousdirection_id;
      $level = 3;
      $is_agence = @get_isagence($level, $sd);

      $action = Action::select('action_id','extrant_id','reference_matrice')->where('id',@$ptab->action_id)->first();
      $master_actions = Master_action::select('id','extrant_id','ref','intitule_action','Intitule_indicateur')->where('id',@$action->reference_matrice)->first();
      //dd($ptab,$action,$master_actions);
      $agents=$ptabRepository->agentByDirection($ptab->direction_id);

      $responsables=$ptabRepository->activiteResponsable($ptab->direction_id,$ptab->sousdirection_id,$ptab->service_id,$is_agence);
      $master_activites = Master_activite::where('master_action_id',@$master_actions->id)->get();
      //dd($ptab,$master_actions,$master_activites);

      return view('Frontend.ptab_edit_activite_form')->with([
                                            'ptab'=>$ptab,
                                            'tid'=>$tid,
                                            'agents'=>$responsables,
                                            'master_activites'=>$master_activites,
                                            'master_actions'=>$master_actions,
                                            'action'=>$action,
                                        ]);

    }else{
      $ptab=$ptabRepository->getTacheDetails($vid);
      //dd($ptab);
      $sd = $ptab->sousdirection_id;
      $level = 3;
      $is_agence = @get_isagence($level, $sd);

      $action = Action::select('action_id','extrant_id','reference_matrice')->where('id',@$ptab->action_id)->first();
      $activites = Activite::select('action_id','activite_id','extrant_id','reference_matrice')->where('id',@$ptab->activite_id)->first();

    $master_actions = Master_action::select('id','extrant_id','ref','intitule_action','Intitule_indicateur')->where('id',@$action->reference_matrice)->first();
    $master_activites = Master_activite::select('id','master_action_id','ref','intitule_activite','Intitule_indicateur')->where('id',@$activites->reference_matrice)->first();
    $master_taches = Master_tache::where('master_activite_id',@$master_activites->id)->get();

    //$agents=$ptabRepository->agentByDirection($ptab->direction_id);

    $responsables=$ptabRepository->tacheResponsable($ptab->direction_id,$ptab->sousdirection_id,$ptab->service_id,$is_agence);

     
      //dd($responsables,$ptab,$activites,$master_actions,$master_activites,$master_taches,$is_agence);

      return view('Frontend.ptab_edit_tache_form')->with([
                                                          'ptab'=>$ptab,
                                                          'tid'=>$tid,
                                                          'agents'=>$responsables,
                                                          'master_actions'=>$master_actions,
                                                          'master_activites'=>$master_activites,
                                                          'master_taches'=>$master_taches
                                                          ]);

    }
        


    
  }

  public function newPtabDetails($tid,$id,PtabRepository $ptabRepository)
  {
        //dd($tid,$id);
    $directions=Direction::All();
    $sousdirections=SousDirection::All();
    $axes = Axe_strategique::All();

    $function_key=Session::get('function_key');
    $is_admin=$function_key->isptabadmin;
    $level=$function_key->level;

    if($tid=='tache'){
      $instance='activite_id';
      //$instance_val=$instance_val;
      $ptab=$ptabRepository->getActiviteDetails($id);
      //dd($ptab);
      return view('Frontend.ptab_tache_form')->with(['tid'=>$tid,'id'=>$id,'directions'=>$directions,'ptab'=>$ptab,'axes'=>$axes]);
    }
    if($tid=='activite'){
      //dd($function_key);
      
      $instance='activite_id';
      $ptab=$ptabRepository->getActionDetails($id);
      $services = Service::where('sousdirection_id',$ptab->sousdirection_id)->get();
      //dd($services,$services);
      return view('Frontend.ptab_activite_form')->with(['tid'=>$tid,'id'=>$id,'directions'=>$directions,'ptab'=>$ptab,'axes'=>$axes,'services'=>$services]);
  }
    if($tid=='action'){
  
      return view('Frontend.ptab_form')->with(['tid'=>$tid,'id'=>$id,'directions'=>$directions,'axes'=>$axes]);

    }
   
  }

  public function exportPtab($direction,$sousdirection){
     
    return Excel::download(new PtabExport($direction,$sousdirection), 'export-ptab.xlsx');

  }


  public function updateLivrableState(Request $request,PtabRepository $ptabRepository)
  {
    
    DB::beginTransaction();
try
{
    $ptabRepository->livrableUpdate($request); 
}
 catch (Exception $e)
   {
            DB::rollback();
           Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
           return Redirect::back();
   } 

            DB::commit();
            Session::flash('success','Le Livrable  à été Modifié avec succès');
            //Session::flash('active','doc');
            return Redirect::back();
    
  }

  public function addptabLivrable(Request $request, PtabRepository $ptabrepository,uploadFile $uploadFile)
  {

    
     //dd($request);
    DB::beginTransaction();
        try
        {
            $did=$ptabrepository->ajouterLivrable($request,$uploadFile);
        }
        catch (Exception $e)
         {
                  DB::rollback();
                  Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                  return Redirect::back();
         }   
                  DB::commit();
                  return Redirect::back()->with('success',"PTAB modifié avec succès");
    
  }

   public function sendptabLivrable(Request $request, PtabRepository $ptabrepository)
  {

    
     //dd($request);
    DB::beginTransaction();
        try
        {
            $did=$ptabrepository->sendLivrable($request);
        }
        catch (Exception $e)
         {
                  DB::rollback();
                  Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                  return Redirect::back();
         }   
                  DB::commit();
                  return Redirect::back()->with('success',"PTAB modifié avec succès");
    
  }


  public function showDroitByUserID($user_id)
  {

    $directions=Direction::All();
    $sousdirections=SousDirection::where('state',2)->get();
    $html_direction = '';
    $html_sousdirections = '';

    foreach ($directions as $direction)
      {
           $html_direction = $html_direction.'<div class="btn btn-success btn-sm" style="margin:5px">
                                <input name="direction[]" type="checkbox" value="'.$direction->id.'">
                                <span class="">'.$direction->designation.'</span>
                            </div>';
      }

      foreach ($sousdirections as $sousdirection)
      {
           $html_sousdirections = $html_sousdirections.'<div class="btn btn-success btn-sm" style="margin:5px">
                                <input name="direction[]" type="checkbox" value="'.$sousdirection->id.'">
                                <span class="">'.$sousdirection->designation.'</span>
                            </div>';
      }


      $obj = new \stdClass;
      $obj->html_direction = $html_direction;
      $obj->html_sousdirections = $html_sousdirections;
     
      return response()->json($obj);


  }

   public function showExtrantByAxe($axe_id)
  {

     $extrants = Extrant::where('axe_id',$axe_id)->get();
     $html_first = '<option value=""></option>';

     foreach ($extrants as $ex)
      {
           $html_first = $html_first.'<option value="'.$ex->id.'">'.$ex->ref.' : '.$ex->extrant.'</option>';
      }

      $obj = new \stdClass;
      $obj->html_first = $html_first;
     
      return response()->json($obj);
  }

   public function showActionByExtrant($extrant_id,$direction,$isagence)
  {

    //dd($extrant_id,$direction,$isagence);
    $function_key=Session::get('function_key');
    $isptabadmin = $function_key->isptabadmin;
    if($isptabadmin){

      $actions = Master_action::where('extrant_id',$extrant_id)
                 ->when($direction, function ($query, $direction) 
                                                {return $query->where('direction_id', $direction);}
                                                    )
                 ->get();

    }else{

          if($isagence==0){

          $actions = Master_action::where('extrant_id',$extrant_id)
                     ->when($direction, function ($query, $direction) 
                                                    {return $query->where('direction_id', $direction);}
                                                        )
                     ->get();

        }else{

          $actions = Master_action::where('extrant_id',$extrant_id)
                     ->when($isagence, function ($query, $isagence) 
                                                    {return $query->where('is_agence', $isagence);}
                                                        )
                     ->get();

        }

    }
    
     $html_first = '<option value=""></option>';

     foreach ($actions as $ac)
      {
           $html_first = $html_first.'<option value="'.$ac->id.'">'.$ac->ref.' : '.$ac->intitule_action.'</option>';
      }
      $html_first = $html_first.'<option value="new">Autre action</option>';

      $obj = new \stdClass;
      $obj->html_first = $html_first;
     
      return response()->json($obj);
  }

   public function showintituleIndicateur($action_id)
  {

     $action = Master_action::where('id',$action_id)->first();

     $intitule = $action->intitule_action;
     $indicateur = $action->Intitule_indicateur;

      $obj = new \stdClass;
      $obj->intitule = $intitule;
      $obj->indicateur = $indicateur;
     
      return response()->json($obj);
  }

   public function showActiviteByActionType($action_id)
  {

     $activite = Master_activite::where('master_action_id',$action_id)->get();
//dd($action_id,$activite);
     $html_first = '<option value=""></option>';

     foreach ($activite as $ac)
      {
           $html_first = $html_first.'<option value="'.$ac->id.'">'.$ac->ref.' : '.$ac->intitule_activite.'</option>';
      }

      $html_first = $html_first.'<option value="new">Autre activité</option>';

      $obj = new \stdClass;
      $obj->html_first = $html_first;
     
      return response()->json($obj);
  }

   public function showactiviteIntituleIndicateur($activite_id)
  {

     $activite = Master_activite::where('id',$activite_id)->first();

     $intitule = $activite->intitule_activite;
     $indicateur = $activite->Intitule_indicateur;

      $obj = new \stdClass;
      $obj->intitule = $intitule;
      $obj->indicateur = $indicateur;
     
      return response()->json($obj);
  }

   public function showtacheIntituleIndicateur($tache_id)
  {

     $tache = Master_tache::where('id',$tache_id)->first();

     $intitule = $tache->intitule_tache;
     $indicateur = $tache->Intitule_indicateur;

      $obj = new \stdClass;
      $obj->intitule = $intitule;
      $obj->indicateur = $indicateur;
     
      return response()->json($obj);
  }

   public function showTacheByActiviteType($activite_id)
  {

     $tache = Master_tache::where('master_activite_id',$activite_id)->get();
//dd($action_id,$activite);
     $html_first = '<option value=""></option>';

     foreach ($tache as $tch)
      {
           $html_first = $html_first.'<option value="'.$tch->id.'">'.$tch->ref.' : '.$tch->intitule_tache.'</option>';
      }

      $html_first = $html_first.'<option value="new">Autre tâche</option>';

      $obj = new \stdClass;
      $obj->html_first = $html_first;
     
      return response()->json($obj);
  }

  public function deleteLivrable($livrable_id)
  {


    DB::beginTransaction();
        try
        {
          $affected = DB::table('livrable')->where('id', $livrable_id)->update(['state' => -5]);
        }
        catch (Exception $e)
         {
                  DB::rollback();
                  Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                  return Redirect::back();
         }   
                  DB::commit();
                  return Redirect::back()->with('success',"Livrable supprimé avec succès");
    
  }

  public function modifLivrable(Request $request, uploadFile $uploadFile)
  {
    if($request->get('livrable_id')){$livrable_id = $request->get('livrable_id');}
    elseif($request->get('livrable_id2')){$livrable_id = $request->get('livrable_id2');}
    elseif($request->get('livrable_id3')){$livrable_id = $request->get('livrable_id3');}
    elseif($request->get('livrable_id4')){$livrable_id = $request->get('livrable_id4');}

    if($request->get('liv_com')){$liv_com = $request->get('liv_com');}
    elseif($request->get('liv_com2')){$liv_com = $request->get('liv_com2');}
    elseif($request->get('liv_com3')){$liv_com = $request->get('liv_com3');}
    elseif($request->get('liv_com4')){$liv_com = $request->get('liv_com4');}

    DB::beginTransaction();
        try
        {
    $affected = DB::table('livrable')->where('id', $livrable_id)->update(['state' => 0, 'commentaire' => $liv_com]);

       if($request->file('livrable_t1')){
    $livrable = $uploadFile->upload($request,'livrable_t1');
    $affected = DB::table('livrable')->where('id', $livrable_id)->update(['livrable' => $livrable]);
                   
                                       }
      if($request->file('livrable_t2')){
     $livrable = $uploadFile->upload($request,'livrable_t2');
     $affected = DB::table('livrable')->where('id', $livrable_id)->update(['livrable' => $livrable]);
                   
                              }
     if($request->file('livrable_t3')){
     $livrable = $uploadFile->upload($request,'livrable_t3');
     $affected = DB::table('livrable')->where('id', $livrable_id)->update(['livrable' => $livrable]);
                
                              }
    if($request->file('livrable_t4')){
      //dd($request);
     $livrable = $uploadFile->upload($request,'livrable_t4');
     $affected = DB::table('livrable')->where('id', $livrable_id)->update(['livrable' => $livrable]);
               
                              }

        }
        catch (Exception $e)
         {
                  DB::rollback();
                  Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                  return Redirect::back();
         }   
                  DB::commit();
                  return Redirect::back()->with('success',"Livrable supprimé avec succès");
    
  }





  
}

?>