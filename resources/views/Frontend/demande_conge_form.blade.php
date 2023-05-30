@extends('Templates.form_master')

@section('titre')
    Noouvelle Demande
@endsection

@php
use Carbon\Carbon;

$current = Carbon::now();
$current_year= $current->year;
$year_1=$current_year - 2;

$active="active";
$open="open";
$show="show";
$d="#";
$page="conges";
$sm="demande";

$agent_function = Session::get('function_key');
$prisedeservice = $agent_function->datepriseservice;
$statut= $agent_function->statut;
$genre= Auth::user()->genre;

$datenaissance=Auth::user()->datenaissance;
$naissance = Carbon::create($datenaissance);
$debutservice=$agent_function->datepriseservice;
$debut_service=Carbon::create($debutservice);

$age=round($naissance->diffInDays($current) / 365);
$anciennete=round($debut_service->diffInDays($current) / 365);
$enfant=0;

          if($anciennete >= 5 && $anciennete < 10){
             $splus = 1;
          }else if($anciennete >= 10 && $anciennete < 15){
            $splus = 2;
          }else if($anciennete >= 15 && $anciennete < 20){
           $splus = 3;
          }else if($anciennete >= 20 && $anciennete < 25){
           $splus = 5;
          }else if($anciennete >= 25 && $anciennete < 30){
           $splus = 7;
          }else if($anciennete > 30 ){
            $splus = 8;
          }else{ $splus = 0; }

          if($statut == 'CONTRACTUEL'){
             $total=26;
          }else{
             $total=30;
          }
if($autorisationpris > 10 ){$depassement=$autorisationpris - 10;} else {$depassement=0;}

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
              <h4 class="mb">Demande de Congé / Absence</h4>
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
              <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" enctype="multipart/form-data" action="{{ route('add.demande') }}">
                             {{ csrf_field() }} 
                  <div class="modal-body ace-scrollbar">
@if(Auth::user()->type_id == 1)

                  <div class="form-group row">
                     <div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1">
                     <select onchange="getSousdirection(this.value)" class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="direction">
                        <option value="">DIRECTION / BUREAU</option>
                        @foreach($directions as $direction)
                        <option value="{{ $direction->id }}">
                          {{ $direction->designation }}
                        </option>
                        @endforeach
                      </select>
                  </div>

                   <div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1">
                       <select onchange="getService(this.value)" class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="sousdirection" id="sousdirection">
                        <option value="">SOUS-DIRECTION / AGENCE</option>
                        
                      </select>
                    </div>

                  </div>

                  <div class="form-group row">
                   <div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1">
                      <select onchange="getAgent(this.value)" class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="service" id="service">
                        <option value="">SERVICE / GUICHET</option>
                       
                      </select>
                    </div>

                    <div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1">
                      <select onchange="getInterimaire(this.value)" class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="agent" id="agent" required="">
                        <option value="">AGENT</option>
                        
                      </select>
                    </div>
                  </div>
@else
                    <input type="hidden" name="direction" id="direction" value="{{$agent_function->direction_id}}">
                    <input type="hidden" name="sousdirection" id="sousdirection" value="{{$agent_function->sousdirection_id}}">
                    <input type="hidden" name="service" id="service" value="{{$agent_function->service_id}}">
                    <input type="hidden" id="demandeur_id" name="agent" value="{{Auth::id()}}">
@endif
                  <input type="hidden" name="statut" id="statut" value="{{$statut}}">
                  <input type="hidden" name="genre" id="genre" value="{{$genre}}">
                  <input type="hidden" name="anciennete" id="anciennete" value="{{$anciennete}}">
                  <input type="hidden" name="age" id="age" value="{{$age}}">
                  <input type="hidden" name="enfant" id="enfant" value="{{$enfant}}">
        
                  <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">OBJET <span style="color:red;">*</span>:</label>
                  <div class="col-sm-3">
                    <select class="form-control" onchange="chooseObjet()" name="objet" id="objet" required="">
                         <option value=""></option>
                          <option value="ABSENCE">DEMANDE D'AUTORISATION D'ABSENCE</option>
                          <option value="CONGE">CONGE ANNUEL</option>
                    </select>
                  </div>

                  <label class="col-sm-3 control-label">INTERIMAIRE <span style="color:red;">*</span>:</label>
                  <div class="col-sm-3">
                    <select class="js-example-basic-single form-control" name="interim" id="interim" required="">
                          <option value=""></option>
                          @foreach($agents as $a)
                         <option value="{{$a->id}}">{{$a->nomprenoms}}</option>
                        @endforeach
                    </select>
                  </div>

                </div>
