@extends('Templates.form_master')

@section('titre')
    Demande List - Aej Admin
@endsection


@php
use Carbon\Carbon;

$current = Carbon::now();
$active="active";
$open="open";
$show="show";
$d="#";
$page="conge";
$sm="demande";
//dd($demandeur_fonction);
$agent_function = $demandeur_fonction;
$prisedeservice = $agent_function->datepriseservice;
$statut= $agent_function->statut;
$genre= $agent_function->genre;

$datenaissance=$agent_function->datenaissance;
$naissance = Carbon::create($datenaissance);
$debutservice=$agent_function->datepriseservice;
$debut_service=Carbon::create($debutservice);

$age=round($naissance->diffInDays($current) / 365);
$anciennete=round($debut_service->diffInDays($current) / 365);
$enfant=0;

@endphp

@section('stylesheet')

@endsection

@section('content')

<section class="wrapper">
       <!--  <h3><i class="fa fa-angle-right"></i> Form Components</h3> -->
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt">
          <div class="col-lg-12">
            <div class="form-panel">
              <h4 class="mb"> Demande Détails</h4>
              <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('update.demande') }}">
                             {{ csrf_field() }} 
                  <div class="modal-body ace-scrollbar">

                  <input type="hidden" name="demandeur_id" id="demandeur_id" value="{{$demandes->demandeur_id}}" />
                  <input type="hidden" name="demande_id" id="demande_id" value="{{$demandes->id}}">
                  <input type="hidden" name="statut" id="statut" value="{{$statut}}">
                  <input type="hidden" name="genre" id="genre" value="{{$genre}}">
                  <input type="hidden" name="anciennete" id="anciennete" value="{{$anciennete}}">
                  <input type="hidden" name="age" id="age" value="{{$age}}">
                  <input type="hidden" name="enfant" id="enfant" value="{{$enfant}}">

                  <div class="form-group row">

                    <div class="col-sm-4">
                     <select class="form-control" name="agent" id="agent" required="" disabled="">
                        <option value="">AGENT</option>
                        @foreach($agents as $a)
                         <option value="{{$a->id}}" @php if($a->id==$demandes->demandeur_id){ echo'selected';} @endphp>{{$a->nomprenoms}}</option>
                        @endforeach
                      </select>
                    </div>

                  </div><br>

                   <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">MOTIF:</label>
                  <div class="col-sm-3">
                    <select class="form-control" onchange="chooseMotif()" name="motif" id="motif" required="">
                         <option value=""></option>
                        <option value="ABSENCE" @php if($demandes->motif=='ABSENCE'){ echo'selected';} @endphp>DEMANDE D'ABSENCE</option>
                          <option value="CONGE" @php if($demandes->motif=='CONGE'){ echo'selected';} @endphp>CONGE ANNUEL</option>
                    </select>
                  </div>

                  <label class="col-sm-3 col-sm-2 control-label">INTERIMAIRE :</label>
                  <div class="col-sm-3">
                    <select class="form-control" name="interim" id="interim" required="">
                          @foreach($agents as $a)
                         <option value="{{$a->id}}" @php if($a->id==$demandes->interim){ echo'selected';} @endphp>{{$a->nomprenoms}}</option>
                        @endforeach
                    </select>
                  </div>

                </div>

                <div class="form-group" id="absence" style="display: none;">

                  <label class="col-sm-2 col-sm-2 control-label" for="objetabsence">OBJET :</label>
                  <div class="col-sm-10">         
                     
                        <label class="col-sm-2">
                          <input type="radio" class="form-check-input" id="objetabsence" name="objetabsence" value="MARIAGE" onclick="choice()" @php if($demandes->objet_absence=='MARIAGE'){ echo'checked';} @endphp>
                         MARIAGE
                        </label>
                     
                        <label class="col-sm-2">
                        <input type="radio" class="form-check-input" id="objetnaissance" name="objetabsence" value="NAISSANCE" onclick="choice()" @php if($demandes->objet_absence=='NAISSANCE'){ echo'checked';} @endphp>
                         NAISSANCE
                      </label>
                     
                         <label class="col-sm-2">
                         <input type="radio" class="form-check-input" id="objetdeces" name="objetabsence" value="DECES" onclick="choice()" @php if($demandes->objet_absence=='DECES'){ echo'checked';} @endphp>
                         DECES
                        </label>
                      
                          <label class="col-sm-2">
                        <input type="radio" class="form-check-input" id="objetautre" name="objetabsence" value="AUTRES" onclick="choice()" @php if($demandes->objet_absence=='AUTRE'){ echo'checked';} @endphp>
                         AUTRES
                      </label>
                        <div class="col-sm-3">
                       <input type="text" class="form-control" id="objetautre1" name="objetautre" placeholder="autre objet d'absence" style="display: none;" value="{{$demandes->objet_autre}}">
                        </div>
                      </div>

                  </div>
