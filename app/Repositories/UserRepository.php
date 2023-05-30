<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

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


class UserRepository
{

      public function countAgentByParam($categorie,$statut,$genre,$direction_id,$sousdirection_id,$service_id,$state)
    {

        $agent =DB::table('users')
               ->join('agent_fonction','users.id','agent_fonction.user_id')
    
               ->when($categorie, function ($query, $categorie) 
                                    {return $query->where('agent_fonction.categorie', $categorie);}
                                        )
               ->when($statut, function ($query, $statut) 
                                    {return $query->where('agent_fonction.statut', $statut);}
                                        )
               ->when($genre, function ($query, $genre) 
                                    {return $query->where('users.genre', $genre);}
                                        )
               ->when($direction_id, function ($query, $direction_id) 
                                    {return $query->where('agent_fonction.direction_id', $direction_id);}
                                        )
               ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                    {return $query->where('agent_fonction.sousdirection_id', $sousdirection_id);}
                                        )
               ->when($service_id, function ($query, $service_id) 
                                    {return $query->where('agent_fonction.service_id', $service_id);}
                                        )
               ->when($state, function ($query, $state) 
                                    {return $query->where('users.state', $state);}
                                        )
               ->whereNull('users.state')
               ->count();

          //dd($agent);  
         return $agent;
  
    }


    public function addUser($request)
    {

        //dd($request);
        $matricule=$request->get('matricule');
        $nom=$request->get('nom');
        $prenom=$request->get('prenom');
        $email=$request->get('email');
        $email_pro=$request->get('email_pro');
        $sexe=$request->get('sexe');
        $naissance=$request->get('naissance');
        $cnps=$request->get('cnps');
        $newYear = new Carbon($naissance);
        $datedepartretraite=$newYear->addYears(60);
        $niveauetude=$request->get('niveauetude');
        $diplome=$request->get('diplome');
        $lieunaissance=$request->get('lieu');
        $matrimonial=$request->get('matrimonial');
        $residence=$request->get('residence');
        $tel1=$request->get('tel1');
        $tel2=$request->get('tel2');
        $nom_pc=$request->get('nom_pc');
        $contact_pc=$request->get('contact_pc');

        $religion=$request->get('religion');
        $autre_religion=$request->get('autre_religion');
        $exp_nbre=$request->get('exp_nbre');
        $exp_unite=$request->get('exp_unite');
        $groupe_sanguin=$request->get('groupe_sanguin');
        $nbreenfant=$request->get('nbreenfant');

        
        //dd($datedepartretraite, $naissance);
        
        
        $agent = new User();

                $agent->matricule = $matricule;
                $agent->nomprenoms = $nom.' '.$prenom;
                $agent->email =  $email;
                $agent->email_pro =  $email_pro;
                $agent->password = bcrypt('123456');
                $agent->genre =  $sexe;
                $agent->datenaissance =  $naissance;
                $agent->cnps =  $cnps;
                $agent->datedepartretraite =  $datedepartretraite ?? '';
                $agent->niveauetude =  $niveauetude;
                $agent->dernierdiplome =  $diplome;
                $agent->lieunaissance=  $lieunaissance;
                $agent->situationmatrimoniale =  $matrimonial;
                $agent->nbreenfant=  $nbreenfant;
                $agent->lieuresidence=  $residence;
                $agent->telephone1 = $tel1;
                $agent->telephone2 = $tel2;
                $agent->personnecontacter = $nom_pc;
                $agent->contact = $contact_pc;

                $agent->religion=  $religion;
                $agent->autre_religion = $autre_religion;
                $agent->exp_nbre = $exp_nbre;
                $agent->exp_unite = $exp_unite;
                $agent->groupe_sanguin = $groupe_sanguin;
                $agent->state = 0;

                $agent->save();
    
       return $agent->id;
    }


    public function editUser($request)
    {

        //dd($request);
        $data = [];
        $user_id=$request->get('user_id');
        if(request()->has("matricule")){$data['matricule'] = $request->matricule;}
        if(request()->has("nom")){$data['nomprenoms'] = $request->nom;}

        if(request()->has("email")){$data['email'] = $request->email;}
        if(request()->has("email_pro")){$data['email_pro'] = $request->email_pro;}
        if(request()->has("sexe")){$data['genre'] = $request->sexe;}
        if(request()->has("naissance")){$data['datenaissance'] = $request->naissance;}
        if(request()->has("cnps")){$data['cnps'] = $request->cnps;}
        if(request()->has("niveauetude")){$data['niveauetude'] = $request->niveauetude;}
        if(request()->has("diplome")){$data['dernierdiplome'] = $request->diplome;}
        if(request()->has("lieu")){$data['lieunaissance'] = $request->lieu;}
        if(request()->has("matrimonial")){$data['situationmatrimoniale'] = $request->matrimonial;}
        if(request()->has("residence")){$data['lieuresidence'] = $request->residence;}
        if(request()->has("tel1")){$data['telephone1'] = $request->tel1;}
        if(request()->has("tel2")){$data['telephone2'] = $request->tel2;}
        if(request()->has("nom_pc")){$data['personnecontacter'] = $request->nom_pc;}
        if(request()->has("contact_pc")){$data['contact'] = $request->contact_pc;}
        if(request()->has("groupe_sanguin")){$data['groupe_sanguin'] = $request->groupe_sanguin;}
        if(request()->has("religion")){$data['religion'] = $request->religion;}
        if(request()->has("autre_religion")){$data['autre_religion'] = $request->autre_religion;}
        if(request()->has("exp_nbre")){$data['exp_nbre'] = $request->exp_nbre;}
        
        if(request()->has("exp_unite")){
            $data['exp_unite'] = $request->exp_unite;
        }

        if ($request->has('poste')) {
            $data_agent_fonction['fonction'] = $request->poste;
        }

         if ($request->has('emploi')) {
            $data_agent_fonction['emploi'] = $request->emploi;
        }

        if($request->direction != null || $request->direction > 0){
        
            $direction = DB::table('direction')->where('id',$request->direction)->first();
            $data_agent_fonction['direction'] = $direction->designation;
            $data_agent_fonction['direction_id'] = $direction->id;
        }

        if($request->sousdirection != null || $request->sousdirection > 0){
        
            $sousdirection = DB::table('sousdirection')->where('id',$request->sousdirection)->first();
            $data_agent_fonction['sousdirection'] = $sousdirection->designation;
            $data_agent_fonction['sousdirection_id'] = $sousdirection->id;
        }

        if($request->service != null || $request->service > 0){
            
            $service = DB::table('service')->where('id',$request->service)->first();
            $data_agent_fonction['service'] = $service->designation;
            $data_agent_fonction['service_id'] = $service->id;
        }

       $agent_fonction =  DB::table('agent_fonction')->where('user_id',$user_id)->update($data_agent_fonction);
        // if(request()->has("nom")){$data['nom'] = $request->nom;}
        // if(request()->has("nom")){$data['nom'] = $request->nom;}
        
        

        // $matricule=$request->get('matricule');
        // $nom=$request->get('nom');
        // $email=$request->get('email');
        // $email_pro=$request->get('email_pro');
        // $sexe=$request->get('sexe');
        // $naissance=$request->get('naissance');
        // $cnps=$request->get('cnps');
        // $niveauetude=$request->get('niveauetude');
        // $diplome=$request->get('diplome');
        // $lieunaissance=$request->get('lieu');
        // $matrimonial=$request->get('matrimonial');
        // $residence=$request->get('residence');
        // $tel1=$request->get('tel1');
        // $tel2=$request->get('tel2');
        // $nom_pc=$request->get('nom_pc');
        // $contact_pc=$request->get('contact_pc');
        // $groupe_sanguin=$request->get('groupe_sanguin');
        // $religion=$request->get('religion');
        // $autre_religion=$request->get('autre_religion');
        // $exp_nbre=$request->get('exp_nbre');
        // $exp_unite=$request->get('exp_unite');
        
        DB::table('users')
                ->where('id', $user_id)
                ->update($data);
    }


     public function editpassword($request)
    {

        //dd($request);
        $motdepasse=$request->get('motdepasse');
        $cmotdepasse=$request->get('cmotdepasse');
        $user_id=$request->get('user_id');
        $password = bcrypt($motdepasse);
        
        DB::table('users')
                        ->where('id', $user_id)
                        ->update([
                            'password' => $password
                        ]);
    }


    public function addUserFunction($request,$uid)
    {

        //dd($uid,$request);
        
            $emploi=$request->get('emploi');
            $grade=$request->get('grade');
            $datepriseservice=$request->get('datedebut');
            $datedefin=$request->get('datedefin') ?? '';
            $fonction=$request->get('poste');
            $statut=$request->get('statut');
            $categorie=$request->get('categorie');
            $level=$request->get('level');
            $direction_id=$request->get('direction');
            $sousdirection_id=$request->get('sousdirection');
            $service_id=$request->get('service');

            $datenominationactuelle=$request->get('datenominationactuelle');
            $datepriseserviceactuelle=$request->get('datepriseserviceactuelle');
            
            $function = new Agent_fonction();

            $function->user_id =  $uid;
            $function->emploi =  $emploi;
            $function->grade =  $grade;
            $function->datepriseservice = $datepriseservice;
            $function->datedefin = $datedefin;
            $function->fonction =  $fonction;
            $function->datenominationactuelle = $datenominationactuelle;
            $function->datepriseserviceactuelle = $datepriseserviceactuelle;
            $function->statut =  $statut;
            $function->categorie =  $categorie;
            $function->service=  '';
            $function->sousdirection=  '';
            $function->direction = '';
            $function->level = $level;
            $function->service_id=  $service_id;
            $function->sousdirection_id=  $sousdirection_id;
            $function->direction_id = $direction_id;


        $function->save();
        
    }

    public function editUserFunction($request)
    {

        //dd($request);
        $user_id=$request->get('user_id');
        $emploi=$request->get('emploi');
        $grade=$request->get('grade');
        $datepriseservice=$request->get('datedebut');
        $datedefin=$request->get('datedefin') ?? '';
        $fonction=$request->get('poste');
        $statut=$request->get('statut');
        $categorie=$request->get('categorie');
        $level=$request->get('level');
        $direction_id=$request->get('direction');
        $sousdirection_id=$request->get('sousdirection');
        $service_id=$request->get('service');

        //dd($emploi,$user_id,$level);
        
         DB::table('agent_fonction')
                        ->where('user_id', $user_id)
                        ->update([
                            'emploi' => $emploi,
                            'grade' => $grade,
                            'datepriseservice' => $datepriseservice,
                            'datedefin' => $datedefin,
                            // 'fonction' => $fonction,
                            'statut' => $statut,
                            // 'categorie' => $categorie,
                            'level' => $level,
                            'service_id' => $service_id,
                            'sousdirection_id' => $sousdirection_id,
                            'direction_id' => $direction_id
                        ]);
        
    }

    public function editUserPtab($request)
    {

        $nom=$request->get('nom');
        $direction_id=$request->get('direction');
        $sousdirection_id=$request->get('sousdirection');
        $service_id=$request->get('service');
        
            DB::table('action')
                        ->where('responsable', $nom)
                        ->update([
                            'service_id' => $service_id,
                            'sousdirection_id' => $sousdirection_id,
                            'direction_id' => $direction_id
                        ]);
        
    }


     public function addFiliation($request, $cni,$photo,$accte_mariage, $acte_naissance)
    {

        //dd($request);
        $user_id=$request->get('user_id');
        $nom=$request->get('nom');
        $prenom=$request->get('prenom');
        $naissance=$request->get('naissance');
        $tel1=$request->get('tel1');
        $tel2=$request->get('tel2');
        $type_filiation=$request->get('filiation');
        $type_piece=$request->get('piece');
        $numero=$request->get('numero');

        
        $filiation = new Filiation();

        $filiation->user_id = $user_id;
        $filiation->type_piece =  $type_piece;
        $filiation->type_filiation = $type_filiation;
        $filiation->fname =  $nom;
        $filiation->lname =  $prenom;
        $filiation->telephone2 =  $tel2;
        $filiation->telephone1 =  $tel1;
        $filiation->fichier_piece = $cni;
        $filiation->fichier_photo = $photo;
        $filiation->fichier_acte_mariage= $accte_mariage;
        $filiation->fichier_acte_naissance= $acte_naissance;
        $filiation->state = 0;

        $filiation->save();
    
       return $filiation->id;
    }

    public function addAgentDoc($request,$nom,$docfile)
    {

        //dd($request);
        $user_id=$request->get('user_id');
        $file_type=$request->get('file_type'); 
        
        $doc = new Agent_document();

        $doc->user_id = $user_id;
        $doc->type_document = $file_type;
        $doc->nom =  $nom;
        $doc->fichier_doc = $docfile;
        $doc->state = 1;

        $doc->save();
    
       return $doc->id;
    }



    public function getAgentByUser($nom,$direction_id,$sousdirection_id,$service_id,$state)
    {

        $agents =DB::table('users')
                ->join('agent_fonction', 'agent_fonction.user_id','=','users.id')
               ->select('users.nomprenoms','users.id','users.datenaissance','users.telephone1','users.telephone2','users.matricule','users.email','agent_fonction.datepriseservice','agent_fonction.service','agent_fonction.sousdirection','agent_fonction.direction','agent_fonction.fonction','agent_fonction.direction_id','agent_fonction.service_id','agent_fonction.sousdirection_id')
               ->when($direction_id, function ($query, $direction_id) 
                                    {return $query->where('agent_fonction.direction_id', $direction_id);}
                                        )
               ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                    {return $query->where('agent_fonction.sousdirection_id', $sousdirection_id);}
                                        )
               ->when($service_id, function ($query, $service_id) 
                                    {return $query->where('agent_fonction.service_id', $service_id);}
                                        )
               ->when($state, function ($query, $state) 
                                    {return $query->where('users.state', $state);}
                                        )
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
               ->paginate(20);
       
       
         return $agents;
  
    }


     public function getAgentBySearch($request)
    {
        //dd($request);
        $naissance=$request['naissance'] ?? '';
        $prisedeservice=$request['prisedeservice'] ?? '';
        $retraite=$request['retraite'] ?? '';
        $genre=$request['genre'] ?? '';
        $matrimoniale=$request['matrimoniale'] ?? '';
        $diplome=$request['diplome'] ?? '';
        $niveauetude=$request['niveauetude'] ?? '';
        $categorie=$request['categorie'] ?? '';
        $statut=$request['statut'] ?? '';
        $fonction=$request['fonction'] ?? '';
        $direction=$request['direction'] ?? '';
        $sousdirection=$request['sousdirection'] ?? '';
        $service=$request['service'] ?? '';
        $nomprenoms=$request['nomprenoms'] ?? '';

        $agents =DB::table('users')
                ->join('agent_fonction', 'agent_fonction.user_id','=','users.id')
               ->select('users.nomprenoms','users.id','users.telephone1','users.telephone2','users.matricule','agent_fonction.service','agent_fonction.sousdirection','agent_fonction.direction','agent_fonction.service_id','agent_fonction.sousdirection_id','agent_fonction.direction_id','agent_fonction.fonction')
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
                                    {return $query->where('users.situationmatrimoniale','like','%'.$matrimoniale.'%');}
                                        )
               ->when($diplome, function ($query, $diplome) 
                                    {return $query->whereIn('users.dernierdiplome', $diplome);}
                                        )
               ->when($niveauetude, function ($query, $niveauetude) 
                                    {return $query->whereIn('users.niveauetude', $niveauetude);}
                                        )
               ->when($categorie, function ($query, $categorie) 
                                    {return $query->whereIn('agent_fonction.categorie', $categorie);}
                                        )
               ->when($statut, function ($query, $statut) 
                                    {return $query->where('agent_fonction.statut', $statut);}
                                        )
               ->when($fonction, function ($query, $fonction) 
                                    {return $query->whereIn('agent_fonction.fonction', $fonction);}
                                        )
               ->when($direction, function ($query, $direction) 
                                    {return $query->whereIn('agent_fonction.direction_id', $direction);}
                                        )
               ->when($sousdirection, function ($query, $sousdirection) 
                                    {return $query->whereIn('agent_fonction.sousdirection_id', $sousdirection);}
                                        )
               ->when($service, function ($query, $service) 
                                    {return $query->whereIn('agent_fonction.service_id', $service);}
                                        )
               ->when($nomprenoms, function ($query, $nomprenoms) 
                                    {return $query->where('users.nomprenoms','like','%'.$nomprenoms.'%');}
                                        )
               ->when($nomprenoms, function ($query, $nomprenoms) 
                                    {return $query->orwhere('users.matricule','like','%'.$nomprenoms.'%');}
                                        )
               ->orderBy('users.nomprenoms', 'asc')
               ->paginate(20);
       
       //dd($agents);
         return $agents;
  
    }

    public function countAgentBySearch($request)
    {
        //dd($request);
        $naissance=$request['naissance'] ?? '';
        $prisedeservice=$request['prisedeservice'] ?? '';
        $retraite=$request['retraite'] ?? '';
        $genre=$request['genre'] ?? '';
        $matrimoniale=$request['matrimoniale'] ?? '';
        $diplome=$request['diplome'] ?? '';
        $niveauetude=$request['niveauetude'] ?? '';
        $categorie=$request['categorie'] ?? '';
        $statut=$request['statut'] ?? '';
        $fonction=$request['fonction'] ?? '';
        $direction=$request['direction'] ?? '';
        $sousdirection=$request['sousdirection'] ?? '';
        $service=$request['service'] ?? '';
        $nomprenoms=$request['nomprenoms'] ?? '';

        $agents =DB::table('users')
                ->join('agent_fonction', 'agent_fonction.user_id','=','users.id')
               ->select('users.nomprenoms','users.id','users.telephone1','users.telephone2','users.matricule','agent_fonction.service','agent_fonction.sousdirection','agent_fonction.direction','agent_fonction.service_id','agent_fonction.sousdirection_id','agent_fonction.direction_id','agent_fonction.fonction')
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
                                    {return $query->where('users.situationmatrimoniale','like','%'.$matrimoniale.'%');}
                                        )
               ->when($diplome, function ($query, $diplome) 
                                    {return $query->whereIn('users.dernierdiplome', $diplome);}
                                        )
               ->when($niveauetude, function ($query, $niveauetude) 
                                    {return $query->whereIn('users.niveauetude', $niveauetude);}
                                        )
               ->when($categorie, function ($query, $categorie) 
                                    {return $query->whereIn('agent_fonction.categorie', $categorie);}
                                        )
               ->when($statut, function ($query, $statut) 
                                    {return $query->where('agent_fonction.statut', $statut);}
                                        )
               ->when($fonction, function ($query, $fonction) 
                                    {return $query->whereIn('agent_fonction.fonction', $fonction);}
                                        )
               ->when($direction, function ($query, $direction) 
                                    {return $query->whereIn('agent_fonction.direction_id', $direction);}
                                        )
               ->when($sousdirection, function ($query, $sousdirection) 
                                    {return $query->whereIn('agent_fonction.sousdirection_id', $sousdirection);}
                                        )
               ->when($service, function ($query, $service_id) 
                                    {return $query->whereIn('agent_fonction.service_id', $service_id);}
                                        )
               ->when($nomprenoms, function ($query, $nomprenoms) 
                                    {return $query->where('users.nomprenoms','like','%'.$nomprenoms.'%');}
                                        )
               ->when($nomprenoms, function ($query, $nomprenoms) 
                                    {return $query->orwhere('users.matricule','like','%'.$nomprenoms.'%');}
                                        )
               ->count();
       
       //dd($agents);
         return $agents;
  
    }


    public function getAgentById($id)
    {

        $agent =DB::table('users')
                ->join('agent_fonction', 'agent_fonction.user_id','=','users.id')
               ->select('users.nomprenoms','users.id','users.telephone1','users.telephone2','users.matricule','users.email','users.email_pro','users.genre','users.datenaissance','users.situationmatrimoniale','users.lieuresidence','users.lieunaissance','users.personnecontacter','users.photodeprofil','agent_fonction.service','agent_fonction.sousdirection','agent_fonction.direction','agent_fonction.direction_id','agent_fonction.service_id','agent_fonction.sousdirection_id','agent_fonction.fonction','agent_fonction.emploi','users.cnps','agent_fonction.statut','agent_fonction.datepriseservice','users.datedepartretraite','agent_fonction.datedefin','agent_fonction.categorie','users.niveauetude','users.dernierdiplome','users.personnecontacter','users.contact','agent_fonction.level','users.religion','users.autre_religion','users.exp_nbre','users.exp_unite','users.groupe_sanguin','agent_fonction.datenominationactuelle','agent_fonction.datepriseserviceactuelle')
               ->where('users.id', $id)
               ->orderBy('agent_fonction.id', 'desc')
               ->first();
       
       
         return $agent;
  
    }

    public function getAgentDocsById($id,$type)
    {

        $agent =DB::table('agent_document')
               ->select('agent_document.id','agent_document.nom','agent_document.fichier_doc','agent_document.user_id')
               ->where('agent_document.user_id', $id)
               ->where('agent_document.type_document', $type)
               ->get();
       
       
         return $agent;
  
    }

     public function getAgentFiliationById($id)
    {

        $agent =DB::table('agent_filiation')
               ->select('agent_filiation.fname','agent_filiation.lname','agent_filiation.telephone1','agent_filiation.user_id','agent_filiation.type_filiation','agent_filiation.type_piece','agent_filiation.telephone2','agent_filiation.fichier_piece','agent_filiation.fichier_photo','agent_filiation.fichier_acte_mariage','agent_filiation.fichier_acte_naissance')
               ->where('agent_filiation.user_id', $id)
               ->get();
       
         return $agent;
  
    }


     public function getAgentFunctionById($id)
    {

        $fonction =DB::table('agent_fonction')
               ->select('agent_fonction.direction_id','agent_fonction.sousdirection_id','agent_fonction.service_id','agent_fonction.emploi','agent_fonction.datepriseservice','agent_fonction.fonction')
               ->where('agent_fonction.user_id', $id)
               ->orderBy('agent_fonction.id','desc')
               ->get();
       
       
         return $fonction;
  
    }


 
}