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
use App\Repositories\CommunicationRepository;

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
use App\Models\Article;
use App\Models\Poste;
use App\Models\Niveauetude;
use App\Models\Fonction;
use App\Models\Diplome;
use App\Models\Categorie;



class CommunicationController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function viewCommunication(Request $request,CommunicationRepository $communicationRepository)
  {
    
     $page=$request->get('page');
     $ob_param=$request->all();
     if($ob_param==[] && $page==''){ 
                  Session::forget('ob_param'); 
                }elseif($ob_param && $page==''){
                       Session::put('ob_param', $ob_param);
                }else{
                      $ob_param=Session::get('ob_param');
                }

    $communications=$communicationRepository->getArticle($ob_param);
    //dd($communications);
    return view('Frontend.view_communication')->with([
                                            'communications'=>$communications
                                        ]);
  }


  public function viewComdash(CommunicationRepository $communicationRepository,UserRepository $userRepository)
  {

     $anniversaires=$communicationRepository->getAnniversaires();
     $monthanniversaires=$communicationRepository->getMonthAnniversaires();
     $mariages = $communicationRepository->getArticleByType(1,2,5,4);  //$article_type,$event,$limit,$state
     $naissances = $communicationRepository->getArticleByType(1,3,5,4);
     $deces = $communicationRepository->getArticleByType(1,4,5,4);
     $articles_rh = $communicationRepository->getArticleByType(1,1,2,4);
     $articles_nl = $communicationRepository->getArticleByType(2,1,2,4);
     $articles_mutuel = $communicationRepository->getArticleByType(3,1,2,4);
     $articles_agent = $communicationRepository->getArticleByType(4,'',2,4);
     $articles_autres = $communicationRepository->getArticleByType(1,'',2,4);
     
     //dd($articles_agent,$articles_autres);
    return view('Frontend.com_dash')->with([
                'articles_rh'=> $articles_rh,
                'articles_nl' => $articles_nl,
                'articles_mutuel' => $articles_mutuel,
                'articles_agent' => $articles_agent,
                'anniversaires'=> $anniversaires,
                'monthanniversaires'=> $monthanniversaires,
                'mariages'=> $mariages,
                'naissances'=> $naissances,
                'deces'=> $deces,
                'articles_autres'=> $articles_autres,
        ]);
  }


  public function newCommunication()
  {
    return view('Frontend.communication_form');
  }

   public function editCommunication($aid,CommunicationRepository $communicationRepository)
  {
     $article=$communicationRepository->getArticleById($aid);
     $image1=$communicationRepository->getImageByArticleId($aid,1,1);
     $image2=$communicationRepository->getImageByArticleId($aid,2,1);
     $fichierjoint=$communicationRepository->getDocByArticleId($aid,2);
     //dd($article);
    return view('Frontend.edit_article_form')->with([
        'article'=>$article,
        'image1'=>$image1,
        'image2'=>$image2,
        'fichierjoint'=>$fichierjoint,
    ]);
  }

  public function updateCommunication(Request $request,CommunicationRepository $communicationRepository,uploadFile $uploadFile)
  {
     //dd($request);
    $articleid=$request->get('aid');
    
     DB::beginTransaction();
        try
        {
            
            $aid=$communicationRepository->updateArticle($request);
            //dd($aid);
             if($request->file('image1')){
              $file_doc = $uploadFile->upload($request,'image1');
              $did=$communicationRepository->deleteArticleImages($articleid,1);
              $uid=$communicationRepository->addArticleImages($articleid,$file_doc,1,1);
          }

    if($request->file('image2')){
              $file_doc = $uploadFile->upload($request,'image2');
              $did=$communicationRepository->deleteArticleImages($articleid,2);
              $uid=$communicationRepository->addArticleImages($articleid,$file_doc,2,1);
          }

    if($request->file('image3')){
              $file_doc = $uploadFile->upload($request,'image3');
              $did=$communicationRepository->deleteArticleImages($articleid,3);
              $uid=$communicationRepository->addArticleImages($articleid,$file_doc,3,2);
          }

        }
        catch (Exception $e)
         {
                  DB::rollback();
                 Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                 return Redirect::back();
         }   
                 DB::commit();
                return Redirect::route('view.communication')->with('success',"Article modifié avec succès");
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function createCommunication(Request $request, CommunicationRepository $communicationRepository,uploadFile $uploadFile)
  {

    //dd($request);

     DB::beginTransaction();
        try
        {
            
            $aid=$communicationRepository->addArticle($request);

    if($request->file('image1')){
              $file_doc = $uploadFile->upload($request,'image1');
              $uid=$communicationRepository->addArticleImages($aid,$file_doc,1,1);
          }

    if($request->file('image2')){
              $file_doc = $uploadFile->upload($request,'image2');
              $uid=$communicationRepository->addArticleImages($aid,$file_doc,2,1);
          }

    if($request->file('image3')){
              $file_doc = $uploadFile->upload($request,'image3');
              $uid=$communicationRepository->addArticleImages($aid,$file_doc,3,2);
          }

        }
        catch (Exception $e)
         {
                  DB::rollback();
                 Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
                 return Redirect::back();
         }   
                 DB::commit();
                return Redirect::route('view.communication')->with('success',"Article ajouté avec succès");

  }

  public function updateArticleState($did,$opt, CommunicationRepository $communicationRepository)
  {

    DB::beginTransaction();
try
{

    $communicationRepository->removeArticle($did, $opt);
          
}
 catch (Exception $e)
   {
            DB::rollback();
           Session::flash('error',"Une erreur s'est produite ".$e->getMessage().", Réessayer svp");
           return Redirect::back();
   } 

            DB::commit();
            Session::flash('success','Article Modifié avec succès');
            //Session::flash('active','doc');
           return redirect()->route('view.communication');
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    
    
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function showArticleById($id,CommunicationRepository $communicationRepository)
  {
  
   $article=$communicationRepository->getArticleById($id);
   $monthanniversaires=$communicationRepository->getMonthAnniversaires();
   $image1=$communicationRepository->getImageByArticleId($id,1,1);
   $image2=$communicationRepository->getImageByArticleId($id,2,1);
   $fichierjoint=$communicationRepository->getDocByArticleId($id,2);
   $anniversaires=$communicationRepository->getAnniversaires();
   $mariages = $communicationRepository->getArticleByType(1,2,5,2);  //$article_type,$event,$limit,$state
     $naissances = $communicationRepository->getArticleByType(1,3,5,2);
     $deces = $communicationRepository->getArticleByType(1,4,5,2);
   //dd($monthanniversaires);
   return view('Frontend.article_detail')->with([
            'anniversaires'=> $anniversaires,
            'monthanniversaires'=> $monthanniversaires,
            'article'=> $article,
            'image1'=> $image1,
            'image2'=> $image2,
            'fichierjoint'=> $fichierjoint,
            'mariages'=> $mariages,
            'naissances'=> $naissances,
            'deces'=> $deces
        ]);

    
  }

  public function showArticleByType($id,CommunicationRepository $communicationRepository)
  {

        $anniversaires=$communicationRepository->getAnniversaires();
        $monthanniversaires=$communicationRepository->getMonthAnniversaires();
        $articles = $communicationRepository->getArticleByType($id,'','',4); //$article_type,$event,$limit,$state
        $articles_rh = $communicationRepository->getArticleByType(1,1,2,4);
        $articles_nl = $communicationRepository->getArticleByType(2,1,2,4);
        $articles_mutuel = $communicationRepository->getArticleByType(3,1,2,4);
        $mariages = $communicationRepository->getArticleByType(1,2,5,4);  //$article_type,$event,$limit,$state
        $naissances = $communicationRepository->getArticleByType(1,3,5,4);
        $deces = $communicationRepository->getArticleByType(1,4,5,4);

        
        //dd($articles);
   return view('Frontend.article_liste')->with([
          'anniversaires'=> $anniversaires,
          'monthanniversaires'=> $monthanniversaires,
          'articles'=> $articles,
           'articles_rh'=> $articles_rh,
          'articles_nl' => $articles_nl,
          'articles_mutuel' => $articles_mutuel,
          'mariages' => $mariages,
          'naissances' => $naissances,
          'deces' => $deces,

        ]);

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