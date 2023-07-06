<!DOCTYPE html>
<html lang="en">
@php
use Carbon\Carbon;

$current = Carbon::now();
$active="active";
$open="open";
$show="show";
$d="#";
$page="parametre";
$sm="agent";
$total=0;

$agent_function = Session::get('function_key');
$direction_=$agent_function->direction_id;

$demandeur_function = getAgentById($agent->id);
$prisedeservice = $demandeur_function->datepriseservice;
$statut= $demandeur_function->statut;
$genre= $demandeur_function->genre;

$datenaissance=$demandeur_function->datenaissance;
$naissance = Carbon::create($datenaissance);
$debutservice=$demandeur_function->datepriseservice;
$debut_service=Carbon::create($debutservice);

$age=round($naissance->diffInDays($current) / 365);
$anciennete=round($debut_service->diffInDays($current) / 365);
$enfant=0;
$jourutilise=getjourdeconge($agent->id,'CONGE');

 if($statut == 'CONTRACTUEL'){
             $total=26;
          }else{
             $total=30;
          }

if($anciennete >= 5 && $anciennete < 10){

             $total=$total + 1;
          }elseif($anciennete >= 10 && $anciennete < 15){

            $total=$total + 2;
          }elseif($anciennete >= 15 && $anciennete < 20){

            $total=$total + 3;
          }elseif($anciennete >= 20 && $anciennete < 25){

            $total=$total + 5;
          }elseif($anciennete >= 25 && $anciennete < 30){

            $total=$total + 7;
          }elseif($anciennete > 30 ){
            $total=$total + 8;
          }

if($genre == 'F' && $age <= 21){
            $total = $total + ( $enfant * 2 ) ;
          }elseif($genre == 'F' && $age > 21){
                             if($enfant >= 4){
                              $total = $total + ( ($enfant - 3) * 2 );
                                           }
          }

