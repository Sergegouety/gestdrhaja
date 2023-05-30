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

use App\Models\Direction;
use App\Models\Grade_sd;
use App\Models\SousDirection;
use App\Models\Service;
use App\Models\Materiel;
use App\Models\User;
use App\Models\Grade;
use App\Models\Demande;
use App\Repositories\DemandeRepository;
use App\Models\Design_materiel;

class StatController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function congeStats(DemandeRepository $demandeRepository, Request $request)
  {

     $materiels= DB::table('materiel')->where('group_id',3)->get();
     $directions=Direction::All();
     $sousdirections=SousDirection::All();
     $grade_sd=Grade_sd::All();
     $services=Service::All();
     $agents=User::All();
     $grades=Grade::All();

     $direction_id=$request->get('direction') ?? '';
     $sousdirection_id=$request->get('sousdirection') ?? '';
     $service_id=$request->get('service') ?? '';
     $motif=$request->get('motif') ?? '';

      $conges=$demandeRepository->getcongeByParametre(Auth::id(),'',$direction_id,$sousdirection_id,$service_id,$motif);
      //dd($materiels);
      return view('Frontend.stat_conge')->with([
                                            'materiels'=>$materiels,
                                            'directions'=>$directions,
                                            'grade_sd'=>$grade_sd,
                                            'sousdirections'=>$sousdirections,
                                            'services'=>$services,
                                            'agents'=>$agents,
                                            'grades'=>$grades,
                                            'conges'=>$conges,
                                            'direction_id'=>$direction_id,
                                            'sousdirection_id'=>$sousdirection_id,
                                            'service_id'=>$service_id,
                                        ]);
    
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function intervention(DemandeRepository $demandeRepository)
  {

    $materiels=Design_materiel::All();
     $mymateriel=$demandeRepository->getMymateriel(Auth::id());
     $demandes=$demandeRepository->getDemandesByUser(Auth::id(),'');
    $interventions=$demandeRepository->getInterventionByUser(Auth::id(),'');
     //dd($interventions);
      return view('Frontend.stat_intervention')->with([
                                            'materiels'=>$materiels,
                                            'demandes'=>$demandes,
                                            'interventions'=>$interventions,
                                            'mymateriel'=>$mymateriel
                                        ]);
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {


    
  }

  

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
 

  

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
  public function update()
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