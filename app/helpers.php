<?php
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Notification;


if(!function_exists('demande_congelist'))
{
   function demande_congelist($state)
   {

     $demande =DB::table('demandes')
             ->where([
                      'state'=>$state
                  ])
             ->get();
     return $demande;
   
   }
} 

if(!function_exists('demande_documentlist'))
{
   function demande_documentlist($state)
   {

     $demande =DB::table('doc_demande')
             ->where([
                      'state'=>$state
                  ])
             ->get();
     return $demande;
   
   }
}

if(!function_exists('nouvelle_articlelist'))
{
   function nouvelle_articlelist($state)
   {

     $demande =DB::table('article')
             ->where([
                      'state'=>$state
                  ])
             ->get();
     return $demande;
   
   }
}

if(!function_exists('getInstanceName'))
{
   function getInstanceName($table,$table_id,$value,$returnName)
   {

     $entree =DB::table($table)
             ->where([
                       $table_id =>$value
                  ])
             ->first();

     return $entree->$returnName;
   
   }
} 

if(!function_exists('getAuteurName'))
{
   function getAuteurName($id)
   {
     if($id==1){$auteur='SDRH';}
     elseif($id==2){$auteur='NEWSLETTER';}
     else{$auteur='MUTUELLE';}

     return $auteur;
   
   }
} 

if(!function_exists('getTotalLivre'))
{
   function getTotalLivre($demandeId,$detailId)
   {

     $livraison =DB::table('stock')
             ->where([
                       'demande_id' =>$demandeId,
                       'detail_id' =>$detailId
                  ])
             ->sum('quantite_carton');

     return $livraison;
   
   }
} 

if(!function_exists('getTotalInStock'))
{
   function getTotalInStock($materielId)
   {

     $entree =DB::table('stock')
             ->where([
                       'materiel_id' =>$materielId,
                       'type' =>1
                  ])
             ->sum('quantite_carton');
      $sortie =DB::table('stock')
             ->where([
                       'materiel_id' =>$materielId,
                       'type' =>2
                  ])
             ->sum('quantite_carton');

             $totalInStock= $entree -  $sortie;
//dd($entree,$sortie,$totalInStock);
     return $totalInStock;
   
   }
} 

if(!function_exists('getDemandeDetail'))
{
   function getDemandeDetail($demandeId)
   {

     $details =DB::table('demande_details')
             ->where([
                       'demande_id' =>$demandeId,
                  ])
             ->get();
     
//dd($entree,$sortie,$totalInStock);
     return $details;
   
   }
} 

if(!function_exists('getResponsableName'))
{
   function getResponsableName($instance,$value,$level)
   {
    $name='';

     $user =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->select('nomprenoms')
             ->where([
                       $instance =>$value,
                       'level' =>$level,
                  ])
             ->first();
     if($user){
      $name=$user->nomprenoms;
     }else{
        $name="Non enrégistré";
     }
     
     return $name;
   
   }
} 

if(!function_exists('getAgentById'))
{
   function getAgentById($id)
   {
    
     $user =DB::table('users')
             ->join('agent_fonction','users.id','agent_fonction.user_id')
             ->select('users.id','users.nomprenoms','agent_fonction.direction_id','agent_fonction.service_id','agent_fonction.sousdirection_id','agent_fonction.level','agent_fonction.datepriseservice','agent_fonction.statut','users.genre','users.datenaissance')
             ->where([
                       'users.id' =>$id,
                  ])
             ->first();
     
     return $user;
   
   }
} 

if(!function_exists('getAgentFunctionById'))
{
   function getAgentFunctionById($id)
   {
    
     $user =DB::table('agent_fonction')
             ->where([
                       'user_id' =>$id,
                  ])
             ->first();
     
     return $user;
   
   }
} 

if(!function_exists('getAgentFunctionByName'))
{
   function getAgentFunctionByName($name)
   {
    
     $agent_function =DB::table('agent_fonction')
             ->join('users','users.id','agent_fonction.user_id')
             ->where([
                       'users.nomprenoms' =>$name,
                     ])
             ->first();
     
     return $agent_function;
   
   }
} 

if(!function_exists('getAgentFunctionByMatricule'))
{
   function getAgentFunctionByMatricule($matricule)
   {
    
     $agent_function =DB::table('agent_fonction')
             ->join('users','users.id','agent_fonction.user_id')
             ->where([
                       'users.matricule' =>$matricule,
                     ])
             ->first();
     
     return $agent_function;
   
   }
} 

