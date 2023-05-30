<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use DB;

class SearchAgentExport implements FromCollection, WithHeadings
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



        $naissance=$this->request->naissance ?? '';
        $prisedeservice=$this->request->prisedeservice ?? '';
        $retraite=$this->request->retraite ?? '';
        $genre=$this->request->genre ?? '';
        $matrimoniale=$this->request->matrimoniale ?? '';
        $diplome=$this->request->diplome ?? '';
        $niveauetude=$this->request->niveauetude ?? '';
        $categorie=$this->request->categorie ?? '';
        $statut=$this->request->statut ?? '';
        $fonction=$this->request->fonction ?? '';
        $direction=$this->request->direction ?? '';
        $sousdirection=$this->request->sousdirection ?? '';
        $service=$this->request->service ?? '';
        $nomprenoms=$this->request->nomprenoms ?? '';

        $agents =DB::table('users')
                ->join('agent_fonction', 'agent_fonction.user_id','=','users.id')
                ->leftjoin('service','agent_fonction.service_id','service.id')
                ->leftjoin('sousdirection','agent_fonction.sousdirection_id','sousdirection.id')
                ->leftjoin('direction','agent_fonction.direction_id','direction.id')
                ->leftjoin('grade','agent_fonction.level','grade.id')
                ->leftjoin('unite_exp','users.exp_unite','unite_exp.id')
                ->leftjoin('groupe_sanguin','users.groupe_sanguin','groupe_sanguin.id')
                ->leftjoin('religion','users.religion','religion.id')
               ->select(
        'users.matricule'
        ,'users.nomprenoms'
        ,'users.email'
        ,'users.email_pro'
        ,'users.genre'
        ,'users.datenaissance'
        ,'users.cnps'
        ,'users.datedepartretraite'
        ,'users.niveauetude'
        ,'users.dernierdiplome'
        ,'users.lieunaissance'
        ,'users.situationmatrimoniale'
        ,'users.nbreenfant'
        ,'users.lieuresidence'
        ,'users.telephone1'
        ,'users.telephone2'
        ,'users.personnecontacter'
        ,'users.contact'
        ,'religion.religion'
        ,'users.autre_religion'
        ,'users.exp_nbre'
        ,'unite_exp.unite'
        ,'groupe_sanguin.groupe'
        ,'agent_fonction.emploi'
        ,'agent_fonction.grade'
        ,'agent_fonction.datepriseservice'
        // ,'agent_fonction.datedefin'
        ,'agent_fonction.fonction'
        ,'agent_fonction.datenominationactuelle'
        ,'agent_fonction.datepriseserviceactuelle'
        ,'agent_fonction.statut'
        ,'agent_fonction.categorie'
        // ,'agent_fonction.service'
        // ,'agent_fonction.sousdirection'
        // ,'agent_fonction.direction'
        ,'grade.name'
        ,'direction.designation as direction_id'
        ,'sousdirection.designation as sousdirection_id '
        ,'service.designation as service_id')
               ->when($naissance, function ($query, $naissance) 
                                    {return $query->where('users.datenaissance','like','%'.$naissance.'%');}
                                        )
               ->when($prisedeservice, function ($query, $prisedeservice) 
                                    {return $query->where('agent_fonction.datepriseservice','like','%'. $prisedeservice.'%');}
                                        )
               ->when($retraite, function ($query, $retraite) 
                                    {return $query->where('users.datedepartretraite','like','%'. $retraite.'%');}
                                        )
               ->when($genre, function ($query, $genre) 
                                    {return $query->where('users.genre', $genre);}
                                        )
               ->when($matrimoniale, function ($query, $matrimoniale) 
                                    {return $query->where('users.situationmatrimoniale','like','%'. $matrimoniale.'%');}
                                        )
               ->when($diplome, function ($query, $diplome) 
                                    {return $query->where('users.dernierdiplome', $diplome);}
                                        )
               ->when($niveauetude, function ($query, $niveauetude) 
                                    {return $query->where('users.niveauetude', $niveauetude);}
                                        )
               ->when($categorie, function ($query, $categorie) 
                                    {return $query->where('agent_fonction.categorie', $categorie);}
                                        )
               ->when($statut, function ($query, $statut) 
                                    {return $query->where('agent_fonction.statut', $statut);}
                                        )
               ->when($fonction, function ($query, $fonction) 
                                    {return $query->where('agent_fonction.fonction', $fonction);}
                                        )
               ->when($direction, function ($query, $direction) 
                                    {return $query->where('agent_fonction.direction_id', $direction);}
                                        )
               ->when($sousdirection, function ($query, $sousdirection) 
                                    {return $query->where('agent_fonction.sousdirection_id', $sousdirection);}
                                        )
               ->when($service, function ($query, $service_id) 
                                    {return $query->where('agent_fonction.service_id', $service_id);}
                                        )
               ->when($nomprenoms, function ($query, $nomprenoms) 
                                    {return $query->where('users.nomprenoms','like','%'.$nomprenoms.'%');}
                                        )
               ->orderBy('users.nomprenoms', 'asc')
               ->get();
        
        return $agents;
    }


    public function headings(): array
    {
        return [
        'Matricule',
        'Nom prenoms',
        'Email personnel',
        'Email professionnel',
        'Genre',
        'Date de naissance',
        'CNPS',
        'Depart à la retraite',
        'Niveau etude',
        'Dernier diplome',
        'Lieu de naissance',
        'Situation matrimoniale',
        'Nbre enfant',
        'Lieu de naissance',
        'telephone 1',
        'telephone 2',
        'Personne à contacter',
        'Contact',
        'Religion',
        'Autre religion',
        'Experience pro',
        'Unite experience pro',
        'Groupe sanguin',
        'Emploi',
        'grade',
        'Date de prise de service',
        'fonction',
        'Date de nomination actuelle',
        'Date de prise de service fonction actuelle',
        'Sattut',
        'Catégorie',
        // 'Service',
        // 'Sous direction / Agence',
        // 'Direction / Cabinet',
        'Level',
        'Direction / Cabinet',
        'Sous direction / Agence',
        'Servcie / Guichet'
            ];
    }




}