<br>

                  <div class="form-group" id="absence" style="display: none;">

                  <label class="col-sm-2 col-sm-2 control-label" for="objetabsence">MOTIF :</label>
                  <div class="col-sm-10">         
                     
                        <label class="col-sm-2">
                          <input type="radio" class="form-check-input" id="objetabsence" name="objetabsence" value="MARIAGE" onclick="choice()">
                         MARIAGE
                        </label>
                     
                        <label class="col-sm-2">
                        <input type="radio" class="form-check-input" id="objetnaissance" name="objetabsence" value="NAISSANCE" onclick="choice()">
                         NAISSANCE
                      </label>
                     
                         <label class="col-sm-2">
                         <input type="radio" class="form-check-input" id="objetdeces" name="objetabsence" value="DECES" onclick="choice()">
                         DECES
                        </label>

                        <label class="col-sm-3">
                         <input type="radio" class="form-check-input" id="objetdemenagement" name="objetabsence" value="DEMENAGEMENT" onclick="choice()">
                         DEMENAGEMENT
                        </label>
                      
                          <label class="col-sm-2">
                        <input type="radio" class="form-check-input" id="objetautre" name="objetabsence" value="AUTRES" onclick="choice()">
                         AUTRE
                      </label>
                        
                      </div>

                  </div>
                  
                <br>     
                <div class="form-group" id="absence_mariage" style="display:none;">

                  <label class="col-sm-2 col-sm-2 control-label"></label>
                  <div class="col-sm-10">         
                     
                        <label class="col-sm-3">
                          <input type="radio" class="form-check-input" id="mariagetravailleur" name="objetabsence_mariage" value="MARIAGETRAVAILLEUR" onclick="mariagechoice()">
                         DU TRAVAILLEUR
                        </label>
                     
                        <label class="col-sm-3">
                        <input type="radio" class="form-check-input" id="mariageenfant" name="objetabsence_mariage" value="MARIAGEENFANT" onclick="mariagechoice()">
                        D'UN DE SES ENFANTS
                      </label>
                     
                         <label class="col-sm-3">
                         <input type="radio" class="form-check-input" id="mariagefrere" name="objetabsence_mariage" value="MARIAGEFRERE" onclick="mariagechoice()">
                         D'UN DE SES FRERES
                        </label>

                      </div>

                  </div>

                  <div class="form-group" id="absence_naissance" style="display: none;">

                  <label class="col-sm-2 col-sm-2 control-label"></label>
                  <div class="col-sm-10">         
                     
                        <label class="col-sm-3">
                          <input type="radio" class="form-check-input" id="naissanceenfant" name="objetabsence_naissance" value="NAISSANCEENFANT" onclick="naissancechoice()">
                          D'UN ENFANT
                        </label>
                     
                        <label class="col-sm-4">
                        <input type="radio" class="form-check-input" id="bapteme" name="objetabsence_naissance" value="BAPTEME" onclick="naissancechoice()">
                        BAPTEME D'UN ENFANT
                      </label>
                     
                         <label class="col-sm-4">
                         <input type="radio" class="form-check-input" id="communion" name="objetabsence_naissance" value="COMMUNION" onclick="naissancechoice()">
                         1ere COMMUNION D'UN ENFANT
                        </label>

                      </div>

                  </div>

                  <div class="form-group" id="absence_deces" style="display: none;">

                  <label class="col-sm-2 col-sm-2 control-label"></label>
                  <div class="col-sm-10">         
                     
                        <label class="col-sm-2">
                          <input type="radio" class="form-check-input" id="decesconjoint" name="objetabsence_deces" value="DECESCONJOINT" onclick="deceschoice()">
                         CONJOINT
                        </label>
                     
                        <label class="col-sm-3">
                        <input type="radio" class="form-check-input" id="decesenfant" name="objetabsence_deces" value="DECESENFANT" onclick="deceschoice()">
                        ENFANT/ PERE/ MERE.
                       </label>
                     
                         <label class="col-sm-3">
                         <input type="radio" class="form-check-input" id="decesfrere" name="objetabsence_deces" value="DECESFRERE" onclick="deceschoice()">
                         FRERE / SOEUR
                        </label>

                        <label class="col-sm-3">
                         <input type="radio" class="form-check-input" id="decesbeaux" name="objetabsence_deces" value="DECESBEAUX" onclick="deceschoice()">
                        BEAU PERE / BELLE MERE
                        </label>

                      </div>
                      
                      

                  </div>
                  <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-9">         
                        <input type="text" class="form-control" id="objetautre1" name="objetautre" placeholder="autre motif d'absence" style="display: none;">
