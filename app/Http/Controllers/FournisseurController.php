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

use App\Models\Fournisseur;
use App\Models\Fabricant;

class FournisseurController extends Controller 
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
        $entreprise=$request->get('entreprise');
        $email=$request->get('email');
        $telephone=$request->get('telephone');
        $adresse=$request->get('adresse');

    $fournisseur = new Fournisseur();

    $fournisseur->nom_entreprise = $entreprise;
    $fournisseur->email = $email;
    $fournisseur->telephone = $telephone;
    $fournisseur->adresse =  $adresse;
    $fournisseur->state = 1;
   
    $response = $fournisseur->save();

    if($response)
    {
       return Redirect::back()->with('success',"Fournisseur ajouté avec succès");
    }
    else
    {
      return Redirect::back()->with('error',"Une erreur s'est produite, réessayer svp");
    }
    
  }

  public function storeFabricant(Request $request)
  {

      //dd($request);
        $entreprise=$request->get('entreprise');
        $description=$request->get('description');
        $email=$request->get('email');
        $telephone=$request->get('telephone');
        $adresse=$request->get('adresse');

    $fabricant = new Fabricant();

    $fabricant->nom_entreprise = $entreprise;
    $fabricant->description = $description;
    $fabricant->email = $email;
    $fabricant->telephone = $telephone;
    $fabricant->adresse =  $adresse;
    $fabricant->state = 1;
   
    $response = $fabricant->save();

    if($response)
    {
       return Redirect::back()->with('success',"Fournisseur ajouté avec succès");
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