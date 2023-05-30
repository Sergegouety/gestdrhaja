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
use App\Models\Sousdirection;
use App\Models\Service;


class ServiceController extends Controller 
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
  public function store(Request $request)
  {

    //dd($request);
    $direction=$request->get('direction');
    $sousdirection=$request->get('sousdirection');
    $designation=$request->get('service');
    //$description=$request->get('description');

     DB::beginTransaction();
        try
        {
    
    $service = new Service();

    $service->direction_id = $direction;
    $service->sousdirection_id = $sousdirection;
    $service->designation = $designation;
    //$service->description = $description;
    //$service->state = 1;
   
    $response = $service->save();
     }
        catch (Exception $e)
         {
                  DB::rollback();
                 Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                 return Redirect::back();
         }   
                 DB::commit();
                return Redirect::back()->with('success',"Service ajoutée avec succès");

    
  }

  public function getServiceById($instance){

                   $instanceVal = Sousdirection::where(['id'=>$instance])->first();

                   //dd($instance,$typeid,$instanceVal);
                    $obj = new \stdClass;
                    $obj->id = $instanceVal->id;
                    $obj->direction = $instanceVal->direction_id;
                    $obj->designation = $instanceVal->designation;
                   
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
  public function edit(Request $request)
  {

    //dd($request);
    $direction=$request->get('direction');
    $sousdirection=$request->get('sousdirection');
    $service=$request->get('service');
    $service_id=$request->get('service_id');

     DB::beginTransaction();
        try
        {

           $affected = DB::table('service')
              ->where('id', $service_id)
              ->update([
                      'direction_id' => $direction,
                      'sousdirection_id' => $sousdirection,
                      'designation' => $service
                      ]);
    
    
         }
            catch (Exception $e)
             {
                      DB::rollback();
                     Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                     return Redirect::back();
             }   
                     DB::commit();
                    return Redirect::back()->with('success',"Service modifié avec succès");

   
    
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