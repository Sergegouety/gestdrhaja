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

class SdirectionController extends Controller 
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
    $niveau=$request->get('niveau');
    $designation=$request->get('sousdirection');
    $description=$request->get('description');
    
    $sousdirection = new Sousdirection();

    
    $sousdirection->direction_id = $direction;
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