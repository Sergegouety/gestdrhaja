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
use App\Models\Materiel;
use App\Models\Stock;
use App\Repositories\DemandeRepository;

class StockController extends Controller 
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
  public function store(Request $request,DemandeRepository $demandeRepository)
  {
    //dd($request);

     $demande_id=$request->get('demande_id');
     $detail_id=$request->get('detail_id');
     $cartons=$request->get('cartons');
     $nbr_demande=$request->get('cartons_d');
     $type_stock=$request->get('type_stock');

     $total_livre=getTotalLivre($demande_id,$detail_id);
     $total=$total_livre + $cartons;

    if ($total==$nbr_demande) {
       $opt=4;
     }else{
      $opt=3;
     }

     
    
      DB::beginTransaction();
try
{
  if ($type_stock==1) {

         $resp1=$demandeRepository->addSortie($request);

  }else{

              if($total<=$nbr_demande){

                   $resp1=$demandeRepository->addSortie($request);
                   $resp2=$demandeRepository->removeDemande($demande_id,$opt);
                   $resp3=$demandeRepository->updateDemandeDetail($detail_id,$opt);

              }else{
                Session::flash('error',"Le Total livré ".$total." est superieur au total demandé ".$nbr_demande.", Vérifiez svp");
                       return Redirect::back();
              }

  }
  

}
 catch (Exception $e)
   {
            DB::rollback();
           Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
           return Redirect::back();
   } 

            DB::commit();
       return Redirect::back()->with('success',"Stock Modifié avec succès");
    
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