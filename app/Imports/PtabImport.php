<?php

namespace App\Imports;

use App\Models\Ptab;
use App\Models\Action;
use App\Models\ActionBck;
use App\Models\Activite;
use App\Models\Tache;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PtabImport implements ToModel, WithStartRow
{
    public $direction_id;
    public $sousdirection_id;
    public $axe_id;
    public $extrant_id;

    public function __construct(array $data)
    {
        $this->direction_id = $data['direction'];
        $this->sousdirection_id = $data['sousdirection'];
        $this->axe_id = $data['axe'];
        $this->extrant_id = $data['extrant'];

    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 5;
    }

   
    public function model(array $row)
    {
                $action_id=1;
                $activite_id=1;

                $agent_function=getAgentFunctionByName($row[17]);

                //dd($row[17], $agent_function);

    

                if($agent_function){

                             $responsable=$agent_function->nomprenoms;

                             if($this->sousdirection_id){
                                
                                    $sousdirection_id=$this->sousdirection_id;

                                }else{
                                    
                                    $sousdirection_id=$agent_function->sousdirection_id;

                                     }
                             
                        if($row[3]=='Action' && $row[4]!=''){

                        DB::beginTransaction(); 
                        try {

                            $action = new ActionBck();

                            $action->direction_id = $this->direction_id;
                            $action->sousdirection_id = $sousdirection_id;
                            $action->extrant_id = $this->extrant_id;
                            $action->type_id = 1;
                            $action->intitule = $row[4];
                            $action->reference_matrice = $row[5];
                            $action->indicateur = $row[6];
                            $action->responsable = $responsable;
                            $action->cible_glo = $row[7];
                            $action->cout_glo =  $row[8];
                            $action->cible_t1 =  $row[9];
                            $action->cout_t1 = $row[10];
                            $action->cible_t2 = $row[11];
                            $action->cout_t2 = $row[12];
                            $action->cible_t3 =$row[13] ;
                            $action->cout_t3 =  $row[14];
                            $action->cible_t4 =  $row[15];
                            $action->cout_t4 = $row[16];
                            $action->entite_prenante = $row[18];
                            $action->action_entite = $row[19];
                            $action->periode_execution = $row[20];
                            $action->zone_exection = $row[21];
                            
                            $action->save();

                         } catch (Exception $e){ DB::rollback();}

                         }elseif($row[3]=='Activite' || $row[3]=='Activité' && $row[4]!=''){

                            $action_id=getLastId_function(1);
  
                             DB::beginTransaction(); 
                        try {

                            $action = new ActionBck();

                            $action->direction_id = $this->direction_id;
                            $action->sousdirection_id = $sousdirection_id;
                            $action->service_id = $agent_function->service_id;
                            $action->extrant_id = $this->extrant_id;
                            $action->type_id = 2;
                            $action->action_id = $action_id;
                            $action->intitule = $row[4];
                            $action->reference_matrice = $row[5];
                            $action->indicateur = $row[6];
                            $action->responsable = $responsable;
                            $action->cible_glo = $row[7];
                            $action->cout_glo =  $row[8];
                            $action->cible_t1 =  $row[9];
                            $action->cout_t1 = $row[10];
                            $action->cible_t2 = $row[11];
                            $action->cout_t2 = $row[12];
                            $action->cible_t3 =$row[13] ;
                            $action->cout_t3 =  $row[14];
                            $action->cible_t4 =  $row[15];
                            $action->cout_t4 = $row[16];
                            $action->entite_prenante = $row[18];
                            $action->action_entite = $row[19];
                            $action->periode_execution = $row[20];
                            $action->zone_exection = $row[21];
                            
                            $action->save();
                         } catch (Exception $e){ DB::rollback();}

                        }elseif(($row[3]=='Tache' || $row[3]=='Tâche') && $row[4]!=''){

                            //$activite_id=getLastId('activite');
                            $action_id=getLastId_function(1);
                            $activite_id=getLastId_function(2);

                             // if($responsable == 'SERY GOUZA STEPHANIE'){ 
                             //    dd($this->direction_id,$sousdirection_id,$agent_function->service_id,$this->extrant_id);
                             // }
                            //dd($action_id,$activite_id);

                         DB::beginTransaction(); 
                        try {
                               
                            $action = new ActionBck();

                            $action->direction_id = $this->direction_id;
                            $action->sousdirection_id = $sousdirection_id;
                            $action->service_id = $agent_function->service_id;
                            $action->extrant_id = $this->extrant_id;
                            $action->type_id = 3;
                            $action->action_id = $action_id;
                            $action->activite_id = $activite_id;
                            $action->intitule = $row[4];
                            $action->reference_matrice = $row[5];
                            $action->indicateur = $row[6];
                            $action->responsable = $responsable;
                            $action->cible_glo = $row[7];
                            $action->cout_glo =  $row[8];
                            $action->cible_t1 =  $row[9];
                            $action->cout_t1 = $row[10];
                            $action->cible_t2 = $row[11];
                            $action->cout_t2 = $row[12];
                            $action->cible_t3 =$row[13];
                            $action->cout_t3 =  $row[14];
                            $action->cible_t4 =  $row[15];
                            $action->cout_t4 = $row[16];
                            $action->entite_prenante = $row[18];
                            $action->action_entite = $row[19];
                            $action->periode_execution = $row[20];
                            $action->zone_exection = $row[21];
                            
                            $action->save();

                         } catch (Exception $e){ DB::rollback();}

                    }
                    
                      DB::commit();

            }else{

                 DB::rollback();
                      
                 Redirect::route('ptab.import')->with('error',"Nom de l'Agent ( ".$row[17]." ), est introuvable vérifiez l'orthographe du nom svp");

                 }


               return null;
        
    }

}