<br>  
                      </div>
                  
<br>               
              <div class="form-group">
                  
                  <label class="col-sm-2 col-sm-2 control-label">DATE DE DEPART <span style="color:red;">*</span>: <span style="color:green;">(inclus)</span></label>
                  <div class="col-sm-3">
                    <input type="date" class="form-control" id="datedepart" name="datedepart" placeholder="" required onchange="validateDateDepart(this.value)">
                          <span style="color:red; display:none;" id="err_datedepart">Date erronée: veuillez changé la date de Départ</span>
                  </div>

                  <label class="col-sm-3 col-sm-3 control-label">DATE DE RETOUR PREVUE <span style="color:red;">*</span>: <span style="color:green;">(Reprise effective de service)</span></label>
                  <div class="col-sm-3">
                    <input type="date" class="form-control" id="dateretour" name="dateretour" placeholder="" required onchange="validateDateRetour(this.value)" >
                    <span style="color:red; display:none;" id="err_dateretour">Date erronée: veuillez changé la date de Retour</span>
                  </div>

                </div>

                <div class="form-group">

                  <label class="col-sm-2 col-sm-2 control-label"><span id="labelnbrejourtotal">TOTAL JOURS</span></label>
                  <div class="col-sm-3">
                     <input type="text" class="form-control" id="nbrejourtotal" name="nbrejourtotal" placeholder="" readonly="readonly">
                     <span style="color:green;" id="err_nbrejourtotal">Ancienneté {{$anciennete}} an(s)==> {{$total}} + {{$splus}} Jour(s)</span>
                  </div>
                  
                  <label class="col-sm-3 col-sm-3 control-label">DUREE EN JOURS OUVRABLES:</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" id="nbrejourouvrable" name="nbrejourouvrable" placeholder="" readonly="readonly">
                    
                  </div>

                </div>

                <div class="form-group">

                  <label class="col-sm-2 col-sm-2 control-label"><span id="labelnbrejourpris">JOURS PRIS :</span></label>
                  <div class="col-sm-3">
                     <input type="text" class="form-control" id="nbrejourpris" name="nbrejourpris" placeholder="" readonly="readonly" value="{{$congepris + $depassement}}">
                     <span style="color:green;" id="labelnbrejourpris_">Dépassement (demande d'absence): {{$depassement}} jour(s)</span>
                  </div>
                  
                  <label class="col-sm-3 col-sm-3 control-label"><span id="labelnbrejourrestant">JOURS RESTANT :</span></label>
                  <div class="col-sm-3">
                     <input type="text" class="form-control" id="nbrejourrestant" name="nbrejourrestant" placeholder="" readonly="readonly">
                     <span style="color:red; display:none;" id="err_nbrjourrestant">Total erroné: veuillez changer l'une des dates.</span>
                  </div>


                </div>

                <div class="form-group">

                  <label class="col-sm-2 col-sm-2 control-label"><span id="labelautorisationpris">AUTORISATION PRIS</span></label>
                  <div class="col-sm-3">
                     <input type="text" class="form-control" id="autorisationpris" name="autorisationpris" placeholder="" readonly="readonly" value="{{$autorisationpris}}">
                  </div>

                </div>

                <div class="form-group">

                  <label class="col-sm-3 col-sm-3 control-label">
                    <span id="labeljustificatif_conge">DEMANDE PHYSIQUE :</span>
                  </label>
                  <div class="col-sm-5">
                      <input type="file" class="form-control" id="justificatif_conge" name="justificatif_conge">
                  </div>

                </div>

                <div class="form-group">

                  <label class="col-sm-2 col-sm-2 control-label">
                    <span id="labeljustificatif">JUSTIFICATIF :</span>
                  </label>
                  <div class="col-sm-5">
                     <input type="file" class="form-control" id="justificatif" name="justificatif">
                  </div>

                </div>

                <div class="form-group">
                  
                  <label class="col-sm-10 control-label">NB : <span style="color:darkorange;">Les demandes de congé de l'année {{$year_1}} prennent fin le 31 Mars {{$current_year}}</span></label>

                  
                  

                </div>
            
                  </div>

                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-warning" data-dismiss="modal">
                      Fermer
                    </button> -->

                    <button class="btn btn-success" id="ajouter">
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
    <script >
  function deleteMember(id,opt)
    {
      rep = confirm("Voulez-vous Valider cette demande?");

      url = "{{url('/demande/update/state')}}/"+id+"/"+opt;

      if(rep == true)
      {
          window.location.href = url;
      }

    }



    </script>

   <script>
    
     var id=$('#demandeur_id').val();
     var url = "{{ url('ajax/interim/show/') }}/"+id;
     $.ajax(
               {
                type: "get",
                url: url,
                success: function(data)
                {
                  console.table(data);
                    $('select#interim').html(data.html_first); 
                }
              }
          );

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
          $('select#agent').html(data.html_two);       
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
          $('select#agent').html(data.html_two);        
      }
    }
);
  }

  function getAgent(id)
  {

    //alert(id);
    
    var url = "{{ url('ajax/agent/show/') }}/"+id;
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
          $('select#agent').html(data.html_first); 
      }
    }
);
  }


   function displayPlateforme(id)
  {

       if (id == 1) {
              $("#divPlateforme").css("display","block");
            }else {
                  $("#divPlateforme").css("display","none");
                  }

  }


  function getInterimaire(id)
  {

    //alert(id);
    
    var url = "{{ url('ajax/interimaire/show') }}/"+id;
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
          $('select#interim').html(data.html_first);   
      }
    }
);
  }

  </script>

   <script type="text/javascript">

        function choice() {

    if ($('input[type=radio][id=objetautre]').is(':checked')) 
            {
                $('#objetautre1').css("display", "block");
                $("#nbrejourouvrable").val('');
                $('#dateretour').val('');
                $('#datedepart').val('');
                $('#dateretour').removeAttr('readonly');
                $('#absence_mariage').css("display", "none");
                $('#absence_naissance').css("display", "none");
                $('#absence_deces').css("display", "none");
            }
            else
            {
                $('#objetautre1').css("display", "none");
                $("#nbrejourouvrable").val('');
                $('#dateretour').val('');
                $('#datedepart').val('');
                $('#dateretour').attr('readonly','true');
            }

    if ($('input[type=radio][id=objetabsence]').is(':checked')) 
            {
                $("#nbrejourouvrable").val('');
                
                $('#dateretour').val('');
                $('#datedepart').val('');
                $('#absence_mariage').css("display", "block");
                $('#absence_naissance').css("display", "none");
                $('#absence_deces').css("display", "none");

            }else if($('input[type=radio][id=objetnaissance]').is(':checked'))
            {
                $("#nbrejourouvrable").val('');
                
                $('#dateretour').val('');
                $('#datedepart').val('');
                $('#absence_mariage').css("display", "none");
                $('#absence_naissance').css("display", "block");
                $('#absence_deces').css("display", "none");

            }else if($('input[type=radio][id=objetdeces]').is(':checked'))
            {
               $("#nbrejourouvrable").val('');
               
                $('#dateretour').val('');
                $('#datedepart').val('');
                $('#absence_mariage').css("display", "none");
                $('#absence_naissance').css("display", "none");
                $('#absence_deces').css("display", "block");

            }else if($('input[type=radio][id=objetdemenagement]').is(':checked'))
            {
               $("#nbrejourouvrable").val(1);
               
                $('#dateretour').val('');
                $('#datedepart').val('');
                $('#absence_mariage').css("display", "none");
                $('#absence_naissance').css("display", "none");
                $('#absence_deces').css("display", "none");

            }




    }

    
    function chooseObjet() {
      var selectedObjet = document.getElementById("objet").value;
          //alert(selectedObjet);
          if(selectedObjet=='ABSENCE'){
             $('#absence').css("display", "block");
             $('#nbrejourtotal').css("display", "none");
             $('#labelnbrejourtotal').css("display", "none");
             $('#err_nbrejourtotal').css("display", "none");
             $('#nbrejourrestant').css("display", "none");
             $('#labelnbrejourrestant').css("display", "none");
             $('#nbrejourpris').css("display", "none");
             $('#labelnbrejourpris').css("display", "none");
             $('#labelnbrejourpris_').css("display", "none");
             $('#autorisationpris').css("display", "block");
             $('#labelautorisationpris').css("display", "block")
             $('#justificatif').css("display", "block");
             $('#labeljustificatif').css("display", "block")
             $('#dateretour').val('');
             $('#datedepart').val('');
             $('#dateretour').attr('readonly','true');
             $('#justificatif_conge').css("display", "none");
             $('#labeljustificatif_conge').css("display", "none")
             
          }
          else
          {
             $('#absence').css("display", "none");
             $('#nbrejourtotal').css("display", "block");
             $('#labelnbrejourtotal').css("display", "block");
             $('#err_nbrejourtotal').css("display", "block");
             $('#nbrejourrestant').css("display", "block");
             $('#labelnbrejourrestant').css("display", "block");
             $('#nbrejourpris').css("display", "block");
             $('#labelnbrejourpris').css("display", "block");
             $('#labelnbrejourpris_').css("display", "block");
             $('#autorisationpris').css("display", "none");
             $('#labelautorisationpris').css("display", "none")
             $('#justificatif').css("display", "none");
             $('#labeljustificatif').css("display", "none")
             $('#dateretour').val('');
             $('#datedepart').val('');
             $('#dateretour').removeAttr('readonly');
             $("#nbrejourouvrable").val(''); 
             $('#absence_mariage').css("display", "none");
             $('#absence_naissance').css("display", "none");
             $('#absence_deces').css("display", "none");
             $('#objetautre1').css("display", "none");
             $('#justificatif_conge').css("display", "block");
             $('#labeljustificatif_conge').css("display", "block")
             $('#justificatif').css("display", "none");
             $('#labeljustificatif').css("display", "none")
          }
    }

    function mariagechoice() {


    if ($('input[type=radio][id=mariagetravailleur]').is(':checked')) 
            {
                $("#nbrejourouvrable").val('4');
                
                $('#dateretour').val('');
                $('#datedepart').val('');

            }else if($('input[type=radio][id=mariageenfant]').is(':checked'))
            {
                $("#nbrejourouvrable").val('2');
                
                $('#dateretour').val('');
                $('#datedepart').val('');

            }else if($('input[type=radio][id=mariagefrere]').is(':checked'))
            {
               $("#nbrejourouvrable").val('2');
               
                $('#dateretour').val('');
                $('#datedepart').val('');

            }else if($('input[type=radio][id=naissanceenfant]').is(':checked'))
            {
               $("#nbrejourouvrable").val('2');
               
                $('#dateretour').val('');
                $('#datedepart').val('');

            }


    }

    function naissancechoice() {


   if($('input[type=radio][id=naissanceenfant]').is(':checked'))
            {
               $("#nbrejourouvrable").val('2');
               
                $('#dateretour').val('');
                $('#datedepart').val('');

            }else if($('input[type=radio][id=bapteme]').is(':checked'))
            {
               $("#nbrejourouvrable").val('1');
               
                $('#dateretour').val('');
                $('#datedepart').val('');

            }else if($('input[type=radio][id=communion]').is(':checked'))
            {
               $("#nbrejourouvrable").val('1');
               
                $('#dateretour').val('');
                $('#datedepart').val('');

            }


    }

    function deceschoice() {


   if($('input[type=radio][id=decesconjoint]').is(':checked'))
            {
               $("#nbrejourouvrable").val('5');
               
                $('#dateretour').val('');
                $('#datedepart').val('');

            }else if($('input[type=radio][id=decesenfant]').is(':checked'))
            {
               $("#nbrejourouvrable").val('5');
               
                $('#dateretour').val('');
                $('#datedepart').val('');

            }else if($('input[type=radio][id=decesfrere]').is(':checked'))
            {
               $("#nbrejourouvrable").val('2');
               
                $('#dateretour').val('');
                $('#datedepart').val('');

            }else if($('input[type=radio][id=decesbeaux]').is(':checked'))
            {
               $("#nbrejourouvrable").val('2');
               
                $('#dateretour').val('');
                $('#datedepart').val('');

            }


    }

    function gettoday(){

      var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      var yyyy = today.getFullYear();
      today = yyyy + '-' + mm + '-' + dd;

      return today;
                                        }

    
   function validateDateDepart(depart){
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      var yyyy = today.getFullYear();
      today = yyyy + '-' + mm + '-' + dd;
      retour =  $("#dateretour").val();

      // console.log(retour);
      

      if(retour){

        if (depart >= retour || depart <= today) { 

                                $('#ajouter').attr('disabled','true');
                                $("#err_datedepart").css("display","block");

                              }else{

                                $("#err_datedepart").css("display","none");
                                $('#dateretour').removeAttr('readonly');
                                $('#ajouter').removeAttr('disabled');

                              }
               } 
      else{

        if (depart <= today) {

                           $("#err_datedepart").css("display","block");
                           $('#dateretour').attr('readonly','true');
                           $('#ajouter').attr('disabled','true');

                            }else{

                                  $("#err_datedepart").css("display","none");
                                  $('#dateretour').removeAttr('readonly');
                                  $('#ajouter').removeAttr('disabled');

                                 }
            }


      }

  function validateDateRetour(retour){
         depart =  $("#datedepart").val();
        //console.log(depart);
      
      if (retour <= depart) {
            $("#err_dateretour").css("display","block");
            $('#ajouter').attr('disabled','true');
         }
      else{
            $("#err_dateretour").css("display","none");
            $("#err_datedepart").css("display","none");
            $('#ajouter').removeAttr('disabled');

           }

      }


  function countDay(){
        
         var dateretour = Date.parse( $("#dateretour").val() );
         var datedepart = Date.parse( $("#datedepart").val() );
    
        d1 = datedepart.getTime() / 86400000;
        d2 = dateretour.getTime() / 86400000;
        var nbrejourouvrable = new Number(d2 - d1).toFixed(0);
        var ouvrable = Number(nbrejourouvrable);
        if(isNaN(ouvrable)){ ouvrable= ""}

       return ouvrable;
      }

  function ajouterDate (date_,nbrejour) {
        const date = new Date(date_);
        date.setDate(date.getDate() + Number(nbrejour));
        return date;
    }

   ////////////calcule du total des jour de congé
   $('#nbrejourtotal').css("display", "none");
   $('#labelnbrejourtotal').css("display", "none");
   $('#err_nbrejourtotal').css("display", "none");
   $('#nbrejourrestant').css("display", "none");
   $('#labelnbrejourrestant').css("display", "none");
   $('#nbrejourpris').css("display", "none");
   $('#labelnbrejourpris').css("display", "none");
   $('#labelnbrejourpris_').css("display", "none");
   $('#autorisationpris').css("display", "none");
   $('#labelautorisationpris').css("display", "none")
   $('#justificatif').css("display", "none");
   $('#labeljustificatif').css("display", "none")
    $('#justificatif_conge').css("display", "none");
    $('#labeljustificatif_conge').css("display", "none")
   
    var age =  $("#age").val();
    var ancienete =  $("#anciennete").val();
    var enfant =  $("#enfant").val();
    var statut =  $("#statut").val();
    var genre =  $("#genre").val();
    var objet =  $("#objet").val();
    var ouvrable =  0;


        if(statut == 'CONTRACTUEL'){
             total=26;
          }else{
             total=30;
          }

          if(ancienete >= 5 && ancienete < 10){
            
             total=total + 1;
          }else if(ancienete >= 10 && ancienete < 15){
            
            total=total + 2
          }else if(ancienete >= 15 && ancienete < 20){
           
            total=total + 3;
          }else if(ancienete >= 20 && ancienete < 25){
            
            total=total + 5;
          }else if(ancienete >= 25 && ancienete < 30){
           
            total=total + 7;
          }else if(ancienete > 30 ){
           
            total=total + 8;
          }

          if(genre == 'F' && age <= 21){
            total = total + ( ( Number(enfant) * 2 ) ) ;
          }else if(genre == 'F' && age > 21){
            if(enfant >= 4){
               total = total + ( (Number(enfant) - 3 ) * 2 );
            }

          }

