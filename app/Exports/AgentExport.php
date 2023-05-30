<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use DB;

class AgentExport implements FromCollection, WithHeadings
{


    /**
    * @return \Illuminate\Support\Collection
    */

    protected $request;
    

     function __construct($request) {

            $this->request = $request;
            
     }

    public function collection()
    {
        
         
        $nom= $this->request->nom;

        $agents =DB::table('users')
                ->join('agent_fonction', 'agent_fonction.user_id','=','users.id')
               ->select('users.nomprenoms','users.telephone1','users.telephone2','users.matricule','users.email','agent_fonction.service','agent_fonction.sousdirection','agent_fonction.direction','agent_fonction.fonction')
               
               ->when($nom, function ($query, $nom) 
                                    {return $query->where('users.nomprenoms','like','%'.$nom.'%');}
                                        )
               ->when($nom, function ($query, $nom) 
                                    {return $query->orwhere('users.matricule','like','%'.$nom.'%');}
                                        )
               ->when($nom, function ($query, $nom) 
                                    {return $query->orwhere('agent_fonction.direction','like','%'.$nom.'%');}
                                        )
               ->when($nom, function ($query, $nom) 
                                    {return $query->orwhere('agent_fonction.sousdirection','like','%'.$nom.'%');}
                                        )
               ->when($nom, function ($query, $nom) 
                                    {return $query->orwhere('agent_fonction.service','like','%'.$nom.'%');}
                                        )
               ->when($nom, function ($query, $nom) 
                                    {return $query->orwhere('users.email','like','%'.$nom.'%');}
                                        )
               ->where('users.state',0)
               ->orderBy('users.nomprenoms', 'asc')
               ->get();
        
        return $agents;
    }


    public function headings(): array
    {
        return [
            'nom prenoms',
            'telephone1',
            'telephone2',
            'matricule',
            'email',
            'service',
            'sousdirection',
            'direction',
            'fonction'
            ];
    }




}