$nbrejourrestant=$total - $jourutilise;
//dd($total,$jourutilise,$nbrejourrestant);
@endphp
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>profile Agent</title>

  <!-- Favicons -->
  <link href="{{asset('img/favicon.png')}}" rel="icon">
  <link href="{{asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="{{asset('lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <!--external css-->
  <link href="{{asset('lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="{{asset('css/style.css')}}" rel="stylesheet">
  <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="{{asset('lib/bootstrap-fileupload/bootstrap-fileupload.css')}}" />


  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->
</head>

<body>
  <section id="container">
    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header orange-bg">
      <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
      <!--logo start-->
      <a href="{{ route('super.dashboard') }}" class="logo"><b>DRH<span>AJA</span></b></a>
      <!--logo end-->

      <div class="top-menu">
        <ul class="nav pull-right top-menu">
          <li><a class="logout" href="{{ route('Logout') }}">Deconnexion</a></li>
        </ul>
      </div>
    </header>
    <!--header end-->
    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
     @include('Templates.aside')
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper site-min-height">
        <div class="row mt">
          <div class="col-lg-12">
            <div class="row content-panel">
              <div class="col-md-4 profile-text mt mb centered">
                <div class="right-divider hidden-sm hidden-xs">
                  <h5 >{{$agent->statut}}</h5>
                  <h6>Statut</h6>
                  <h5>
                    @if($agent->datepriseservice)
                     {{format_date($agent->datepriseservice)}}
                    @endif
                </h5>
                  <h6>Date de Prise de serveice</h6>
                  <h5>
                    @if($agent->datedepartretraite)
                     {{format_date($agent->datedepartretraite)}}
                    @endif
                  </h5>
                  <h6>Date de retraite</h6>
                  <h5>
                    @if($agent->datenominationactuelle)
                     {{format_date($agent->datenominationactuelle)}}
                    @endif
                  </h5>
                  <h6>Date de nomination dans la fonction actuelle</h6>
                  <h5>
                    @if($agent->datepriseserviceactuelle)
                     {{format_date($agent->datepriseserviceactuelle)}}
                    @endif
                  </h5>
                  <h6>Date de prise de service dans la fonction actuelle</h6>
                   <!-- <h5>
                    @if($agent->datedefin)
                     {{format_date($agent->datedefin)}}
                     @elseif($agent->datedepartretraite)
                     {{format_date($agent->datedepartretraite)}}
                    @endif
                </h5>
                  <h6>Date de fin</h6> -->
                </div>
              </div>
              <!-- /col-md-4 -->
              <div class="col-md-4 profile-text text-center" >
                <h3>{{$agent->nomprenoms}} ({{$agent->fonction}})</h3>

                <h6>
                  @if($agent->direction_id )
                  {{getInstanceName('direction','id',$agent->direction_id,'designation')}}
                  @endif
                  /  @if($agent->sousdirection_id)
                  {{getInstanceName('sousdirection','id',$agent->sousdirection_id,'designation')}}
                  @endif
                  /  @if($agent->service_id)
                  {{getInstanceName('service','id',$agent->service_id,'designation')}}
                  @endif
                </h6>
                <br>
                <p>{{$agent->email}} / ({{$agent->telephone1}})</p>
                <br>
               <!--  <p><button class="btn btn-theme"><i class="fa fa-envelope"></i> Send Message</button></p> -->
              </div>
              <!-- /col-md-4 -->
              <div class="col-md-4 centered">
                <div class="profile-pic">
                  <p><a href="#" data-toggle="modal" data-target="#myModal">
                    @if($agent->photodeprofil)
                    <img src="{{asset('docs/'.$agent->photodeprofil)}}" class="img-circle">
                    @else
                    <img src="{{asset('img/user.png')}}" class="img-circle">
                   @endif
                 </a></p>
                  <p>
                   <!--  <button class="btn btn-theme"><i class="fa fa-check"></i> Follow</button>
                    <button class="btn btn-theme02">Add</button> -->
                  </p>
                </div>
              </div>
               @if (session('success'))
                     <div class="form-group ">
                      <div class="col-xs-12">
                        <div class="alert alert-success">
                               {{ session('success') }}
                        </div>
                      </div>
                    </div>
                @endif
                 @if (session('error'))
                     <div class="form-group ">
                      <div class="col-xs-12">
                        <div class="alert alert-danger">
                               {{ session('error') }}
                        </div>
                      </div>
                    </div>
            @endif
              <!-- /col-md-4 -->
            </div>
            <!-- /row -->
          </div>
          <!-- /col-lg-12 -->

          <div class="col-lg-12 mt">
            <div class="row content-panel">
              <div class="panel-heading">
                <ul class="nav nav-tabs nav-justified">

                  <li class="active">
                    <a data-toggle="tab" href="#profil" class="">Profil</a>
                  </li>
                  <li>
                    <a data-toggle="tab" href="#conge" class="">Congés / Absences</a>
                  </li>
                  <li>
                    <a data-toggle="tab" href="#contact" class="contact-map">Filiation</a>
                  </li>
                  <li>
                    <a data-toggle="tab" href="#parcours" class="parcours-map">Parcours</a>
                  </li>
                   <li >
                    <a data-toggle="tab" href="#overview">Documents</a>
                  </li>
                  <li>
                    <a data-toggle="tab" href="#motdepasse_tab" class="contact-map">Mot de passe</a>
                  </li>
                 <!--  <li>
                    <a data-toggle="tab" href="#edit">Modifier Profile</a>
                  </li> -->
                </ul>
              </div>
              <!-- /panel-heading -->
              <div class="panel-body">
                <div class="tab-content">
                  <div id="overview" class="tab-pane">
                    <div class="row">
                      <div class="col-md-6 detailed">
                        <h4>Documents à l'embauche </h4>
                      <table class="table table-striped table-advance table-hover">
                        <thead>
                          <tr>
                            <th>Designation</th>
                            <th class="hidden-phone"><i class="fa fa-download"></i> Télécharger</th>
                            <th><a class="btn btn-warning btn-round" href="#" data-toggle="modal" data-target="#mycv" >Ajouter un cv</a></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($doc_embauches as $doc_embauche)
                          <tr>
                            <td>
                              <a>{{$doc_embauche->nom}}</a>
                            </td>
                            <td class="hidden-phone">
                            <a href="{{asset('docs/'.$doc_embauche->fichier_doc)}}" target="_blank"><button class="btn btn-warning btn-xs"><i class="fa fa-download"></i></button></a>
                            </td>
                            <td>
                              <button class="btn btn-danger btn-xs" onclick="deleteDocument({{$doc_embauche->id}})"><i class="fa fa-trash-o"></i></button>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>

                      <br>

                      <h4>Documents de santé</h4>

                      <table class="table table-striped table-advance table-hover">

                        <thead>
                          <tr>
                            <th>Designation</th>
                            <th class="hidden-phone"><i class="fa fa-download"></i> Télécharger</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($doc_santes as $doc_sante)
                          <tr>
                            <td>
                              <a>{{$doc_sante->nom}}</a>
                            </td>
                            <td class="hidden-phone">
                            <a href="{{asset('docs/'.$doc_sante->fichier_doc)}}" target="_blank"><button class="btn btn-warning btn-xs"><i class="fa fa-download"></i></button></a>
                            </td>
                            <td>
                              <button class="btn btn-danger btn-xs" onclick="deleteDocument({{$doc_sante->id}})"><i class="fa fa-trash-o"></i></button>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <br>

                      <h4>Documents des Sanctions disciplinaires</h4>

              <table class="table table-striped table-advance table-hover">

                <thead>
                  <tr>
                    <th>Designation</th>
                    <th class="hidden-phone"><i class="fa fa-download"></i> Télécharger</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                   @foreach($doc_disciplines as $doc_discpline)
                          <tr>
                            <td>
                              <a>{{$doc_discpline->nom}}</a>
                            </td>
                            <td class="hidden-phone">
                            <a href="{{asset('docs/'.$doc_discpline->fichier_doc)}}" target="_blank"><button class="btn btn-warning btn-xs"><i class="fa fa-download"></i></button></a>
                            </td>
                            <td>
                              <button class="btn btn-danger btn-xs" onclick="deleteDocument({{$doc_discpline->id}})"><i class="fa fa-trash-o"></i></button>
                            </td>
                          </tr>
                          @endforeach
                </tbody>
              </table>

                      <br>

                      <h4>Autres Documents</h4>

              <table class="table table-striped table-advance table-hover">

                <thead>
                  <tr>
                    <th>Designation</th>
                    <th class="hidden-phone"><i class="fa fa-download"></i> Télécharger</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                   @foreach($doc_autres as $doc_autre)
                          <tr>
                            <td>
                              <a>{{$doc_autre->nom}}</a>
                            </td>
                            <td class="hidden-phone">
                            <a href="{{asset('docs/'.$doc_autre->fichier_doc)}}" target="_blank"><button class="btn btn-warning btn-xs"><i class="fa fa-download"></i></button></a>
                            </td>
                            <td>
                              <button class="btn btn-danger btn-xs" onclick="deleteDocument({{$doc_autre->id}})"><i class="fa fa-trash-o"></i></button>
                            </td>
                          </tr>
                          @endforeach
                </tbody>
              </table>

                </div>
                      <!-- /col-md-6 -->
                      <div class="col-md-6 detailed">
                        <h4>Document de relation de travail</h4>

                      <table class="table table-striped table-advance table-hover">
                          <thead>
                            <tr>
                              <th>Designation</th>
                              <th class="hidden-phone"><i class="fa fa-download"></i> Télécharger</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                             @foreach($rel_travails as $rel_travail)
                          <tr>
                            <td>
                              <a>{{$rel_travail->nom}}</a>
                            </td>
                            <td class="hidden-phone">
                            <a href="{{asset('docs/'.$rel_travail->fichier_doc)}}" target="_blank"><button class="btn btn-warning btn-xs"><i class="fa fa-download"></i></button></a>
                            </td>
                            <td>
                              <button class="btn btn-danger btn-xs" onclick="deleteDocument({{$rel_travail->id}})"><i class="fa fa-trash-o"></i></button>
                            </td>
                          </tr>
                          @endforeach
                          </tbody>
                   </table>
                   <br>

                   <h4>Documents de formation</h4>

                      <table class="table table-striped table-advance table-hover">

                        <thead>
                          <tr>
                            <th>Designation</th>
                            <th class="hidden-phone"><i class="fa fa-download"></i> Télécharger</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                           @foreach($doc_formations as $doc_formation)
                          <tr>
                            <td>
                              <a>{{$doc_formation->nom}}</a>
                            </td>
                            <td class="hidden-phone">
                            <a href="{{asset('docs/'.$doc_formation->fichier_doc)}}" target="_blank"><button class="btn btn-warning btn-xs"><i class="fa fa-download"></i></button></a>
                            </td>
                            <td>
                              <button class="btn btn-danger btn-xs" onclick="deleteDocument({{$doc_formation->id}})"><i class="fa fa-trash-o"></i></button>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>

                      <br>

                      <h4>Documents de banque</h4>

                      <table class="table table-striped table-advance table-hover">

                        <thead>
                          <tr>
                            <th>Designation</th>
                            <th class="hidden-phone"><i class="fa fa-download"></i> Télécharger</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                           @foreach($doc_banques as $doc_banque)
                                  <tr>
                                    <td>
                                      <a>{{$doc_banque->nom}}</a>
                                    </td>
                                    <td class="hidden-phone">
                                    <a href="{{asset('docs/'.$doc_banque->fichier_doc)}}" target="_blank"><button class="btn btn-warning btn-xs"><i class="fa fa-download"></i></button></a>
                                    </td>
                                    <td>
                                      <button class="btn btn-danger btn-xs" onclick="deleteDocument({{$doc_banque->id}})"><i class="fa fa-trash-o"></i></button>
                                    </td>
                                  </tr>
                            @endforeach
                        </tbody>
                      </table>

                      <br>

                      <h4>Fiche de poste</h4>

                      <table class="table table-striped table-advance table-hover">

                        <thead>
                          <tr>
                            <th>Designation</th>
                            <th class="hidden-phone"><i class="fa fa-download"></i> Télécharger</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                           @foreach($doc_postes as $doc_poste)
                                  <tr>
                                    <td>
                                      <a>{{$doc_poste->nom}}</a>
                                    </td>
                                    <td class="hidden-phone">
                                    <a href="{{asset('docs/'.$doc_poste->fichier_doc)}}" target="_blank"><button class="btn btn-warning btn-xs"><i class="fa fa-download"></i></button></a>
                                    </td>
                                    <td>
                                      <button class="btn btn-danger btn-xs" onclick="deleteDocument({{$doc_poste->id}})"><i class="fa fa-trash-o"></i></button>
                                    </td>
                                  </tr>
                            @endforeach
                        </tbody>
                      </table>

                      </div>
                      <!-- /col-md-6 -->
                    </div>
                    <!-- /OVERVIEW -->
                  </div>
 <!-- /Profil -->
                  <div id="profil" class="tab-pane active">
                    <div class="row">
                      <div class="col-md-12 detailed">
                        <h4>Informations</h4>
 <br>
                  <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('update.agent') }}">
                             {{ csrf_field() }}

                <div class="form-group">
                  <input type="hidden" name="user_id" value="{{$agent->id}}"/>
                  <label class="col-sm-2 col-sm-2 control-label">Nom & prénoms <span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="nom" value="{{$agent->nomprenoms}}" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'readonly';} ?> />
                  </div>


                   <label class="col-sm-1 col-sm-2 control-label"> genre <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <select class="form-control" name="sexe" required="" >
                        <option value="M" <?php if($agent->genre=='M'){ echo 'selected'; } ?>>Masculin</option>
                         <option value="F" <?php if($agent->genre=='F'){ echo 'selected'; } ?>>Feminin</option>
                    </select>
                  </div>
                </div>
