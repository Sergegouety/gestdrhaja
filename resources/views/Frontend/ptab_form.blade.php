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

$function_key=Session::get('function_key');
//dd($function_key);
$is_admin=$function_key->isptabadmin;
$level = $function_key->level;
$sd = $function_key->sousdirection_id;
$is_agence = get_isagence($level, $sd);
//dd($level, $sd,$is_agence);

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
              <h4 class="mb">Nouvelle Action</h4>
              <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('add.ptab') }}">
                             {{ csrf_field() }} 
                  <div class="modal-body ace-scrollbar">

                  <input type="hidden" name="tid"  value="{{$tid}}" />
                  <input type="hidden" name="direction" id="direction" value="{{$function_key->direction_id}}" />
                  <input type="hidden" name="is_agence" id="is_agence" value="{{$is_agence}}" />
                  <input type="hidden" name="responsable" id="responsable" />
                  <input type="hidden" name="matricule" id="matricule" />
                  <input type="hidden" name="type" value="1" />

                  
<!-- <div <?php if($tid != 'action'){ echo 'style="display:none"';} ?> > -->
  <div >
@if($is_admin)
    <div class="form-group">
      <label class="col-sm-3 control-label">
        Direction / Bureau <span style="color:red;">*</span>:
      </label>
    <div class="col-sm-3">
      <select class="form-control" onchange="getSousdirection(this.value)" name="direction_" id="direction_">
           <option value=""></option>
             @foreach($directions as $direction)
           <option value="{{ $direction->id }}">
            {{ $direction->designation }}
            </option>
            @endforeach
      </select>
    </div>

  </div>

                <br>
@endif
                  <div class="form-group">

                  <label class="col-sm-3 control-label">Sous-Direction / Agence <span style="color:red;">*</span>:
                  </label>
                  <div class="col-sm-3">
                    <select class="js-example-basic-single form-control" name="sousdirection" id="sousdirection" onchange="getServiceandresponsable(this.value)">
                          <option value=""></option>
                    </select>
                  </div>

                  <!-- <label class="col-sm-3 control-label">Service / Guichet <span style="color:red;">*</span>:
                  </label>
                  <div class="col-sm-3">
                    <select class="js-example-basic-single form-control" name="service" id="service">
                          <option value=""></option>
                    </select>
                  </div> -->

                </div>
                <br>
                
                   <div class="form-group row" >
                    <label class="col-sm-2 col-sm-2 control-label">Axe Stratégique</label>
                    <div class="col-sm-4">
                     <select class="form-control" name="axe" id="axe" onchange="getExtrant(this.value)" required="">
                        <option></option>
                         @foreach($axes as $axe)
                          <option value="{{$axe->id}}">{{ $axe->id.' : '.$axe->axe}}</option>
                         @endforeach
                    </select>
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label">Extrant</label>
                    <div class="col-sm-4">
                     <select class="form-control" name="extrant" id="extrant" onchange="getAction(this.value)" required="">
                        <option></option>
                    </select>
                    </div>
                    </div>
                    <!--  <div class="form-group row" >
                    <label class="col-sm-2 col-sm-2 control-label">Reference</label>
                    <div class="col-sm-2">
                      <textarea class="form-control" name="reference_matrice"></textarea>
                     
                    </div>
                  </div> -->
</div>
               
                  <br>
                  <div class="form-group row">
                    <label class="col-sm-2 col-sm-2 control-label">Action</label>
                    <div class="col-sm-4">
                     <select class="form-control" name="action_id" id="action_id" onchange="getIntituleIndicateur(this.value)">
                        <option ></option>
                    </select>
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label">Responsable <span style="color:red;">*</span>:</label>
                  <div class="col-sm-4">
                    <select class="form-control" id="agent" name="responsable_id" onchange="getAgent(this.value)" required>
                          
                    </select>

                    </div>

                  </div>
                  <br>

                   <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Intitulé action <span style="color:red;">*</span>:</label>
                  <div class="col-sm-4">
                    <textarea class="form-control" name="intitule" id="intitule" required readonly></textarea>
                  </div>

                   <label class="col-sm-2 col-sm-2 control-label">Indicateur action <span style="color:red;">*</span>:</label>
                  <div class="col-sm-4">
                    <textarea class="form-control" name="indicateur" id="indicateur" required readonly></textarea>
                  </div>

                </div>

  
<br>

               <div class="form-group">

                <label class="col-sm-2 col-sm-2 control-label" for="cible_globale">Cible Global <span style="color:red;">*</span>:</label>
                    <div class="col-sm-4">
                    <textarea class="form-control" name="cible_globale" required></textarea>
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

   var direction_id = $('#direction').val()
   //alert(direction_id);
   var url = "{{ url('ajax/sousdirection/show') }}/"+direction_id;
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

    $('#direction').val(id);
    
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


 function getServiceandresponsable(sid)
  {

    
    var id = $('#direction').val();
    var url = "{{ url('ajax/service_and_responsable/show') }}/"+id+"/"+sid;
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
    
    var url = "{{ url('ajax/agent/get') }}/"+id;
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
          $('#responsable').val(data.responsable);
          $('#matricule').val(data.badge);        
      }
    }
);
  }

   function getExtrant(id)
  {
    
    var url = "{{ url('ajax/extrant/show') }}/"+id;
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
          $('select#extrant').html(data.html_first);  
      }
    }
);
  }

   function getAction(id)
  {
    var direction_id = $('#direction').val();
    var isagence = $('#is_agence').val();
    if(isagence==1){is_agence =isagence;}else{is_agence =0;}

    var url = "{{ url('ajax/action/show') }}/"+id+"/"+direction_id+"/"+is_agence;
    //alert(url);
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
          $('select#action_id').html(data.html_first);  
      }
    }
);
  }

  function getIntituleIndicateur(id)
  {

    //alert(id);
    if(id == 'new'){

      $('#intitule').removeAttr('readonly');
      $('#indicateur').removeAttr('readonly');
      $("#intitule").val('');
      $("#indicateur").val('');

    }else{

      $('#intitule').attr('readonly','true');
      $('#indicateur').attr('readonly','true');

      var url = "{{ url('ajax/intituleIndicateur/show') }}/"+id;
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

</script>
  
@endsection



