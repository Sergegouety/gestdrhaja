<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Session;

use Carbon\Carbon;
use App\Models\Article;
use App\Models\Article_image;


class CommunicationRepository
{


    public function getArticle($request)
    {
    
       $agent_function = Session::get('function_key');
       $direction_id=$agent_function->direction_id;
       $sousdirection_id=$agent_function->sousdirection_id;
       $service_id=$agent_function->service_id;
       $level=$agent_function->level;
       $nom=$request['nom'] ?? '';
       $date=$request['datepub'] ?? '';

       if(Session::get('function_key')->isredact==10 || Session::get('function_key')->isredact==1 || $sousdirection_id == 12 || ($direction_id == 4 && $level >= 3) ){
                $direction_id='';
                $sousdirection_id='';
                $service_id='';
                $user_id='';
        }else{

                if($level==1){$user_id=Auth::id();}
                if($level==2){$user_id=''; $service_id=$service_id;}
                if($level==3){$user_id=''; $service_id=''; $sousdirection_id=$sousdirection_id;}
                if($level==4){$user_id=''; $service_id=''; $sousdirection_id=''; $direction_id=$direction_id;}
            
        }
        
        

        $articles =DB::table('article')
               ->join('agent_fonction','article.user_id','agent_fonction.user_id')
               ->select('article.id','article.user_id','article.titre','article.resume','article.created_at as date_publication','article.contenu','article.state','article.type_event','article.article_type','agent_fonction.direction_id','agent_fonction.sousdirection_id','agent_fonction.service_id')
               ->when($user_id, function ($query, $user_id) 
                                    {return $query->where('article.user_id', $user_id);}
                                        )
               ->when($nom, function ($query, $nom) 
                                    {return $query->where('article.titre','like','%'.$nom.'%');}
                                        )
               ->when($nom, function ($query, $nom) 
                                    {return $query->where('article.resume','like','%'.$nom.'%');}
                                        )
               ->when($nom, function ($query, $nom) 
                                    {return $query->where('article.contenu','like','%'.$nom.'%');}
                                        )
               ->when($date, function ($query, $date) 
                                    {return $query->where('article.created_at','like','%'.$date.'%');}
                                        )
               ->when($direction_id, function ($query, $direction_id) 
                                    {return $query->where('agent_fonction.direction_id', $direction_id);}
                                        )
               ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                    {return $query->where('agent_fonction.sousdirection_id', $sousdirection_id);}
                                        )
               ->when($service_id, function ($query, $service_id) 
                                    {return $query->where('agent_fonction.service_id', $service_id);}
                                        )
               ->orderBy('date_publication', 'desc')
               ->paginate(20);
       
