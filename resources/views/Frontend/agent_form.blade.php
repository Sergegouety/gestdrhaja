@extends('Templates.form_master')

@section('titre')
    Noouveau Agent
@endsection

@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="parametre";
$sm="agent";
@endphp

@section('stylesheet')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<section class="wrapper">
       <!--  <h3><i class="fa fa-angle-right"></i> Form Components</h3> -->
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt">
          <div class="col-lg-12">
            <div class="form-panel">
              <h4 class="mb"> Nouvel Agent</h4>
              <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('add.agent') }}">
                             {{ csrf_field() }}

                <div class="form-group">
                  <label class="col-sm-1 col-sm-2 control-label">Nom <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="nom" required=""/>
                  </div>

                  <label class="col-sm-1 col-sm-2 control-label">Prénom <span style="color:red">*</span> :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="prenom" required=""/>
                  </div>

                   <label class="col-sm-1 col-sm-2 control-label"> genre <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <select class="form-control" name="sexe" required="">
                      <option value=""></option>
                        <option value="M">Masculin</option>
                         <option value="F">Feminin</option>
                    </select>
                  </div>
                </div>
<br>
                <div class="form-group">
                 
                  <label class="col-sm-2 col-sm-2 control-label">Date de naissance <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <input type="date" class="form-control" id="naissance" name="naissance" required=""/>
                  </div>
                  <label class="col-sm-2 col-sm-2 control-label">Lieu de naissance :</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="lieu" name="lieu"/>
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label">Sit. matrimoniale <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <select class="form-control" name="matrimonial" required="" onchange="displaydatefin(this.value)">
                          <option value=""></option>
                          <option value="CELIBATAIRE">Célibataire</option>
                          <option value="MARIE.E">Marié.e</option>
                          <option value="DIVORCE.E">Divorcé.e</option>
                          <option value="VEUF.VE">Veuf.ve</option>
                      </select>
                  </div>
                 
                </div>
<br>
                <div class="form-group">
                 
                  <label class="col-sm-2 col-sm-2 control-label">Lieu de residence:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="residence" name="residence"/>
                  </div>
                  <label class="col-sm-2 col-sm-2 control-label">Telephone <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="tel1" name="tel1" required=""/>
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label">Telephone 2:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="tel2" name="tel2"/>
                  </div>
                 
                </div>
<br>
                <div class="form-group">
                 
                  <label class="col-sm-2 col-sm-2 control-label">Groupe sanguin :</label>
                  <div class="col-sm-2">
                    <select class="form-control" name="groupe_sanguin">
                          <option value=""></option>
                          <option value="O-">0<sup>-</sup></option>
                          <option value="O+">0<sup>+</sup></option>
                          <option value="A-">A<sup>-</sup></option>
                          <option value="A+">A<sup>+</sup></option>
                          <option value="B-">B<sup>-</sup></option>
                          <option value="B+">B<sup>+</sup></option>
                          <option value="AB-">AB<sup>-</sup></option>
                          <option value="AB+">AB<sup>+</sup></option>
                      </select>
                  </div>
                  <label class="col-sm-2 col-sm-2 control-label">Religion :</label>
                  <div class="col-sm-2">
                    <select class="form-control" name="religion" onchange="displayAutreReligion(this.value)">
                          <option value=""></option>
                          <option value="1">Christianisme</option>
                          <option value="2">Islam</option>
                          <option value="3">Judaïsme</option>
                          <option value="4">Bouddhisme</option>
                          <option value="5">Hindouisme</option>
                          <option value="6">Autre</option>
                      </select>
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label" id="labelautrereligion" style="display:none">Autre:</label>
                  <div class="col-sm-2" id="divautrereligion" style="display:none">
                    <input type="text" class="form-control" id="autre_religion" name="autre_religion" placeholder="autre religion" />
                  </div>
                 
                </div>
<br>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Matricule <span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="matricule" required=""/>
                  </div>
                   <label class="col-sm-2 col-sm-2 control-label">Catégorie <span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                   <select class="form-control" name="categorie" required="">
                        <option value=""></option>
                        <option value="AGENT DE MAITRISE">Agent de maîtrise</option>
                        <option value="CADRE">Cadre</option>
                        <option value="CADRE JUNIOR">Cadre Junior</option>
                        <option value="CADRE MOYEN">Cadre Moyen</option>
                        <option value="CADRE SUPERIEUR">Grade Superieur</option>
                        <option value="EMPLOYE">Employé</option>
                    </select>
                  </div>

                </div>
<br>
                 <div class="form-group">
                  
                   <label class="col-sm-2 col-sm-2 control-label"> Email <span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                    <input type="email" class="form-control" name="email" placeholder="Personnel" required=""/>
                  </div>
                  <label class="col-sm-2 col-sm-2 control-label"> Email Professionnel <span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                    <input type="email" class="form-control" name="email_pro" placeholder="Professionnel" required=""/>
                  </div>
                </div>
