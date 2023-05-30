<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DB;
use App\Services\uploadFile;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Agent_fonction;
use Illuminate\Support\Facades\Redirect;
use App\Models\Demande;
use App\Models\Demande_details;
use App\Models\Stock;
use App\Models\Attribution;
use App\Models\Doc_demande;
use App\Models\Doc_demande_details;
use App\Models\Filiation;
use App\Models\Agent_document;
use App\Models\Action;
use App\Models\ActionBck;
use App\Models\Activite;
use App\Models\Tache;
use App\Models\Livrable;
use App\Models\Droit_ptab;
use App\Models\Droit_ptab_detail;
use App\Models\Commentaire_livrable;
use App\Models\Master_action;
use App\Models\Master_activite;
use App\Models\Master_tache;
use App\Models\Extrant;


class PtabRepository
{


      public function getActionlist($extrant_id,$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,$state,$type)
    {
       //dd($direction_id,$sousdirection_id,$service_id,$agent_nom,$year);

        $agent_nom = trim(rtrim($agent_nom)); 
        $actions =DB::table('action')
               ->join('extrant','action.extrant_id','extrant.id')
               ->join('axe_strategique','extrant.axe_id','axe_strategique.id')
               ->select('axe_strategique.id as axeId','axe_strategique.date_debut','axe_strategique.date_fin','axe_strategique.axe','extrant.id as extrantId','extrant.extrant','action.*')
    
               ->when($direction_id, function ($query, $direction_id) 
                                    {return $query->where('action.direction_id', $direction_id);}
                                        )
               ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                    {return $query->where('action.sousdirection_id', $sousdirection_id);}
                                        )
               ->when($service_id, function ($query, $service_id) 
                                    {return $query->where('action.service_id', $service_id);}
                                        )
               ->when($user_id, function ($query, $user_id)
                                    {return $query->where('action.user_id',$user_id);}
                                        )
               ->when($agent_nom, function ($query, $agent_nom)
                                    {return $query->where('action.responsable','like','%'.$agent_nom.'%');}
                                        )
               ->when($year, function ($query, $year)
                                    {return $query->where('action.annee',$year);}
                                        )
               ->when($type, function ($query, $type)
                                    {return $query->where('action.type_id',$type);}
                                        )
                ->where(function($query){
                                  return $query->whereNull('action.state')->orwhere('action.state','!=',-5); 
                              } )
                ->orderBy('action.id','ASC')
               //->get();
               ->paginate(20);

