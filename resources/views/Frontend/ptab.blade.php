@extends('Templates.list_master')

@section('titre')
    Demande List - Aej Admin
@endsection


@php
$i=1;
$active="active";
$open="open";
$show="show";
$d="#";
$page="evaluation";
$sm="ptab";

$page_ = request('page');
$ses_page = Session::put('ses_page',$page_);

$agent_function = Session::get('function_key');
//dd($agent_function);
$sd = $agent_function->sousdirection_id;
$level = $agent_function->level;
$is_agence = get_isagence($level, $sd);
//dd($level, $sd,$is_agence);
$ob_param=Session::get('ob_param');
//dd($ob_param);
$nom=$ob_param['nom'] ?? '';
$direction_=$ob_param['direction'] ?? 0;
$sousdirection_=$ob_param['sousdirection'] ?? 0;
$service_=$ob_param['service'] ?? 0;
$level = $agent_function->level;
$isptabadmin = $agent_function->isptabadmin;
$iscipac = $agent_function->iscipac;
$annee=$ob_param['annee'] ?? 2023;
//dd($annee);
//dd($nom,$datedemande);


$search_name = permit_search_name($isptabadmin,$level);
$search_direction = permit_search_direction($isptabadmin,$level);
$search_sdirection = permit_search_sdirection($isptabadmin,$level);
$search_service = permit_search_service($isptabadmin,$level);
//dd($search_name,$search_sdirection,$search_direction);

$ajout = is_activve(1);
$desactive = is_activve(2);
$retire = is_activve(3);
$modif = is_activve(4);
$supprime = is_activve(5);

if($modif && ($level==5 || $isptabadmin)){ $modifierAction = 1 ;}else{ $modifierAction = null; }
if($modif && ($level==3 || $isptabadmin)){ $modifierActivity = 1 ;}else{ $modifierActivity = null; }
if($modif && ($level==2 || $isptabadmin || $iscipac==2)){ $modifierTache = 1 ;}else{ $modifierTache = null; }

//dd($ajout,$desactive,$retire,$modif,$supprime);
@endphp

@section('stylesheet')


@endsection

@section('content')

