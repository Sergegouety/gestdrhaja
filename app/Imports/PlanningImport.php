<?php

namespace App\Imports;

use App\Models\Planning;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PlanningImport implements ToModel, WithStartRow
{
    public $direction_id;
    public $sousdirection_id;
    

    public function __construct(array $data)
    {
        $this->direction_id = $data['direction_id'];
        //$this->sousdirection_id = $data['sousdirection'];
       
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 9;
    }

   
    public function model(array $row)
    {
               

     $agent_function=getAgentFunctionByMatricule($row[1]);
   
    
     //dd($agent_function,$row[0],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7]);

    if($agent_function == null){
               
                 //dd($name);
                 DB::rollback();
                 
                 return null;
                
            }else{

                $planning = new Planning();

                $planning->direction_id = $agent_function->direction_id;
                $planning->sousdirection_id = $agent_function->sousdirection_id;
                $planning->service_id = $agent_function->service_id;
                $planning->demandeur_id = $agent_function->user_id;
                $planning->fonction = $agent_function->fonction;
                $planning->demandeur_level = $agent_function->level;
                $planning->interim = $row[8];
                $planning->date_depart = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row[4]));
                $planning->date_retour = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row[5]));
                $planning->date_reprise = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row[6]));
                $planning->duree = $row[7];
                $planning->state = 1;
                
                $planning->save();
                

                 }
      return null;
    }

}
