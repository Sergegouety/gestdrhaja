<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Services\uploadFile;

use Carbon\Carbon;
use App\Models\Cour;
use Illuminate\Support\Facades\Redirect;
use App\Models\Demande;
use App\Models\Demande_details;
use App\Models\Stock;
use App\Models\Attribution;
use App\Models\Doc_demande;
use App\Models\Doc_demande_details;
use App\Models\Intervention_details;


class DemandeRepository
{


   public function getDemandesByUser($direction_id,$sousdirection_id,$service_id,$user_id,$limit,$state,$level,$objet,$request)
    {
        
        
        $nom=$request['nom'] ?? '';
        $direction=$request['direction_id'] ?? '';
        $datedemande=$request['datedemande'] ?? '';


        $demandes =DB::table('demandes')
               ->join('users', 'demandes.demandeur_id','=','users.id')
               ->select('demandes.id','demandes.demandeur_id','demandes.direction_id','demandes.sousdirection_id','demandes.service_id','demandes.demandeur_level','demandes.objet','demandes.objet_absence','demandes.detail_objet_absence','demandes.objet_autre','demandes.interim','demandes.created_at as date_demande','demandes.date_depart','demandes.date_retour','demandes.duree','demandes.justificatif','demandes.state','demandes.observation_cs','demandes.observation_sd','demandes.observation_d','demandes.observation_sdrh','demandes.observation_drh','demandes.observation_admin', 'users.nomprenoms')
               ->when($direction_id, function ($query, $direction_id) 
                                    {return $query->where('demandes.direction_id', $direction_id);}
                                        )
                ->when($direction, function ($query, $direction) 
                                    {return $query->where('demandes.direction_id', $direction);}
                                        )
               ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                    {return $query->where('demandes.sousdirection_id', $sousdirection_id);}
                                        )
               ->when($service_id, function ($query, $service_id) 
                                    {return $query->where('demandes.service_id', $service_id);}
                                        )
               ->when($user_id, function ($query, $user_id) 
                                    {return $query->where('users.id', $user_id);}
                                        )
               ->when($state, function ($query, $state) 
                                    {return $query->where('demandes.state', $state);}
                                        )
               ->when($nom, function ($query, $nom) 
                                    {return $query->where('users.nomprenoms','like','%'.$nom.'%');}
                                        )
               ->when($datedemande, function ($query, $datedemande) 
                                    {return $query->where('demandes.created_at','like','%'.$datedemande.'%');}
                                        )
               ->when($objet, function ($query, $objet) 
                                    {return $query->where('demandes.objet',$objet);}
                                        )
               ->when($level, function ($query, $level) 
                                    {return $query->orwhere('demandes.demandeur_level', $level);}
                                        )
               ->orderBy('demandes.created_at', 'desc')
               ->paginate(20);
       
       
         return $demandes;
  
    }


     public function getDemandesOfAdmin($direction_id,$sousdirection_id,$service_id,$user_id,$limit,$state,$level,$objet,$request)
    {
        
        
        $nom=$request['nom'] ?? '';
        $direction=$request['direction_id'] ?? '';
        $datedemande=$request['datedemande'] ?? '';


        $demandes =DB::table('demandes')
               ->join('users', 'demandes.demandeur_id','=','users.id')
               ->select('demandes.id','demandes.demandeur_id','demandes.direction_id','demandes.sousdirection_id','demandes.service_id','demandes.demandeur_level','demandes.objet','demandes.objet_absence','demandes.detail_objet_absence','demandes.objet_autre','demandes.interim','demandes.created_at as date_demande','demandes.date_depart','demandes.date_retour','demandes.duree','demandes.justificatif','demandes.state','demandes.observation_cs','demandes.observation_sd','demandes.observation_d','demandes.observation_sdrh','demandes.observation_drh','demandes.observation_admin', 'users.nomprenoms')
               ->when($direction_id, function ($query, $direction_id) 
                                    {return $query->where('demandes.direction_id', $direction_id);}
                                        )
                ->when($level, function ($query, $level) 
                                    {return $query->orwhereIn('demandes.demandeur_level', [4, 5]);}
                                        )
               ->when($nom, function ($query, $nom) 
                                    {return $query->where('users.nomprenoms','like','%'.$nom.'%');}
                                        )
               ->when($datedemande, function ($query, $datedemande) 
                                    {return $query->where('demandes.created_at','like','%'.$datedemande.'%');}
                                        )
               ->when($objet, function ($query, $objet) 
                                    {return $query->where('demandes.objet',$objet);}
                                        )
               
               ->orderBy('demandes.created_at', 'desc')
               ->paginate(20);
       
       
         return $demandes;
  
    }


    public function getPlanningByUser($direction_id,$sousdirection_id,$service_id,$user_id,$limit,$level,$objet,$request)
    {
        
        
        $nom=$request['nom'] ?? '';
        $direction=$request['direction_id'] ?? '';
        $datedemande=$request['datedemande'] ?? '';
        //dd();

        $demandes =DB::table('planning_conge')
               ->join('users', 'planning_conge.demandeur_id','=','users.id')
               ->select('users.id','planning_conge.demandeur_id','planning_conge.direction_id','planning_conge.sousdirection_id','planning_conge.service_id','planning_conge.demandeur_level','planning_conge.interim','planning_conge.created_at','planning_conge.date_depart','planning_conge.date_retour','planning_conge.duree','planning_conge.date_reprise','planning_conge.state','planning_conge.fonction', 'users.nomprenoms')
               ->when($direction_id, function ($query, $direction_id) 
                                    {return $query->where('planning_conge.direction_id', $direction_id);}
                                        )
                ->when($direction, function ($query, $direction) 
                                    {return $query->where('planning_conge.direction_id', $direction);}
                                        )
               ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                    {return $query->where('planning_conge.sousdirection_id', $sousdirection_id);}
                                        )
               ->when($service_id, function ($query, $service_id) 
                                    {return $query->where('planning_conge.service_id', $service_id);}
                                        )
               ->when($user_id, function ($query, $user_id) 
                                    {return $query->where('users.id', $user_id);}
                                        )
               ->when($nom, function ($query, $nom) 
                                    {return $query->where('users.nomprenoms','like','%'.$nom.'%');}
                                        )
               ->when($datedemande, function ($query, $datedemande) 
                                    {return $query->where('planning_conge.created_at','like','%'.$datedemande.'%');}
                                        )
               ->when($level, function ($query, $level) 
                                    {return $query->orwhereIn('planning_conge.demandeur_level', [4, 5]);}
                                        )
               ->orderBy('planning_conge.created_at', 'desc')
               ->paginate(20);
       
       
         return $demandes;
  
    }

    public function getMymateriel($userId){

      $rep = DB::table('attribution_materiel')
                 ->join('design_materiel','attribution_materiel.materiel_id','=','design_materiel.id')
                 ->select('attribution_materiel.id','design_materiel.designation')
                 ->WHERE('attribution_materiel.user_id',$userId)
                 ->get();
        return $rep;
    }

     public function removeDemande($did,$opt)
    {

      //$opt=4;
   
     $rep = Demande::where('id', $did)
             ->update([
               'state' =>$opt
               ]);
           return $rep;
          
    }

     public function update_docDemande($did,$opt)
    {

      //$opt=4;
   
     $rep = Doc_demande::where('id', $did)
             ->update([
               'state' =>$opt
               ]);
           return $rep;
          
    }

      public function store_doc_Demande($did,$opt)
    {

   
     $demande = new Doc_demande_details();

            $demande->doc_demande_id = $did;
            $demande->user_id = Auth::id();
            $demande->state = $opt;

            $demande->save();
            
            return $demande->id;
          
    }

    public function updateDemandeDetail($did,$opt)
    {

      //$opt=4;
   
     $rep = Demande_details::where('id', $did)
             ->update([
               'state' =>$opt
               ]);
           return $rep;
          
    }

    public function addDemandes($request,$path_justif)
    {

            $direction=$request->get('direction');
            $sousdirection=$request->get('sousdirection');
            $service=$request->get('service');
            $demandeur_id=$request->get('agent');
            $objet=$request->get('objet');
            $interim=$request->get('interim');
            $objetabsence=$request->get('objetabsence');
            $objetautre=$request->get('objetautre');
            $datedemande=$request->get('datedemande');
            $datedepart=$request->get('datedepart');
            $dateretour=$request->get('dateretour');
            $duree=$request->get('nbrejourouvrable');
            $restant=$request->get('nbrejourrestant');
            $objetabsence_mariage=$request->get('objetabsence_mariage');
            $objetabsence_naissance=$request->get('objetabsence_naissance');
            $objetabsence_deces=$request->get('objetabsence_deces');
            $detail_objet_absence='';

            $agent_function = Session::get('function_key');
            //dd($agent_function,$agent_function->level);
            // if($agent_function->level==1){$state=1;}
            // elseif($agent_function->level==2){$state=2;}
            // elseif($agent_function->level==3){$state=3;}
            // elseif($agent_function->level==4){$state=3;}
            // else{$state=4;}
            // if($agent_function->isassistant==1){$state=3;}
            $state=1;

            if($objet=='CONGE'){$objetabsence='';}

            if($objetabsence=='MARIAGE'){
                $detail_objet_absence==$objetabsence_mariage;
            }elseif($objetabsence=='NAISSANCE'){
                $detail_objet_absence=$objetabsence_naissance;
            }elseif($objetabsence=='DECES'){
                $detail_objet_absence=$objetabsence_deces;
            }

            $demande = new Demande();

            $demande->direction_id = $direction;
            $demande->sousdirection_id = $sousdirection;
            $demande->service_id = $service;
            $demande->demandeur_id = $demandeur_id;
            $demande->demandeur_level = $agent_function->level;

            $demande->interim = $interim;
            $demande->objet = $objet;
            $demande->objet_absence = $objetabsence;
            $demande->detail_objet_absence = $detail_objet_absence;
            $demande->objet_autre = $objetautre;
            $demande->date_demande = $datedemande;
            $demande->date_depart = $datedepart;
            $demande->date_retour = $dateretour;
            $demande->duree = $duree;
            $demande->reste = $restant;
            $demande->justificatif = $path_justif;
            $demande->state = $state;
           
            $response = $demande->save();
            
            return $demande->id;
     
    }

    public function updateDemandes($request)
    {
        //dd($request);
            $demande_id=$request->get('demande_id');
           
            $objet=$request->get('objet');
            $interim=$request->get('interim');
            $objetabsence=$request->get('objetabsence');
            $objetautre=$request->get('objetautre');
            $datedemande=$request->get('datedemande');
            $datedepart=$request->get('datedepart');
            $dateretour=$request->get('dateretour');
            $duree=$request->get('nbrejourouvrable');
            $restant=$request->get('nbrejourrestant');
            $state=$request->get('state');


            DB::table('demandes')
            ->where('id', $demande_id)
            ->update([
                'interim' => $interim,
                'objet' => $objet,
                'objet_absence' => $objetabsence,
                'objet_autre' => $objetautre,
                'date_demande' => $datedemande,
                'date_depart' => $datedepart,
                'date_retour' => $dateretour,
                'duree' => $duree,
                'reste' => $restant,
                'state' => $state
            ]);
     
    }



     public function getDemandesDetails($did)
    {
      $details = Demande::where('id', $did)
                 ->first();
            return $details;
    }

     public function getInterventionDetails($i_id)
    {
      $details = DB::table('intervention_details')
                 ->join('intervention', 'intervention_details.intervention_id', '=', 'intervention.id')
                 ->WHERE('intervention.id',$i_id)
                 ->get();
               return $details;
    }
    


    public function getDoc_demandeByUser($user_id,$state,$limit,$request) {

        $nom=$request['nom'] ?? '';
        $datedemande=$request['datedemande'] ?? '';
      
       $agent_function = Session::get('function_key');
       $direction_id=$agent_function->direction_id;
       $sousdirection_id=$agent_function->sousdirection_id;
       $service_id=$agent_function->service_id;

       //dd($agent_function);
       if(Auth::user()->state==1){$user_id='';}
       if($sousdirection_id==12 && $service_id==0){$user_id='';}  //sous direction RH
       if($direction_id==4 && $sousdirection_id==0){$user_id='';} //drhaja
       if($direction_id==9 && $sousdirection_id==0){$user_id=''; } //administrateur
       if($direction_id==4 && $sousdirection_id==12 && $service_id==30){$user_id='';}  // service courrier
       $demande =DB::table('doc_demande')
                ->join('users', 'users.id','=','doc_demande.user_id')
                // ->join('agent_fonction', 'users.id','=','agent_fonction.user_id')
               ->select('users.id','users.nomprenoms','doc_demande.id as docId','doc_demande.document_id','doc_demande.nbr_doc','doc_demande.description','doc_demande.date','doc_demande.state')
               ->when($user_id, function ($query, $user_id) 
                                    {return $query->where('users.id', $user_id);}
                                        )
               ->when($state, function ($query, $state) 
                                    {return $query->where('doc_demande.state', $state);}
                                        )
                ->when($nom, function ($query, $nom) 
                                    {return $query->where('users.nomprenoms','like','%'.$nom.'%');}
                                        )
               ->when($datedemande, function ($query, $datedemande) 
                                    {return $query->where('doc_demande.date','like','%'.$datedemande.'%');}
                                        )
               ->orderBy('doc_demande.date', 'desc')
               ->get();
     
         return $demande;
    }

     public function getDoc_demandeDetail($i_id)
    {
      $details =DB::table('doc_demande')
                        ->join('doc_demande_details', 'doc_demande.id','=','doc_demande_details.doc_demande_id')
                        ->join('users', 'users.id','=','doc_demande.user_id')
                        ->select('users.id','users.fname','users.lname','users.direction_id','users.sousdirection_id','users.service_id','users.matricul','users.type_id','doc_demande.id as docId','doc_demande.document_id','doc_demande.description','doc_demande.date','doc_demande.state','doc_demande_details.state','doc_demande_details.updated_at','doc_demande_details.created_at')
                        ->where('doc_demande.id',$i_id)
                        ->get();
     
         return $details;
    }

      public function getAttributionByUserId($user_id,$limit)
    {
       $type_id=Auth::user()->type_id;
       $service_id=Auth::user()->service_id;
       $sousdirection_id=Auth::user()->sousdirection_id;
       $direction_id=Auth::user()->direction_id;
      $sqlQuery ='SELECT
                  attribution_materiel.id,attribution_materiel.user_id,attribution_materiel.materiel_id,attribution_materiel.date,attribution_materiel.state,users.lname,users.fname
                  FROM attribution_materiel, users 
                  where attribution_materiel.user_id=users.id';
               // echo $sqlQuery;
       
        $sqlQuery= $sqlQuery." Order By attribution_materiel.date DESC";
        if($limit){ $sqlQuery= $sqlQuery." LIMIT $limit";}
        //dd( $sqlQuery,$service_id);

        $attribution = DB::select($sqlQuery);
         return $attribution;
  
    }

     public function modifie_demande_conge($request)
    {

        //dd($request);

    $demandeur_id=$request->get('demandeur_id');
    $demande_id=$request->get('demande_id');
    $demande_objet=$request->get('demande_objet');
    $interimaire=$request->get('interimaire');
    $objetabsence=$request->get('objetabsence');
    $objetautre=$request->get('objetautre');
    $date_demande=$request->get('date_demande');
    $date_depart=$request->get('date_depart');
    $date_retour=$request->get('date_retour');
    $state=$request->get('state');

     $response = Demande::where([
        'id'=>$demande_id
        ])->update([
                    "interim"=>$interimaire,
                    "objet"=>$demande_objet,
                    "objet_absence"=>$objetabsence,
                    "objet_autre"=>$objetautre,
                    "date_demande"=>$date_demande,
                    "date_depart"=>$date_depart,
                    "date_retour"=>$date_retour,
                    "state"=>$state

         ]); 
      
  
    }



     public function getcongeByParametre($user_id,$limit,$direction_id,$sousdirection_id,$service_id,$objet)
    {
      
      $conges =DB::table('demandes')
                ->join('users', 'demandes.demandeur_id','=','users.id')
               ->select('demandes.id','demandes.direction_id','demandes.sousdirection_id','demandes.service_id','users.fname','users.lname','demandes.interim','demandes.objet','demandes.date_depart','demandes.date_retour','demandes.state')
               ->when($direction_id, function ($query, $direction_id) 
                                    {return $query->where('demandes.direction_id', $direction_id);}
                                        )
               ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                    {return $query->where('demandes.sousdirection_id', $sousdirection_id);}
                                        )
               ->when($service_id, function ($query, $service_id) 
                                    {return $query->where('demandes.service_id', $service_id);}
                                        )
               ->when($objet, function ($query, $objet) 
                                    {return $query->where('demandes.objet', $objet);}
                                        )
               ->get();
    
         return $conges;
  
    }

     public function addIntervention($request)
    {

            $date=Carbon::now();
            $materiel_id=$request->get('materiel_id');
            $demandeur_id=$request->get('user_id');
            $description=$request->get('description');
            $state=1;

            $intervention = new Intervention();

            $intervention->user_id = $demandeur_id;
            $intervention->materiel_id = $materiel_id;
            $intervention->description = $description;
            $intervention->date = $date;
            $intervention->state = $state;
            
            $response = $intervention->save();
            
            return $intervention->id;
     
    }

     public function addDemandeDocument($document_id,$demandeur_id, $nbr_doc,$motif,$state)
    {
          $date=Carbon::now();

            $doc_demande = new Doc_demande();

            $doc_demande->user_id = $demandeur_id;
            $doc_demande->document_id = $document_id;
            $doc_demande->nbr_doc = $nbr_doc ;
            //$doc_demande->motif = $motif ;
            $doc_demande->description = $motif;
            $doc_demande->date = $date;
            $doc_demande->state = $state;
            
            $response = $doc_demande->save();
            
            return $doc_demande->id;
     
    }

     public function addRapport($request)
    {

            $date=Carbon::now();
            $materiel_id=$request->get('materiel_id');
            $intervention_id=$request->get('intervention_id');
            $user_id=$request->get('user_id');
            $commentaire=$request->get('commentaire');
            $materiel_state=$request->get('materiel_state');
            $state=1;

            $rapport = new Rapport();

            $rapport->intervention_id = $intervention_id;
            $rapport->intervenant_id = $user_id;
            $rapport->commentaire = $commentaire;
            $rapport->date = $date;
            $rapport->materiel_state = $materiel_state;
            $rapport->state = 1;
            
            $response = $rapport->save();
            
            return $rapport->id;
     
    }

     public function addSendedDoc($request, $docpath)
    {

            $date=Carbon::now();
            $intervention_id=$request->get('intervention_id');
            $user_id=$request->get('user_id');
            $commentaire=$request->get('commentaire');
            $demandeur_id=$request->get('demandeur_id');
            $state=1;

            $doc = new Intervention_details();

            $doc->intervention_id = $intervention_id;
            $doc->demandeur_id = $demandeur_id;
            $doc->sender_id = $user_id;
            $doc->commentaire = $commentaire;
            $doc->document_path = $docpath;
            $doc->date = $date;
            $doc->state = 1;
            
            $response = $doc->save();
            
            return $doc->id;
     
    }


    




}