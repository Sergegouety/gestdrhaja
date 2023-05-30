@extends('Templates.form_master')

@section('titre')
    Noouvelle fonction
@endsection

@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="recherche";
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
              <h4 class="mb"> Nouvelle fonction de {{$agent->nomprenoms}} ( {{$agent->fonction}} )</h4>
              <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('add.fonction') }}">
                             {{ csrf_field() }}
              <input type="hidden" class="form-control" id="uid" name="uid" value="{{$agent->id}}"/>
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
                  <div class="col-sm-6">
                    <select  class="form-control js-example-basic-single" name="diplome" required="" >
                      <option value=""></option>
                        @foreach($diplomes as $diplome)
                         <option value="{{$diplome->diplome}}">{{$diplome->diplome}}</option>
                         @endforeach
                      </select>
                  </div>

                </div>

<br>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Fonction <span style="color:red">*</span>:</label>
                  <div class="col-sm-4">
                    <select  class="form-control js-example-basic-single" name="level" required="" >
                      <option value=""></option>
                        @foreach($grades as $grade)
                         <option value="{{$grade->id}}">{{$grade->name}}</option>
                         @endforeach
                      </select>
                  </div>

                   <label class="col-sm-2 col-sm-2 control-label">Poste <span style="color:red">*</span>:</label>
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
<br>
                <div class="form-group">

                   <label class="col-sm-2 col-sm-3 control-label">Prise de service <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <input type="date" class="form-control" id="datedebut" name="datedebut" required=""/>
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label"> Statut <span style="color:red">*</span>:</label>
                  <div class="col-sm-2">
                    <select class="form-control"  name="statut" required="" onchange="displaydatefin(this.value)">
                        <option value=""></option>
                        <option value="CONTRACTUEL">Contractuel</option>
                         <option value="FONCTIONNAIRE">Fonctionnaire</option>
                      </select>
                  </div>

                <span style="display:none" id="gradelabel">
                   <label class="col-sm-2 col-sm-2 control-label">Grade:</label>
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

  </script>

  @endsection