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

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Services\uploadFile;
use Carbon\Carbon;
use PDF;

use App\Repositories\DirectionRepository;

use App\Models\Direction;
use App\Models\Sousdirection;

class SousdirectionController extends Controller 
{

	public function store(Request $request)
  {
     //dd($request);
    $direction=$request->get('direction');
    $niveau=$request->get('niveau');
    $designation=$request->get('sousdirection');
    $description=$request->get('description');
    
    $sousdirection = new Sousdirection();

    
    $sousdirection->direction_id = $direction;
    $sousdirection->grade_sd_id  = $niveau;
    $sousdirection->designation = $designation;
    $sousdirection->description = $description;
    $sousdirection->state = 1;
   
    $response = $sousdirection->save();

    if($response)
    {
       return Redirect::back()->with('success',"Sous Direction ajouté avec succès");
    }
    else
    {
      return Redirect::back()->with('error',"Une erreur s'est produite, réessayer svp");
    }
    
  }



     public function showByDirectionID($direction_id, DirectionRepository $directionrepository)
  {

     $soudirections = $directionrepository->getByDirectionID($direction_id);
     $html_first = '<option value="">Sous-direction / Agence:</option>';
     $html_two = '<option value="">Selectionnez responsable</option>';

     foreach ($soudirections as $sd)
      {
           $html_first = $html_first.'<option value="'.$sd->id.'">'.$sd->designation.'</option>';
      }

      $agents =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->where([
                       'agent_fonction.direction_id' =>$direction_id
                    ])
               ->orderBy('nomprenoms', 'asc')
               ->get();
     
    foreach ($agents as $a)
      {
           $html_two = $html_two.'<option value="'.$a->id.'">'.$a->nomprenoms.'</option>';
      }


      $obj = new \stdClass;
      $obj->html_first = $html_first;
      $obj->html_two = $html_two;
     
      return response()->json($obj);


  }

   public function showBySousDirectionID($sousdirection_id, DirectionRepository $directionrepository)
  {

     $services = $directionrepository->getBySousDirectionID($sousdirection_id);
    $html_first = '<option value"" ></option>';
    $html_two = '<option value"" >Selectionnez responsable</option>';

    foreach ($services as $serv)
      {
           $html_first = $html_first.'<option value="'.$serv->id.'">'.$serv->designation.'</option>';
      }

      $agents =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->where([
                       'agent_fonction.sousdirection_id' =>$sousdirection_id
                    ])
               ->orderBy('nomprenoms', 'asc')
               ->get();
     
    foreach ($agents as $a)
      {
           $html_two = $html_two.'<option value="'.$a->id.'">'.$a->nomprenoms.'</option>';
      }


      $obj = new \stdClass;
      $obj->html_first = $html_first;
      $obj->html_two = $html_two;
     
      return response()->json($obj);


  }

  public function showServiceAndResponsableByDirectionID($direction_id,$sousdirection_id, DirectionRepository $directionrepository)
  {

    $services = $directionrepository->getBySousDirectionID($sousdirection_id);
    $html_first = '<option value"" ></option>';
    $html_two = '<option value"" >Selectionnez responsable</option>';

    foreach ($services as $serv)
      {
           $html_first = $html_first.'<option value="'.$serv->id.'">'.$serv->designation.'</option>';
      }

      $agents =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->where([
                       'agent_fonction.sousdirection_id' =>$sousdirection_id,
                       'agent_fonction.level' => 3,
                    ])
               ->orderBy('nomprenoms', 'asc')
               ->get();
      $agents_resp =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->where([
                       'agent_fonction.direction_id' =>$direction_id,
                       'agent_fonction.level' => 5,
                    ])
               ->orderBy('nomprenoms', 'asc')
               ->get();
     
    foreach ($agents as $a)
      {
           $html_two = $html_two.'<option value="'.$a->id.'">'.$a->nomprenoms.'</option>';
      }

    foreach ($agents_resp as $ar)
      {
           $html_two = $html_two.'<option value="'.$ar->id.'">'.$ar->nomprenoms.'</option>';
      }


      $obj = new \stdClass;
      $obj->html_first = $html_first;
      $obj->html_two = $html_two;
     
      return response()->json($obj);


  }