if(!function_exists('countDemandeByDirection'))
{
   function countDemandeByDirection($did)
   {
    
     $user =DB::table('demandes')
             ->where([
                       'direction_id' =>$did,
                  ])
             ->count();
     
     return $user;
   
   }
} 

if(!function_exists('countDemande'))
{
       function countDemande()
       {
        
         $demande =DB::table('demandes')
                 ->select('id')
                 ->count();
         
         if($demande){
            return $demande;
        }else{
            return 1;
        }
         
    }
} 
   
    if(!function_exists('format_date'))
{
   function format_date($date)
   {
    
    $tab = explode(" ", $date);

    $date = $tab[0];
   // $heure = $tab[1];

    $fr_format = explode('-',$date);

    //dd($fr_format);

    $new_date = $fr_format[2].'/'.$fr_format[1].'/'.$fr_format[0];

    return $new_date;
    
   }
}

 if(!function_exists('format_date2'))
{
   function format_date2($date)
   {
    
    $tab = explode(" ", $date);

    $new_date = $tab[0];
   
    return $new_date;
    
   }
}

  if(!function_exists('format_date3'))
{
   function format_date3($date)
   {
    
    $tab = explode(" ", $date);

    $date = $tab[0];
   // $heure = $tab[1];

    $fr_format = explode('-',$date);

    //dd($fr_format);

    $new_date = $fr_format[0].'/'.$fr_format[1].'/'.$fr_format[2];

    return $new_date;
    
   }
}

if(!function_exists('getInstanceName'))
{
   function getInstanceName($table,$table_id,$value,$returnName)
   {

     $entree =DB::table($table)
             ->where([
                       $table_id =>$value
                  ])
             ->first();

     return $entree->$returnName;
   
   }
} 

if(!function_exists('getMessageDestination'))
{
   function getMessageDestination($texte)
   {
     $direction='';
     $sousdirection='';
     $service='';
     $text=explode(';',$texte);

     $text_dir=$text[0];$text_sdir=$text[1];$text_serv=$text[2];$text_ag=$text[3];

     $direction_tab=explode('=',$text_dir);  $sdirection_tab=explode('=',$text_sdir);
     $service_tab=explode('=',$text_serv);  $ag_tab=explode('=',$text_ag);

     $direction_id=$direction_tab[1];$sousdirection_id=$sdirection_tab[1];
     $service_id=$service_tab[1];$agent_id=$ag_tab[1];
     
     if($agent_id){
         $agent='';
         $ids=explode(',',$agent_id);
         $agents =DB::table('users')
             ->select('nomprenoms')
             ->wherein('id',$ids)
             ->get();
       
       foreach($agents as $a){$agent=$agent.', '.$a->nomprenoms; }
       return $agent;
     }else{

        if($direction_id){ $direction_f=DB::table('direction')->where(['id' =>$direction_id])->first(); 
                           $direction=$direction_f->designation;
        }
        if($sousdirection_id){ $sousdirection_f=DB::table('sousdirection')->where(['id' =>$sousdirection_id])->first(); 
                           $sousdirection=$sousdirection_f->designation;
        }
        if($service_id){ $service_f=DB::table('service')->where(['id' =>$service_id])->first(); 
                           $service=$service_f->designation;
        }

        return $direction.' / '.$sousdirection.' / '.$service;
        
     }
   
   }
}

if(!function_exists('multiple_selected'))
{
   function multiple_selected($table,$table_id)
   {
      //dd($table,$table_id);
      $count_=count($table);
      $selected='';
    for ($i=0; $i < $count_ ; $i++) { 

       if($table[$i]==$table_id){
       $selected= 'selected';
       }

    }
    // dd($selected,$table,$table_id);

    if($selected){echo 'selected';}
    
   }
} 

if(!function_exists('getImagePrincipale'))
{
   function getImagePrincipale($id)
   {
      $article =DB::table('article_image')
                ->select('article_image.article_id','article_image.image_file')
                ->where('article_image.article_id',$id)
                ->where('article_image.image_file','like','%image1%')
                ->first();
     return $article;
    
   }
} 