$("#nbrejourtotal").val(total);

$("#datedepart").change(function(){
  
  var depart = $("#datedepart").val();
  var objet =  $("#objet").val();
  var fer =  0;
  var nbrj = $("#nbrejourouvrable").val();
  
 

  if (objet == 'ABSENCE') {
         
  const datededepart = new Date(depart);

  var result =datededepart.setDate(datededepart.getDate() + Number(nbrj));
    
  for (i = 0; i < nbrj; i++) { 
            
            jour = ajouterDate(depart,i);
            jour_ = jour.getDay();
            if(jour_ === 0){ 
              fer = fer + 1; 
                         }
            }

  var  date_=new Date(result); 

       d=date_.getDay();
       //alert(d); alert(fer);

      if(d==0){
        result_ =date_.setDate(date_.getDate() + Number(fer) + 1);
      }else if(d==6){
        result_ =date_.setDate(date_.getDate() + Number(fer) + 2);
      }else{
        result_ =date_.setDate(date_.getDate() + Number(fer));
      }
    
       date_=new Date(result_).toLocaleDateString("fr");

      const myArray = date_.split("/");
      const mydateretour = myArray[2]+'-'+myArray[1]+'-'+myArray[0];
 
    $("#dateretour").val(mydateretour);
    $('#dateretour').attr('readonly','true');

  }

});

