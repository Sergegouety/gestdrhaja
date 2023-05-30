@extends('Templates.form_master')

@section('titre')
    ptab detail
@endsection


@php
use Carbon\Carbon;

$current = Carbon::now();
$active="active";
$open="open";
$show="show";
$d="#";
$page="evaluation";
$sm="ptab";

$actionIntitule ='';
$actionId ='';
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
              <h4 class="mb"><?php if($tid=='action'){ echo 'Nouvelle Action';}elseif($tid=='activite'){ echo 'Nouvelle Activité';}else{ echo 'Nouvelle Tâche';} ?></h4>
              <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('add.ptab') }}">
                             {{ csrf_field() }} 
                  <div class="modal-body ace-scrollbar">

                  <input type="hidden" name="tid"  value="{{$tid}}" />
                  <input type="hidden" name="direction" id="direction"  value="{{$ptab->direction_id}}" />
                  <input type="hidden" name="sousdirection" id="sousdirection"  value="{{$ptab->sousdirection_id}}" />
                  <input type="hidden" name="service" id="service"  value="{{$ptab->service_id}}" />
                  <input type="hidden" id="type_activite" name="type_activite"  value="{{$ptab->reference_matrice}}" />
                  <input type="hidden" id="extrant" name="extrant"  value="{{$ptab->extrant_id}}" />
                  <input type="hidden" name="type" value="3" />
                  <input type="hidden" name="responsable" id="responsable" />
                  <input type="hidden" name="matricule" id="matricule" />
                  
                  <br>
                   <div class="form-group row" >
                   
                    @php
                      $action=getActionByActiviteId($id);
                      $actionIntitule=$action->intitule;
                      $actionId=$action->id;
                      @endphp
                      <input type="hidden" name="action_id"  value="{{$actionId}}" />
                      <input type="hidden" name="activite_id"  value="{{$id}}" />
                   
                    <label class="col-sm-2 col-sm-2 control-label">Intitulé Action :</label>
                    <div class="col-sm-4">
                     <textarea class="form-control" name="action" rows="4" readonly>{{$actionIntitule}}</textarea>
                    </div>
                   
                   
                    <label class="col-sm-2 col-sm-2 control-label">Intitulé Activité :</label>
                    <div class="col-sm-4">
                     <textarea class="form-control" name="activite" rows="4" readonly>{{$ptab->intitule}}</textarea>
                    </div>
                  
                  </div>
                  <br>
                  <div class="form-group row">
                    <label class="col-sm-2 col-sm-2 control-label">Tâche</label>
                    <div class="col-sm-4">
                     <select class="form-control" name="tache_id" id="tache_id" onchange="getTacheIntituleIndicateur(this.value)"></select>
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label">Responsable :</label>
                  <div class="col-sm-4">
                    <select class="form-control" id="agent" name="responsable_id" required onchange="getAgent(this.value)">
                          
                    </select>

                    </div>

                  </div>
                  <br>

                   <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Intitulé tache :</label>
                  <div class="col-sm-4">
                    <textarea class="form-control" name="intitule" id="intitule" required readonly></textarea>
                  </div>

                   <label class="col-sm-2 col-sm-2 control-label">Indicateur tache:</label>
                  <div class="col-sm-4">
                    <textarea class="form-control" name="indicateur" id="indicateur" required readonly></textarea>
                  </div>

                </div>

  