if(!function_exists('getjourdeconge'))
{
   function getjourdeconge($id,$objet)
   {
        
        $dt = Carbon::now();
        $year=$dt->year;
        //dd($year);
      
    $total = DB::table('demandes')
                ->where('demandeur_id', $id)
                ->where('objet', $objet)
                ->where('state',5)
                ->whereYear('demandes.created_at',$year)
                ->sum('duree');
    return $total;
    
   }
} 

if(!function_exists('getLastId_function'))
{
   function getLastId_function($id)
   {
        
    $last =DB::table('action_bck')
             ->where('action_bck.type_id',$id)
             ->orderBy('id','desc')
             ->first();
     //dd($last->id);
     return $last->id;
    
   }
} 

if(!function_exists('getLastId_function2'))
{
   function getLastId_function2($id)
   {
        
    $last =DB::table('action')
             ->where('action.type_id',$id)
             ->orderBy('id','desc')
             ->first();
     //dd($last->id);
     return $last->id;
    
   }
} 

if(!function_exists('getLastId'))
{
   function getLastId($table)
   {
        
    $last =DB::table($table)
             ->orderBy('id','desc')
             ->first();

     return $last->id;
    
   }
} 

if(!function_exists('getActivitelist'))
{
   function getActivitelist($action_id,$direction_id,$sousdirection_id,$responsable,$state)
    {

        $activites =DB::table('activite')
               ->join('action','activite.action_id','action.id')
               ->select('action.id as actionId','activite.*')
               ->where('activite.action_id',$action_id)
               ->get();

          //dd($activites);  
         return $activites;
  
    }
} 

if(!function_exists('gettachelist'))
{
   function gettachelist($activite_id,$direction_id,$sousdirection_id,$responsable,$state)
    {

        $tache =DB::table('tache')
               ->join('activite','tache.activite_id','activite.id')
               ->select('activite.id as activiteId','tache.*')
               ->where('tache.activite_id',$activite_id)
               ->get();

          //dd($tache);  
         return $tache;
  
    }
} 

if(!function_exists('getActionByActiviteId'))
{
   function getActionByActiviteId($activite_id)
    {

        $activite =DB::table('activite')
               ->select('activite.action_id')
               ->where('activite.id',$activite_id)
               ->first();

        $action =DB::table('action')
               ->where('action.id',$activite->action_id)
               ->first();

          //dd($action);  
         return $action;
  
    }
} 


if(!function_exists('echo_disables'))
{
   function echo_disables($trimestre,$grade,$cible,$resp_id)
    {
        $dt = Carbon::now();
        $date=format_date3(Carbon::parse($dt)->format('Y-m-d'));
        $collette_active=DB::table('periode')
               ->where('periode.state',1)
               ->where('periode.trimestre',$trimestre)
               ->where('periode.grade',$grade)
               ->orderBy('periode.id', 'desc')
               ->first();
               //dd($trimestre,$grade);
    if($collette_active && $cible && $resp_id == Auth::id()){
        $debut=format_date3($collette_active->date_debut);
        $fin=format_date3($collette_active->date_fin);

        if ($debut <= $date && $date <= $fin){ //si date compris ds la periode de collette retourne 'disable'
            echo '';
            }else{
               
                 echo 'disabled';
            }
    }else{
               
                 echo 'disabled';
            }
    
        //si non echo disable
  
    }
} 

if(!function_exists('echo_disables2'))
{
   function echo_disables2($trimestre,$grade,$cible)
    {
        $dt = Carbon::now();
        $date=format_date3(Carbon::parse($dt)->format('Y-m-d'));
        $collette_active=DB::table('periode')
               ->where('periode.state',1)
               ->where('periode.trimestre',$trimestre)
               ->where('periode.grade',$grade)
               ->orderBy('periode.id', 'desc')
               ->first();
               //dd($trimestre,$grade);
    if($collette_active && $cible){
        $debut=format_date3($collette_active->date_debut);
        $fin=format_date3($collette_active->date_fin);

        if ($debut <= $date && $date <= $fin){ //si date compris ds la periode de collette retourne 'disable'
            echo '';
            }else{
               
                 echo 'disabled';
            }
    }else{
               
                 echo 'disabled';
            }
    
        //si non echo disable
  
    }
} 