<br>
                <div class="form-group">

                  <label class="col-sm-2 control-label">Date de naissance <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <input type="date" class="form-control" id="naissance" name="naissance" value="{{format_date2($agent->datenaissance)}}" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>/>
                  </div>
                  <label class="col-sm-2 col-sm-2 control-label">Lieu de naissance <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="lieu" name="lieu" value="{{$agent->lieunaissance}}" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>/>
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label">Sit. matrimoniale <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <select class="form-control" name="matrimonial" required="" onchange="displaydatefin(this.value)" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>>
                          <option value="CELIBATAIRE" <?php if($agent->situationmatrimoniale=='CELIBATAIRE'){ echo 'selected'; } ?>>Célibataire</option>
                          <option value="CONCUBINAGE" <?php if($agent->situationmatrimoniale=='CONCUBINAGE'){ echo 'selected'; } ?> >Concubinage</option>
                            <option value="MARIE.E" <?php if($agent->situationmatrimoniale=='MARIE.E'){ echo 'selected'; } ?> >Marié.e</option>
                            <option value="VEUF.VE" <?php if($agent->situationmatrimoniale=='VEUF.VE'){ echo 'selected'; } ?> >Veuf.ve</option>
                            <option value="DIVORCE.E" <?php if($agent->situationmatrimoniale=='DIVORCE.E'){ echo 'selected'; } ?> >Divorcé.e</option>
                      </select>
                  </div>

                </div>
<br>
                <div class="form-group">

                  <label class="col-sm-2 col-sm-2 control-label">Lieu de residence:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="residence" name="residence" value="{{$agent->lieuresidence}}"/>
                  </div>
                  <label class="col-sm-2 col-sm-2 control-label">Telephone 1 <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="tel1" name="tel1" value="{{$agent->telephone1}}" required="" />
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label">Telephone 2:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="tel2" name="tel2" value="{{$agent->telephone2}}" />
                  </div>

                </div>