   public function showServiceAndResponsableByServiceID($direction_id,$sousdirection_id,$service_id, DirectionRepository $directionrepository)
  {

        $agent_function = Session::get('function_key');
        $sd = $sousdirection_id;
        $level = 3;
        $is_agence = @get_isagence($level, $sd);

    $services = $directionrepository->getBySousDirectionID($sousdirection_id);
    $html_first = '<option value"" ></option>';
    $html_two = '<option value"" >Selectionnez responsable</option>';
    //dd($direction_id,$sousdirection_id,$service_id,$is_agence);
    foreach ($services as $serv)
      {
           $html_first = $html_first.'<option value="'.$serv->id.'">'.$serv->designation.'</option>';
      }

      if($is_agence==1){

        //CIP , Informaticien, controleur, chagé d'accueil (agent_fonction.iscipac == 2)
        //AC  (agent_fonction.iscipac == 1)

        $agents =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->where([
                       'agent_fonction.service_id' => $service_id,
                       'agent_fonction.iscipac' => 2,
                    ])
               ->orderBy('nomprenoms', 'asc')
               ->get();

      }else{

        $agents =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->where([
                       'agent_fonction.service_id' => $service_id,
                       'agent_fonction.level' => 2,
                    ])
               ->orderBy('nomprenoms', 'asc')
               ->get();

      }

      
      $agents_resp1 =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->where([
                       'agent_fonction.sousdirection_id' =>$sousdirection_id,
                       'agent_fonction.level' => 3,
                    ])
               ->orderBy('nomprenoms', 'asc')
               ->get();

      // $agents_resp2 =DB::table('users')
      //        ->join('agent_fonction','users.id','agent_fonction.user_id')
      //        ->where([
      //                  'agent_fonction.direction_id' =>$direction_id,
      //                  'agent_fonction.level' => 5,
      //               ])
      //          ->orderBy('nomprenoms', 'asc')
      //          ->get();

    //dd($agents,$agents_resp1);
     
    foreach ($agents as $a)
      {
           $html_two = $html_two.'<option value="'.$a->id.'">'.$a->nomprenoms.'</option>';
      }

    foreach ($agents_resp1 as $ar)
      {
           $html_two = $html_two.'<option value="'.$ar->id.'">'.$ar->nomprenoms.'</option>';
      }

      // foreach ($agents_resp2 as $ar)
      // {
      //      $html_two = $html_two.'<option value="'.$ar->id.'">'.$ar->nomprenoms.'</option>';
      // }


      $obj = new \stdClass;
      $obj->html_first = $html_first;
      $obj->html_two = $html_two;
     
      return response()->json($obj);


  }

  public function showAllResponsable($direction_id,$sousdirection_id,$service_id, DirectionRepository $directionrepository)
  {

    $agent_function = Session::get('function_key');
    $sd = $sousdirection_id;
    $level = 3;
    $is_agence = @get_isagence($level, $sd);

    $services = $directionrepository->getBySousDirectionID($sousdirection_id);
    $html_first = '<option value"" ></option>';
    $html_two = '<option value"" >Selectionnez responsable</option>';
    //dd($direction_id,$sousdirection_id,$service_id,$is_agence);
    foreach ($services as $serv)
      {
           $html_first = $html_first.'<option value="'.$serv->id.'">'.$serv->designation.'</option>';
      }

     if($is_agence==1){

        $agents =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->where([
                       'agent_fonction.sousdirection_id' => $sousdirection_id,
                       'agent_fonction.iscipac' => 1,
                    ])
               ->orderBy('nomprenoms', 'asc')
               ->get();

     }else{

        $agents =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->where([
                       'agent_fonction.service_id' => $service_id,
                    ])
               ->orderBy('nomprenoms', 'asc')
               ->get();

     }
      

      if($is_agence==1){
        $agents_resp1 =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->where([
                       'agent_fonction.user_id' => Auth::id(),
                    ])
               ->orderBy('nomprenoms', 'asc')
               ->get();

      }else{

        // $agents_resp1 =DB::table('users')
        //      ->join('agent_fonction','users.id','agent_fonction.user_id')
        //      ->where([
        //                'agent_fonction.sousdirection_id' =>$sousdirection_id,
        //                'agent_fonction.level' => 3,
        //             ])
        //        ->orderBy('nomprenoms', 'asc')
        //        ->get();

        $agents_resp1 = null;

      }
      

      

      // $agents_resp2 =DB::table('users')
      //        ->join('agent_fonction','users.id','agent_fonction.user_id')
      //        ->where([
      //                  'agent_fonction.direction_id' =>$direction_id,
      //                  'agent_fonction.level' => 5,
      //               ])
      //          ->orderBy('nomprenoms', 'asc')
      //          ->get();

    //dd($agents,$agents_resp1,$agents_resp2);
     
    foreach ($agents as $a)
      {
           $html_two = $html_two.'<option value="'.$a->id.'">'.$a->nomprenoms.'</option>';
      }
      if($agents_resp1){
        foreach ($agents_resp1 as $ar)
      {
           $html_two = $html_two.'<option value="'.$ar->id.'">'.$ar->nomprenoms.'</option>';
      }
      }
    

      // foreach ($agents_resp2 as $ar)
      // {
      //      $html_two = $html_two.'<option value="'.$ar->id.'">'.$ar->nomprenoms.'</option>';
      // }


      $obj = new \stdClass;
      $obj->html_first = $html_first;
      $obj->html_two = $html_two;
     
      return response()->json($obj);


  }








}
?>