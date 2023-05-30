<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;

use DB;

class CongeExport implements FromCollection, WithHeadings
{


    /**
    * @return \Illuminate\Support\Collection
    */

    protected $request;
    

     function __construct($request,$agent_function) {

            $this->request = $request;
            $this->agent_function = $agent_function;
            
     }

    public function collection()
    {
        
         
        $nom= $this->request->nom;
        $datedemande= $this->request->datedemande;

        $direction_id=$this->agent_function->direction_id;
        $sousdirection_id=$this->agent_function->sousdirection_id;
        $service_id=$this->agent_function->service_id;
        $user_id=$this->agent_function->user_id;
        $level=$this->agent_function->level;

    if(Auth::user()->state==1 || $direction_id==4){ //soit admin ou de la DRH
              $direction_id='';
              $sousdirection_id='';
              $service_id='';
              $user_id='';
     }else{

             $user_id=Auth::id();
             if($level==2){$user_id='';}
             if($level==3){$user_id='';  $service_id='';}
             if($level==4){$user_id='';  $service_id=''; $sousdirection_id='';}
     }



        $demandes =DB::table('demandes')
                ->join('users as demandeur', 'demandes.demandeur_id','=','demandeur.id')
                ->join('users as interimer', 'demandes.interim','=','interimer.id')
                ->join('statut_demande', 'demandes.state','=','statut_demande.id')
                ->select('demandes.created_at','demandeur.nomprenoms as demandeur','demandes.motif','interimer.nomprenoms as interimer','demandes.date_depart','demandes.date_retour','demandes.duree','statut_demande.demande_conge' )
               ->when($user_id, function ($query, $user_id) 
                                        {return $query->where('users.id', $user_id);}
                                            )
               ->when($direction_id, function ($query, $direction_id) 
                                        {return $query->where('demandes.direction_id', $direction_id);}
                                            )
               ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                        {return $query->where('demandes.sousdirection_id', $sousdirection_id);}
                                            )
               ->when($service_id, function ($query, $service_id) 
                                        {return $query->where('demandes.service_id', $service_id);}
                                            )
               ->when($nom, function ($query, $nom) 
                                    {return $query->where('users.nomprenoms','like','%'.$nom.'%');}
                                        )
               ->when($datedemande, function ($query, $datedemande) 
                                    {return $query->where('demandes.created_at','like','%'.$datedemande.'%');}
                                        )
               ->orderBy('demandeur.nomprenoms', 'asc')
               ->get();

               //dd($demandes);
        
        return $demandes;
    }



    public function headings(): array
    {
        return [
            'Date de demande',
            'Demandeur',
            'Motif',
            'Intérimaire',
            'Date de départ',
            'Date de retour',
            'Durée',
            'Statut'
            ];
    }




}