<br>

               <div class="form-group">
                  
                  <label class="col-sm-2 col-sm-2 control-label">DATE DE DEPART:</label>
                  <div class="col-sm-3">
                    <input type="date" class="form-control" id="datedepart" name="datedepart" value="{{$demandes->date_depart}}" required onchange="validateDateDepart(this.value)">
                          <span style="color:red; display:none;" id="err_datedepart">Date erronée: veuillez changé la date de Départ</span>
                  </div>

                  <label class="col-sm-3 col-sm-3 control-label">DATE DE RETOUR PREVUE:</label>
                  <div class="col-sm-3">
                    <input type="date" class="form-control" id="dateretour" name="dateretour" value="{{$demandes->date_retour}}" required onchange="validateDateRetour(this.value)" >
                          <span style="color:red; display:none;" id="err_dateretour">Date erronée: veuillez changé la date de Retour</span>
                  </div>

                </div>

                <div class="form-group">

                  <label class="col-sm-2 col-sm-2 control-label"><span id="labelnbrejourtotal">TOTAL JOURS</span></label>
                  <div class="col-sm-3">
                     <input type="text" class="form-control" id="nbrejourtotal" name="nbrejourtotal" placeholder="" readonly="readonly">
                  </div>
                  
                  <label class="col-sm-3 col-sm-3 control-label">DUREE EN JOURS OUVRABLES:</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" id="nbrejourouvrable" name="nbrejourouvrable" placeholder="" readonly="readonly" value="{{$demandes->duree}}">
                  </div>

                </div>

                <div class="form-group">

                  <label class="col-sm-2 col-sm-2 control-label"><span id="labelnbrejourrestant">JOURS RESTANT</span></label>
                  <div class="col-sm-3">
                     <input type="text" class="form-control" id="nbrejourrestant" name="nbrejourrestant" placeholder="" readonly="readonly">
                     <span style="color:red; display:none;" id="err_nbrjourrestant">Total erroné: veuillez changer l'une des dates.</span>
                  </div>
                  
                </div>