$("#dateretour,#datedepart").change(function(){

        var ouvrable = 0;
        
        var age =  $("#age").val();
        var ancienete =  $("#anciennete").val();
        var enfant =  $("#enfant").val();
        var statut =  $("#statut").val();
        var genre =  $("#genre").val();
        var objet =  $("#objet").val();
        if(objet== 'CONGE'){
          var nbrejourouvrable=countDay();
        }else{
          var nbrejourouvrable=$("#nbrejourouvrable").val();
        }
        
        var datedepart = $("#datedepart").val();
        var dateretour = $("#dateretour").val();
        var fin = Number(nbrejourouvrable);
        var fer= 0;
        var today=gettoday();

        for (i = 0; i < fin; i++) { 
            
            jour = ajouterDate(datedepart,i);
            jour_ = jour.getDay();
            if(jour_ === 0){ 
              fer = fer + 1; 
            }

           console.log(jour.getDay());
  
            }

          
       if (objet == 'CONGE') {

        if(statut == 'CONTRACTUEL'){
             total=26;
             ouvrable = Number(nbrejourouvrable)  - Number(fer);
          }else{
             ouvrable = Number(nbrejourouvrable) ;
             total=30;
          }

          if(ancienete >= 5 && ancienete < 10){
             
             total=total + 1;
          }else if(ancienete >= 10 && ancienete < 15){
           
            total=total + 2
          }else if(ancienete >= 15 && ancienete < 20){
            
            total=total + 3;
          }else if(ancienete >= 20 && ancienete < 25){
           
            total=total + 5;
          }else if(ancienete >= 25 && ancienete < 30){
           
            total=total + 7;
          }else if(ancienete > 30 ){
           
            total=total + 8;
          }

          if(genre == 'F' && age <= 21){
           
            total = total + ( ( Number(enfant) * 2 ) ) ;
          }else if(genre == 'F' && age > 21){
            if(enfant >= 4){
               total = total + ( (Number(enfant) - 3 ) * 2 );
            }

          }


           if (datedepart <= dateretour && datedepart>today) {
            $("#err_dateretour").css("display","none");
            $("#err_datedepart").css("display","none");
            $('#ajouter').removeAttr('disabled');
            //$('#dateretour').removeAttr('disabled');

         }

           nbrejourrestant=total - {{$congepris}} - ouvrable - {{$depassement}};
           if(nbrejourrestant < 0){
             $('#ajouter').attr('disabled','true');
             $("#err_nbrjourrestant").css("display","block");
            }else{
              $("#err_nbrjourrestant").css("display","none");
            }


       }else{

             if ($('input[type=radio][id=objetautre]').is(':checked')) 
            {
               ouvrable = Number(nbrejourouvrable)
            }else{
              ouvrable = $("#nbrejourouvrable").val();
            }

             
       }

        
          $("#nbrejourouvrable").val(ouvrable); 
          $("#nbrejourrestant").val(nbrejourrestant);         
        
    });

            // console.log(ouvrable);
            nbrejourrestant=total - {{$congepris}} - ouvrable - {{$depassement}};
          $("#nbrejourrestant").val(nbrejourrestant);

     
    </script>

    @endsection