@extends('Templates.list_master')

@section('titre')
    Planning List - Aej Admin
@endsection


@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="conges";
$sm="planning";

$agent_function = Session::get('function_key');

$ob_param=Session::get('ob_param');
$nom=$ob_param['nom'] ?? '';
$direction_id=$ob_param['direction_id'] ?? '';
$datedemande=$ob_param['datedemande'] ?? '';
//dd($nom,$datedemande);
@endphp

@section('stylesheet')



@endsection

@section('content')

<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Planning des Congés</h3>

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
         
        <!-- row -->
        <div class="row mt">
          <div class="col-md-12">
            <div class="content-panel">
              <table class="table table-striped table-advance table-hover">
                <div class="position-relative" align="right" style="padding-right:5px">

                  <form method="get" action="{{ route('conge.planning') }}" >
                     {{ csrf_field() }} 
                    <div class="form-group">
                        <label class="col-sm-1 control-label">Recherche:</label>
                        <div class="col-sm-2">
                          <input type="text" class="form-control" name="nom" value="{{$nom}}"/>
                        </div>

                         <label class="col-sm-1 control-label">Direction:</label>
                        <div class="col-sm-2">
                         <select class="form-control" name="direction_id">
                           <option value=""></option>
                           @foreach($directions as $direction)
                           <option value="{{$direction->id}}" <?php if($direction_id==$direction->id){echo 'selected';} ?>>{{$direction->designation}}</option>
                           @endforeach
                         </select>
                        </div>

                        <label class="col-sm-1 control-label">date:</label>
                        <div class="col-sm-2">
                          <input type="date" class="form-control" name="datedemande" value="{{format_date2($datedemande)}}"/>
                        </div>
                    </div >
                    <div class="col-sm-1">
                     <button type="submit" class="btn btn-success" >
                              Rechercher
                    </button>
                   </div>
                   </form>
                      <a class="btn btn-info" data-toggle="modal" data-target="#import_modal" >
                                Importer
                      </a>
                       <a href="{{ route('export.conge',$ob_param) }}" class="btn btn-warning" style="float:right">
                        <i class="fa fa-download"></i> Exporter
                       </a>
                </div>
               <br>
                <hr>
                <thead class="sticky-nav text-green-m1 text-uppercase text-85">
                    <tr>

                      <th class="td-toggle-details border-0 bgc-white shadow-sm">
                       
                      </th>

                       <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Nom
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Fonction
                      </th>
                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                       Intérimaire
                      </th>
                      <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">
                        Date de départ
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Date de retour
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Date de reprise
                      </th>
                      
                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Durée
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
                      <td>
                        <span class="text-105">
                           {{$demande->nomprenoms}}
                        </span>
                        <div class="text-95 text-secondary-d1">
                        </div>
                      </td>

                      <td>
                        <span class="text-105">
                         {{$demande->fonction}}
                        </span>
                      </td>
                      <td class="text-grey">
                       
                        {{$demande->interim}}
                       
                        <div><span class='badge bgc-orange-d1 text-white badge-sm'></span></div>
                      </td>
                      <td>
                        <span class="text-105">
                         {{ format_date($demande->date_depart) }}
                        </span>
                      </td>
                       <td>
                        <span class="text-105">
                         {{ format_date($demande->date_retour) }}
                        </span>
                      </td>
                      <td>
                        <span class="text-105">
                         {{ format_date($demande->date_reprise) }}
                        </span>
                      </td>
                      <td>
                        <span class="text-105">
                         {{ $demande->duree }} Jour.s
                        </span>
                       
                      </td>
                    </tr>

                    @endforeach
                    
                  </tbody>
              </table>
            </div>
           {{ $demandes->links() }}
            <!-- /content-panel -->
          </div>
          <!-- /col-md-12 -->
        </div>
        <!-- /row -->

            <div class="modal fade" id="import_modal" tabindex="-1" role="dialog" aria-labelledby="myimport_modal" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Importer planning <span class="u_comment"></span> </h4>
                    </div>
                    <div class="modal-body">

                      <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('planning.import_in') }}" enctype="multipart/form-data">
                              {{ csrf_field() }}
                        <div class="modal-body ace-scrollbar">

                  <div class="form-group">
                  <label class="col-sm-4 col-sm-4 control-label">Direction / Bureau 
                    <span style="color:red;">*</span>:
                  </label>
                  <div class="col-sm-8">
                   <select  class="form-control" name="direction_id" id="direction_id" required="">
                        <option value=""></option>
                        @foreach($directions as $direction)
                        <option value="{{$direction->id}}">{{$direction->designation}}</option>
                        @endforeach
                      </select>
                  </div>

                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">
                     Planning des congés <span style="color:red;">*</span>:
                    </label>
                  <div class="col-sm-8">
                    <input type="file" name="planning_file" class="form-control" required>
                  </div>


                </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">fermer</button>
                        <button class="btn btn-success" id="ajouter">Ajouter</button>
                      </div>

                  
                    </form>
                      
                    </div>
                    
                  </div>
                </div>
              </div>


      </section>


    @endsection

     @section('scriptjs')
    
     <script >

  function deleteMember(id,opt)
    {
      //alert(id); alert(opt);
      rep = confirm("Voulez-vous Valider cette demande?");
      url = "{{url('/demande/update/state')}}/"+id+"/"+opt;

      if(rep == true)
      {
          window.location.href = url;
      }

    }

    function updatedemande(demande_id,demandeur_name,demandeur_id,demande_motif,interimaire,date_demande,date_depart,date_retour,demande_state) {
alert(demandeur_id);
          $("#demandeur_id").val(demandeur_id);
          $("#demandeur_name").val(demandeur_name);
          $("#demande_id").val(demande_id);
          $("#demande_motif").val(demande_motif);
          $("#interimaire").val(interimaire);
          $("#date_demande").val(date_demande);
          $("#date_depart").val(date_depart);
          $("#date_retour").val(date_retour);
          $("#demande_state").val(demande_state);
    }

    </script>


   <script>

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
          }
          else
          {
             $('#absence').css("display", "none");
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

   $("#dateretour,#datedepart").change(function(){
        var dateretour = $("#dateretour").val();
        var datedepart = $("#datedepart").val();
        var start = moment(dateretour, "YYYY-MM-DD");
        var end = moment(datedepart, "YYYY-MM-DD");
        var nbrejourouvrable = moment.duration(start.diff(end)).asDays();
        var nbrejour;
        
        if(isNaN(nbrejourouvrable)){ nbrejourouvrable= ""}
        // console.log(nbrejourouvrable);
        $("#nbrejourouvrable").val(nbrejourouvrable);
    });

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
                                  $('#dateretour').removeAttr('disabled');
                                  $('#ajouter').removeAttr('disabled');

                              }



               }
      else{

        if (depart <= today) {

                           $("#err_datedepart").css("display","block");
                           $('#dateretour').attr('disabled','true');
                           $('#ajouter').attr('disabled','true');

                            }else{

                                  $("#err_datedepart").css("display","none");
                                  $('#dateretour').removeAttr('disabled');
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


  </script>
     
    @endsection



