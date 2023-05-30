<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use App\Http\Requests\typeRequest;
use App\Http\Requests\contratRequest;
use App\Http\Requests\departmentRequest;
use App\Http\Requests\fournisseurRequest;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Exception;


use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Config;

use Carbon\Carbon;

use PDF;

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

use App\Repositories\DemandeRepository;
use App\Repositories\DirectionRepository;
use App\Repositories\UserRepository;
use App\Repositories\CommunicationRepository;

class HomeController extends Controller
{


  public function indexSuper(UserRepository $userRepository,CommunicationRepository $communicationRepository)
  {

     $user_id=Auth::id();
     $total=$userRepository->countAgentByParam('','','','','','','');
     $employe=$userRepository->countAgentByParam('EMPLOYE','','','','','','');
     $ag_maitrise=$userRepository->countAgentByParam('AGENT DE MAITRISE','','','','','','');
     $cadre=$userRepository->countAgentByParam('CADRE','','','','','','');
     $cadremoyen=$userRepository->countAgentByParam('CADRE MOYEN','','','','','','');
     $cadresup=$userRepository->countAgentByParam('CADRE SUPERIEUR','','','','','','');
     $cadrejunior=$userRepository->countAgentByParam('CADRE JUNIOR','','','','','','');
     $genre_fem=$userRepository->countAgentByParam('','','F','','','','');
     $genre_max=$userRepository->countAgentByParam('','','M','','','','');
     $contractuel=$userRepository->countAgentByParam('','CONTRACTUEL','','','','','');
     $fonctionnaire=$userRepository->countAgentByParam('','FONCTIONNAIRE','','','','','');

     $dop=$userRepository->countAgentByParam('','','','1','','','');
     $dpf=$userRepository->countAgentByParam('','','','2','','','');
     $dmg=$userRepository->countAgentByParam('','','','3','','','');
     $drhaja=$userRepository->countAgentByParam('','','','4','','','');
     $dic=$userRepository->countAgentByParam('','','','5','','','');
     $desse=$userRepository->countAgentByParam('','','','6','','','');
     $daicg=$userRepository->countAgentByParam('','','','7','','','');
     $admin_adjoin=$userRepository->countAgentByParam('','','','8','','','');
     $admin=$userRepository->countAgentByParam('','','','9','','','');

     $abengourou=$userRepository->countAgentByParam('','','','','24','','');
     $abobo=$userRepository->countAgentByParam('','','','','20','','');
     $aboisso=$userRepository->countAgentByParam('','','','','25','','');
     $Adjame=$userRepository->countAgentByParam('','','','','21','','');
     $beoumi=$userRepository->countAgentByParam('','','','','34','','');
     $bouake=$userRepository->countAgentByParam('','','','','26','','');
     $daloa=$userRepository->countAgentByParam('','','','','27','','');
     $daoukro=$userRepository->countAgentByParam('','','','','37','','');
     $dimbokro=$userRepository->countAgentByParam('','','','','28','','');
     $gagnoa=$userRepository->countAgentByParam('','','','','29','','');
     $guiglo=$userRepository->countAgentByParam('','','','','30','','');
     $korhogo=$userRepository->countAgentByParam('','','','','31','','');
     $Man=$userRepository->countAgentByParam('','','','','36','','');
     $odiene=$userRepository->countAgentByParam('','','','','38','','');
     $prestige=$userRepository->countAgentByParam('','','','','19','','');
     $sanpedro=$userRepository->countAgentByParam('','','','','32','','');
     $soubre=$userRepository->countAgentByParam('','','','','35','','');
     $treichville=$userRepository->countAgentByParam('','','','','22','','');
     $yamoussoukro=$userRepository->countAgentByParam('','','','','33','','');
     $yopougon=$userRepository->countAgentByParam('','','','','23','','');

     $dop_m=$userRepository->countAgentByParam('','','M','1','','','');
     $dop_f=$userRepository->countAgentByParam('','','F','1','','','');
     $dpf_m=$userRepository->countAgentByParam('','','M','2','','','');
     $dpf_f=$userRepository->countAgentByParam('','','F','2','','','');
     $dmg_m=$userRepository->countAgentByParam('','','M','3','','','');
     $dmg_f=$userRepository->countAgentByParam('','','F','3','','','');
     $drhaja_m=$userRepository->countAgentByParam('','','M','4','','','');
     $drhaja_f=$userRepository->countAgentByParam('','','F','4','','','');
     $dic_m=$userRepository->countAgentByParam('','','M','5','','','');
     $dic_f=$userRepository->countAgentByParam('','','F','5','','','');
     $desse_m=$userRepository->countAgentByParam('','','M','6','','','');
     $desse_f=$userRepository->countAgentByParam('','','F','6','','','');
     $daicg_m=$userRepository->countAgentByParam('','','M','7','','','');
     $daicg_f=$userRepository->countAgentByParam('','','F','7','','','');
     $admin_adjoin_m=$userRepository->countAgentByParam('','','M','8','','','');
     $admin_adjoin_f=$userRepository->countAgentByParam('','','F','8','','','');
     $admin_m=$userRepository->countAgentByParam('','','M','9','','','');
     $admin_f=$userRepository->countAgentByParam('','','F','9','','','');

     $dop_contractuel=$userRepository->countAgentByParam('','CONTRACTUEL','','1','','','');
     $dop_fonct=$userRepository->countAgentByParam('','FONCTIONNAIRE','','1','','','');
     $dpf_contractuel=$userRepository->countAgentByParam('','CONTRACTUEL','','2','','','');
     $dpf_fonct=$userRepository->countAgentByParam('','FONCTIONNAIRE','','2','','','');
     $dmg_contractuel=$userRepository->countAgentByParam('','CONTRACTUEL','','3','','','');
     $dmg_fonct=$userRepository->countAgentByParam('','FONCTIONNAIRE','','3','','','');
     $drhaja_contractuel=$userRepository->countAgentByParam('','CONTRACTUEL','','4','','','');
     $drhaja_fonct=$userRepository->countAgentByParam('','FONCTIONNAIRE','','4','','','');
     $dic_contractuel=$userRepository->countAgentByParam('','CONTRACTUEL','','5','','','');
     $dic_fonct=$userRepository->countAgentByParam('','FONCTIONNAIRE','','5','','','');
     $desse_contractuel=$userRepository->countAgentByParam('','CONTRACTUEL','','6','','','');
     $desse_fonct=$userRepository->countAgentByParam('','FONCTIONNAIRE','','6','','','');
     $daicg_contractuel=$userRepository->countAgentByParam('','CONTRACTUEL','','7','','','');
     $daicg_fonct=$userRepository->countAgentByParam('','FONCTIONNAIRE','','7','','','');
     $admin_adjoin_contractuel=$userRepository->countAgentByParam('','CONTRACTUEL','','8','','','');
     $admin_adjoin_fonct=$userRepository->countAgentByParam('','FONCTIONNAIRE','','8','','','');
     $admin_contractuel=$userRepository->countAgentByParam('','CONTRACTUEL','','9','','','');
     $admin_fonct=$userRepository->countAgentByParam('','FONCTIONNAIRE','','9','','','');

     $trancheF2024 = $communicationRepository->countAgentByAge('F',20,24);
     $trancheF2529 = $communicationRepository->countAgentByAge('F',25,29);
     $trancheF3034 = $communicationRepository->countAgentByAge('F',30,34);
     $trancheF3539 = $communicationRepository->countAgentByAge('F',35,39);
     $trancheF4044 = $communicationRepository->countAgentByAge('F',40,44);
     $trancheF4549 = $communicationRepository->countAgentByAge('F',45,49);
     $trancheF5054 = $communicationRepository->countAgentByAge('F',50,54);
     $trancheF5559 = $communicationRepository->countAgentByAge('F',55,59);
     $trancheF6064 = $communicationRepository->countAgentByAge('F',60,64);
     $trancheF6569 = $communicationRepository->countAgentByAge('F',65,69);

     $trancheM2024 = $communicationRepository->countAgentByAge('M',20,24);
     $trancheM2529 = $communicationRepository->countAgentByAge('M',25,29);
     $trancheM3034 = $communicationRepository->countAgentByAge('M',30,34);
     $trancheM3539 = $communicationRepository->countAgentByAge('M',35,39);
     $trancheM4044 = $communicationRepository->countAgentByAge('M',40,44);
     $trancheM4549 = $communicationRepository->countAgentByAge('M',45,49);
     $trancheM5054 = $communicationRepository->countAgentByAge('M',50,54);
     $trancheM5559 = $communicationRepository->countAgentByAge('M',55,59);
     $trancheM6064 = $communicationRepository->countAgentByAge('M',60,64);
     $trancheM6569 = $communicationRepository->countAgentByAge('M',65,69);
     //dd($dop_m,$dop_f,$dop_m+$dop_f);

     
      return view('Frontend.superDash')->with([
                               'total'=>$total,
                               'employe'=>$employe,
                               'ag_maitrise'=>$ag_maitrise,
                               'cadre'=>$cadre,
                               'cadremoyen'=>$cadremoyen,
                               'cadresup'=>$cadresup,
                               'cadrejunior'=>$cadrejunior,
                               'genre_fem'=>$genre_fem,
                               'genre_max'=>$genre_max,
                               'contractuel'=>$contractuel,
                               'fonctionnaire'=>$fonctionnaire,
                               'dop'=>$dop,
                               'dpf'=>$dpf,
                               'dmg'=>$dmg,
                               'drhaja'=>$drhaja,
                               'dic'=>$dic,
                               'desse'=>$desse,
                               'daicg'=>$daicg,
                               'admin_adjoin'=>$admin_adjoin,
                               'admin'=>$admin,

                               'dop_m'=>$dop_m,
                               'dpf_m'=>$dpf_m,
                               'dmg_m'=>$dmg_m,
                               'drhaja_m'=>$drhaja_m,
                               'dic_m'=>$dic_m,
                               'desse_m'=>$desse_m,
                               'daicg_m'=>$daicg_m,
                               'admin_adjoin_m'=>$admin_adjoin_m,
                               'admin_m'=>$admin_m,

                               'dop_f'=>$dop_f,
                               'dpf_f'=>$dpf_f,
                               'dmg_f'=>$dmg_f,
                               'drhaja_f'=>$drhaja_f,
                               'dic_f'=>$dic_f,
                               'desse_f'=>$desse_f,
                               'daicg_f'=>$daicg_f,
                               'admin_adjoin_f'=>$admin_adjoin_f,
                               'admin_f'=>$admin_f,

                               'dop_contractuel'=>$dop_contractuel,
                               'dpf_contractuel'=>$dpf_contractuel,
                               'dmg_contractuel'=>$dmg_contractuel,
                               'drhaja_contractuel'=>$drhaja_contractuel,
                               'dic_contractuel'=>$dic_contractuel,
                               'desse_contractuel'=>$desse_contractuel,
                               'daicg_contractuel'=>$daicg_contractuel,
                               'admin_adjoin_contractuel'=>$admin_adjoin_contractuel,
                               'admin_contractuel'=>$admin_contractuel,
                               
                               'dop_fonct'=>$dop_fonct,
                               'dpf_fonct'=>$dpf_fonct,
                               'dmg_fonct'=>$dmg_fonct,
                               'drhaja_fonct'=>$drhaja_fonct,
                               'dic_fonct'=>$dic_fonct,
                               'desse_fonct'=>$desse_fonct,
                               'daicg_fonct'=>$daicg_fonct,
                               'admin_adjoin_fonct'=>$admin_adjoin_fonct,
                               'admin_fonct'=>$admin_fonct,

                              'trancheF2529' => $trancheF2529,
                              'trancheF2024' => $trancheF2024,
                              'trancheF3539' => $trancheF3539,
                              'trancheF3034' => $trancheF3034,
                              'trancheF4549' => $trancheF4549,
                              'trancheF4044' => $trancheF4044,
                              'trancheF5559' => $trancheF5559,
                              'trancheF5054' => $trancheF5054,
                              'trancheF6569' => $trancheF6569,
                              'trancheF6064' => $trancheF6064,

                              'trancheM2529' => $trancheM2529,          
                              'trancheM2024' => $trancheM2024,
                              'trancheM3539' => $trancheM3539,
                              'trancheM3034' => $trancheM3034,
                              'trancheM4549' => $trancheM4549,
                              'trancheM4044' => $trancheM4044,
                              'trancheM5559' => $trancheM5559,
                              'trancheM5054' => $trancheM5054,
                              'trancheM6569' => $trancheM6569,
                              'trancheM6064' => $trancheM6064,

                              'abengourou' => $abengourou,
                              'abobo' => $abobo,
                              'aboisso' => $aboisso,
                              'Adjame' => $Adjame,
                              'beoumi' => $beoumi,
                              'bouake' => $bouake,
                              'daloa' => $daloa,
                              'daoukro' => $daoukro,
                              'dimbokro' => $dimbokro,
                              'gagnoa' => $gagnoa,
                              'guiglo' => $guiglo,          
                              'korhogo' => $korhogo,
                              'Man' => $Man,
                              'odiene' => $odiene,
                              'prestige' => $prestige,
                              'sanpedro' => $sanpedro,
                              'soubre' => $soubre,
                              'treichville' => $treichville,
                              'yamoussoukro' => $yamoussoukro,
                              'yopougon' => $yopougon,
                            
                               ]);
  }