     return $articles;
    }


    public function addArticle($request)
    {

        //dd($request);
        $user_id=$request->get('user_id');
        $article_type=$request->get('article_type');
        $type_event=$request->get('type_event') ?? 1;
        $titre=$request->get('titre');
        $resume=$request->get('resume');
        $contenu=$request->get('contenu');
        $agent_function = Session::get('function_key');
        $state=1;
        
        
        $article = new Article();
                $article->user_id = $user_id;
                $article->article_type = $article_type;
                $article->type_event = $type_event;
                $article->titre =  $titre;
                $article->resume =  $resume;
                $article->contenu = $contenu;
                $article->state =  $state;

                $article->save();
    
       return $article->id;
    }

    public function updateArticle($request)
    {

        //dd($request);
        $user_id=$request->get('user_id');
        $aid=$request->get('aid');
        $article_type=$request->get('article_type');
        $type_event=$request->get('type_event');
        $titre=$request->get('titre');
        $resume=$request->get('resume');
        $contenu=$request->get('contenu');
        $event=$request->get('type_event') ?? '';
        
        $affected = DB::table('article')
              ->where('id', $aid)
              ->update([
                'user_id' => $user_id,
                'article_type' => $article_type,
                'titre' => $titre,
                'contenu' => $contenu,
                'type_event' => $event
            ]);
       return $aid;
    }

     public function addArticleImages($aid,$file_doc,$numero,$state)
    {
        
            $article = new Article_image();

            $article->article_id = $aid;
            $article->image_file = $file_doc;
            $article->numero = $numero;
            $article->state =  $state;

            $article->save();
    
       return $article->id;
    }

    

    public function deleteArticleImages($aid,$numero)
    {
        $deleted = DB::table('article_image')
        ->where([
                'article_image.article_id'=> $aid,
                'article_image.numero'=> $numero
                ])
        ->delete();
    }

    public function updateArticleImages($aid,$numero,$file_doc)
    {

        $affected = DB::table('article_image')
              ->where('article_image.id',$aid)
              ->where('article_image.numero', $numero)
              ->update([
                         'image_file' => $file_doc
                       ]);
        
    }

     public function getAnniversaires()
    {
      $today = Carbon::today();
      $today_ = explode(' ',$today);
      $param = explode('-', $today_[0]);
      $param_ = $param[1].'-'.$param[2];
       $anniversaire =DB::table('users')
                ->join('agent_fonction', 'users.id','agent_fonction.user_id')
                ->select('users.id','users.nomprenoms','users.telephone1','agent_fonction.direction_id','agent_fonction.sousdirection_id','agent_fonction.service_id','agent_fonction.fonction')
                ->where('users.datenaissance','like','%'.$param_.'%')
                ->orderBy('users.nomprenoms', 'asc')
                ->paginate(5);
     //dd($param_,$anniversaire);
     return $anniversaire;
    }

     public function getMonthAnniversaires()
    {
      $today = Carbon::today();
      $today_ = explode(' ',$today);
      $param = explode('-', $today_[0]);
      $param_ = $param[1].'-'.$param[2];
       $anniversaire =DB::table('users')
                ->join('agent_fonction', 'users.id','agent_fonction.user_id')
                ->select('users.id','users.nomprenoms','users.telephone1','agent_fonction.fonction','users.datenaissance')
                ->whereMonth('users.datenaissance',Carbon::now()->format('m'))
                ->orderBy('users.nomprenoms', 'asc')
                ->get();
     //dd($param_,$anniversaire);
     return $anniversaire;
    }

     
     public function countAgentByAge($genre,$inf,$sup)
    {
      $anniversaire=DB::table('users')
                ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(datenaissance), current_date) as age")
                ->where('users.genre',$genre)
                ->whereRaw("TIMESTAMPDIFF(YEAR, DATE(datenaissance), current_date) BETWEEN $inf AND $sup" )
                ->count();
     return $anniversaire;
    }

    public function removeArticle($did,$opt)
    {

      //$opt=4;
        $dt = Carbon::now();
        $delay = Carbon::now()->addDays(7);
        //dd($dt,$delay);
        if($opt==4){
            $publicated_at=$dt;
            $delayed_at=$delay;
                  }else{
            $publicated_at=NULL;
            $delayed_at=NULL;
             
                      }
   
     $rep = Article::where('id', $did)
             ->update([
               'state' =>$opt,
               'validated_at' =>$publicated_at,
               'delayed_at' =>$delayed_at
               ]);
           return $rep;
          
    }

    public function getArticleByType($article_type,$event,$limit,$state)
    {

         $dt = Carbon::now();
        // $date= $dt->subDays(7);
        // dd($date);
   
     $article =DB::table('article')
                ->select('article.id','article.user_id','article.article_type','article.type_event','article.titre','article.resume','article.contenu','article.created_at','article.validated_at','article.delayed_at','article.state')
                 ->where('article.delayed_at','>=', $dt)
                 ->when($article_type, function ($query, $article_type) 
                                    {return $query->where('article.article_type', $article_type);}
                                        )
                  ->when($state, function ($query, $state) 
                                    {return $query->where('article.state', $state);}
                                        )
                  ->when($event, function ($query, $event) 
                                    {return $query->where('article.type_event', $event);}
                                        )
                   ->when($limit, function ($query, $limit) 
                                    {return $query->limit($limit);}
                                        )
                    ->orderBy('created_at', 'desc')
                ->get();
     return $article;
          
    }

    public function getArticleById($id)
    {
     
     $article =DB::table('article')
                ->select('article.id','article.article_type','article.type_event','article.titre','article.resume','article.contenu','article.created_at','article.state')
                 ->when($id, function ($query, $id) 
                                    {return $query->where('article.id', $id);}
                                        )
                ->first();
     return $article;
          
    }

    public function getImageByArticleId($id,$numero,$state)
    {
     $article =DB::table('article_image')
                ->select('article_image.article_id','article_image.image_file')
                 ->when($id, function ($query, $id) 
                                    {return $query->where('article_image.article_id', $id);}
                                        )
                 ->when($numero, function ($query, $numero) 
                                    {return $query->where('article_image.numero', $numero);}
                                        )
                 ->when($state, function ($query, $state) 
                                    {return $query->where('article_image.state', $state);}
                                        )
                ->first();
     return $article;
          
    }

    public function getDocByArticleId($id,$state)
    {
     $article =DB::table('article_image')
                ->select('article_image.article_id','article_image.image_file')
                 ->when($id, function ($query, $id) 
                                    {return $query->where('article_image.article_id', $id);}
                                        )
                 ->when($state, function ($query, $state) 
                                    {return $query->where('article_image.state', $state);}
                                        )
                 ->orderBy('article_image.created_at','desc')
                ->first();
     return $article;
          
    }




 
}