<br>
                <div class="form-group">

                  <label class="col-sm-2 col-sm-2 control-label">Groupe sanguin :</label>
                  <div class="col-sm-2">
                    <select class="form-control" name="groupe_sanguin">
                          <option value=""></option>
                          <option value="O-" <?php if($agent->groupe_sanguin=='0-'){ echo 'selected'; } ?>>0<sup>-</sup></option>
                          <option value="O+" <?php if($agent->groupe_sanguin=='O+'){ echo 'selected'; } ?>>0<sup>+</sup></option>
                          <option value="A-" <?php if($agent->groupe_sanguin=='A-'){ echo 'selected'; } ?>>A<sup>-</sup></option>
                          <option value="A+" <?php if($agent->groupe_sanguin=='A+'){ echo 'selected'; } ?>>A<sup>+</sup></option>
                          <option value="B-" <?php if($agent->groupe_sanguin=='B-'){ echo 'selected'; } ?>>B<sup>-</sup></option>
                          <option value="B+" <?php if($agent->groupe_sanguin=='B+'){ echo 'selected'; } ?>>B<sup>+</sup></option>
                          <option value="AB-" <?php if($agent->groupe_sanguin=='AB-'){ echo 'selected'; } ?>>AB<sup>-</sup></option>
                          <option value="AB+" <?php if($agent->groupe_sanguin=='AB+'){ echo 'selected'; } ?>>AB<sup>+</sup></option>
                      </select>
                  </div>
                  <label class="col-sm-2 col-sm-2 control-label">Religion :</label>
                  <div class="col-sm-2">
                    <select class="form-control" name="religion" onchange="displayAutreReligion(this.value)">
                          <option value=""></option>
                          <option value="1" <?php if($agent->religion=='1'){ echo 'selected'; } ?>>Christianisme</option>
                          <option value="2" <?php if($agent->religion=='2'){ echo 'selected'; } ?>>Islam</option>
                          <option value="3" <?php if($agent->religion=='3'){ echo 'selected'; } ?>>Judaïsme</option>
                          <option value="4" <?php if($agent->religion=='4'){ echo 'selected'; } ?>>Bouddhisme</option>
                          <option value="5" <?php if($agent->religion=='5'){ echo 'selected'; } ?>>Hindouisme</option>
                          <option value="6" <?php if($agent->religion=='6'){ echo 'selected'; } ?>>Autre</option>
                      </select>
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label" id="labelautrereligion" style="display:block">Autre:</label>
                  <div class="col-sm-2" id="divautrereligion" style="display:block">
                    <input type="text" class="form-control" id="autre_religion" name="autre_religion" value="{{$agent->autre_religion}}" />
                  </div>

                </div>
<br>
                <div class="form-group">
                  <label class="col-sm-2 control-label"> Matricule :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="matricule" value="{{$agent->matricule}}" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>/>
                  </div>
                   <label class="col-sm-2 control-label">Catégorie:</label>
                  <div class="col-sm-4">
                   <select class="form-control" name="categorie" required="" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>>
                      <option value="AGENT DE MAITRISE" <?php if(trim($agent->categorie)=='AGENT DE MAITRISE'){ echo 'selected'; } ?>>Agent de maitrise</option>
                      <option value="EMPLOYE" <?php if(trim($agent->categorie)=='EMPLOYE'){ echo 'selected'; } ?>>Employé</option>
                      <option value="CADRE" <?php if(trim($agent->categorie)=='CADRE'){ echo 'selected'; } ?>>Cadre</option>
                      <option value="CADRE JUNIOR" <?php if(trim($agent->categorie)=='CADRE JUNIOR'){ echo 'selected'; } ?>>Cadre junior</option>
                      <option value="CADRE MOYEN" <?php if(trim($agent->categorie)=='CADRE MOYEN'){ echo 'selected'; } ?>>Cadre moyen</option>
                      <option value="CADRE SUPERIEUR" <?php if(trim($agent->categorie)=='CADRE SUPERIEUR'){ echo 'selected'; } ?>>Cadre supérieur</option>
                    </select>
                  </div>

                </div>
<br>
                <div class="form-group">


                   <label class="col-sm-2 col-sm-2 control-label"> Email <span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="email" placeholder="Personnel" value="{{$agent->email}}" required=""/>
                  </div>
                   <label class="col-sm-2 col-sm-2 control-label"> Email Professionnel :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="email_pro" value="{{$agent->email_pro}}" placeholder="Professionnel"/>
                  </div>
                </div>
<br>
                <div class="form-group">

                   <label class="col-sm-2 col-sm-3 control-label">Prise de service :</label>
                  <div class="col-sm-2">
                    <input type="date" class="form-control" id="datedebut" name="datedebut" value="{{format_date2($agent->datepriseservice)}}" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>/>
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label">Statut :</label>
                  <div class="col-sm-2">
                    <select class="form-control" name="statut" id="statut" onchange="displaydatefin(this.value)" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>>
                        <option value=""></option>
                        <option value="FONCTIONNAIRE" <?php if($agent->statut=='FONCTIONNAIRE'){ echo 'selected'; } ?>>Fonctionnaire</option>
                          <option value="CDI" <?php if($agent->statut=='CDI'){ echo 'selected'; } ?>>Contractuel (CDI)</option>
                          <option value="CDD" <?php if($agent->statut=='CDD'){ echo 'selected'; } ?>>Contractuel (CDD)</option>
                          <option value="STAGIAIRE" <?php if($agent->statut=='STAGIAIRE'){ echo 'selected'; } ?>>Stagiaire</option>
                      </select>
                  </div>

                <span style="display:none" id="gradelabel">
                   <label class="col-sm-2 col-sm-2 control-label"  >Grade :</label>
                  <div class="col-sm-2">
                   <select class="form-control js-example-basic-single" name="grade" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>>
                    <option value=""></option>
                    @foreach ($grade_sds as $grade_sd)
                        <option value="{{$grade_sd->id}}">{{$grade_sd->name}}</option>
                    @endforeach
                   </select>
                  </div>
                </span>

                  <label class="col-sm-2 col-sm-2 control-label" style="display: none;" id="divlabelfin">Date de fin:</label>
                  <div class="col-sm-2">
                    <input type="date" class="form-control" value="{{format_date2($agent->datedefin)}}" id="divinputfin" name="datedefin" style="display: none;" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>/>
                  </div>
                </div>