<br>
                  <div class="form-group row">

                    <div class="col-sm-2">
                     <select class="form-control" name="state" id="state">
                            <option value="1" @php if($demandes->state==1){ echo'selected';} @endphp>EN ATTENTE</option>
                            <option value="2" @php if($demandes->state==2){ echo'selected';} @endphp>VALIDE</option>
                            <option value="3" @php if($demandes->state==3){ echo'selected';} @endphp>ACCEPTE</option>
                            <option value="0" @php if($demandes->state==4){ echo'selected';} @endphp>REJETE</option>
                      </select>
                    </div>

                  </div>

                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-warning" data-dismiss="modal">
                      Fermer
                    </button> -->

                    <button type="submit" class="btn btn-success" id="ajouter">
                      Modifier
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

    <script type="text/javascript">
     
    </script>


   <script>
     var selectedMotif=$('#motif').val();
    if(selectedMotif=='ABSENCE'){
             $('#absence').css("display", "block");
             $('#nbrejourtotal').css("display", "none");
             $('#labelnbrejourtotal').css("display", "none");
             $('#nbrejourrestant').css("display", "none");
             $('#labelnbrejourrestant').css("display", "none");
             
          }
          else
          {
             $('#absence').css("display", "none");
             $('#nbrejourtotal').css("display", "block");
             $('#labelnbrejourtotal').css("display", "block");
             $('#nbrejourrestant').css("display", "block");
             $('#labelnbrejourrestant').css("display", "block");
          }
    
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
    
     function choice() {
    if ($('input[type=radio][id=objetautre]').is(':checked')) 
            {
                $('#objetautre1').css("display", "block");
            }
            else
            {
                $('#objetautre1').css("display", "none");
            }
    }

    
    function chooseMotif() {
      var selectedMotif = document.getElementById("motif").value;
          //alert(selectedMotif);
          if(selectedMotif=='ABSENCE'){
             $('#absence').css("display", "block");
             $('#nbrejourtotal').css("display", "none");
             $('#labelnbrejourtotal').css("display", "none");
             $('#nbrejourrestant').css("display", "none");
             $('#labelnbrejourrestant').css("display", "none");
             
          }
          else
          {
             $('#absence').css("display", "none");
             $('#nbrejourtotal').css("display", "block");
             $('#labelnbrejourtotal').css("display", "block");
             $('#nbrejourrestant').css("display", "block");
             $('#labelnbrejourrestant').css("display", "block");
             total =  $("#nbrejourtotal").val();
             ouvrable =  $("#nbrejourouvrable").val();
             nbrejourrestant=total - ouvrable;
             $("#nbrejourrestant").val(nbrejourrestant);

          }
    }

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


   function validateDateDepart(depart){
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      var yyyy = today.getFullYear();
      today = yyyy + '-' + mm + '-' + dd;
      retour =  $("#dateretour").val();
      // console.log(retour);
      

      if(retour){

        if (depart >= retour) { 
                                $('#ajouter').attr('disabled','true');
                                $("#err_datedepart").css("display","block");
                              }else{
                                $("#err_datedepart").css("display","none");
                                  $('#dateretour').removeAttr('disabled');
                                  $('#ajouter').removeAttr('disabled');
                                  $("#err_dateretour").css("display","none")
                              }
               }
                else{
                      $('#ajouter').removeAttr('disabled');
                      $("#err_datedepart").css("display","none");
                      $("#err_dateretour").css("display","none");
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
        var ouvrable = Number(nbrejourouvrable) + 1
        if(isNaN(ouvrable)){ ouvrable= ""}

       return ouvrable;
      }

  function ajouterDate (date_,nbrejour) {
        const date = new Date(date_);
        date.setDate(date.getDate() + nbrejour);
        return date;
    }

   ////////////calcule du total des jour de congé
   $('#nbrejourtotal').css("display", "none");
   $('#labelnbrejourtotal').css("display", "none");
   $('#nbrejourrestant').css("display", "none");
   $('#labelnbrejourrestant').css("display", "none");
   
    var age =  $("#age").val();
    var ancienete =  $("#anciennete").val();
    var enfant =  $("#enfant").val();
    var statut =  $("#statut").val();
    var genre =  $("#genre").val();
    var motif =  $("#motif").val();
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

$("#dateretour,#datedepart").change(function(){

        var ouvrable = 0;
        var nbrejourouvrable=countDay();
        var age =  $("#age").val();
        var ancienete =  $("#anciennete").val();
        var enfant =  $("#enfant").val();
        var statut =  $("#statut").val();
        var genre =  $("#genre").val();
        var motif =  $("#motif").val();
        
        var datedepart = $("#datedepart").val();
        var fin = Number(nbrejourouvrable);
        var fer= 0;

        for (i = 0; i < fin; i++) { 
            
            jour = ajouterDate(datedepart,i);
            jour_ = jour.getDay();
            if(jour_ === 0){ 
              fer = fer + 1; 
            }

           //console.log(jour.getDay());
  
            }

          
       if (motif == 'CONGE') {

        if(statut == 'CONTRACTUEL'){
             total=26;
             ouvrable = Number(nbrejourouvrable) - Number(fer);
          }else{
             ouvrable = Number(nbrejourouvrable);
             total=30;
          }

          if(ancienete >= 5 && ancienete < 10){
             //ouvrable = Number(nbrejourouvrable) - Number(fer) + 1;
             total=total + 1;
          }else if(ancienete >= 10 && ancienete < 15){
            //ouvrable = Number(nbrejourouvrable) - Number(fer) + 2;
            total=total + 2
          }else if(ancienete >= 15 && ancienete < 20){
            //ouvrable = Number(nbrejourouvrable) - Number(fer) + 3;
            total=total + 3;
          }else if(ancienete >= 20 && ancienete < 25){
            //ouvrable = Number(nbrejourouvrable) - Number(fer) + 5;
            total=total + 5;
          }else if(ancienete >= 25 && ancienete < 30){
            //ouvrable = Number(nbrejourouvrable) - Number(fer) + 7;
            total=total + 7;
          }else if(ancienete > 30 ){
            //ouvrable = Number(nbrejourouvrable) - Number(fer) + 8;
            total=total + 8;
          }

          if(genre == 'F' && age <= 21){
            //ouvrable = ouvrable + ( ( Number(enfant) * 2 ) ) ;
            total = total + ( ( Number(enfant) * 2 ) ) ;
          }else if(genre == 'F' && age > 21){
            if(enfant >= 4){
               //ouvrable = ouvrable + ( (Number(enfant) - 3 ) * 2 );
               total = total + ( (Number(enfant) - 3 ) * 2 );
            }

          }


       }else{

             ouvrable = Number(nbrejourouvrable) - Number(fer);
       }
          
          
           nbrejourrestant=total - ouvrable;
           if(nbrejourrestant < 0){
             $('#ajouter').attr('disabled','true');
             $("#err_nbrjourrestant").css("display","block");
            }else{
              $("#err_nbrjourrestant").css("display","none");
            }
          $("#nbrejourouvrable").val(ouvrable); 
          $("#nbrejourrestant").val(nbrejourrestant);         
        
    });
     
            // console.log(ouvrable);
            nbrejourrestant=total - ouvrable;

          $("#nbrejourrestant").val(nbrejourrestant);


  </script>


@endsection