   public function indexDirection()
  {
      return view('Frontend.direction');
  }

   public function indexSousdirection()
  {
      $directions=Direction::All();
      $grade_sd=Grade_sd::All();
       $sousdirections=SousDirection::All();

      return view('Frontend.sousdirection')->with([
        'directions'=>$directions,
        'grade_sd'=>$grade_sd,
        'sousdirections'=>$sousdirections,
    ]);
  }

   public function indexService()
  {
      $directions=Direction::All();
      $sousdirections=SousDirection::All();
      $grade_sd=Grade_sd::All();
      $services=Service::All();
      return view('Frontend.service')->with([
        'directions'=>$directions,
        'grade_sd'=>$grade_sd,
        'sousdirections'=>$sousdirections,
        'services'=>$services,
    ]);
  }


   public function indexAgent(Request $request,UserRepository $userRepository)
  {
      //Session::forget('nom');
      $directions=Direction::All();    $direction_id='';
      $sousdirections=SousDirection::All();   $sousdirection_id='';
      $services=Service::All();    $service_id='';
      $grade_sd=Grade_sd::All();
      $grades=Grade::All();
      $nom=$request->get('nom')??'';
      $page=$request->get('page');
      
      if($nom=='' && $page==''){ 
        Session::forget('nom'); 
      }elseif($nom && $page==''){
             Session::put('nom', $nom);
      }else{
            $nom=Session::get('nom');
      }
      

      $agents=$userRepository->getAgentByUser($nom,$direction_id,$sousdirection_id,$service_id,0);
      
      return view('Frontend.agent')->with([
        'directions'=>$directions,
        'sousdirections'=>$sousdirections,
        'services'=>$services,
        'grade_sd'=>$grade_sd,
        'agents'=>$agents,
        'grades'=>$grades,
    ]);
  }

