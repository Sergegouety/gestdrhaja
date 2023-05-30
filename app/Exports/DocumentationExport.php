<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;

use DB;

class DocumentationExport implements FromCollection, WithHeadings
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

       //dd($agent_function);
       if(Auth::user()->state==1){$user_id='';}
       if($sousdirection_id==12 && $service_id==0){$user_id='';}  //sous direction RH
       if($direction_id==4 && $sousdirection_id==0){$user_id='';} //drhaja
       if($direction_id==9 && $sousdirection_id==0){$user_id=''; } //administrateur
       if($direction_id==4 && $sousdirection_id==12 && $service_id==30){$user_id='';}  // service courrier

        $demande =DB::table('doc_demande')
                    ->join('users', 'users.id','=','doc_demande.user_id')
                    ->join('documentation', 'doc_demande.document_id','=','documentation.id')
                    ->join('statut_demande', 'doc_demande.state','=','statut_demande.id')
                    ->select('doc_demande.date','users.nomprenoms','documentation.designation','doc_demande.nbr_doc','statut_demande.demande_document')
                    ->when($user_id, function ($query, $user_id) 
                                        {return $query->where('users.id', $user_id);}
                                            )
               // ->when($state, function ($query, $state) 
               //                      {return $query->where('doc_demande.state', $state);}
               //                          )
                ->when($nom, function ($query, $nom)
                                    {return $query->where('users.nomprenoms','like','%'.$nom.'%');}
                                        )
               ->when($datedemande, function ($query, $datedemande) 
                                    {return $query->where('doc_demande.date','like','%'.$datedemande.'%');}
                                        )
               ->orderBy('users.nomprenoms', 'asc')
               ->get();
        
        return $demande;
    }


    public function headings(): array
    {
        return [
            'Date de demande',
            'Demandeur',
            'Document',
            'Exemplaire',
            'Statut'
            ];
    }




}
