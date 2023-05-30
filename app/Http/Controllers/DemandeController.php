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
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Services\uploadFile;
use Carbon\Carbon;
use PDF;

use App\Models\Direction;
use App\Models\SousDirection;
use App\Models\Service;
use App\Models\Materiel;
use App\Models\Demande;
use App\Models\Grade;
use App\Models\Grade_sd;
use App\Models\User;
use App\Models\Documentation;

use App\Repositories\DemandeRepository;
use App\Repositories\DirectionRepository;

use App\Exports\CongeExport;
use App\Exports\DocumentationExport; 
use App\Imports\PlanningImport; 
use App\Mail\SendMessage;

class DemandeController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request, DemandeRepository $demanderepository, uploadFile $uploadFile)
  {

    
    //dd($request);
    $datedepart=$request->get('datedepart');
    $datedepart=$request->get('datedepart');
    $dt = new Carbon($datedepart);
    if($request->file('justificatif')){
                  $path_doc = $uploadFile->upload($request,'justificatif');
                  $path_justif ='/docs/' . $path_doc;
                                          }else{ $path_justif = ''; }
    if($request->file('justificatif_conge')){
                  $path_doc = $uploadFile->upload($request,'justificatif_conge');
                  $path_justif ='/docs/' . $path_doc;
                                          }else{ $path_justif = ''; }


    //dd($dt->dayOfWeek);

    DB::beginTransaction();
        try
        {
            $did=$demanderepository->addDemandes($request,$path_justif);
        }
        catch (Exception $e)
         {
                  DB::rollback();
                 Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                 return Redirect::back();
         }   
                 DB::commit();
                return Redirect::route('super.demande')->with('success',"Demande ajoutée avec succès");
    
  }

  public function updateDemandeConge(Request $request, DemandeRepository $demanderepository)
  {

    
    
    $datedepart=$request->get('datedepart');
    $datedepart=$request->get('datedepart');
    $dt = new Carbon($datedepart);


    //dd($dt->dayOfWeek);

    DB::beginTransaction();
        try
        {
            $did=$demanderepository->updateDemandes($request);
        }
        catch (Exception $e)
         {
                  DB::rollback();
                 Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                 return Redirect::back();
         }   
                 DB::commit();
                return Redirect::route('super.demande')->with('success',"Demande modifié avec succès");
    
  }

  public function updateDemandeCommentaire(Request $request, DemandeRepository $demanderepository)
  {

    
  //dd($request);


    DB::beginTransaction();
        try
        {
            
            $demande_id=$request->get('demande_id');
            $level_id=$request->get('level_id');
            if($level_id==1){$observation='observation_cs';}
            if($level_id==2){$observation='observation_sd';}
            if($level_id==3){$observation='observation_d';}
            if($level_id==4){$observation='observation_sdrh';}
            if($level_id==5){$observation='observation_drh';}
            if($level_id==6){$observation='observation_admin';}
            $commentaire=$request->get('commentaire');
            $state_id=$request->get('state_id');
            

            DB::table('demandes')
            ->where('id', $demande_id)
            ->update([
                $observation => $commentaire,
                'state' => $state_id
            ]);

        }
        catch (Exception $e)
         {
                  DB::rollback();
                 Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                 return Redirect::back();
         }   
                 DB::commit();
                return Redirect::route('super.demande')->with('success',"Demande modifié avec succès");
    
  }

  public function storeAttribution(Request $request, DemandeRepository $demanderepository)
  {

    //dd($request);

    DB::beginTransaction();
try
{
    $did=$demanderepository->addAttribution($request);
    //$details=$demanderepository->addDemandesDetails($request,$did);
  
}
catch (Exception $e)
 {
          DB::rollback();
         Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
         return Redirect::back();
 }   
         DB::commit();
        return Redirect::back()->with('success',"Attribution ajoutée avec succès");
    
  }

   public function nouvelleDemandeDocument(DemandeRepository $DemandeRepository)
  {
    $documents=Documentation::All();
     return view('Frontend.demande_document_form')->with([
                                            'documents'=>$documents
                                        ]);
  }

  public function storeDemandeDocument(Request $request, DemandeRepository $demanderepository)
  {

    //dd($request);
  
    $document_id=$request->get('document_id');
    $demandeur_id=$request->get('user_id');
    $nbr_doc=$request->get('nbr_doc');
    $motif=$request->get('motif');
    $agent_function = Session::get('function_key');
            //dd($agent_function,$agent_function->level);
            // if($agent_function->level==1){$state=1;}  //agent
            // elseif($agent_function->level==2){$state=2;} //chef de service
            // elseif($agent_function->level==3){$state=3;} //sous directeur
            // elseif($agent_function->level==4){$state=4;} //Directeur
            // else{$state=4;}  //Administrateur et autre
            $state=1;

    DB::beginTransaction();
try
{

    $val=count($document_id);
for ($i=0; $i<$val; $i++){
     $did=$demanderepository->addDemandeDocument($document_id[$i],$demandeur_id, $nbr_doc[$i],$motif[$i],$state);
    }
  
}
catch (Exception $e)
 {
          DB::rollback();
         Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
         return Redirect::back();
 }   
         DB::commit();
        return Redirect::Route('super.documentation')->with('success',"Demande de document(s) ajouté(s) avec succès");
    
  }

  public function storeIntervention(Request $request, DemandeRepository $demanderepository)
  {

    //dd($request);

    DB::beginTransaction();
try
{
     $did=$demanderepository->addIntervention($request);
     //$resp1=$demanderepository->addSortie($request);
    //$details=$demanderepository->addDemandesDetails($request,$did);
  
}
catch (Exception $e)
 {
          DB::rollback();
         Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
         return Redirect::back();
 }   
         DB::commit();
        return Redirect::back()->with('success',"Demande d'intervention ajoutée avec succès");
    
  }


  public function storeRapport(Request $request, DemandeRepository $demanderepository)
  {

    //dd($request);

    DB::beginTransaction();
try
{
    $did=$demanderepository->addRapport($request);
    //$details=$demanderepository->addDemandesDetails($request,$did);
  
}
catch (Exception $e)
 {
          DB::rollback();
         Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
         return Redirect::back();
 }   
         DB::commit();
        return Redirect::back()->with('success',"Rapport d'intervention ajouté avec succès");
    
  }


  public function sendDocument(Request $request, DemandeRepository $demanderepository, uploadFile $uploadFile)
  {

   
    $fichiers = $uploadFile->upload($request,'fichier');
    //dd($request,$fichiers);

     

    DB::beginTransaction();
try
{
    $did=$demanderepository->addSendedDoc($request, $fichiers);
  
}
catch (Exception $e)
 {
          DB::rollback();
         Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
         return Redirect::back();
 }   
         DB::commit();
        return Redirect::back()->with('success',"Document envoyé avec succès");
    
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function showDemandeDetails($did , DemandeRepository $demanderepository)
  {

        $demandes=$demanderepository->getDemandesDetails($did);
        $demandeur_id=$demandes->demandeur_id;
        $demandeur_fonction= getAgentById($demandeur_id);
        $directions=Direction::All();
        $sousdirections=SousDirection::All();
        $grade_sd=Grade_sd::All();
        $services=Service::All();
        $agents=User::All();
        $grades=Grade::All();

     //dd($demandeur_fonction);
    
      return view('Frontend.demande_detail')->with([
                                            'demandes'=>$demandes,
                                            'directions'=>$directions,
                                            'grade_sd'=>$grade_sd,
                                            'sousdirections'=>$sousdirections,
                                            'services'=>$services,
                                            'agents'=>$agents,
                                            'grades'=>$grades,
                                            'demandeur_fonction'=>$demandeur_fonction,
                                        ]);
    
  }

   public function planning_import(){

     $directions=Direction::All();
     $sousdirections=SousDirection::All();
     
     return view('Frontend.import_planning')->with([
                                            'directions'=>$directions,
                                            'sousdirections'=>$sousdirections
                                        ]);
    }


  public function planningimport_in(Request $request){
        $limit = ini_get('memory_limit');
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 300);
        //dd($request->all());

        DB::beginTransaction();
        try
        {
           Excel::import(new PlanningImport($request->all()),request()->file('planning_file'));
        }
        catch (Exception $e)
         {
                  DB::rollback();
                  return Redirect::back();
         }   
                DB::commit();
                return back()->with('success',"Planning ajoutée avec succès");
    }






  public function showInterventionDetails($i_id , DemandeRepository $demanderepository)
  {

     $interventions=$demanderepository->getInterventionDetails($i_id);

     //dd($interventions);
    
      return view('Frontend.intervention_detail')->with([
                                            'interventions'=>$interventions
                                        ]);
    
  }

   public function showDoc_demandeDetails($i_id , DemandeRepository $demanderepository)
  {

     $details=$demanderepository->getDoc_demandeDetail($i_id);

     //dd($details);
    
      return view('Frontend.doc_demande_details')->with([
                                            'details'=>$details
                                        ]);
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit(Request $request, DemandeRepository $demanderepository)
  {
    //dd($request);

     DB::beginTransaction();
  try
  {
    $response = $demanderepository->modifie_demande_conge($request);
   }   
   catch (Exception $e)
   {
            DB::rollback();
           Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
           return Redirect::back();
   } 

  DB::commit();
  return Redirect::back()->with('success',"Modifié avec succès");


  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function updateDemandeState($did,$opt, DemandeRepository $demanderepository)
  {

    DB::beginTransaction();
try
{

    $demanderepository->removeDemande($did, $opt);
          
}
 catch (Exception $e)
   {
            DB::rollback();
           Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
           return Redirect::back();
   } 

            DB::commit();
            Session::flash('success','La Demande  à été Modifié avec succès');
            //Session::flash('active','doc');
           return redirect()->route('super.demande');
    
  }


  public function doc_demande_update($did,$opt, DemandeRepository $demanderepository)
  {

    DB::beginTransaction();
try
{

    $demanderepository->update_docDemande($did, $opt);
    $demanderepository->store_doc_Demande($did, $opt);
          
}
 catch (Exception $e)
   {
            DB::rollback();
           Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
           return Redirect::back();
   } 

            DB::commit();
            Session::flash('success','La Demande  à été Modifié avec succès');
            //Session::flash('active','doc');
          return Redirect::back();
    
  }


  public function doc_demande_delete($did)
  {

    DB::beginTransaction();
try
{

    DB::table('agent_document')->where('id', $did)->delete();
          
}
 catch (Exception $e)
   {
            DB::rollback();
           Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
           return Redirect::back();
   } 

            DB::commit();
            Session::flash('success','Document éffacé avec succès');
            //Session::flash('active','doc');
          return Redirect::back();
    
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

   public function sendMessage(Request $request, DirectionRepository $directionrepository, uploadFile $uploadFile)
  {

    $direction_id=$request->get('direction');
    $sousdirection_id=$request->get('sousdirection');
    $service_id=$request->get('service');
    $user_id=$request->get('agent');
    $content_message=$request->get('content_message');
    $sujet=$request->get('sujet');
    $sender_id=Auth::id();
    if($user_id){$s_user_ids = implode(',', $user_id);}else{$s_user_ids = $user_id;}
    
    $destinataires=$directionrepository->getUserByOption($direction_id,$sousdirection_id,$service_id,$user_id);
    //dd($s_user_ids);
    
//     DB::beginTransaction();
// try
// {
    if($request->file('mail_doc')){
      $mail_doc = $uploadFile->upload($request,'mail_doc');
      $path_doc = public_path(). '/docs/' . $mail_doc;
      
    }else{ $mail_doc = ''; }
    foreach($destinataires as $destinataire){
        $directionrepository->storeMessage($sender_id,$destinataire->id,$sujet,$content_message,$mail_doc,1);
        //envoyer mail
       // Mail::to($destinataire->email)->send(new SendMessage($sujet, $content_message,  @$path_doc));
    }
    $dest='dir='.$direction_id.';sdir='.$sousdirection_id.';serv='.$service_id.';ag='.$s_user_ids;
       $directionrepository->storeMessage($sender_id,$dest,$sujet,$content_message,$mail_doc,2);
  
// }
// catch (Exception $e)
//  {
//           DB::rollback();
//          Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
//          return Redirect::back();
//  }   
         DB::commit();
        return Redirect::route('message.sent')->with('success',"Message envoyé avec succès");
    
  }


  public function exportconge(Request $request){

    $agent_function = Session::get('function_key');
     
    return Excel::download(new CongeExport($request,$agent_function), 'export-conge.xlsx');

  }

   public function exportdocumentation(Request $request){

    $agent_function = Session::get('function_key');
     
    return Excel::download(new DocumentationExport($request,$agent_function), 'export-document.xlsx');

  }




  
}

?>