<br>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Niveau d'étude <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <select  class="form-control js-example-basic-single col-sm-4" name="niveauetude" required <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?> >
                      <option value=""></option>
                        @foreach($niveauetudes as $niveauetude)
                         <option <?php if($agent->niveauetude==$niveauetude->name){ echo 'selected'; } ?> value="{{$niveauetude->name}}">{{$niveauetude->name}}</option>
                         @endforeach
                      </select>
                  </div>

                  <label class="col-sm-2 control-label">Intitulé du diplôme :</label>
                  <div class="col-sm-2">
                    <select class="js-example-basic-single form-control" name="diplome" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>>
                          <option value=""></option>
                           @foreach($diplomes as $diplome)
                          <option <?php if($agent->dernierdiplome==$diplome->diplome){ echo 'selected'; } ?> value="{{$diplome->diplome}}">{{$diplome->diplome}}</option>
                          @endforeach
                        </select>
                  </div>

                    <label class="col-sm-1 col-sm-1 control-label">Expérience</label>
                  <div class="col-sm-1">
                    <input type="number" class="form-control" id="exp_nbre" name="exp_nbre" value="{{$agent->exp_nbre}}" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>/>
                  </div>
                  <div class="col-sm-2">
                    <select class="form-control"  id="exp_unite" name="exp_unite" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>>
                        <option value="1" <?php if($agent->exp_unite=='1'){ echo 'selected'; } ?>>Année</option>
                        <option value="2" <?php if($agent->exp_unite=='2'){ echo 'selected'; } ?>>Mois</option>
                      </select>
                  </div>

                </div>

<br>
                <div class="form-group">
                  <!-- <label class="col-sm-2 col-sm-2 control-label">Niveau hiérachique <span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                    <select  class="form-control js-example-basic-single" name="level" required="" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>>
                      <option value=""></option>
                        @foreach($grades as $grade)
                         <option <?php if($agent->level==$grade->id){ echo 'selected'; } ?> value="{{$grade->id}}">{{$grade->name}}</option>
                         @endforeach
                      </select>
                  </div> -->

                   <label class="col-sm-2 col-sm-2 control-label">Fonction <span style="color:red">*</span>:</label>
                  <div class="col-sm-6">
                    <select  class="form-control js-example-basic-single" name="poste" required="" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>>
                      <option value=""></option>
                        @foreach($fonctions as $fonction)
                         <option <?php if($agent->fonction==$fonction->fonction){ echo 'selected'; } ?> value="{{$fonction->fonction}}">{{$fonction->fonction}}</option>
                         @endforeach
                      </select>
                  </div>

                </div>
<br>
                <div class="form-group">
                   <label class="col-sm-2 col-sm-2 control-label">Emploi:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="emploi" name="emploi" value="{{$agent->emploi}}" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>/>
                  </div>

                   <label class="col-sm-2 col-sm-2 control-label">N° CNPS:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="cnps" name="cnps" value="{{$agent->cnps}}" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>/>
                  </div>

                </div>

<br>
                <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Direction/Administration <span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                    <select onchange="getSousdirection(this.value)" class="form-control" name="direction" required=""<?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>>
                      <option value=""></option>
                        @foreach($directions as $direction)
                        <option <?php if($agent->direction_id==$direction->id){ echo 'selected'; } ?> value="{{ $direction->id }}">
                          {{ $direction->designation }}
                        </option>
                        @endforeach
                      </select>
                  </div>

                <label class="col-sm-2 col-sm-2 control-label">Sous-direction / Agence</label>
                <div class="col-sm-4">
                  <select onchange="getService(this.value)" class="form-control js-example-basic-single" name="sousdirection" id="sousdirection" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>>
                  <option value=""></option>
                   @foreach($sousdirections as $sousdirection)
                        <option <?php if($agent->sousdirection_id==$sousdirection->id){ echo 'selected'; } ?> value="{{ $sousdirection->id }}">
                          {{ $sousdirection->designation }}
                        </option>
                        @endforeach
                  </select>
                </div>

                </div>
<br>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Service / Guichet:</label>
                  <div class="col-sm-4">
                   <select class="form-control js-example-basic-single" name="service" id="service" <?php if(Auth::user()->state==1 || $direction_ ==4){ echo ''; }else{echo 'disabled';} ?>>
                       <option value=""></option>
                        @foreach($services as $service)
                        <option <?php if($agent->service_id==$service->id){ echo 'selected'; } ?> value="{{ $service->id }}">
                          {{ $service->designation }}
                        </option>
                        @endforeach
                    </select>
                  </div>
                </div>

<br><br>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Personne à contacter<span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="nom_pc" value="{{$agent->personnecontacter}}" required="" />
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label">Contacts <span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="contact_pc" value="{{$agent->contact}}" required=""/>
                  </div>

                </div>

                  <div class="modal-footer">
                   <!--  <button type="button" class="btn btn-warning" data-dismiss="modal">
                      Fermer
                    </button> -->

                    <button type="submit" class="btn btn-success">
                      Modifier
                    </button>
                  </div>

               </form>


                      </div>

                    </div>

                  </div>
<!-- /Profil -->

