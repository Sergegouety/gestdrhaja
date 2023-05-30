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

$agent_function = Session::get('function_key');
$responsable_userid = get_responsableid( $ptab->responsable );
//dd($agent_function,$ptab,$responsable_userid, auth()->user()->id);
$isptabadmin= $agent_function->isptabadmin;
$level= $agent_function->level;
if($tid=='tache'){$grade=1;}
if($tid=='activite'){$grade=2;}
if($tid=='action'){$grade=3;}

$isptabHelper= get_ptab_helper(auth()->user()->id);

//dd($isptabHelper , $isptabadmin);

@endphp

@section('stylesheet')
<link rel="stylesheet" type="text/css" href="{{asset('lib/gritter/css/jquery.gritter.css')}}" />
@endsection

@section('content')

<section class="wrapper">
  <div class="row mt">
          <div class="col-lg-12">

            <a class="btn btn-info btn-bold opacity-2" href="javascript:history.go(-1)" >Retour</a>
            <div class="form-panel">
              <h4 class="mb">Modifier Tache</h4>
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
            <div class="row">

                <div class="modal-body ace-scrollbar">
                 <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('update.ptab.detail') }}" id="form_action">
                   {{ csrf_field() }} 

                  <input type="hidden" name="action_id" value="{{$ptab->id}}">
                  <input type="hidden" name="tid" value="{{$tid}}">
                   <input type="hidden" name="type_action" value="{{@$master_actions->action_id}}">
                    <input type="hidden" name="extrant" value="{{@$master_actions->extrant_id}}">
                    <input type="hidden" name="action" value="{{@$ptab->action_id}}">
                   <input type="hidden" name="activite" value="{{@$ptab->activite_id}}">
                   <input type="hidden" name="type_activite" value="{{@$master_activites->id}}">
                   <input type="hidden" name="responsable" id="responsable" />
                  <div class="form-group">
                    

                    <label class="col-sm-2 col-sm-2 control-label" style="padding-top: 10px;">Intitulé Action :</label>
                     <div class="col-sm-10" style="padding-top: 10px;">
                     <textarea class="form-control" rows="3" readonly >{{@$master_actions->ref}} : {{getInstanceName('action','id',$ptab->action_id,'intitule')}}</textarea>
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label" style="padding-top: 10px;">Indicateur Action :</label>
                    <div class="col-sm-10" style="padding-top: 10px;">
                      <textarea class="form-control" rows="3" readonly >{{getInstanceName('action','id',$ptab->action_id,'indicateur')}}</textarea>
                    </div>
                   
                   <label class="col-sm-2 col-sm-2 control-label" style="padding-top: 10px;">Intitulé Activité:</label>
                    <div class="col-sm-10" style="padding-top: 10px;">
                      <textarea class="form-control" rows="3" readonly >{{@$master_activites->ref}} : {{getInstanceName('action','id',$ptab->activite_id,'intitule')}}</textarea>
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label" style="padding-top: 10px;">Indicateur Activité :</label>
                    <div class="col-sm-10" style="padding-top: 10px;">
                      <textarea class="form-control" rows="3" readonly >{{getInstanceName('activite','id',$ptab->activite_id,'indicateur')}}</textarea>
                    </div>

                     <label class="col-sm-2 col-sm-2 control-label" style="padding-top: 10px;">Tâche :</label>
                    <div class="col-sm-10" style="padding-top: 10px;">
                     <select class="form-control" name="master_tache_id" id="master_tache_id" onchange="getTacheIntituleIndicateur(this.value)">
                      <option></option>
                      @foreach($master_taches as $tache)
                          <option value="{{@$tache->id}}" <?php if(@$tache->id == $ptab->reference_matrice){ echo 'selected';} ?> >{{ @$tache->ref.' : '.@$tache->intitule_tache}}</option>
                         @endforeach
                         <option value="new">Autre tâche</option>
                    </select>
                    </div>

                     <label class="col-sm-2 col-sm-2 control-label" style="padding-top: 10px;">Intitulé :</label>
                    <div class="col-sm-10" style="padding-top: 10px;">
                      <textarea class="form-control" rows="3" name="intitule" id="intitule" readonly >{{getInstanceName('tache','id',$ptab->id,'intitule')}}</textarea>
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label" style="padding-top: 10px;">Indicateur :</label>
                    <div class="col-sm-10" style="padding-top: 10px;">
                      <textarea class="form-control" rows="3" name="indicateur" id="indicateur" readonly >{{getInstanceName('tache','id',$ptab->id,'indicateur')}}</textarea>
                    </div>

                    
                    <label class="col-sm-2 col-sm-2 control-label" style="padding-top: 10px;">Responsable :</label>
                    <div class="col-sm-10" style="padding-top: 10px;">
                      <select class="form-control" name="user_id" id="user_id" onchange="getAgent(this.value)" >
                            <option value=""></option>
                            @foreach($agents as $agent)
                             <option value="{{$agent->id}}" <?php if($agent->id == $ptab->user_id){echo 'selected';} ?> >{{ $agent->nomprenoms }}</option>
                            @endforeach
                      </select>
                    </div>
                </div>

               <div class="form-group" >
                <label class="col-sm-2 col-sm-2 control-label" for="cible_globale" style="padding-top: 10px;">Cible Global :</label>
                    <div class="col-sm-4" style="padding-top: 10px;">
                    <textarea class="form-control" name="cible_globale" >{{$ptab->cible_glo}}</textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label"style="padding-top: 10px;">Coût global:</label>
                  <div class="col-sm-4"style="padding-top: 10px;">
    <input type="text" class="form-control" name="cout_global" value="{{$ptab->cout_glo}}"  >
                  </div>
                </div>

                <div class="form-group" >
                <label class="col-sm-2 col-sm-2 control-label" for="cible_t1" style="padding-top: 10px;">Cible 1er Trim :</label>
                    <div class="col-sm-4" style="padding-top: 10px;">
                    <textarea class="form-control" name="cible_t1" >{{$ptab->cible_t1}}</textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label"style="padding-top: 10px;">Coût 1er Trim:</label>
                  <div class="col-sm-4"style="padding-top: 10px;">
    <input type="text" class="form-control" name="cout_t1" value="{{$ptab->cout_t1}}"  >
                  </div>
                </div>

                <div class="form-group" >
                <label class="col-sm-2 col-sm-2 control-label" for="cible_t2" style="padding-top: 10px;">Cible 2ème Trim :</label>
                    <div class="col-sm-4" style="padding-top: 10px;">
                    <textarea class="form-control" name="cible_t2" >{{$ptab->cible_t2}}</textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label"style="padding-top: 10px;">Coût 1er Trim:</label>
                  <div class="col-sm-4"style="padding-top: 10px;">
    <input type="text" class="form-control" name="cout_t2" value="{{$ptab->cout_t2}}"  >
                  </div>
                </div>

                <div class="form-group" >
                <label class="col-sm-2 col-sm-2 control-label" for="cible_t3" style="padding-top: 10px;">Cible 3ème Trim :</label>
                    <div class="col-sm-4" style="padding-top: 10px;">
                    <textarea class="form-control" name="cible_t3" >{{$ptab->cible_t3}}</textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label"style="padding-top: 10px;">Coût 3ème Trim:</label>
                  <div class="col-sm-4"style="padding-top: 10px;">
    <input type="text" class="form-control" name="cout_t3" value="{{$ptab->cout_t3}}"  >
                  </div>
                </div>

                <div class="form-group" >
                <label class="col-sm-2 col-sm-2 control-label" for="cible_t4" style="padding-top: 10px;">Cible 4ème Trim :</label>
                    <div class="col-sm-4" style="padding-top: 10px;">
                    <textarea class="form-control" name="cible_t4" >{{$ptab->cible_t4}}</textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label"style="padding-top: 10px;">Coût 4ème Trim:</label>
                  <div class="col-sm-4"style="padding-top: 10px;">
    <input type="text" class="form-control" name="cout_t4" value="{{$ptab->cout_t4}}"  >
                  </div>
                </div>

                <div class="form-group">

                <label class="col-sm-2 col-sm-2 control-label" for="entite_prenante">Entité Prenante :</label>
                    <div class="col-sm-4">
                    <textarea class="form-control" name="entite_prenante">{{$ptab->entite_prenante}}</textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label">Action de l'entité:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="action_entite" value="{{$ptab->action_entite}}" >
                  </div>

                </div>

                <div class="form-group">

                <label class="col-sm-2 col-sm-2 control-label" for="periode_execution">Periode d'execution :</label>
                    <div class="col-sm-4">
                    <textarea class="form-control" name="periode_execution">{{$ptab->periode_execution}}</textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label">Zone d'execution:</label>
                  <div class="col-sm-4">
                    <textarea class="form-control" name="zone_exection">{{$ptab->zone_exection}}</textarea>
                  </div>

                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-success" id="ajouter" onclick="submit_form()">
                  Modifier
                </button>
              </div>

                  </form>
                </div>
              
            </div>

          </div>

          </div>
  </div>