<br>

               <div class="form-group">

                <label class="col-sm-2 col-sm-2 control-label" for="cible_globale">Cible Global :</label>
                    <div class="col-sm-4">
                    <textarea class="form-control" name="cible_globale"></textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label">Coût global:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="cout_global" >
                  </div>

                </div>

                 <div class="form-group">

                <label class="col-sm-2 col-sm-2 control-label" for="cible_t1">Cible 1er Trimestre :</label>
                    <div class="col-sm-4">
                    <textarea class="form-control" name="cible_t1"></textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label">Coût 1er Trimestre:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="cout_t1" >
                  </div>

                </div>

                 <div class="form-group">

                <label class="col-sm-2 col-sm-2 control-label" for="cible_t2">Cible 2eme Trimestre :</label>
                    <div class="col-sm-4">
                    <textarea class="form-control" name="cible_t2"></textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label">Coût 2eme Trimestre:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="cout_t2" >
                  </div>

                </div>

                 <div class="form-group">

                <label class="col-sm-2 col-sm-2 control-label" for="cible_t3">Cible 3eme Trimestre :</label>
                    <div class="col-sm-4">
                    <textarea class="form-control" name="cible_t3"></textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label">Coût 3eme Trimestre:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="cout_t3" >
                  </div>

                </div>

                <div class="form-group">

                <label class="col-sm-2 col-sm-2 control-label" for="cible_t4">Cible 4eme Trimestre :</label>
                    <div class="col-sm-4">
                    <textarea class="form-control" name="cible_t4"></textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label">Coût 4eme Trimestre:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="cout_t4" >
                  </div>

                </div>

                <div class="form-group">

                <label class="col-sm-2 col-sm-2 control-label" for="objetabsence">Entité Prenante :</label>
                    <div class="col-sm-4">
                    <textarea class="form-control" name="entite_prenante"></textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label">Action de l'entité:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="entite_action" >
                  </div>

                </div>

                <div class="form-group">

                <label class="col-sm-2 col-sm-2 control-label" for="objetabsence">Periode d'execution :</label>
                    <div class="col-sm-4">
                    <textarea class="form-control" name="periode_execution"></textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label">Zone d'execution:</label>
                  <div class="col-sm-4">
                    <textarea class="form-control" name="zone_execution"></textarea>
                  </div>

                </div>
              
<br>
                

                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-warning" data-dismiss="modal">
                      Fermer
                    </button> -->

                    <button type="submit" class="btn btn-success" id="ajouter">
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
<script type="text/javascript">

  
    serviceId = $('#service').val();
    directionId = $('#direction').val();
    sousdirectionId = $('#sousdirection').val();
  var url = "{{ url('ajax/all_agent_responsable/show') }}/"+directionId+"/"+sousdirectionId+"/"+serviceId;
  //alert(url);
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
          $('select#agent').html(data.html_two);        
      }
    }
);

     type_activite = $('#type_activite').val();
     var url = "{{ url('ajax/tache/show') }}/"+type_activite;
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
         $('select#tache_id').html(data.html_first);  
         
            //console.log(data)
      }
    }
);


  justif=$("#justif").val();
  if(justif==2){ $("#justif").css("display","block");}else{$("#justif").css("display","none");}

   function displayJustification(id)
  {

       if (id == 2) {
              $("#justif").css("display","block");
            }else {
                  $("#justif").css("display","none");
                  }
  }
</script>

<script type="text/javascript">
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

  function getTacheIntituleIndicateur(id)
  {

    if(id == 'new'){

      $('#intitule').removeAttr('readonly');
      $('#indicateur').removeAttr('readonly');
      $("#intitule").val('');
      $("#indicateur").val('');

    }else{
      $('#intitule').attr('readonly','true');
      $('#indicateur').attr('readonly','true');
      var url = "{{ url('ajax/tacheIntituleIndicateur/show') }}/"+id;
      $.ajax(
             {
              type: "get",
              url: url,
              success: function(data)
              {
                  $('#intitule').val(data.intitule);  
                   $('#indicateur').val(data.indicateur); 
                   // console.log(data)
              }
            }
        );

    }
    
  }

  function getAgent(id)
  {

    //alert(id);
    
    var url = "{{ url('ajax/agent/get') }}/"+id;
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
          $('#responsable').val(data.responsable);
          $('#matricule').val(data.badge);  
          $('#service').val(data.service);       
      }
    }
);
  }


</script>
  
@endsection