<!-- /Conges -->
                  <div id="conge" class="tab-pane">
                    <div class="row">
                      <div class="col-md-12 detailed">
                        <h4>Congés / Absences</h4>
                        @php
                        $agent_id=$agent->id;
                        $jourutilise=getjourdeconge($agent->id,'CONGE');

                        @endphp

                      <h4 style="color: orange;">Jours de congé restant:
                        <input id="nbrejourrestant" style="border:none" value="{{$nbrejourrestant}}">
                      </h4>
 <br>
                        <table class="table table-striped table-advance table-hover">

                          <thead class="sticky-nav text-green-m1 text-uppercase text-85">
                    <tr>

                      <th class="td-toggle-details border-0 bgc-white shadow-sm">

                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Motif
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                       Intérimaire
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Date de demande
                      </th>

                      <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">
                        Date de départ
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Date de retour
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Nbre de jour
                      </th>

                       <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">
                        Statut
                      </th>

                    </tr>
                  </thead>
                  <tbody class="pos-rel">

                     @foreach($demandes as $demande)
                     @php

                     @endphp

                    <tr class="d-style bgc-h-orange-l4">

                      <td class="pl-3 pl-md-4 align-middle pos-rel">

                      </td>

                      <td class="text-grey">
                        {{ $demande->objet }}
                        <div><span class='badge bgc-orange-d1 text-white badge-sm'></span></div>
                      </td>

                       <td class="text-grey">
                        @if($demande->interim)
                        {{getInstanceName('users','id',$demande->interim,'nomprenoms')}}
                        @endif
                        <div><span class='badge bgc-orange-d1 text-white badge-sm'></span></div>
                      </td>

                      <td>
                        <span class="text-105">
                         {{ $demande->date_demande }}
                        </span>

                      </td>

                       <td>
                        <span class="text-105">
                         {{ $demande->date_depart }}
                        </span>
                      </td>

                       <td>
                        <span class="text-105">
                         {{ $demande->date_retour }}
                        </span>

                      </td>

                      <td>
                        <span class="text-105">
                          {{ $demande->duree }}
                        </span>

                      </td>

                       <td>

                        <div class="btn-group">
                          @if($demande->state==1)
                        <button type="button" class="btn btn-warning btn-bold opacity-2">en attente</button>
                        <button type="button" class="px-2 btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                         @elseif($demande->state==2)
                         <button type="button" class="btn btn-info btn-bold opacity-2">Accordé</button>
                          <button type="button" class="px-2 btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                          @elseif($demande->state==3)
                           <button type="button" class="btn btn-success btn-bold opacity-5">Accepté</button>
                            <button type="button" class="px-2 btn btn-success dropdown-toggle dropdown-toggle-split opacity-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @elseif($demande->state==4 || $demande->state==6 )
                           <button type="button" class="btn btn-success btn-bold opacity-5">Validé</button>
                            <button type="button" class="px-2 btn btn-success dropdown-toggle dropdown-toggle-split opacity-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @elseif($demande->state==5)
                           <button type="button" class="btn btn-success btn-bold opacity-5">Validé def.</button>
                            <button type="button" class="px-2 btn btn-success dropdown-toggle dropdown-toggle-split opacity-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                           @else
                           <button type="button" class="btn btn-danger btn-bold opacity-2">Rejeté</button>
                           <button type="button" class="px-2 btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                           @endif

                      </div>

                        <div class="text-95 text-secondary-d1">

                        </div>
                      </td>

                    </tr>

                    @endforeach

                  </tbody>
                        </table>



                      </div>

                    </div>

                  </div>