</section>


@endsection

@section('scriptjs')
<script>

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

 function getTacheIntituleIndicateur(id)
  {
   
    if(id == 'new'){

      $('#intitule').removeAttr('readonly');
      $('#indicateur').removeAttr('readonly');
      // $("#intitule").val('');
      // $("#indicateur").val('');

    }else{
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
    
    var url = "{{ url('ajax/action/show') }}/"+id;
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
          $('select#master_action_id').html(data.html_first);  
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

  function submit_form(){
    document.getElementById("form_action").submit();
  }

</script>
<script type="text/javascript">
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

  $('#add-without-image1').click(function(){

        $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'A lire Attentivement SVP!',
            // (string | mandatory) the text inside the notification
            text: 'LORSQUE LA CIBLE DE L’INDICATEUR EsT DISPONIBLE, vous ne pouvez renseigner que disponible ou non disponible. <br/> LORSQUE LA CIBLE DE L’INDICATEUR EsT oui, vous ne pouvez renseigner que oui ou non. <br/> LORSQUE LA CIBLE DE L’INDICATEUR est un nombre, vous ne pouvez renseigner qu’un nombre.'
        });

        return false;
    });

  $('#add-without-image2').click(function(){

        $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'A lire Attentivement SVP!',
            // (string | mandatory) the text inside the notification
            text: 'LORSQUE LA CIBLE DE L’INDICATEUR EsT DISPONIBLE, vous ne pouvez renseigner que disponible ou non disponible. <br/> LORSQUE LA CIBLE DE L’INDICATEUR EsT oui, vous ne pouvez renseigner que oui ou non. <br/> LORSQUE LA CIBLE DE L’INDICATEUR est un nombre, vous ne pouvez renseigner qu’un nombre.'
        });

        return false;
    });

  $('#add-without-image3').click(function(){

        $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'A lire Attentivement SVP!',
            // (string | mandatory) the text inside the notification
            text: 'LORSQUE LA CIBLE DE L’INDICATEUR EsT DISPONIBLE, vous ne pouvez renseigner que disponible ou non disponible. <br/> LORSQUE LA CIBLE DE L’INDICATEUR EsT oui, vous ne pouvez renseigner que oui ou non. <br/> LORSQUE LA CIBLE DE L’INDICATEUR est un nombre, vous ne pouvez renseigner qu’un nombre.'
        });

        return false;
    });

  $('#add-without-image4').click(function(){

        $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'A lire Attentivement SVP!',
            // (string | mandatory) the text inside the notification
            text: 'LORSQUE LA CIBLE DE L’INDICATEUR EsT DISPONIBLE, vous ne pouvez renseigner que disponible ou non disponible. <br/> LORSQUE LA CIBLE DE L’INDICATEUR EsT oui, vous ne pouvez renseigner que oui ou non. <br/> LORSQUE LA CIBLE DE L’INDICATEUR est un nombre, vous ne pouvez renseigner qu’un nombre.'
        });

        return false;
    });