if(!function_exists('echo_readonly'))
{
   function echo_readonly($trimestre,$grade,$cible,$resp_id)
    {
        $dt = Carbon::now();
        $date=format_date3(Carbon::parse($dt)->format('Y-m-d'));
        $collette_active=DB::table('periode')
               ->where('periode.state',1)
               ->where('periode.trimestre',$trimestre)
               ->where('periode.grade',$grade)
               ->orderBy('periode.id', 'desc')
               ->first();
               //dd($collette_active);
    if($collette_active && $cible && $resp_id == Auth::id() ){
                        $debut=format_date3($collette_active->date_debut);
                        $fin=format_date3($collette_active->date_fin);
                        //dd($trimestre,$grade,$collette_active,$debut,$date,$fin);
                        if ( $debut <= $date && $date <= $fin ){ //si date compris ds la periode de collette retourne 'disable'
                                                                echo '';
                                                              }else{
                                                                     echo 'readonly';
                                                              }
                        }else{
                                echo 'readonly';
                             }
    
        //si non echo disable
  
    }
} 

if(!function_exists('echo_readonly2'))
{
   function echo_readonly2($trimestre,$grade,$cible)
    {
        $dt = Carbon::now();
        $date=format_date3(Carbon::parse($dt)->format('Y-m-d'));
        $collette_active=DB::table('periode')
               ->where('periode.state',1)
               ->where('periode.trimestre',$trimestre)
               ->where('periode.grade',$grade)
               ->orderBy('periode.id', 'desc')
               ->first();
               //dd($collette_active);
    if($collette_active && $cible){
                        $debut=format_date3($collette_active->date_debut);
                        $fin=format_date3($collette_active->date_fin);
                        //dd($trimestre,$grade,$collette_active,$debut,$date,$fin);
                        if ( $debut <= $date && $date <= $fin ){ //si date compris ds la periode de collette retourne 'disable'
                                                                echo '';
                                                              }else{
                                                                     echo 'readonly';
                                                              }
                        }else{
                                echo 'readonly';
                             }
    
        //si non echo disable
  
    }
} 

if(!function_exists('getOtherLivrable'))
{
   function getOtherLivrable($id,$trimestre,$type)
    {
        
        $livrable=DB::table('livrable')
               ->where('instance_id',$id)
               ->where('trimestre',$trimestre)
               ->where('type_id',$type)
               ->where('state','!=',-5)
               ->get();
               //dd($livrable);
    
    return $livrable;
  
    }
}

if(!function_exists('getOtherLivrableHierachie'))
{
   function getOtherLivrableHierachie($id,$trimestre,$type)
    {
        
        $livrable=DB::table('livrable')
               ->where('instance_id',$id)
               ->where('trimestre',$trimestre)
               ->where('type_id',$type)
               ->whereNotIn('state',[-5,0])
               ->get();
               //dd($id,$trimestre,$type,$livrable);
    
    return $livrable;
  
    }
} 

if(!function_exists('getOtherLivrableState'))
{
   function getOtherLivrableState($id,$trimestre,$type,$state)
    {
        
        $livrable=DB::table('livrable')
               ->where('instance_id',$id)
               ->where('trimestre',$trimestre)
               ->where('type_id',$type)
               ->whereIn('state',[0,-1])                  
               ->get();
               //dd($id,$trimestre,$type,$state,$livrable);
               //dd($livrable);
    
    return $livrable;
  
    }
} 

if(!function_exists('getOtherCommentaire'))
{
   function getOtherCommentaire($id,$trimestre,$type)
    {

        //dd($id,$trimestre,$type);
        $livrable=DB::table('commentaire_livrable')
               ->where('instance_id',$id)
               ->where('trimestre',$trimestre)
               ->where('type_id',$type)
               ->get();
               //dd($livrable);
    
    return $livrable;
  
    }
} 


if(!function_exists('get_responsableid'))
{
   function get_responsableid($responsable)
    {
        $user=DB::table('users')
               ->where('nomprenoms',$responsable)
               ->select('id')
               ->first();
               
    return @$user->id;
  
    }
} 

if(!function_exists('ptab_gestion_rigth'))
{
   function ptab_gestion_rigth($user_id)
    {
        $rigth=DB::table('droit_ptab')
               ->where('user_id',$user_id)
               ->where('state',1)
               ->select('id')
               ->first();
        
    if($rigth){return $rigth->id;}else{ return NULL;}
  
    }
} 


if(!function_exists('ptab_gestion_direction'))
{
   function ptab_gestion_direction($user_id)
    {
        $directions = DB::table('droit_ptab_detail')
                  ->join('droit_ptab','droit_ptab.id','droit_ptab_detail.droit_id')
                  ->where('droit_ptab.state',1)
                  ->where('type',1)
                  ->where('droit_ptab.user_id',$user_id )->get();

         return $directions;
  
    }
} 