<!-- /Profil -->
                  <div id="contact" class="tab-pane">
                    <div class="row">
                      <div class="col-md-12 detailed">
                        <h4>Membres de la famille</h4>
                        <br>

                            <table class="table table-striped table-advance table-hover">

                            <thead>
                              <tr>
                                <th>Nom & Prénom</th>
                                <th class="hidden-phone">Filiation</th>
                                <th>Contacts</th>
                                <th>Document</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($filiations as $filiation)
                              <tr>
                                <td>{{$filiation->fname.' '.$filiation->lname}}</td>
                               <td>
                                @if($filiation->type_filiation)
                                {{getInstanceName('master_filiation','id',$filiation->type_filiation,'filiation')}}
                                @endif
                               </td>
                               <td>{{$filiation->telephone1.' / '.$filiation->telephone1}}</td>
                               <td>
                                <div class="btn-group">
                                  <button type="button" class="btn btn-theme03">Document</button>
                                  <button type="button" class="btn btn-theme03 dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                  <ul class="dropdown-menu" role="menu">
                                     @if($filiation->fichier_piece)
                                    <li><a href="{{ asset('docs/'.$filiation->fichier_piece) }}" target="_blank">Piece d'identité</a></li>@endif
                                     @if($filiation->fichier_photo)
                                    <li><a href="{{ asset('docs/'.$filiation->fichier_photo) }}" target="_blank">Photo</a></li>
                                    @endif
                                     @if($filiation->fichier_acte_mariage)
                                    <li><a href="{{ asset('docs/'.$filiation->fichier_acte_mariage) }}" target="_blank">Acte de mariage</a></li>
                                    @endif
                                     @if($filiation->fichier_acte_naissance)
                                    <li><a href="{{ asset('docs/'.$filiation->fichier_acte_naissance) }}" target="_blank">Acte de naissance</a></li>@endif

                                  </ul>
                                </div>
                                <!--  @if($filiation->type_piece)
                                {{getInstanceName('master_identity','id',$filiation->type_piece,'identity')}}
                                @endif -->
                              </td>

                              </tr>
                              @endforeach
                            </tbody>
                          </table>

                      </div>

                    </div>
                    <!-- /row -->
                  </div>
                  <!-- contact -->


                  <!-- /Parcours -->
                  <div id="parcours" class="tab-pane">
                    <div class="row">
                      <div class="col-md-12 detailed">
                        <h4>Parcours de l'agent</h4>
                        <br>

                        <div class="detailed mt">
                          <div class="recent-activity">
                            @php
                            $i=0;
                            @endphp
                            @foreach($fonctions as $fonction)
                            @if($i==0)
                            <div class="activity-icon bg-theme"><i class="fa fa-check"></i></div>
                            @else
                            <div class="activity-icon bg-theme04"><i class="fa fa-check"></i></div>
                            @endif
                            <div class="activity-panel">
                              @if($i==0)
                              <h5>Depuis: {{format_date2($fonction->datepriseservice)}}</h5>
                               @else
                                <h5>Du {{format_date2($fonction->datepriseservice)}} Au {{format_date($fonction->datepriseservice)}}</h5>
                               @endif
                              <p>{{$fonction->fonction}}</p>
                              <p>
                                @if($fonction->direction_id )
                                {{getInstanceName('direction','id',$fonction->direction_id,'designation')}}
                                @endif
                                 @if($fonction->sousdirection_id)
                                 / {{getInstanceName('sousdirection','id',$fonction->sousdirection_id,'designation')}}
                                @endif
                               @if($fonction->service_id)
                              /  {{getInstanceName('service','id',$fonction->service_id,'designation')}}
                              @endif

                              </p>
                            </div>
                            @php
                            $i++;
                            @endphp
                            @endforeach
                          </div>
                          <!-- /recent-activity -->
                        </div>

                      </div>

                    </div>
                    <!-- /row -->
                  </div>
                  <!-- Parcours -->
                  <!-- /Mot de passe -->
                  <div id="motdepasse_tab" class="tab-pane">
                    <div class="row">
                      <div class="col-md-12 detailed">
                        <h4>Changer Mot de passe</h4>
                        <br>

                        <br>
                      <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('update.motdepasse') }}">
                             {{ csrf_field() }}

                             @if (session('success'))
                             <div class="form-group ">
                              <div class="col-xs-12">
                                <div class="alert alert-success">
                                       {{ session('success') }}
                                </div>
                              </div>
                            </div>
                        @endif
                         @if (session('error'))
                             <div class="form-group ">
                              <div class="col-xs-12">
                                <div class="alert alert-danger">
                                       {{ session('error') }}
                                </div>
                              </div>
                            </div>
                        @endif

                <div class="form-group">
                  <input type="hidden" name="user_id" value="{{$agent->id}}"/>
                  <label class="col-sm-2 col-sm-2 control-label">Mot de passe:</label>
                  <div class="col-sm-4">
                    <input type="password" class="form-control" name="motdepasse" id="motdepasse"  value="{{ old('motdepasse') }}" onkeyup="validatePassword(this.value)"/>
                  </div>
                  <label class="col-sm-2 col-sm-2 control-label">Confirmer :</label>
                  <div class="col-sm-4">
                    <input type="password" class="form-control" name="cmotdepasse" id="cmotdepasse" value="{{ old('cmotdepasse') }}" onkeyup="activeSubmit()"/>
                    <span style="display: none; color:red" id="pwdrepeat">
                        <label>Repetez le mot de passe svp !</label>
                   </span>
                  </div>

                </div>
              <div class="form-group">
                <span style="display: block; color:red" id="non_majuscule">
                    <input type="checkbox" style="margin: 10px"><label>Au moins une lettre Majuscule</label>
                </span>
                <span style="display: none; color:green" id="majuscule">
                        <input type="checkbox" checked style="margin: 10px"><label>Au moins une lettre Majuscule</label>
                </span>

                <span style="display: block; color:red" id="non_chiffre">
                        <input type="checkbox" style="margin: 10px"><label>Au moins 1 chiffre</label>
                </span>
                <span style="display: none; color:green" id="chiffre">
                        <input type="checkbox" checked style="margin: 10px" ><label>Au moins 1 chiffre</label>
                </span>

                <span style="display: block; color:red" id="non_longueur">
                        <input type="checkbox" style="margin: 10px"><label>Au moins 8 carractères</label>
                </span>
                <span style="display: none; color:green" id="longueur">
                        <input type="checkbox" checked style="margin: 10px" ><label>Au moins 8 carractères</label>
                </span>

              </div>
                <div class="modal-footer">
                   <!--  <button type="button" class="btn btn-warning" data-dismiss="modal">
                      Fermer
                    </button> -->

                    <button type="submit" class="btn btn-success" disabled id="btn_submit">
                      Modifier
                    </button>
                  </div>

               </form>

                      </div>

                    </div>
                    <!-- /row -->
                  </div>
                  <!-- /Mot de passe -->
                  <!-- /tab-pane -->
                  <div id="edit" class="tab-pane">
                    <div class="row">
                      <div class="col-lg-8 col-lg-offset-2 detailed">
                        <h4 class="mb">Personal Information</h4>
                        <form role="form" class="form-horizontal">
                          <div class="form-group">
                            <label class="col-lg-2 control-label"> Avatar</label>
                            <div class="col-lg-6">
                              <input type="file" id="exampleInputFile" class="file-pos">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Company</label>
                            <div class="col-lg-6">
                              <input type="text" placeholder=" " id="c-name" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Lives In</label>
                            <div class="col-lg-6">
                              <input type="text" placeholder=" " id="lives-in" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Country</label>
                            <div class="col-lg-6">
                              <input type="text" placeholder=" " id="country" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Description</label>
                            <div class="col-lg-10">
                              <textarea rows="10" cols="30" class="form-control" id="" name=""></textarea>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="col-lg-8 col-lg-offset-2 detailed mt">
                        <h4 class="mb">Contact Information</h4>
                        <form role="form" class="form-horizontal">
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Address 1</label>
                            <div class="col-lg-6">
                              <input type="text" placeholder=" " id="addr1" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Address 2</label>
                            <div class="col-lg-6">
                              <input type="text" placeholder=" " id="addr2" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Phone</label>
                            <div class="col-lg-6">
                              <input type="text" placeholder=" " id="phone" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Cell</label>
                            <div class="col-lg-6">
                              <input type="text" placeholder=" " id="cell" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-6">
                              <input type="text" placeholder=" " id="email" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Skype</label>
                            <div class="col-lg-6">
                              <input type="text" placeholder=" " id="skype" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                              <button class="btn btn-theme" type="submit">Save</button>
                              <button class="btn btn-theme04" type="button">Cancel</button>
                            </div>
                          </div>
                        </form>
                      </div>
                      <!-- /col-lg-8 -->
                    </div>
                    <!-- /row -->
                  </div>
                  <!-- /tab-pane -->
                </div>
                <!-- /tab-content -->
              </div>
              <!-- /panel-body -->
            </div>
            <!-- /col-lg-12 -->
          </div>

          <!-- /row -->
        </div>
        <!-- /container -->
      </section>
      <!-- /wrapper -->
    </section>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Modifier photo</h4>
                    </div>
                <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" enctype="multipart/form-data" action="{{ route('update.photo') }}">
                   {{ csrf_field() }}
                    <div class="modal-body">
                             <input type="hidden"  name="user_id" value="{{$agent->id}}">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Photo de profil :</label>
                          <div class="col-sm-12">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                              <span class="btn btn-success btn-file">
                                <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner la photo</span>
                              <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                              <input type="file" class="default" name="photo_identite" required>
                              </span>
                              <span class="fileupload-preview" style="margin-left:5px;"></span>
                            </div>
                          </div>
                    </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">fermer</button>
                      <button type="submit" class="btn btn-warning">Modifier</button>
                    </div>
                     </form>
                  </div>
                </div>
              </div>
    <!-- /MAIN CONTENT -->

    <div class="modal fade" id="mycv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Ajouter un CV</h4>
                    </div>
                <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" enctype="multipart/form-data" action="{{ route('add.document') }}">
                   {{ csrf_field() }}
                    <div class="modal-body">
                             <input type="hidden"  name="user_id" value="{{$agent->id}}">
                             <input type="hidden"  name="file_type" value="1">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Curiculum vitae :</label>
                          <div class="col-sm-12">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                              <span class="btn btn-success btn-file">
                                <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner cv</span>
                              <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                              <input type="file" class="default" name="cv" required>
                              </span>
                              <span class="fileupload-preview" style="margin-left:5px;"></span>
                            </div>
                          </div>
                    </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">fermer</button>
                      <button type="submit" class="btn btn-warning">Ajouter</button>
                    </div>
                     </form>
                  </div>
                </div>
              </div>
    <!--main content end-->
    <!--footer start-->
    <footer class="site-footer">
      <div class="text-center">
        <p>
          &copy; Copyrights <strong>DRHAJA</strong>. Tous droitd reservés
        </p>

        <a href="profile.html#" class="go-top">
          <i class="fa fa-angle-up"></i>
          </a>
      </div>
    </footer>
    <!--footer end-->
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('lib/bootstrap/js/bootstrap.min.js')}}"></script>
  <script class="include" type="text/javascript" src="{{asset('lib/jquery.dcjqaccordion.2.7.js')}}"></script>
   <script type="text/javascript" src="{{asset('lib/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
  <script src="{{asset('lib/jquery.scrollTo.min.js')}}"></script>
  <script src="{{asset('lib/jquery.nicescroll.js')}}" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="{{asset('lib/common-scripts.js')}}"></script>
  <!--script for this page-->
  <!-- MAP SCRIPT - ALL CONFIGURATION IS PLACED HERE - VIEW OUR DOCUMENTATION FOR FURTHER INFORMATION -->
  
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
        $(document).ready(function() {
          $('.js-example-basic-multiple').select2();
          });

        $(document).ready(function() {
          $('.js-example-basic-single').select2();
          });