<br>
                <div class="form-group">

                   <label class="col-sm-2 col-sm-3 control-label">Prise de service <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <input type="date" class="form-control" id="datedebut" name="datedebut" required=""/>
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label">Statut <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <select class="form-control"  name="statut" required="" onchange="displaydatefin(this.value)">
                        <option value=""></option>
                        <option value="CONTRACTUEL">Contractuel</option>
                         <option value="FONCTIONNAIRE">Fonctionnaire</option>
                         <option value="STAGIAIRE">Stagiaire</option>
                      </select>
                  </div>

                <span style="display:none" id="gradelabel">
                   <label class="col-sm-2 col-sm-2 control-label"  >Grade:</label>
                  <div class="col-sm-2">

                   <select class="form-control js-example-basic-single" name="grade">
                    <option value=""></option>
                    @foreach ($grade_sds as $grade_sd)
                        <option value="{{$grade_sd->id}}">{{$grade_sd->name}}</option>
                    @endforeach
                   </select>
                  </div>
                </span>

                  <label class="col-sm-2 col-sm-2 control-label" style="display: none;" id="divlabelfin">Date de fin:</label>
                  <div class="col-sm-2">
                    <input type="date" class="form-control" id="divinputfin" name="datedefin" style="display: none;"/>
                  </div>
                </div>
<br>
                <div class="form-group">

                   <label class="col-sm-4 col-sm-3 control-label">Prise de service dans la fonction actuelle <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <input type="date" class="form-control" id="datepriseserviceactuelle" name="datepriseserviceactuelle" />
                  </div>

                  <label class="col-sm-4 col-sm-3 control-label">Nomination dans la fonction actuelle <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                   <input type="date" class="form-control" id="datenominationactuelle" name="datenominationactuelle" />
                  </div>

                </div>
<br>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Niveau d'étude <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <select  class="form-control js-example-basic-single" name="niveauetude" required="" >
                      <option value=""></option>
                        @foreach($niveauetudes as $niveauetude)
                         <option value="{{$niveauetude->name}}">{{$niveauetude->name}}</option>
                         @endforeach
                      </select>
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label">Intitulé du diplôme <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <select  class="form-control js-example-basic-single" name="diplome" required="" >
                      <option value=""></option>
                        @foreach($diplomes as $diplome)
                         <option value="{{$diplome->diplome}}">{{$diplome->diplome}}</option>
                         @endforeach
                      </select>
                  </div>

                  <label class="col-sm-1 col-sm-1 control-label">Expérience</label>
                  <div class="col-sm-1">
                    <input type="number" class="form-control" id="exp_nbre" name="exp_nbre"/>
                  </div>
                  <div class="col-sm-2">
                    <select class="form-control"  id="exp_unite" name="exp_unite">
                        <option value="1">Année</option>
                        <option value="2">Mois</option>
                      </select>
                  </div>

                </div>

<br>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Niveau hierachique <span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                    <select  class="form-control js-example-basic-single" name="level" required="" >
                      <option value=""></option>
                        @foreach($grades as $grade)
                         <option value="{{$grade->id}}">{{$grade->name}}</option>
                         @endforeach
                      </select>
                  </div>

                   <label class="col-sm-2 col-sm-2 control-label">Fonction <span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                    <select  class="form-control js-example-basic-single" name="poste" required="" >
                      <option value=""></option>
                        @foreach($postes as $poste)
                         <option value="{{$poste->name}}">{{$poste->name}}</option>
                         @endforeach
                      </select>
                  </div>

                  
                </div>
<br>
                <div class="form-group">
                   <label class="col-sm-2 col-sm-2 control-label">Emploi:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="emploi" name="emploi"/>
                  </div>

                   <label class="col-sm-2 col-sm-2 control-label">N° CNPS:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="cnps" name="cnps"/>
                  </div>

                </div>

<br>
                <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Direction/Administration <span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                    <select onchange="getSousdirection(this.value)" class="form-control" name="direction" required="">
                      <option value=""></option>
                        @foreach($directions as $direction)
                        <option value="{{ $direction->id }}">
                          {{ $direction->designation }}
                        </option>
                        @endforeach
                      </select>
                  </div>

                <label class="col-sm-2 control-label">Sous-direction/Agence</label>
                <div class="col-sm-4">
                  <select onchange="getService(this.value)" class="form-control js-example-basic-single" name="sousdirection" id="sousdirection">
                  <option value=""></option>
                  </select>
                </div>

                </div>
<br>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Service/Guichet:</label>
                  <div class="col-sm-4">
                   <select class="form-control js-example-basic-single" name="service" id="service">
                       <option value=""></option>
                    </select>
                  </div>
                </div>

<br><br>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Personne à contacter <span style="color:red">*</span> :</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="nom_pc" required="" placeholder="Personne à contacter (en cas d'urgence)" />
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label">Contacts <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="contact_pc" required="" />
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label">Nbr enfant :</label>
                  <div class="col-sm-1">
                    <input type="number" class="form-control" name="nbreenfant" />
                  </div>

                </div>

                  <div class="modal-footer">
                   <!--  <button type="button" class="btn btn-warning" data-dismiss="modal">
                      Fermer
                    </button> -->

                    <button type="submit" class="btn btn-success">
                      Ajouter
                    </button>
                  </div>
               </form>
            </div>
          </div>
          <!-- col-lg-12-->
        </div>
       
      </section>

@endsection

@section('scriptjs')
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


   function displaydatefin(id)
  {
       if (id == 'CONTRACTUEL') {
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

  function displayAutreReligion(id)
  {
       if (id == 6) {
              $("#labelautrereligion").css("display","block");
              $("#divautrereligion").css("display","block");
              
             
            } else 
            {
              $("#labelautrereligion").css("display","none");
              $("#divautrereligion").css("display","none");
              
            }
  }

  </script>

  @endsection