if(!function_exists('ptab_gestion_agence'))
{
   function ptab_gestion_agence($user_id)
    {
        $agences = DB::table('droit_ptab_detail')
                  ->join('droit_ptab','droit_ptab.id','droit_ptab_detail.droit_id')
                  ->where('droit_ptab.state',1)
                  ->where('type',2)
                  ->where('droit_ptab.user_id',$user_id )->get();

         return $agences;
  
    }
} 

if(!function_exists('get_ptab_helper'))
{
   function get_ptab_helper($user_id)
    {
        $user=DB::table('droit_ptab')
               ->where('user_id',$user_id)
               ->where('state',1)
               ->first();
    
    if($user){return 1;}else{return null;}
    
    }
} 

if(!function_exists('get_total_activite'))
{
   function get_total_activite($action_id,$annee)
    {
        $action=DB::table('action')->where('id',$action_id)->first();

        //dd($action);
        $aid = $action->action_id;
        $action=DB::table('action')->where(['action_id',$aid,'annee',$annee])->count();
    
        return $action;
    
    }
} 

if(!function_exists('get_total_tache'))
{
   function get_total_tache($action_id,$annee)
    {
        $user=DB::table('action')
               ->where('user_id',$actiion_id)
               ->where('state',1)
               ->first();
    
    if($user){return 1;}else{return null;}
    
    }
} 

if(!function_exists('permit_search_name'))
{
   function permit_search_name($isptabadmin,$level)
    {
        if($isptabadmin || $level == 2 || $level == 3 || $level == 5){
            return 1;
        }else{
            return null;
        }
    
    }
} 

if(!function_exists('permit_search_direction'))
{
   function permit_search_direction($isptabadmin,$level)
    {
        if($isptabadmin){
            return 1;
        }else{
            return null;
        }
    
    }
} 

if(!function_exists('permit_search_sdirection'))
{
   function permit_search_sdirection($isptabadmin,$level)
    {
        if($isptabadmin || $level == 5){
            return 1;
        }else{
            return null;
        }
    
    }
}

if(!function_exists('permit_search_service'))
{
   function permit_search_service($isptabadmin,$level)
    {
        if($isptabadmin || $level >=3){
            return 1;
        }else{
            return null;
        }
    
    }
}

if(!function_exists('is_activve'))
{
   function is_activve($id)
    {
        $btn=DB::table('parametre_bouton')
               ->where('id',$id)
               ->first();
       $bouton = $btn->state;
    
    if($bouton){return 1;}else{return null;}
    
    }
}

if(!function_exists('show_confirme'))
{
   function show_confirme($instance,$user)
    {
        $conf=DB::table('archive_action')
               ->where('instance_id',$instance)
               ->first();
        $userId = @$conf->user_id;

       if($conf && $userId != $user){return 1;}else{return null;}
    
    }
}  

if(!function_exists('get_isagence'))
{
   function get_isagence($level,$sousdirection)
    {
    //dd($level,$sousdirection);

        $sd=DB::table('sousdirection')
               ->where('id',$sousdirection)
               ->first();
        $state = @$sd->state;

        //dd($level,$sousdirection,$state,$level==3 && $state);

       if($level==3 && $state){return 1;}else{return null;}
    
    }
} 

if(!function_exists('getnamebyparam'))
{
   function getnamebyparam($direction_id,$sousdirection_id,$service,$nom)
    {
//dd($level,$sousdirection);

        $agent=DB::table('users')
              ->join('agent_fonction','users.id','agent_fonction.user_id')
              
              ->when($direction_id, function ($query, $direction_id)
                                    {return $query->where('agent_fonction.direction_id',$direction_id);}
                                        )
              ->when($sousdirection_id, function ($query, $sousdirection_id)
                                    {return $query->where('agent_fonction.sousdirection_id',$sousdirection_id);}
                                        )
              ->when($service, function ($query, $service)
                                    {return $query->where('agent_fonction.service_id',$service);}
                                        )
              ->when($nom, function ($query, $nom)
                                    {return $query->where('users.nomprenoms','like','%'.$nom.'%');}
                                        )
               ->first();
        

       return $agent;
    
    }
} 


 
  