</script>
  <script>

    $('.contact-map').click(function() {

      //google map in tab click initialize
      function initialize() {
        var myLatlng = new google.maps.LatLng(40.6700, -73.9400);
        var mapOptions = {
          zoom: 11,
          scrollwheel: false,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title: 'Dashio Admin Theme!'
        });
      }
      google.maps.event.addDomListener(window, 'click', initialize);
    });

    function displaydatefin(id)
  {

    //alert(id)
       if (id == 'CDD' || id == 'STAGIAIRE') {
              $("#divlabelfin").css("display","block");
              $("#divinputfin").css("display","block");
              $("#gradelabel").css("display","none");

            }else if(id == 'FONCTIONNAIRE'){
              $("#divlabelfin").css("display","none");
              $("#divinputfin").css("display","none");
              $("#gradelabel").css("display","block");

            } else
            {
              $("#divlabelfin").css("display","none");
              $("#divinputfin").css("display","none");
              $("#gradelabel").css("display","none");

            }
  }

  var contrat='{{$agent->statut}}';
  //console.log(contrat);

  if ( contrat == 'CDD') {
              $("#divlabelfin").css("display","block");
              $("#divinputfin").css("display","block");
              $("#gradelabel").css("display","none");

            }else if(contrat == 'FONCTIONNAIRE'){
              $("#divlabelfin").css("display","none");
              $("#divinputfin").css("display","none");
              $("#gradelabel").css("display","block");

            } else
            {
              $("#divlabelfin").css("display","none");
              $("#divinputfin").css("display","none");
              $("#gradelabel").css("display","none");
            }

  function deleteDocument(id)
  {
       rep=confirm('Voulez-vous supprimer ce document ?')

       url = "{{url('/documentation/delete')}}/"+id;

      if(rep == true)
      {
          window.location.href = url;
      }

  }
  </script>


<script>
    function getSousdirection(id)
  {

    //alert(id);

    var url = "{{ url('ajax/sousdirection/show') }}/"+id;
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
          $('select#sousdirection').html(data.html_first);
      }
    }
);
  }


 function getService(id)
  {

    //alert(id);

    var url = "{{ url('ajax/service/show') }}/"+id;
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
          $('select#service').html(data.html_first);
      }
    }
);
  }


  function validatePassword(password) {


// Au moins une lettre majuscule
if (!/[A-Z]/.test(password)) { $('#majuscule').css("display","none");$('#non_majuscule').css("display","block");}else{$('#majuscule').css("display","block");$('#non_majuscule').css("display","none");}

// Au moins un chiffre
if (!/\d/.test(password)) { $('#chiffre').css("display","none");$('#non_chiffre').css("display","block");}else{$('#chiffre').css("display","block");$('#non_chiffre').css("display","none");}

//Minimum 8 caractères
if (password.length < 8) { $('#longueur').css("display","none");$('#non_longueur').css("display","block");}else{$('#longueur').css("display","block");$('#non_longueur').css("display","none");}

if (!/^(?=.*[A-Z])(?=.*\d).{8,}$/.test(password)) { $('#password-confirm').attr('disabled','true')}else{ $('#password-confirm').removeAttr('disabled');}


}

function activeSubmit() {
//alert('test');
var password_confirmation = $('#cmotdepasse').val();
var password_new = $('#motdepasse').val();
console.log(password_confirmation);
console.log(password_new);
if(password_confirmation == password_new){$('#btn_submit').removeAttr('disabled'); $('#pwdrepeat').css("display","none");}else{$('#pwdrepeat').css("display","block");$('#btn_submit').attr('disabled','true');}

}



  </script>

</body>

</html>