   public function indexFiliation()
  {
    $directions=Direction::All();
     $sousdirections=SousDirection::All();
     $grade_sd=Grade_sd::All();
      $services=Service::All();
      $agents=User::All();
      $grades=Grade::All();

      return view('Frontend.filiation')->with([
        'directions'=>$directions,
        'grade_sd'=>$grade_sd,
        'sousdirections'=>$sousdirections,
        'services'=>$services,
        'agents'=>$agents,
        'grades'=>$grades,
    ]);
  }

   public function create_form_filiation($id,UserRepository $userRepository)
  {
    $agent=$userRepository->getAgentById($id);
    return view('Frontend.filiation_form')->with([
               'agent'=>$agent
    ]);
  }

  public function create_form_document($id,UserRepository $userRepository)
  {
    //dd();
    $agent=$userRepository->getAgentById($id);
    return view('Frontend.document_form')->with([
               'agent'=>$agent
    ]);
  }

  public function createAgent_form_fonction($id,UserRepository $userRepository)
  {
    //dd();
    $agent=$userRepository->getAgentById($id);
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
    //dd($agent);

    return view('Frontend.agent_fonction_form')->with([
            'agent'=>$agent,
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

  public function create_form_conge()
  {
    //dd();
            $current = Carbon::now();

            $direction_id=Auth::user()->direction_id;
            $sousdirection_id=Auth::user()->sousdirection_id;
            $service_id=Auth::user()->service_id;
            $user_type=Auth::user()->type_id;
            $user_grade=Auth::user()->grade_id;
            $user_id=Auth::id();
            $nom='';


            $directions=Direction::All();
            $sousdirections=SousDirection::All();
            $grade_sd=Grade_sd::All();
            $services=Service::All();
            $agents=DB::table('users')
                ->orderBy('nomprenoms', 'asc')
                ->get();
            $grades=Grade::All();
            $enfant= '';
            $age= '';
            $anciennete= '';
            $interim=DB::table('users')
                ->orderBy('nomprenoms', 'asc')
                ->get();
             $congepris=getjourdeconge($user_id,'CONGE');
             $autorisationpris=getjourdeconge($user_id,'ABSENCE');
            //dd($congepris);
            return view('Frontend.demande_conge_form')->with([
                      'directions'=>$directions,
                      'grade_sd'=>$grade_sd,
                      'sousdirections'=>$sousdirections,
                      'services'=>$services,
                      'agents'=>$agents,
                      'grades'=>$grades,
                      'congepris'=>$congepris,
                      'autorisationpris'=>$autorisationpris
            ]);
  }

   public function indexDocument()
  {
    $directions=Direction::All();
     $sousdirections=SousDirection::All();
     $grade_sd=Grade_sd::All();
      $services=Service::All();
      $agents=User::All();
      $grades=Grade::All();

      return view('Frontend.document')->with([
        'directions'=>$directions,
        'grade_sd'=>$grade_sd,
        'sousdirections'=>$sousdirections,
        'services'=>$services,
        'agents'=>$agents,
        'grades'=>$grades,
    ]);
  }

   public function indexDemande(Request $request,DemandeRepository $demandeRepository)
  {
     //dd(Auth::user()->state==1);
    $agent_function = Session::get('function_key');
    $level='';

     if(Auth::user()->state==1 || $agent_function->direction_id==4){ //soit admin ou de la DRH
      $direction_id='';
      $sousdirection_id='';
      $service_id='';
      $user_id='';
     }elseif($agent_function->level==6 ){
            $direction_id=$agent_function->direction_id;
            $sousdirection_id='';
            $service_id='';
            $user_id='';
            $level=1;
     }else{

     $direction_id=$agent_function->direction_id;
     $sousdirection_id=$agent_function->sousdirection_id;
     $service_id=$agent_function->service_id;
     $user_id=Auth::id();
     if($agent_function->level==2){$user_id='';}
     if($agent_function->level==3){$user_id='';  $service_id='';}
     if($agent_function->level==4){$user_id='';  $service_id=''; $sousdirection_id='';}
     }

      $page=$request->get('page');
      $ob_param=$request->all();
      
      if($ob_param==[] && $page==''){ 
            Session::forget('ob_param'); 
          }elseif($ob_param && $page==''){
                 Session::put('ob_param', $ob_param);
          }else{
                $ob_param=Session::get('ob_param');
          }
        if($agent_function->level==6){
          $demandes=$demandeRepository->getDemandesOfAdmin($direction_id,$sousdirection_id,$service_id,$user_id,'','',$level,'',$ob_param);
        }else{
          $demandes=$demandeRepository->getDemandesByUser($direction_id,$sousdirection_id,$service_id,$user_id,'','',$level,'',$ob_param);
        }
     

      //dd($direction_id,$sousdirection_id,$service_id,$agent_function->level, $user_id,$demandes);
        $directions=Direction::All();
        $sousdirections=SousDirection::All();
        $grade_sd=Grade_sd::All();
        $services=Service::All();
        $agents=User::All();
        $grades=Grade::All();
     //dd($demandes);
      return view('Frontend.demande')->with([
                                            'demandes'=>$demandes,
                                            'directions'=>$directions,
                                            'grade_sd'=>$grade_sd,
                                            'sousdirections'=>$sousdirections,
                                            'services'=>$services,
                                            'agents'=>$agents,
                                            'grades'=>$grades,
                                        ]);
  }

  public function indexPlanning(Request $request,DemandeRepository $demandeRepository)
  {
     //dd(Auth::user()->state==1);
     if(Auth::user()->state==1 || Session::get('function_key')->direction_id==4){ //soit admin ou de la DRH
      $direction_id='';
      $sousdirection_id='';
      $service_id='';
      $user_id='';
     }else{

     $agent_function = Session::get('function_key');
     $direction_id=$agent_function->direction_id;
     $sousdirection_id=$agent_function->sousdirection_id;
     $service_id=$agent_function->service_id;
     $user_id=Auth::id();
     if($agent_function->level==2){$user_id='';}
     if($agent_function->level==3){$user_id='';  $service_id='';}
     if($agent_function->level==4){$user_id='';  $service_id=''; $sousdirection_id='';}
     }

      $page=$request->get('page');
      $ob_param=$request->all();
      
      if($ob_param==[] && $page==''){ 
            Session::forget('ob_param'); 
          }elseif($ob_param && $page==''){
                 Session::put('ob_param', $ob_param);
          }else{
                $ob_param=Session::get('ob_param');
          }
     
    
     $demandes=$demandeRepository->getPlanningByUser($direction_id,$sousdirection_id,$service_id,$user_id,'','','CONGE',$ob_param);
      //dd($direction_id,$sousdirection_id,$service_id,$agent_function->level, $user_id,$demandes);
        $directions=Direction::All();
        $sousdirections=SousDirection::All();
        $grade_sd=Grade_sd::All();
        $services=Service::All();
        $agents=User::All();
        $grades=Grade::All();
     //dd($demandes);
      return view('Frontend.planning')->with([
                                            'demandes'=>$demandes,
                                            'directions'=>$directions,
                                            'grade_sd'=>$grade_sd,
                                            'sousdirections'=>$sousdirections,
                                            'services'=>$services,
                                            'agents'=>$agents,
                                            'grades'=>$grades,
                                        ]);
  }

  public function indexDocumentation(Request $request,DemandeRepository $demandeRepository)
  {

    $documents=Documentation::All();

    $page=$request->get('page');
    $ob_param=$request->all();
    
    if($ob_param==[] && $page==''){ 
          Session::forget('ob_param'); 
        }elseif($ob_param && $page==''){
               Session::put('ob_param', $ob_param);
        }else{
              $ob_param=Session::get('ob_param');
        }
  
    $demandes=$demandeRepository->getDoc_demandeByUser(Auth::id(),'','',$ob_param);
     //dd($demandes);
      return view('Frontend.documentation')->with([
                                            'demandes'=>$demandes,
                                            'documents'=>$documents
                                        ]);
    
  }

  

   public function inbox(DirectionRepository $directionrepository)
  {

    $user_id=Auth::id();
    $messages=$directionrepository->getMessagebyUser($user_id,1);
     //dd($messages);
    return view('Frontend.inbox')->with([
                                          'messages'=>$messages
                                        ]);
    
  }

  public function messagesent(DirectionRepository $directionrepository)
  {

    $user_id=Auth::id();
    $messages=$directionrepository->getMessageSentbyUser($user_id,2);
     //dd($messages);
    return view('Frontend.sent')->with([
                                          'messages'=>$messages
                                        ]);
  }

   public function nouveauMessage(DirectionRepository $directionrepository)
  {

    $directions=Direction::All();
    $sousdirections=SousDirection::All();
    $services=Service::All();
    $agents=User::All();
    $type=Auth::user()->type_id;
    $user_id=Auth::id();
    $messages=$directionrepository->getMessagebyUser($type,$user_id);
//dd($messages);
    return view('Frontend.message_form')->with([
                                            'directions'=>$directions,
                                            'sousdirections'=>$sousdirections,
                                            'services'=>$services,
                                            'agents'=>$agents,
                                            'messages'=>$messages
                                        ]);
    
  }
  

   public function viewMessage($id, DirectionRepository $directionrepository)
  {

    $messages=$directionrepository->getMessagebyId($id);

    return view('Frontend.view_message')->with([
                                            'messages'=>$messages
                                        ]);
  }

  

}









  
