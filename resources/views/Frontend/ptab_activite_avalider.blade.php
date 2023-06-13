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

$ses_page = Session::get('ses_page');
if($ses_page){ $url_page = '/ptab?page='.$ses_page;}else{ $url_page = '/ptab';}


$agent_function = Session::get('function_key');

$isptabadmin= $agent_function->isptabadmin;
$level= $agent_function->level;

$isptabHelper= get_ptab_helper(auth()->user()->id);

//dd($isptabHelper , $isptabadmin);

$sd = $agent_function->sousdirection_id;
$is_agence = get_isagence($level, $sd);


$search_name = permit_search_name($isptabadmin,$level);
$search_direction = permit_search_direction($isptabadmin,$level);
$search_sdirection = permit_search_sdirection($isptabadmin,$level);
//dd($search_name,$search_sdirection,$search_direction);

$ajout = is_activve(1);
$desactive = is_activve(2);
$retire = is_activve(3);
$modif = is_activve(4);
$supprime = is_activve(5);

@endphp

@section('stylesheet')
<link rel="stylesheet" type="text/css" href="{{asset('lib/gritter/css/jquery.gritter.css')}}" />
<script src="{{asset('lib/chart-master/Chart.js')}}"></script>
@endsection

@section('content')

<section class="wrapper">
  <div class="row mt">
          <div class="col-lg-12">

            <a class="btn btn-info btn-bold opacity-2" href="{{url($url_page)}}" >Retour</a>

            <div class="form-panel">
              <h4 class="mb">Statistique action</h4>
          
            <div class="row">
                <div class="modal-body ace-scrollbar">
                <div class="col-md-4 col-sm-4 mb">
                <div class="white-panel pn donut-chart">
                  <div class="white-header">
                    <h5>ACTIVITES A VALIDER</h5>
                  </div>
                  <canvas id="serverstatus01" height="120" width="120"></canvas>
                  <script>
                    var doughnutData = [{
                        value: {{$total_activites - $total_activite_realises}},
                        color: "#FF6B6B"
                      },
                      {
                        value: {{$total_activite_realises}},
                        color: "#fdfdfd"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus01").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <div class="row">
                    <div class="col-sm-6 col-xs-6 goleft">
                      <p>TAUX<br/>DE REALISATION:</p>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                       @php if($total_activites == 0){$total_ = 1;}else{$total_ = $total_activites;} @endphp
                      <h2>{{round(($total_activite_realises / $total_)*100,2)}}%</h2>
                    </div>
                  </div>
                </div>
                <!-- /grey-panel -->
              </div>

              <div class="col-md-8 col-sm-8 mb">
                <div class="white-panel pn donut-chart">
                  <div class="white-header">
                    <h5>ACTIVITES A VALIDER</h5>
                  </div>

                  <h4 style="text-align: left; margin: 5px;">Nombre d'activités totale : {{$total_activites}}</h4><br>
                   <h4 style="text-align: left; margin: 5px;">Nombre d'activités réalisées à valider : {{$total_activite_realises}}</h4><br>
                  <h4 style="text-align: left; margin: 5px;">Nombre d'activités partiellement réalisées à valider : {{$total_activite_patrealises}}</h4><br>
                  <h4 style="text-align: left; margin: 5px;">Nombre d'activités non réalisées à valider : {{$total_activite_nonrealises}}</h4>
                  
                </div>
                <!-- /grey-panel -->
              </div>

              
                </div>
              
            </div>

          </div>

          <div class="row mt">
          <div class="col-lg-12">
            <div class="content-panel">
              
              <section id="no-more-tables">
                <table class="table table-bordered table-striped table-condensed cf">
                  <thead class="cf">
                    <tr>
                      <th>#</th>
                      <th>ref.</th>
                      <th>Responsable</th>
                      <th>Intitule</th>
                      <th>Indicateur</th>
                      <th>Action à mener</th>
                      <th>Statut</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $i =1; @endphp
                    @foreach($actions as $action)
                    @php $responsable_userid = get_responsableid( $action->responsable );  @endphp
                    <tr>
                      <td >{{$i}}</td>
                      <td >
                        <?php 
                        if($action->type_id==1){
                          @$ref = getInstanceName('master_action','id',$action->reference_matrice,'ref');
                          echo $ref;
                        }elseif($action->type_id==2){
                          @$ref = getInstanceName('master_activite','id',$action->reference_matrice,'ref');
                          echo $ref;
                        }else{
                          @$ref = getInstanceName('master_tache','id',$action->reference_matrice,'ref');
                          echo $ref;} 
                        ?>
                      </td>
                      <td >{{$action->responsable}}</td>
                      <td >{{$action->intitule}}</td>
                      <td >{{$action->indicateur}}</td>
                     
                      <td >
                  <div class="btn-group">
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-th"></i>
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    
                     
                     @if($action->type_id == 2)
                    <!-- <li><a onclick="actiondedetail('activite',{{$action->id}})" href="#">Voir Détail</a></li> -->
                    <li><a href="{{route('tache.avalider',[$action->id,3])}}">Valider les taches</a></li>
                    <li><a onclick="actiondedetail('activite',{{$action->id}})" href="#">Etat d'avancement</a></li>
                    <li class="divider"></li>
                     @if($desactive && $action->state == null && ($level == 3 || Session::get('function_key')->isptabadmin))
                    <li><a data-toggle="modal" data-target="#arretModal" onclick="actionarreter({{$action->id}},{{$action->type_id}},-1)" href="#">Désactiver</a></li>
                    @endif

                    @if($retire && $action->state != -3 && $action->state != -4 && ($level == 3 || Session::get('function_key')->isptabadmin))
                    <li><a data-toggle="modal" data-target="#arretModal" onclick="actionarreter({{$action->id}},{{$action->type_id}},-3)" href="#">Rétirer</a></li>
                    @endif

                    @endif
                    
                    @if($desactive)
                    @if($action->state == -1 && show_confirme($action->id,Auth::id()))
                     <li><a data-toggle="modal" data-target="#arretModal" onclick="actionconfirmarret({{$action->id}},{{$action->type_id}},-2)" href="#">Confirmer désactivation</a></li>
                    @endif

                     @if($action->state == -2)
                    <li><a onclick="actionretrait({{$action->id}},{{$action->type_id}},0)" href="#">Activer</a></li>
                    @endif

                    @endif

                    @if($retire)
  
                    @if($action->state == -3 && show_confirme($action->id,Auth::id()))
                    <li><a data-toggle="modal" data-target="#arretModal" onclick="actionconfirmarret({{$action->id}},{{$action->type_id}},-4)" href="#">Confirmer retrait</a></li>
                    @endif
                    @endif
                   
                    @if($action->type_id==1)
                    @if($modif)
                    <li><a onclick="actionEdit('activite',{{$action->id}})" href="#">Modifier</a></li>
                    @endif
                    @if($ajout)
                       <li>
                        <a class="dropdown-item" onclick="actiondajout( 'activite',{{$action->id}} )" href="#">
                        Ajouter Activité
                        </a>
                      </li>
                      @endif
                      @endif
                      @if($action->type_id==2)
                      @if($modif)
                      <li><a onclick="actionEdit('activite',{{$action->id}})" href="#">Modifier</a></li>
                      @endif
                      @if($ajout)
                       <li>
                        <a class="dropdown-item" onclick="actiondajout('tache',{{$action->id}})" href="#">
                        Ajouter Tâche
                        </a>
                      </li>
                      @endif
                      @endif
                      @if($modif)
                      @if($action->type_id==3)
                      <li><a onclick="actionEdit('tache',{{$action->id}})" href="#">Modifier</a></li>
                      @endif
                      @endif
                      @if($supprime)
                       <li><a onclick="actionretrait({{$action->id}},{{$action->type_id}},-5)" href="#">Supprimer</a></li>
                       @endif
                  </ul>
                </div>
                      </td>
                       <td >
          <?php if($action->state == -2){ echo '<span class="badge bg-important">DESACTIVEE</span>';} ?> 
          <?php if($action->state == -1){ echo '<span class="badge bg-warning">Désactivation en attente</span>';} ?> 
          <?php if($action->state == -3){ echo '<span class="badge bg-warning">Retrait en attente</span>';} ?>
          <?php if($action->state == -4){ echo '<span class="badge bg-important">RETIREE</span>';} ?> 
          <?php if($action->state == 1){ echo '<span class="badge bg-important">NON REALISEE</span>';} ?> 
          <?php if($action->state == 2){ echo '<span class="badge bg-warning">PART. REALISEE</span>';} ?> 
          <?php if($action->state == 3){ echo '<span class="badge bg-success">REALISEE</span>';} ?> 
                      </td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                  </tbody>
                </table>
              </section>
            </div>
      
            <!-- /content-panel -->
          </div>
          <!-- /col-lg-12 -->
        </div>
          </div>
  </div>
</section>

<div class="modal fade" id="arretModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Demande d'arret <span class="u_comment"></span> </h4>
                    </div>
                    <div class="modal-body">

                      <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{route('add.arret.periode')}}" enctype="multipart/form-data" id="arret_form">
                           {{ csrf_field() }} 
                           <input type="hidden" name="instance_id" id="instance_id">
                           <input type="hidden" name="type_id" id="type_id">
                           <input type="hidden" name="val" id="val">
                        <div class="modal-body ace-scrollbar">

                        <div class="form-group">

                        <label class="col-sm-12 col-sm-12 control-label">Periode d'arrêt:</label>

                        <label class="checkbox-inline" style="padding:20px">
                        <input type="checkbox" id="inlineCheckbox1" name="arret1">1er Trimestre
                        </label>

                        <label class="checkbox-inline" style="padding:20px">
                        <input type="checkbox" id="inlineCheckbox2" name="arret2" >2ème Trimestre
                        </label>

                        <label class="checkbox-inline" style="padding:20px">
                        <input type="checkbox" id="inlineCheckbox3" name="arret3">3ème Trimestre
                        </label>

                        <label class="checkbox-inline" style="padding:20px">
                        <input type="checkbox" id="inlineCheckbox4" name="arret4">4ème Trimestre
                        </label>
                        </div>
                        <br>

                        <div class="form-group">

                        <label class="col-sm-4 col-sm-4 control-label">Motif de l'arrêt :</label>
                        <div class="col-sm-8">
                          <textarea class="form-control" id="commentaire" name="commentaire" rows="4" required></textarea>
                        </div>

                        </div>

                        <div class="form-group">
                        <label class="col-sm-4 col-sm-4 control-label">Joindre un fichier :</label>
                         <input class="form-control" type="file" name="justif_action" id="justif_action">
                         <span style="color:red;">Taille Max: 5 Mo</span>
                        </div>

                      </div>
                       <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="ajouter">
                          Enregistrer
                        </button>
                      </div>

                  
                    </form>
                      
                    </div>
                    
                  </div>
                </div>
              </div>


@endsection

@section('scriptjs')
<script src="{{asset('lib/sparkline-chart.js')}}"></script>
<script src="{{asset('lib/zabuto_calendar.js')}}"></script>



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

</script>
   <script >

      function actionretrait(action,type_id,value)
    {
      //alert(action); alert(value); 
      if(value == -5){rep = confirm("Voulez-vous supprimer ?");}
      if(value == -3){rep = confirm("Voulez-vous retirer ?");}
      if(value == -4){rep = confirm("Voulez-vous confirmer le retrait ?");}
      if(value == 0){rep = confirm("Voulez-vous activer ?");}
      
      if(rep){
        url = "{{url('/action/supprime')}}/"+action+"/"+type_id+"/"+value;
        window.location.href = url;
      }
  
    }

     function actionarreter(action,type_id,value)
    {
      //alert(action); alert(value); 
      if(value == -3){
        rep = confirm("Voulez-vous retirer ?");

        $('#inlineCheckbox1').attr('checked','true');
        $('#inlineCheckbox1').attr('readonly','true');
        $('#inlineCheckbox2').attr('checked','true');
        $('#inlineCheckbox2').attr('readonly','true');
        $('#inlineCheckbox3').attr('checked','true');
        $('#inlineCheckbox3').attr('readonly','true');
        $('#inlineCheckbox4').attr('checked','true');
        $('#inlineCheckbox4').attr('readonly','true');
        $('#myModalLabel').html('Demande de retrait');
    }
      if(value == -1){rep = confirm("Voulez-vous arrêter ?");$('#myModalLabel').html('Demande d\'arret');}
      
      if(rep == true){
        $('#instance_id').val(action);$('#type_id').val(type_id);$('#val').val(value);
      }
    }

    function actionconfirmarret(action,type_id,value)
    {
      //alert(action); alert(value); 
       if(value == -4){rep = confirm("Voulez-vous confirmer le retrait ?");}
       if(value == -2){rep = confirm("Voulez-vous confirmer la désactivation ?");}
      
      if(rep == true){
        url = "{{url('ajax/action/archive')}}/"+action+"/"+type_id+"/"+value;
        $.ajax(
                 {
                  type: "get",
                  url: url,
                  success: function(data)
                  {
                    console.log(data);
                      if(data.trimestre1){$('#inlineCheckbox1').attr('checked','true');}  
                      if(data.trimestre2){$('#inlineCheckbox2').attr('checked','true');}  
                      if(data.trimestre3){$('#inlineCheckbox3').attr('checked','true');}  
                      if(data.trimestre4){$('#inlineCheckbox4').attr('checked','true');} 
                      $('#commentaire').val(data.commentaire);
                  }
                }
              );

             $('#instance_id').val(action); $('#type_id').val(type_id); $('#val').val(value)
      }
    }

  function actiondesuppression(table,champ,value)
    {
      //alert(table); alert(champ); alert(value);
      rep = confirm("Voulez-vous supprimer?");
      url = "{{url('/action/delete')}}/"+table+"/"+champ+"/"+value;

      if(rep == true)
      {
          window.location.href = url;
      }

    }

    function actiondedetail(table,value)
    {
      
      url = "{{url('/ptab/detail')}}/"+table+"/"+value;

      window.location.href = url;

    }

     function actionEdit(table,value)
    {
      
      url = "{{url('/ptab/edit')}}/"+table+"/"+value;

      window.location.href = url;

    }

    function actiondajout(table,id)
    {
      
      url = "{{url('/ptab/nouveau')}}/"+table+"/"+id;
      //alert(url);
      window.location.href = url;

    }

    function updatedemande(demande_id,demandeur_name,demandeur_id,demande_motif,interimaire,date_demande,date_depart,date_retour,demande_state) {
//alert(demandeur_id);
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

    function submitValidateAction(){

      var accept=confirm('Voulez-vous valider ?');
      if(accept){
        document.getElementById("form_validateAction").submit();
      }
      
    }

    function displayValidateButton(val){
      //alert(val);
      $("#validateButton").css("display","block");
    }

    </script>
  
@endsection



