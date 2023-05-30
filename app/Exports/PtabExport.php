<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use DB;

class PtabExport implements FromCollection, WithHeadings
{


    /**
    * @return \Illuminate\Support\Collection
    */

    protected $request;
    

     function __construct($direction,$sousdirection) {

            $this->direction = $direction;
            $this->sousdirection = $sousdirection;
            
     }

    public function collection()
    {
        set_time_limit(10000);
        $direction=$this->direction;
        $sousdirection= $this->sousdirection;
        //dd($direction,$sousdirection);

        $ptab =DB::table('action')
                ->join('type_action','action.type_id','type_action.id')
                ->leftjoin('direction','action.direction_id','direction.id')
                ->leftjoin('sousdirection','action.sousdirection_id','sousdirection.id')
                ->leftjoin('master_statut','action.statut_t1','master_statut.id')
                ->leftjoin('master_statut as statut2','action.statut_t2','statut2.id')
                ->leftjoin('master_statut as statut3','action.statut_t3','statut3.id')
                ->leftjoin('master_statut as statut4','action.statut_t4','statut4.id')
                ->leftjoin('master_statut as statutf','action.statut_final','statutf.id')
                ->select('action.id','direction.designation as direction','sousdirection.designation as sousdirection','type_action.designation','intitule','indicateur','responsable','cible_glo','cout_glo',
                    'cible_t1','cout_t1','valeur_t1','commentaire_t1','master_statut.statut','observation_t1',
                    'cible_t2','cout_t2','valeur_t2','commentaire_t2','statut2.statut as statut2','observation_t2',
                    'cible_t3','cout_t3','valeur_t3','commentaire_t3','statut3.statut as statut3','observation_t3',
                    'cible_t4','valeur_t4','cout_t4','commentaire_t4','statut4.statut as statut4','observation_t4',
                    'statutf.statut as statutf','observation_final','commentaire_final',
                    'entite_prenante','action_entite','periode_execution','zone_exection')
               
               ->when($direction, function ($query, $direction) 
                                    {return $query->where('action.direction_id',$direction);}
                                        )
               ->when($sousdirection, function ($query, $sousdirection) 
                                    {return $query->where('action.sousdirection_id',$sousdirection);}
                                        )
               ->orderBy('action.id')
               ->get();
//dd($ptab);
               $datalivrable = array();
               $dataFormatPtab = array();

               foreach($ptab as $item){
            $livrable_t1 = DB::table('livrable')->select(DB::Raw("CONCAT('http://gestdrhaja.emploijeunes.ci/docs','/', livrable) AS livrable"))->where(['action_id' => $item->id,'trimestre'=> 1])->get();
            if($livrable_t1){
                $lt1 = collect($livrable_t1);
                $livrable_t1 = $lt1->implode('livrable',',');
            }else{$livrable_t1='';}
            

            $livrable_t2 = DB::table('livrable')->select(DB::Raw("CONCAT('http://gestdrhaja.emploijeunes.ci/docs','/', livrable) AS livrable"))->where(['action_id' => $item->id,'trimestre'=> 2])->get();
            if($livrable_t2){
               $lt2 = collect($livrable_t2);
            $livrable_t2 = $lt2->implode('livrable',',');
            }else{$livrable_t2='';}
            

            $livrable_t3 = DB::table('livrable')->select(DB::Raw("CONCAT('http://gestdrhaja.emploijeunes.ci/docs','/', livrable) AS livrable"))->where(['action_id' => $item->id,'trimestre'=> 3])->get();
            if($livrable_t3){
               $lt3 = collect($livrable_t3);
            $livrable_t3 = $lt3->implode('livrable',',');
            }else{$livrable_t3='';}

            $livrable_t4 = DB::table('livrable')->select(DB::Raw("CONCAT('http://gestdrhaja.emploijeunes.ci/docs','/', livrable) AS livrable"))->where(['action_id' => $item->id,'trimestre'=> 4])->get();
           if($livrable_t4){
               $lt4 = collect($livrable_t4);
            $livrable_t4 = $lt4->implode('livrable',',');
            }else{$livrable_t4='';}
              

                 $dataFormatPtab [] = [
                        'direction' => $item->direction,
                        'sousdirection' => $item->sousdirection,
                        'designation' => $item->designation,
                        'intitule' => $item->intitule,
                        'indicateur' => $item->indicateur,
                        'responsable' => $item->responsable,
                        'cible_glo' => $item->cible_glo,
                        'cout_glo' => $item->cout_glo,

                        'cible_t1' => $item->cible_t1,
                        'cout_t1' => $item->cout_t1,
                        'valeur_t1' => $item->valeur_t1,
                        'commentaire_t1' => $item->commentaire_t1,
                        'statut' => $item->statut,
                        'observation_t1' => $item->observation_t1,
                        'livrable_t1' => $livrable_t1,

                        'cible_t2' => $item->cible_t2,
                        'cout_t2' => $item->cout_t2,
                        'valeur_t2' => $item->valeur_t2,
                        'commentaire_t2' => $item->commentaire_t2,
                        'statut2' => $item->statut2,
                        'observation_t2' => $item->observation_t2,
                        'livrable_t2' => $livrable_t2,

                        'cible_t3' => $item->cible_t3,
                        'cout_t3' => $item->cout_t3,
                        'valeur_t3' => $item->valeur_t3,
                        'commentaire_t3' => $item->commentaire_t3,
                        'statut3' => $item->statut3,
                        'observation_t3' => $item->observation_t3,
                        'livrable_t3' => $livrable_t3,

                        'cible_t4' => $item->cible_t4,
                        'cout_t4' => $item->cout_t4,
                        'valeur_t4' => $item->valeur_t4,
                        'commentaire_t4' => $item->commentaire_t4,
                        'statut4' => $item->statut4,
                        'observation_t4' => $item->observation_t4,
                        'livrable_t4' => $livrable_t4,

                        
                        'statut_final' => $item->statutf,
                        'observation_final' => $item->observation_final,
                        'commentaire_final' => $item->commentaire_final,

                        'entite_prenante' => $item->entite_prenante,
                        'action_entite' => $item->action_entite,
                        'periode_execution' => $item->periode_execution,
                        'zone_exection' => $item->zone_exection,
                     ];


               }

               //dd($dataFormatPtab);

        
        return collect($dataFormatPtab);
    }