<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>PTAB</h3>

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

                  <form method="get" action="{{ route('ptab') }}" >
                     {{ csrf_field() }}

                   <div class="form-group">
                    <div class="col-sm-2">
                          <select class="form-control" name="annee" id="annee">
                            <option value="">Année</option>
                            <option <?php if($annee == 2023) { echo "selected";} ?> value="2023">2023</option>
                            <option <?php  if($annee == 2022) { echo "selected";} ?> value="2022">2022</option>
                          </select>

                        </div>
                       @if($search_direction)
                        <div class="col-sm-2">
                          <select class="form-control" onchange="getSousdirection(this.value)" name="direction" id="direction">
                            <option value="">Direction/Bureau</option>
                             @foreach($directions as $direction)
                             <option <?php if($direction_==$direction->id){ echo 'selected';} ?> value="{{ $direction->id }}">
                              {{ $direction->designation }}
                          </option>
                          @endforeach
                          </select>

                        </div>
                        @endif
                        @if($search_sdirection)
                        <div class="col-sm-2">
                           <select class="form-control" name="sousdirection" id="sousdirection" onchange="getService(this.value)">
                            <option value="" >Sous-Direction / Agence</option>
                            @foreach($sousdirections as $sousdirection)
                             <option <?php if($sousdirection_==$sousdirection->id){ echo 'selected';} ?> value="{{ $sousdirection->id }}">
                              {{ $sousdirection->designation }}
                          </option>
                          @endforeach
                          </select>
                        </div>
                        @endif
                         @if($search_service)
                        <div class="col-sm-2">
                           <select class="form-control" name="service" id="service">
                           <option value="" > Service/Guichet</option>
                            @foreach($services as $service)
                             <option <?php if($service_==$service->id){ echo 'selected';} ?> value="{{ $service->id }}">
                              {{ $service->designation }}
                          </option>
                          @endforeach
                          </select>
                        </div>
                        @endif
                        @if($search_name)
                        <div class="col-sm-2">
                          <input type="text" placeholder="Nom ou Prénoms" class="form-control" name="nom" value="{{$nom}}"/>
                        </div>
                        @endif

                        <div class="col-sm-2">
                          <button type="submit" class="btn btn-success" >Ok</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-th"></i>
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    {{--  <li>@if(Session::get('function_key')->isptabadmin)
                       <a href="{{route('ptab.import')}}">
                        <i class="fa fa-download"></i> Importer
                       </a>
                       @endif
                     </li>  --}}
                      <li><a href="{{route('export.ptab',[$direction_,$sousdirection_])}}">
                             Exporter
                        </a>
                      </li>
                      @if($ajout)
                      <li>@if(Session::get('function_key')->isptabadmin || $level == 5)
                        <a href="#" onclick="actiondajout('action',0)">
                              <strong>Ajouter</strong> Action
                        </a>
                        @endif
                      </li>
                      @endif
                  </ul>
                        </div>

                    </div >

                   </form>
                </div>
                <br>
                <div class="col-sm-2">
                  <a href="#" onclick="submitValidateAction()" id="validateButton"  class="btn btn-success" style="margin-left: 15px; display: none;">
                           Valider
                </a>
                </div>



              </table>
            </div>

            <!-- /content-panel -->
          </div>
          <!-- /col-md-12 -->
        </div>
        <!-- /row -->
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
                     @if($action->type_id == 1)
                    <!-- <li><a onclick="actiondedetail('action',{{$action->id}})" href="#">Voir Détail</a></li> -->
                    <li><a href="{{route('activite.avalider',[$action->id,2])}}">Valider les activités</a></li>
                    <li><a onclick="actiondedetail('action',{{$action->id}})" href="#">Etat d'avancement</a></li>
                    <li class="divider"></li>

                    @if($desactive && $action->state == null && ($level == 5 || Session::get('function_key')->isptabadmin))
                    <li><a data-toggle="modal" data-target="#arretModal" onclick="actionarreter({{$action->id}},{{$action->type_id}},-1)" href="#">Désactiver</a></li>
                    @endif


                    @if($retire && $action->state != -3 && $action->state != -4 && ($level == 5 || Session::get('function_key')->isptabadmin))
                    <li><a data-toggle="modal" data-target="#arretModal" onclick="actionarreter({{$action->id}},{{$action->type_id}},-3)" href="#">Rétirer</a></li>
                    @endif

                     @elseif($action->type_id == 2)
                    <!-- <li><a onclick="actiondedetail('activite',{{$action->id}})" href="#">Voir Détail</a></li> -->
                    <li><a href="{{route('tache.avalider',[$action->id,3])}}" href="#">Valider les taches</a></li>
                    <li><a onclick="actiondedetail('activite',{{$action->id}})" href="#">Etat d'avancement</a></li>
                    <li class="divider"></li>
                     @if($desactive && $action->state == null && ($level == 3 || Session::get('function_key')->isptabadmin))
                    <li><a data-toggle="modal" data-target="#arretModal" onclick="actionarreter({{$action->id}},{{$action->type_id}},-1)" href="#">Désactiver</a></li>
                    @endif

                    @if($retire && $action->state != -3 && $action->state != -4 && ($level == 3 || Session::get('function_key')->isptabadmin))
                    <li><a data-toggle="modal" data-target="#arretModal" onclick="actionarreter({{$action->id}},{{$action->type_id}},-3)" href="#">Rétirer</a></li>
                    @endif

                     @else
                    <!-- <li><a onclick="actiondedetail('tache',{{$action->id}})" href="#">Voir Détail</a></li> -->
                    <li><a onclick="actiondedetail('tache',{{$action->id}})" href="#">Etat d'avancement</a></li>
                     <li class="divider"></li>
                     @if($desactive && $action->state == null && ($level == 2 || Session::get('function_key')->isptabadmin))
                    <li><a data-toggle="modal" data-target="#arretModal" onclick="actionarreter({{$action->id}},{{$action->type_id}},-1)" href="#">Désactiver</a></li>
                    @endif

                    @if($retire && $action->state != -3 && $action->state != -4 && ($level == 2 || Session::get('function_key')->isptabadmin))
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
                    @if($modifierAction && $action->user_id != Auth::id())
                    <li><a onclick="actionEdit('action',{{$action->id}})" href="#">Modifier</a></li>
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
                      @if($modifierActivity && $action->user_id != Auth::id())
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
                      @if($modifierTache)
                      @if($action->type_id==3 && $action->user_id != Auth::id())
                      <li><a onclick="actionEdit('tache',{{$action->id}})" href="#">Modifier</a></li>
                      @endif
                      @endif
                      @if($supprime && $action->user_id != Auth::id())
                        
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
             {{ $actions->links() }}
            <!-- /content-panel -->
          </div>
          <!-- /col-lg-12 -->
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
    }
      if(value == -1){rep = confirm("Voulez-vous arrêter ?");}

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

             $('#instance_id').val(action);$('#type_id').val(type_id);;$('#val').val(value)
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