          //dd($actions);  
         return $actions;
  
    }

    public function getActivitelistByActionId($id,$type,$state)
    {
        //dd($id,$type,$state);
        $actions =DB::table('activite')
                ->join('action','action.id','activite.action_id')
                ->join('extrant','action.extrant_id','extrant.id')
                ->join('axe_strategique','extrant.axe_id','axe_strategique.id')
                ->select('axe_strategique.id as axeId','axe_strategique.date_debut','axe_strategique.date_fin','axe_strategique.axe','extrant.id as extrantId','extrant.extrant','activite.*')
                ->where('activite.type_id',$type)
                ->where('activite.action_id',$id)
                ->when($state, function ($query, $state) 
                            {return $query->where('activite.state',$state);}
                                )
                ->where(function($query){
                          return $query->whereNull('activite.state')->orwhere('activite.state','!=',-5); 
                      } )
                ->orderBy('activite.id','ASC')
                ->get();

          //dd($actions);  
         return $actions;
  
    }

    public function getTachelistByActiviteId($id,$type,$state)
    {

        $actions =DB::table('tache')
                ->join('activite','activite.id','tache.activite_id')
                ->join('action','action.id','activite.action_id')
                ->join('extrant','action.extrant_id','extrant.id')
                ->join('axe_strategique','extrant.axe_id','axe_strategique.id')
                ->select('axe_strategique.id as axeId','axe_strategique.date_debut','axe_strategique.date_fin','axe_strategique.axe','extrant.id as extrantId','extrant.extrant','tache.*')
                ->where('tache.type_id',$type)
                ->where('tache.activite_id',$id)
                ->when($state, function ($query, $state) 
                                    {return $query->where('tache.state',$state);}
                                        )
                ->where(function($query){
                                  return $query->whereNull('tache.state')->orwhere('tache.state','!=',-5); 
                              } )
                ->orderBy('tache.id','ASC')
                ->get();

          //dd($actions);  
         return $actions;
  
    }


      public function getGestionActionlist($agence,$agent_nom)
    {
        //dd($agence,$agent_nom);
        $actions =DB::table('action')
               ->join('extrant','action.extrant_id','extrant.id')
               ->join('axe_strategique','extrant.axe_id','axe_strategique.id')
               ->select('axe_strategique.id as axeId','axe_strategique.date_debut','axe_strategique.date_fin','axe_strategique.axe','extrant.id as extrantId','extrant.extrant','action.*')
    
               // ->when($direction, function ($query, $direction) 
               //                      {return $query->whereIn('action.direction_id', $direction);}
               //                          )
               ->when($agence, function ($query, $agence) 
                                    {return $query->OrWhereIn('action.sousdirection_id', $agence);}
                                        )
               ->when($agent_nom, function ($query, $agent_nom)
                                    {return $query->where('action.responsable','like','%'.$agent_nom.'%');}
                                        )
               //->get();
               ->paginate(20);

          //dd($actions);  
         return $actions;
  
    }

    public function getActivitelist($extrant_id,$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,$state,$type)
    {
       //dd($direction_id,$sousdirection_id,$service_id,$agent_nom,$year);

        $agent_nom = trim(rtrim($agent_nom)); 
        $actions =DB::table('activite')
               ->join('action','action.id','activite.action_id')
               ->join('extrant','action.extrant_id','extrant.id')
               ->join('axe_strategique','extrant.axe_id','axe_strategique.id')
               ->select('axe_strategique.id as axeId','axe_strategique.date_debut','axe_strategique.date_fin','axe_strategique.axe','extrant.id as extrantId','extrant.extrant','activite.*')
    
               ->when($direction_id, function ($query, $direction_id) 
                                    {return $query->where('activite.direction_id', $direction_id);}
                                        )
               ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                    {return $query->where('activite.sousdirection_id', $sousdirection_id);}
                                        )
               ->when($service_id, function ($query, $service_id) 
                                    {return $query->where('activite.service_id', $service_id);}
                                        )
               ->when($user_id, function ($query, $user_id)
                                    {return $query->where('activite.user_id',$user_id);}
                                        )
               ->when($agent_nom, function ($query, $agent_nom)
                                    {return $query->where('activite.responsable','like','%'.$agent_nom.'%');}
                                        )
               ->when($year, function ($query, $year)
                                    {return $query->where('activite.annee',$year);}
                                        )
               ->when($type, function ($query, $type)
                                    {return $query->where('activite.type_id',$type);}
                                        )
                ->where(function($query){
                                  return $query->whereNull('activite.state')->orwhere('activite.state','!=',-5); 
                              } )
                ->orderBy('activite.id','ASC')
               //->get();
               ->paginate(20);

          //dd($actions);  
         return $actions;
  
    }

    public function getTachelist($extrant_id,$direction_id,$sousdirection_id,$service_id,$agent_nom,$user_id,$year,$state,$type)
    {
       //dd($user_id,$direction_id,$sousdirection_id,$service_id,$agent_nom,$year);

        $agent_nom = trim(rtrim($agent_nom)); 
        $actions =DB::table('tache')
               ->join('activite','activite.id','tache.activite_id')
               ->join('action','action.id','activite.action_id')
               ->join('extrant','action.extrant_id','extrant.id')
               ->join('axe_strategique','extrant.axe_id','axe_strategique.id')
               ->select('axe_strategique.id as axeId','axe_strategique.date_debut','axe_strategique.date_fin','axe_strategique.axe','extrant.id as extrantId','extrant.extrant','tache.*')
    
               ->when($direction_id, function ($query, $direction_id) 
                                    {return $query->where('tache.direction_id', $direction_id);}
                                        )
               ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                    {return $query->where('tache.sousdirection_id', $sousdirection_id);}
                                        )
               ->when($service_id, function ($query, $service_id) 
                                    {return $query->where('tache.service_id', $service_id);}
                                        )
               ->when($user_id, function ($query, $user_id)
                                    {return $query->where('tache.user_id',$user_id);}
                                        )
               ->when($agent_nom, function ($query, $agent_nom)
                                    {return $query->where('tache.responsable','like','%'.$agent_nom.'%');}
                                        )
               ->when($year, function ($query, $year)
                                    {return $query->where('tache.annee',$year);}
                                        )
               ->when($type, function ($query, $type)
                                    {return $query->where('tache.type_id',$type);}
                                        )
                ->where(function($query){
                                  return $query->whereNull('tache.state')->orwhere('tache.state','!=',-5); 
                              } )
                ->orderBy('tache.id','ASC')
               //->get();
               ->paginate(20);

          //dd($actions);  
         return $actions;



         
  
    }


     public function copyAction_bck()
    {

        $actions= ActionBck::all();
        foreach ($actions as $act) {

            if($act->type_id==3){
                $action_id=getLastId_function2(1);
                $activite_id=getLastId_function2(2);

                $action = new Action();

                $action->direction_id = $act->direction_id;
                $action->sousdirection_id = $act->sousdirection_id;
                $action->service_id = $act->service_id;
                $action->extrant_id = $act->extrant_id;
                $action->type_id = $act->type_id;
                $action->action_id = $action_id;
                $action->activite_id = $activite_id;
                $action->intitule = $act->intitule;
                $action->reference_matrice = $act->reference_matrice;
                $action->indicateur = $act->indicateur;
                $action->responsable =$act->responsable;
                $action->cible_glo = $act->cible_glo;
                $action->cout_glo =  $act->cout_glo;
                $action->cible_t1 =  $act->cible_t1;
                $action->cout_t1 = $act->cout_t1;
                $action->cible_t2 = $act->cible_t2;
                $action->cout_t2 = $act->cout_t2;
                $action->cible_t3 = $act->cible_t3;
                $action->cout_t3 =  $act->cout_t3;
                $action->cible_t4 =  $act->cible_t4;
                $action->cout_t4 = $act->cout_t4;
                $action->entite_prenante = $act->entite_prenante;
                $action->action_entite = $act->action_entite;
                $action->periode_execution = $act->periode_execution;
                $action->zone_exection = $act->zone_exection ;
                
                $action->save();

                // DB::insert('INSERT INTO action (direction_id,sousdirection_id,service_id,extrant_id,type_id,action_id,activite_id,intitule,reference_matrice,indicateur,responsable,cible_glo,cout_glo,cible_t1,cout_t1,cible_t2,cout_t2,cible_t3,cout_t3,cible_t4,cout_t4,entite_prenante,action_entite,periode_execution,zone_exection) 
                //      SELECT direction_id,sousdirection_id,service_id,extrant_id,type_id,'.$action_id.','.$activite_id.',intitule,reference_matrice,indicateur,responsable,cible_glo,cout_glo,cible_t1,cout_t1,cible_t2,cout_t2,cible_t3,cout_t3,cible_t4,cout_t4,entite_prenante,action_entite,periode_execution,zone_exection 
                //      FROM action_bck
                //      Where action_bck.id='.$action);
            }
            elseif($act->type_id==2){
                $action_id=getLastId_function2(1);

                $action = new Action();

                $action->direction_id = $act->direction_id;
                $action->sousdirection_id = $act->sousdirection_id;
                $action->service_id = $act->service_id;
                $action->extrant_id = $act->extrant_id;
                $action->type_id = $act->type_id;
                $action->action_id = $action_id;
                $action->activite_id = $act->activite_id;
                $action->intitule = $act->intitule;
                $action->reference_matrice = $act->reference_matrice;
                $action->indicateur = $act->indicateur;
                $action->responsable =$act->responsable;
                $action->cible_glo = $act->cible_glo;
                $action->cout_glo =  $act->cout_glo;
                $action->cible_t1 =  $act->cible_t1;
                $action->cout_t1 = $act->cout_t1;
                $action->cible_t2 = $act->cible_t2;
                $action->cout_t2 = $act->cout_t2;
                $action->cible_t3 = $act->cible_t3;
                $action->cout_t3 =  $act->cout_t3;
                $action->cible_t4 =  $act->cible_t4;
                $action->cout_t4 = $act->cout_t4;
                $action->entite_prenante = $act->entite_prenante;
                $action->action_entite = $act->action_entite;
                $action->periode_execution = $act->periode_execution;
                $action->zone_exection = $act->zone_exection ;
                
                $action->save();
            }
            else{

                $action = new Action();

                $action->direction_id = $act->direction_id;
                $action->sousdirection_id = $act->sousdirection_id;
                $action->service_id = $act->service_id;
                $action->extrant_id = $act->extrant_id;
                $action->type_id = $act->type_id;
                $action->action_id = $act->action_id;
                $action->activite_id = $act->activite_id;
                $action->intitule = $act->intitule;
                $action->reference_matrice = $act->reference_matrice;
                $action->indicateur = $act->indicateur;
                $action->responsable =$act->responsable;
                $action->cible_glo = $act->cible_glo;
                $action->cout_glo =  $act->cout_glo;
                $action->cible_t1 =  $act->cible_t1;
                $action->cout_t1 = $act->cout_t1;
                $action->cible_t2 = $act->cible_t2;
                $action->cout_t2 = $act->cout_t2;
                $action->cible_t3 = $act->cible_t3;
                $action->cout_t3 =  $act->cout_t3;
                $action->cible_t4 =  $act->cible_t4;
                $action->cout_t4 = $act->cout_t4;
                $action->entite_prenante = $act->entite_prenante;
                $action->action_entite = $act->action_entite;
                $action->periode_execution = $act->periode_execution;
                $action->zone_exection = $act->zone_exection ;
                
                $action->save();
            }
            
            
        }

     
          
    }

     public function action_delete($table,$champ,$value)
    {

     $deleted = DB::table($table)->where($champ, $value)->delete();
          
    }


     public function getActionDetails($value)
    {

     $detail =DB::table('action')
                ->leftjoin('extrant','action.extrant_id','extrant.id')
                ->leftjoin('axe_strategique','extrant.axe_id','axe_strategique.id')
                ->select('action.id','action.type_id','action.action_id','action.extrant_id','action.direction_id','action.sousdirection_id','action.service_id','action.activite_id','action.reference_matrice','action.intitule','action.indicateur','action.responsable','action.cible_glo','action.cout_glo','action.cible_t1','action.cout_t1','action.cible_t2','action.cout_t2','cible_t3','action.cout_t3','action.cible_t4','action.cout_t4','action.entite_prenante','action.action_entite','action.periode_execution','action.zone_exection','extrant.id as extrantId','axe_strategique.id as axeId','action.valeur_t1','action.livrable_t1','action.is_valide1','action.commentaire_t1','action.statut_t1','action.valeur_t2','action.livrable_t2','action.is_valide2','action.commentaire_t2','action.statut_t2','action.valeur_t3','action.livrable_t3','action.is_valide3','action.commentaire_t3','action.statut_t3','action.valeur_t4','action.livrable_t4','action.is_valide4','action.commentaire_t4','action.statut_t4','action.valeur_final','action.livrable_final','action.is_valideF','action.commentaire_final','action.statut_final','action.observation_t1','action.observation_t2','action.observation_t3','action.observation_t4','action.observation_final','action.statut_livrable_t1','action.statut_livrable_t2','action.statut_livrable_t3','action.statut_livrable_t4','action.statut_livrable_final','action.tache_id','action.user_id')
                 ->where('action.id', $value)
                 ->first();
                //dd($detail);
     return $detail;
          
    }

    public function getActiviteDetails($value)
    {

     $detail =DB::table('activite')
                 ->leftjoin('action','action.id','activite.action_id')
                ->leftjoin('extrant','action.extrant_id','extrant.id')
                ->leftjoin('axe_strategique','extrant.axe_id','axe_strategique.id')
                ->select('activite.id','activite.type_id','activite.action_id','activite.extrant_id','activite.direction_id','activite.sousdirection_id','activite.service_id','activite.activite_id','activite.reference_matrice','activite.intitule','activite.indicateur','activite.responsable','activite.cible_glo','activite.cout_glo','activite.cible_t1','activite.cout_t1','activite.cible_t2','activite.cout_t2','activite.cible_t3','activite.cout_t3','activite.cible_t4','activite.cout_t4','activite.entite_prenante','activite.action_entite','activite.periode_execution','activite.zone_exection','extrant.id as extrantId','axe_strategique.id as axeId','activite.valeur_t1','activite.livrable_t1','activite.is_valide1','activite.commentaire_t1','activite.statut_t1','activite.valeur_t2','activite.livrable_t2','activite.is_valide2','activite.commentaire_t2','activite.statut_t2','activite.valeur_t3','activite.livrable_t3','activite.is_valide3','activite.commentaire_t3','activite.statut_t3','activite.valeur_t4','activite.livrable_t4','activite.is_valide4','activite.commentaire_t4','activite.statut_t4','activite.valeur_final','activite.livrable_final','activite.is_valideF','activite.commentaire_final','activite.statut_final','activite.observation_t1','activite.observation_t2','activite.observation_t3','activite.observation_t4','activite.observation_final','activite.statut_livrable_t1','activite.statut_livrable_t2','activite.statut_livrable_t3','activite.statut_livrable_t4','activite.statut_livrable_final','activite.tache_id','activite.user_id')
                 ->where('activite.id', $value)
                 ->first();
                //dd($detail);
     return $detail;
          
    }

    public function getTacheDetails($value)
    {

     $detail =DB::table('tache')
                ->leftjoin('activite','activite.id','tache.activite_id')
                ->leftjoin('action','action.id','activite.action_id')
                ->leftjoin('extrant','action.extrant_id','extrant.id')
                ->leftjoin('axe_strategique','extrant.axe_id','axe_strategique.id')
                ->select('tache.id','tache.type_id','tache.action_id','tache.extrant_id','tache.direction_id','tache.sousdirection_id','tache.service_id','tache.activite_id','tache.reference_matrice','tache.intitule','tache.indicateur','tache.responsable','tache.cible_glo','tache.cout_glo','tache.cible_t1','tache.cout_t1','tache.cible_t2','tache.cout_t2','tache.cible_t3','tache.cout_t3','tache.cible_t4','tache.cout_t4','tache.entite_prenante','tache.action_entite','tache.periode_execution','tache.zone_exection','extrant.id as extrantId','axe_strategique.id as axeId','tache.valeur_t1','tache.livrable_t1','tache.is_valide1','tache.commentaire_t1','tache.statut_t1','tache.valeur_t2','tache.livrable_t2','tache.is_valide2','tache.commentaire_t2','tache.statut_t2','tache.valeur_t3','tache.livrable_t3','tache.is_valide3','tache.commentaire_t3','tache.statut_t3','tache.valeur_t4','tache.livrable_t4','tache.is_valide4','tache.commentaire_t4','tache.statut_t4','tache.valeur_final','tache.livrable_final','tache.is_valideF','tache.commentaire_final','tache.statut_final','tache.observation_t1','tache.observation_t2','tache.observation_t3','tache.observation_t4','tache.observation_final','tache.statut_livrable_t1','tache.statut_livrable_t2','tache.statut_livrable_t3','tache.statut_livrable_t4','tache.statut_livrable_final','tache.tache_id','tache.user_id')
                 ->where('tache.id', $value)
                 ->first();
                //dd($detail);
     return $detail;
          
    }



    public function getPtabDetailsByType($id,$instance)
    {

     $detail =DB::table('action')
                 ->where('id', $id)
                ->first();
     return $detail;
          
    }


    public function addaction($request,$instance_id)
    {
      //dd($request);
        $action_id = null;
        $activite_id = null;
        $tache_id = null;

        


       $action = new Action();

            $action->type_id = $request->get('type');
            $action->action_id = $action_id;
            $action->activite_id = $activite_id;
            $action->extrant_id = $request->get('extrant');
            $action->direction_id = $request->get('direction');
            $action->sousdirection_id = $request->get('sousdirection');
            $action->service_id = $request->get('service');
            $action->reference_matrice = $instance_id;
            $action->indicateur = $request->get('indicateur');
            $action->intitule = $request->get('intitule');
            $action->responsable =$request->get('responsable');
            $action->cible_glo = $request->get('cible_globale');
            $action->cout_glo =  $request->get('cout_global');
            $action->cible_t1 =  $request->get('cible_t1');
            $action->cout_t1 = $request->get('cout_t1');
            $action->cible_t2 = $request->get('cible_t2');
            $action->cout_t2 = $request->get('cout_t2');
            $action->cible_t3 = $request->get('cible_t3');
            $action->cout_t3 =  $request->get('cout_t3');
            $action->cible_t4 =  $request->get('cible_t4');
            $action->cout_t4 = $request->get('cout_t4');
            $action->entite_prenante = $request->get('entite_prenante');
            $action->action_entite = $request->get('entite_action');
            $action->periode_execution = $request->get('periode_execution');
            $action->zone_exection = $request->get('zone_execution') ;
            $action->annee = '2023' ;
            $action->user_id = $request->get('responsable_id') ;
            $action->matricule = $request->get('matricule') ;
            
            $action->save();
     
          
    }

     public function addactivite($request,$instance_id)
    {
      //dd($request,$instance_id);
        $action_id = null;
        $activite_id = null;
        $tache_id = null;


       $action = new Activite();

            
            $action->type_id = $request->get('type');
            $action->action_id = $request->get('action_id');;
            $action->activite_id = $activite_id;
            $action->extrant_id = $request->get('extrant');
            $action->direction_id = $request->get('direction');
            $action->sousdirection_id = $request->get('sousdirection');
            $action->service_id = $request->get('service');
            $action->reference_matrice = $instance_id;
            $action->indicateur = $request->get('indicateur');
            $action->intitule = $request->get('intitule');
            $action->responsable =$request->get('responsable');
            $action->cible_glo = $request->get('cible_globale');
            $action->cout_glo =  $request->get('cout_global');
            $action->cible_t1 =  $request->get('cible_t1');
            $action->cout_t1 = $request->get('cout_t1');
            $action->cible_t2 = $request->get('cible_t2');
            $action->cout_t2 = $request->get('cout_t2');
            $action->cible_t3 = $request->get('cible_t3');
            $action->cout_t3 =  $request->get('cout_t3');
            $action->cible_t4 =  $request->get('cible_t4');
            $action->cout_t4 = $request->get('cout_t4');
            $action->entite_prenante = $request->get('entite_prenante');
            $action->action_entite = $request->get('entite_action');
            $action->periode_execution = $request->get('periode_execution');
            $action->zone_exection = $request->get('zone_execution') ;
            $action->annee = '2023' ;
            $action->user_id = $request->get('responsable_id') ;
            $action->matricule = $request->get('matricule') ;
            
            $action->save();
     
          
    }

     public function addtache($request,$instance_id)
    {
      //dd($request);
        $action_id = null;
        $activite_id = null;
        $tache_id = null;


       $action = new Tache();

            
            $action->type_id = $request->get('type');
            $action->action_id = $request->get('action_id');
            $action->activite_id = $request->get('activite_id');
            $action->extrant_id = $request->get('extrant');
            $action->direction_id = $request->get('direction');
            $action->sousdirection_id = $request->get('sousdirection');
            $action->service_id = $request->get('service');
            $action->reference_matrice = $instance_id;
            $action->indicateur = $request->get('indicateur');
            $action->intitule = $request->get('intitule');
            $action->responsable =$request->get('responsable');
            $action->cible_glo = $request->get('cible_globale');
            $action->cout_glo =  $request->get('cout_global');
            $action->cible_t1 =  $request->get('cible_t1');
            $action->cout_t1 = $request->get('cout_t1');
            $action->cible_t2 = $request->get('cible_t2');
            $action->cout_t2 = $request->get('cout_t2');
            $action->cible_t3 = $request->get('cible_t3');
            $action->cout_t3 =  $request->get('cout_t3');
            $action->cible_t4 =  $request->get('cible_t4');
            $action->cout_t4 = $request->get('cout_t4');
            $action->entite_prenante = $request->get('entite_prenante');
            $action->action_entite = $request->get('entite_action');
            $action->periode_execution = $request->get('periode_execution');
            $action->zone_exection = $request->get('zone_execution') ;
            $action->annee = '2023' ;
            $action->user_id = $request->get('responsable_id') ;
            $action->matricule = $request->get('matricule') ;
            
            $action->save();
     
          
    }


     public function addMasterAction($request)
    {
      
        $extrant_id = $request->get('extrant');
        $nbaction = Master_action::where('extrant_id',$extrant_id)->count();
        $unite_action = $nbaction + 1;
        $ref_extrant = Extrant::where('id',$extrant_id)->select('ref')->first();
        $ref = $ref_extrant->ref.'.'.$unite_action;
       
        
            $action = new Master_action();
            // direction_id
            // is_agence
            // ref_extrant
            $action->extrant_id = $request->get('extrant');
            $action->ref = $ref;
            $action->intitule_action = $request->get('intitule');
            $action->Intitule_indicateur = $request->get('indicateur');
            $action->valeur_indicateur = '';
            $action->state = null;
            $action->save();

            return $action->id;
     
          
    }

    public function addMasterActivite($request)
    {
      
        $extrant_id = $request->get('extrant');
        $type_action = $request->get('type_action');
        $ref_action =  Master_action::where('id',$type_action)->select('ref')->first();
        $nbaction = Master_activite::where('master_action_id',$type_action)->count();
        $unite_action = $nbaction + 1;
        //dd($unite_action,);
        $ref = $ref_action->ref.'.'.$unite_action;

        //dd($type_action,$nbaction,$ref_action,$ref);

            $activite = new Master_activite();

            $activite->master_action_id = $request->get('type_action');
            $activite->ref = $ref;
            $activite->intitule_activite = $request->get('intitule');
            $activite->Intitule_indicateur = $request->get('indicateur');
            $activite->valeur_indicateur = '';
            $activite->state = null;
            $activite->save();
            
            return $activite->id;
          
    }

    public function addMasterTache($request)
    {
      //dd($request);
        $type_activite = $request->get('type_activite');
        $nbaction = Master_tache::where('master_activite_id',$type_activite)->count();
        $unite_action = $nbaction + 1;
        $ref_activite =  Master_activite::where('id',$type_activite)->select('ref')->first();
        $ref = $ref_activite->ref.'.'.$unite_action;

        
            $tache = new Master_tache();

            $tache->master_activite_id = $request->get('type_activite');
            $tache->ref = $ref;
            $tache->intitule_tache = $request->get('intitule');
            $tache->Intitule_indicateur = $request->get('indicateur');
            $tache->state = null;
            $tache->save();

            return $tache->id;
     
          
    }

    public function modifierptab($request,$uploadFile)
    {

      //dd($request,$uploadFile);
        $table = 'action';//$request->get('tid'); 
        $aid =$request->get('aid');

      if($request->file('livrable_t1')){
                  foreach($request->file('livrable_t1') as $file1){
                    $livrable_t1 = $uploadFile->uploadMultiple($file1,'livrable_t1');
                    $this->createLivrable($aid,1,$livrable_t1);
                  }
                  $affected = DB::table($table)->where('id', $aid)->update(['livrable_t1' => $livrable_t1,'is_valide1' => 3]);
                                       }

      if($request->file('livrable_t2')){
                    foreach($request->file('livrable_t2') as $file2){
                    $livrable_t2 = $uploadFile->uploadMultiple($file2,'livrable_t2');
                    $this->createLivrable($aid,2,$livrable_t2);
                  }
                   $affected = DB::table($table)->where('id', $aid)->update(['livrable_t2' => $livrable_t2,'is_valide2' => 3]);
                              }

     if($request->file('livrable_t3')){
                    foreach($request->file('livrable_t3') as $file3){
                    $livrable_t3 = $uploadFile->uploadMultiple($file3,'livrable_t3');
                    $this->createLivrable($aid,3,$livrable_t3);
                  }
                   $affected = DB::table($table)->where('id', $aid)->update(['livrable_t3' => $livrable_t3,'is_valide3' => 3]);
                              }

    if($request->file('livrable_t4')){
               foreach($request->file('livrable_t4') as $file4){
                    $livrable_t4 = $uploadFile->uploadMultiple($file4,'livrable_t4');
                    $this->createLivrable($aid,4,$livrable_t4);
                  }
               $affected = DB::table($table)->where('id', $aid)->update(['livrable_t4' => $livrable_t4,'is_valide4' => 3]);
                              }

    if($request->file('livrable_final')){
                foreach($request->file('livrable_final') as $file5){
                    $livrable_final = $uploadFile->uploadMultiple($file5,'livrable_final');
                    $this->createLivrable($aid,5,$livrable_final);
                  }
               $livrable_final = $uploadFile->upload($request,'livrable_final');
               $affected = DB::table($table)->where('id', $aid)->update(['livrable_final' => $livrable_final,'is_valideF' => 3]);
                              }
       $responsable = trim(rtrim($request->get('responsable')));
     
      $affected = DB::table($table)
              ->where('id', $aid)
              ->update([
                        'intitule' => $request->get('intitule'),
                        //'responsable' => $request->get('responsable'),
                        'cible_glo' => $request->get('cible_globale'),
                        'cout_glo' => $request->get('cout_global'),
                        'cible_t1' => $request->get('cible_t1'),
                        'cout_t1' => $request->get('cout_t1'),
                        'valeur_t1' => $request->get('valeur_t1'),

                        'statut_t1' => $request->get('statut_t1'),
                        'commentaire_t1' => $request->get('commentaire_t1'),
                        'cible_t2' => $request->get('cible_t2'),
                        'cout_t2' => $request->get('cout_t2'),
                        'valeur_t2' => $request->get('valeur_t2'),

                        'statut_t2' => $request->get('statut_t2'),
                        'commentaire_t2' => $request->get('commentaire_t2'),
                        'cible_t3' => $request->get('cible_t3'),
                        'cout_t3' => $request->get('cout_t3'),
                        'valeur_t3' => $request->get('valeur_t3'),
                        
                        'statut_t3' => $request->get('statut_t3'),
                        'commentaire_t3' => $request->get('commentaire_t3'),
                        'cible_t4' => $request->get('cible_t4'),
                        'cout_t4' => $request->get('cout_t4'),
                        'valeur_t4' => $request->get('valeur_t4'),
                        
                        'statut_t4' => $request->get('statut_t4'),
                        'commentaire_t4' => $request->get('commentaire_t4'),
                        'valeur_final' => $request->get('valeur_final'),
                        
                        'statut_final' => $request->get('statut_final'),
                        'commentaire_final' => $request->get('commentaire_final'),
                        'entite_prenante' => $request->get('entite_prenante'),
                        'action_entite' => $request->get('entite_action'),
                        'periode_execution' => $request->get('periode_execution'),
                        'zone_exection' => $request->get('zone_execution'),
                        'statut_t4' => $request->get('statut_t4'),
                        'commentaire_t4' => $request->get('commentaire_t4'),
                        'valeur_final' => $request->get('valeur_final'),
                        
                        'statut_final' => $request->get('statut_final'),
                        'commentaire_final' => $request->get('commentaire_final'),
                        'entite_prenante' => $request->get('entite_prenante'),
                        'action_entite' => $request->get('entite_action'),
                        'periode_execution' => $request->get('periode_execution'),
                        'zone_exection' => $request->get('zone_execution'),
                        'observation_t1' => $request->get('observation_t1'),
                        'observation_t2' => $request->get('observation_t2'),
                        'observation_t3' => $request->get('observation_t3'),
                        'observation_t4' => $request->get('observation_t4'),
                        'observation_final' => $request->get('observation_final'),
                        'statut_livrable_t1' => $request->get('statut_livrable_t1'),
                        'statut_livrable_t2' => $request->get('statut_livrable_t2'),
                        'statut_livrable_t3' => $request->get('statut_livrable_t3'),
                        'statut_livrable_t4' => $request->get('statut_livrable_t4'),
                        'statut_livrable_final' => $request->get('statut_livrable_final')
                       ]);


          
    }


    public function modifierptabTrimestre($request,$uploadFile)
    {

        $table = $request->get('t_id');;
        $aid =$request->get('instance_id');
        $trimestre =$request->get('trimestre');
        if($table=='tache'){$type_id=3;}elseif($table=='activite'){$type_id=2;}else{$type_id=1;}

        
        //dd($request,$uploadFile);


      if($request->file('livrable_t1')){
        $file1 =$request->file('livrable_t1');
        $commentaire =$request->get('commentaire_lt1');
        $val = count($file1);
            for ($i=0; $i<$val; $i++){
                $livrable_t1 = $uploadFile->uploadMultiple($file1[$i],'livrable_t1');
                //dd($livrable_t1,$commentaire[$i]);
                $this->createLivrable($aid,1,$livrable_t1,$commentaire[$i],$type_id);

            }

    $affected = DB::table($table)->where('id', $aid)->update(['is_valide1' => 3]);
                                       }

      if($request->file('livrable_t2')){
        $file2 =$request->file('livrable_t2');
        $commentaire =$request->get('commentaire_lt2');
        $val = count($file2);
            for ($i=0; $i<$val; $i++){
                $livrable_t2 = $uploadFile->uploadMultiple($file2[$i],'livrable_t2');
                //dd($livrable_t1,$commentaire[$i]);
                $this->createLivrable($aid,2,$livrable_t2,$commentaire[$i],$type_id);

            }

    $affected = DB::table($table)->where('id', $aid)->update(['is_valide2' => 3]);
                              }

     if($request->file('livrable_t3')){
        $file3 =$request->file('livrable_t3');
        $commentaire =$request->get('commentaire_lt3');
        $val = count($file3);
            for ($i=0; $i<$val; $i++){
                $livrable_t3 = $uploadFile->uploadMultiple($file3[$i],'livrable_t3');
                //dd($livrable_t1,$commentaire[$i]);
                $this->createLivrable($aid,3,$livrable_t3,$commentaire[$i],$type_id);

            }

    $affected = DB::table($table)->where('id', $aid)->update(['is_valide3' => 3]);
                              }

    if($request->file('livrable_t4')){
        $file4 =$request->file('livrable_t4');
        $commentaire =$request->get('commentaire_lt4');
        $val = count($file4);
            for ($i=0; $i<$val; $i++){
                $livrable_t4 = $uploadFile->uploadMultiple($file4[$i],'livrable_t4');
                //dd($livrable_t1,$commentaire[$i]);
                $this->createLivrable($aid,4,$livrable_t4,$commentaire[$i],$type_id);

            }

    $affected = DB::table($table)->where('id', $aid)->update(['is_valide4' => 3]);
                              }

    
if($trimestre==1){
    $affected = DB::table($table)
              ->where('id', $aid)
              ->update(['cible_t1' => $request->get('cible_t1'),'cout_t1' => $request->get('cout_t1'),'valeur_t1' => $request->get('valeur_t1'),]);
}
if($trimestre==2){
    $affected = DB::table($table)
              ->where('id', $aid)
              ->update(['cible_t2' => $request->get('cible_t2'),'cout_t2' => $request->get('cout_t2'),'valeur_t2' => $request->get('valeur_t2'),]);
}
if($trimestre==3){
    $affected = DB::table($table)
              ->where('id', $aid)
              ->update(['cible_t3' => $request->get('cible_t3'),'cout_t3' => $request->get('cout_t3'),'valeur_t3' => $request->get('valeur_t3'),]);
}
if($trimestre==4){
    $affected = DB::table($table)
              ->where('id', $aid)
              ->update(['cible_t4' => $request->get('cible_t4'),'cout_t4' => $request->get('cout_t4'),'valeur_t4' => $request->get('valeur_t4'),]);
}
      

   
    }

    public function modifierptabDetail($request)
    {
        $action_add= null;
        $activite_add= null;
        $tache_add= null;

        if($request->get('tid')=='action'){

            if($request->get('master_action_id')=='new'){
                 $reference_matrice = $this->addMasterAction($request);
            }else{
                 $reference_matrice= $request->get('master_action_id');
             }

        }

        if($request->get('tid')=='activite'){
            //dd($request);
            if($request->get('master_activite_id')=='new'){
            $reference_matrice = $this->addMasterActivite($request); 
            $action_add = $request->get('action');
        
                }else{
                    $reference_matrice = $request->get('master_activite_id');
                    $action_add = $request->get('action');
                }

        }
        
        if($request->get('tid')=='tache'){

            if($request->get('master_tache_id')=='new'){
            $reference_matrice = $this->addMasterTache($request); 
            $action_add = $request->get('action');
            $activite_add = $request->get('activite');
            }else{
                $activite_add = $request->get('activite');
                $action_add = $request->get('action');
                $reference_matrice = $request->get('master_tache_id');
            }

        }

        $up_table = $request->get('tid');

        //dd($request,$action_add);

        $affected = DB::table($up_table)
              ->where('id', $request->get('action_id'))
              ->update([
                        'extrant_id' => $request->get('extrant'),
                        'action_id' => $action_add,
                        'activite_id' => $activite_add,
                        'tache_id' => $tache_add,
                        'reference_matrice' => $reference_matrice,
                        'intitule' => $request->get('intitule'),
                        'indicateur' => $request->get('indicateur'),
                        'cible_glo' => $request->get('cible_globale'),
                        'cout_glo' => $request->get('cout_global'),
                        'cible_t1' => $request->get('cible_t1'),
                        'cout_t1' => $request->get('cout_t1'),
                        'cible_t2' => $request->get('cible_t2'),
                        'cout_t2' => $request->get('cout_t2'),
                        'cible_t3' => $request->get('cible_t3'),
                        'cout_t3' => $request->get('cout_t3'),
                        'cible_t4' => $request->get('cible_t4'),
                        'cout_t4' => $request->get('cout_t4'),
                        'entite_prenante' => $request->get('entite_prenante'),
                        'action_entite' => $request->get('action_entite'),
                        'periode_execution' => $request->get('periode_execution'),
                        'zone_exection' => $request->get('zone_exection'),
                        'user_id' => $request->get('user_id'),
                        'responsable' => $request->get('responsable'),
                       ]);

    }


    public function modifierptabCommentaire($request)
    {

        $table = $request->get('tid');
        if($table=='tache'){$type_id=3;}elseif($table=='activite'){$type_id=2;}else{$type_id=1;}
        $aid =$request->get('instance_id');
        $trimestre =$request->get('trimestre');
        $commentaire_final =$request->get('commentaire_final');
        $statut_final =$request->get('statut_final');
        $statut_avancement =$request->get('statut_avancement');
        
        //dd($request)
            
            

if($trimestre==1){

        $observation_t1 =$request->get('observation_t1');
        $statut_t1 =$request->get('statut_t1');
        $livrables = getOtherLivrable($aid,$trimestre,$type_id);

    if($statut_t1){
        //dd($request,$livrables);
        $this->createLivrableComment($aid,1,$statut_t1,$request->get('observation_t1'),$type_id,$statut_avancement);
        $affected = DB::table($table)->where('id', $aid)->update(['is_valide1' => $statut_t1,'statut_t1'=> $statut_avancement,'state'=>$statut_avancement]);
        foreach($livrables as $livrable){
            $affected = DB::table('livrable')->where(['id'=>$livrable->id])->update(['state' => $statut_t1]);
            }
    }
    
    if($request->get('statut_final')){
    $affected = DB::table($table)->where('id', $aid)->update(['commentaire_t1' => $commentaire_final,'statut_t1' => $statut_final]);
    }
}

if($trimestre==2){

    $observation_t2 =$request->get('observation_t2');
    $statut_t2 =$request->get('statut_t2');
    $livrables = getOtherLivrable($aid,$trimestre,$type_id);

    if($statut_t2){
        $this->createLivrableComment($aid,2,$statut_t2,$request->get('observation_t2'),$type_id,$statut_avancement);
        $affected = DB::table($table)->where('id', $aid)->update(['is_valide1' => $statut_t1,'statut_t1'=> $statut_avancement,'state'=>$statut_avancement]);
        foreach($livrables as $livrable){
            $affected = DB::table('livrable')->where(['id'=>$livrable->id])->update(['state' => $statut_t1]);
            }
    }
    
    if($request->get('statut_final')){
    $affected = DB::table($table)->where('id', $aid)->update(['commentaire_t2' => $commentaire_final,'statut_t2' => $statut_final]);
    }

}
if($trimestre==3){
   $observation_t3 =$request->get('observation_t3');
   $statut_t3 =$request->get('statut_t3');
   $livrables = getOtherLivrable($aid,$trimestre,$type_id);

    if($statut_t3){
        $this->createLivrableComment($aid,3,$statut_t3,$request->get('observation_t3'),$type_id,$statut_avancement);
        $affected = DB::table($table)->where('id', $aid)->update(['is_valide3' => $statut_t3,'statut_t3'=> $statut_avancement,'state'=>$statut_avancement]);
        foreach($livrables as $livrable){
            $affected = DB::table('livrable')->where(['id'=>$livrable->id])->update(['state' => $statut_t3]);
            }
    }
    
    if($request->get('statut_final')){
    $affected = DB::table($table)->where('id', $aid)->update(['commentaire_t3' => $commentaire_final,'statut_t3' => $statut_final]);
    }
}
if($trimestre==4){
   $observation_t4 =$request->get('observation_t4');
   $statut_t4 =$request->get('statut_t4');
   $livrables = getOtherLivrable($aid,$trimestre,$type_id);

    if($statut_t4){
        $this->createLivrableComment($aid,4,$statut_t4,$request->get('observation_t4'),$type_id,$statut_avancement);
        $affected = DB::table($table)->where('id', $aid)->update(['is_valide4' => $statut_t4,'statut_t4'=> $statut_avancement,'state'=>$statut_avancement]);
        foreach($livrables as $livrable){
            $affected = DB::table('livrable')->where(['id'=>$livrable->id])->update(['state' => $statut_t4]);
            }
    }
    
    if($request->get('statut_final')){
    $affected = DB::table($table)->where('id', $aid)->update(['commentaire_t4' => $commentaire_final,'statut_t4' => $statut_final]);
    }
}
      

   
    }


    public function agentByDirection($direction)
    {

     $agent =DB::table('users')
                 ->join('agent_fonction','users.id','agent_fonction.user_id')
                 ->where('agent_fonction.direction_id', $direction)
                 ->orderBy('users.nomprenoms','asc')
                ->get();
     return $agent;
          
    }

    public function actionResponsable($direction_id)
    {

        //dd($direction_id,$sousdirection_id,$service_id,$isagence);

        $agent =DB::table('users')
                        ->join('agent_fonction','users.id','agent_fonction.user_id')
                        ->select('users.id','users.nomprenoms')
                        ->when($direction_id, function ($query, $direction_id) 
                                        {return $query->where('agent_fonction.direction_id', $direction_id);}
                                            )
                        ->whereIn('agent_fonction.level',[5,3])
                        ->orderBy('users.nomprenoms','asc')
                        ->get();


     return $agent;
          
    }

    public function activiteResponsable($direction_id,$sousdirection_id,$service_id,$isagence)
    {

        //dd($direction_id,$sousdirection_id,$service_id,$isagence);

    if($isagence){

        $agent =DB::table('users')
                        ->join('agent_fonction','users.id','agent_fonction.user_id')
                        ->select('users.id','users.nomprenoms')
                        ->when($direction_id, function ($query, $direction_id) 
                                        {return $query->where('agent_fonction.direction_id', $direction_id);}
                                            )
                        ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                        {return $query->where('agent_fonction.sousdirection_id', $sousdirection_id);}
                                            )
                        ->where( function ($query) 
                                        {return $query->where('agent_fonction.iscipac',2 )->orwhere('agent_fonction.level',3 );}
                                            )
                        ->orderBy('users.nomprenoms','asc')
                        ->get();



    }else{

        $agent =DB::table('users')
                        ->join('agent_fonction','users.id','agent_fonction.user_id')
                        ->select('users.id','users.nomprenoms')
                        ->when($direction_id, function ($query, $direction_id) 
                                        {return $query->where('agent_fonction.direction_id', $direction_id);}
                                            )
                        ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                        {return $query->where('agent_fonction.sousdirection_id', $sousdirection_id);}
                                            )
                       ->whereIn('agent_fonction.level',[2,3])
                        ->orderBy('users.nomprenoms','asc')
                        ->get();

    }

     
     return $agent;
          
    }


    public function tacheResponsable($direction_id,$sousdirection_id,$service_id,$isagence)
    {

        //dd($direction_id,$sousdirection_id,$service_id,$isagence);

    if($isagence){

        $agent =DB::table('users')
                        ->join('agent_fonction','users.id','agent_fonction.user_id')
                        ->select('users.id','users.nomprenoms')
                        ->when($direction_id, function ($query, $direction_id) 
                                        {return $query->where('agent_fonction.direction_id', $direction_id);}
                                            )
                        ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                        {return $query->where('agent_fonction.sousdirection_id', $sousdirection_id);}
                                            )
                        ->where( function ($query) 
                                        {return $query->where('agent_fonction.iscipac',1 )->orwhere('users.id',auth()->id() );}
                                            )
                        ->orderBy('users.nomprenoms','asc')
                        ->get();



    }else{

        $agent =DB::table('users')
                        ->join('agent_fonction','users.id','agent_fonction.user_id')
                        ->select('users.id','users.nomprenoms')
                        ->when($direction_id, function ($query, $direction_id) 
                                        {return $query->where('agent_fonction.direction_id', $direction_id);}
                                            )
                        ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                        {return $query->where('agent_fonction.sousdirection_id', $sousdirection_id);}
                                            )
                        ->when($service_id, function ($query, $service_id) 
                                    {return $query->where('agent_fonction.service_id', $service_id);}
                                        )
                        ->orderBy('users.nomprenoms','asc')
                        ->get();

    }

     
     return $agent;
          
    }


    public function agentDroitptab($direction)
    {

     $agent =DB::table('users')
                 ->join('agent_fonction','users.id','agent_fonction.user_id')
                 ->where('agent_fonction.direction_id', $direction)
                 ->orWhereIn('agent_fonction.user_id', [290,410,660,661,662,663,624])
                 ->orderBy('users.nomprenoms','asc')
                ->get();
     return $agent;
          
    }


     public function livrableUpdate($request)
    {

      //dd($request);
        $did=$request->get('action_id');
        $t=$request->get('trim');
        $opt=$request->get('opt');
        $commentaire=$request->get('commentaire');
        if($t==1){$trim='is_valide1'; $comm='commentaire_t1';}
        if($t==2){$trim='is_valide2'; $comm='commentaire_t2';}
        if($t==3){$trim='is_valide3'; $comm='commentaire_t3';}
        if($t==4){$trim='is_valide4'; $comm='commentaire_t4';}
        if($t==5){$trim='is_valideF'; $comm='commentaire_final';}
   
     $rep = Action::where('id', $did)
             ->update([
               $trim =>$opt,
               $comm =>$commentaire
               ]);
           return $rep;
          
    }

    public function ajouterLivrable($request,$uploadFile)
    {

      //dd($request);
    

      if($request->file('livrable_t1')){
                   $livrable = $uploadFile->upload($request,'livrable_t1');
                   
                                       }
      if($request->file('livrable_t2')){
                   $livrable = $uploadFile->upload($request,'livrable_t2');
                   
                              }
     if($request->file('livrable_t3')){
                   $livrable = $uploadFile->upload($request,'livrable_t3');
                
                              }
    if($request->file('livrable_t4')){
               $livrable = $uploadFile->upload($request,'livrable_t4');
               
                              }
    if($request->file('livrable_final')){
               $livrable = $uploadFile->upload($request,'livrable_final');
               
                              }
     
                            $livrable_ = new Livrable();

                            $livrable_->action_id = $request->get('action_id');
                            $livrable_->trimestre = $request->get('trim') ;
                            $livrable_->user_id = Auth::user()->id;
                            $livrable_->livrable = $livrable;
                            $livrable_->commentaire =  '';
                            $livrable_->state = 1;

                            $livrable_->save();

          
    }

     public function createLivrable($action_id,$trimestre,$livrable,$commentaire,$type_id)
    {
        
    
                            $livrable_ = new Livrable();

                            $livrable_->instance_id = $action_id;
                            $livrable_->type_id = $type_id;
                            $livrable_->trimestre = $trimestre ;
                            $livrable_->user_id = Auth::user()->id;
                            $livrable_->livrable = $livrable;
                            $livrable_->commentaire =  $commentaire;
                            $livrable_->state = 0;

                            $livrable_->save();

    }

     public function createLivrableComment($action_id,$trimestre,$statut_livrable,$commentaire,$type_id,$avancement)
    {
        //dd($action_id,$trimestre,$commentaire);
        $agent_function = Session::get('function_key');

                            $comment = new Commentaire_livrable();

                            $comment->instance_id = $action_id;
                            $comment->type_id = $type_id;
                            $comment->trimestre = $trimestre ;
                            $comment->user_id = Auth::user()->id;
                            $comment->user_level = $agent_function->fonction;
                            $comment->commentaire =  $commentaire;
                            $comment->statut_livrable =  $statut_livrable;
                            $comment->statut_avancement =  $avancement;
                            $comment->state = 1;
                            $comment->save();
          
    }

     public function sendLivrable($request)
    {
             
            
        $table_affected = $request->get('tid');
        if($table_affected=='tache'){$type_id=3;}elseif($table_affected=='activite'){$type_id=2;}else{$type_id=1;}
            $instance_id = $request->get('instance_id');
            $trimestre = $request->get('trimestre');
            $statut_final = $request->get('statut_final');
            $commentaire = $request->get('commentaire');
            $livrables = getOtherLivrable($instance_id,$trimestre,$type_id);
            //dd($request,$livrables);
            $affected = DB::table($table_affected)->where('id', $instance_id)->update(['commentaire_t1' => $commentaire,'statut_t1' => $statut_final,'state' => $statut_final]);
            foreach($livrables as $livrable){
                $affected = DB::table('livrable')->where(['id'=>$livrable->id, 'state'=>0])->update(['state' => 1]);
            }

            $this->createLivrableComment($instance_id,1,1,$request->get('commentaire'),$type_id,$statut_final);


          
    }

      public function addPtabDroit($agent_id)
    {
            $droit = new Droit_ptab();

            $droit->user_id = $agent_id;
            $droit->description = '' ;
            $droit->state = 1;

            $droit->save();

            return $droit->id;
    }


    public function addPtabStructure($droit_id,$structure,$type)
    {

        $droit = new Droit_ptab_detail();

        $droit->droit_id = $droit_id;
        $droit->type = $type ;
        $droit->structure = $structure;
        $droit->state = 1;

        $droit->save();

        return $droit->id;

          
    }


    


 
}