    public function headings(): array
    {
        return [
            'Direction',
            'Sous Direction',
            'Action / Activité/ Tâche',
            'Libelllé',
            // 'Référence Matrice d\'actions Budgetisée du PSD',
            'Intitulé de l\'indicateur',
            'Responsable',
            'Cibles globales de l\'indicateur',
            'Coût globale (en millions FCFA)',

            'Cibles Trimestre 1 de l\'indicateur',
            'Coût Trimestre 1 (en millions FCFA)',
            'Valeur de l\'indicateur au trimestre 1',
            'Commentaire au trimestre 1',
            '"Etat d\'avancement au trimestre 1 (R : Réalisée; PR : Partiellement Réalisée; NR : Non Réalisée)"',
            '"Observation du livrable Trimestre 1"',
            '"livrable Trimestre 1"',

            'Cibles Trimestre 2 de l\'indicateur',
            'Coût Trimestre 2 (en millions FCFA)',
            'Valeur de l\'indicateur au trimestre 2',
            'Commentaire au trimestre 2',
            '"Etat d\'avancement au trimestre 2 (R : Réalisée; PR : Partiellement Réalisée; NR : Non Réalisée)"',
            '"Observation du livrable Trimestre 2"',
            '"livrable Trimestre 2"',

            'Cibles Trimestre 3 de l\'indicateur',
            'Coût Trimestre 3 (en millions FCFA)',
            'Valeur de l\'indicateur au trimestre 3',
            'Commentaire au trimestre 3',
            '"Etat d\'avancement au trimestre 3 (R : Réalisée; PR : Partiellement Réalisée; NR : Non Réalisée)"',
            '"Observation du livrable Trimestre 3"',
            '"livrable Trimestre 3"',

            'Cibles Trimestre 4 de l\'indicateur',
            'Coût Trimestre 4 (en millions FCFA)',
            'Valeur de l\'indicateur au trimestre 4',
            'Commentaire au trimestre 4',
            '"Etat d\'avancement au trimestre 4 (R : Réalisée; PR : Partiellement Réalisée; NR : Non Réalisée)"',
            '"Observation du livrable Trimestre 4"',
            '"livrable Trimestre 4"',

            '"Statut final"',
            '"Observation final"',
            '"Commentaire final"',

            'Entité (Direction ou Sous direction ou service ou agent)',
            'Action à réaliser',
            'Période d\'execution',
            'Zone d\'execution',
            
            ];
    }




}