</script>


<script type="text/javascript" src="{{asset('lib/gritter/js/jquery.gritter.js')}}"></script>

<script type="text/javascript">

  function changestatut(id,opt,trim){

            $("#action_id").val(id);
            $("#opt").val(opt);
            $("#trim").val(trim);
            if(opt==1){
               $("#myModalLabel").html("Valider le Livrable");
             }else if(opt==2){
              $("#myModalLabel").html("Réjeter le livrabre");
             }else{
              $("#myModalLabel2").html("Ajouter un livrable");
             }


          }

function changeLivrable(id,opt,trim){

            $("#action_idl").val(id);
            $("#optl").val(opt);
            $("#triml").val(trim);
            $("#myModalLabel2").html("Ajouter un livrable");
            var livrableName='';
            if (trim ==1) {livrableName = 'livrable_t1';}
            else if(trim==2){livrableName = 'livrable_t1';}
            else if(trim==3){livrableName = 'livrable_t3';}
            else if(trim==4){livrableName = 'livrable_t4';}
            else {livrableName = 'livrable_final';}
            document.getElementById('livrable').name = livrableName;

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
          // $('#matricule').val(data.badge);  
          // $('#service').val(data.service);       
      }
    }
);
  }

  var user_id = $('#user_id').val();
  var url = "{{ url('ajax/agent/get') }}/"+user_id;
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
          $('#responsable').val(data.responsable);   
      }
    }
);

</script>
  
@endsection
