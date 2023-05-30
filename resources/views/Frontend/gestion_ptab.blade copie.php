@extends('Templates.list_master')

@section('titre')
    Gestion PTAB - Aej Admin
@endsection


@php
$i=1;
$active="active";
$open="open";
$show="show";
$d="#";
$page="evaluation";
$sm="ptab";

$agent_function = Session::get('function_key');
//dd($agent_function);
$ob_param=Session::get('ob_param');
$nom=$ob_param['nom'] ?? '';
$direction_=$ob_param['direction'] ?? '';
$sousdirection_=$ob_param['sousdirection'] ?? '';
//dd($nom,$datedemande);
@endphp

@section('stylesheet')


@endsection

@section('content')

<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>GERER PTAB</h3>

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

                  <form method="get" action="{{ route('ptab.gestion') }}" >
                     {{ csrf_field() }} 

                   <div class="form-group">
                        <div class="col-sm-2">
                          <input type="text" placeholder="Nom / Matricule" class="form-control" name="nom" value="{{$nom}}"/>
                        </div>

                        <div class="col-sm-2">
                          <select class="form-control" name="direction" id="direction" onchange="doEmpty(1)">
                            <option value="">Direction/Bureau</option>
                             @foreach($directions as $direction)
                             <option <?php if($direction_==$direction->structure){ echo 'selected';} ?> value="{{ $direction->structure }}">
                              {{getInstanceName('direction','id',$direction->structure,'designation')}}
                          </option>
                          @endforeach
                          </select>
                          
                        </div>

                        <div class="col-sm-4">
                           <select class="form-control" name="sousdirection" id="sousdirection" onchange="doEmpty(2)">
                            <option value="">Agence</option>
                            @foreach($agences as $agence)
                             <option <?php if($sousdirection_==$agence->structure){ echo 'selected';} ?> value="{{ $agence->structure }}">
                              {{getInstanceName('sousdirection','id',$agence->structure,'designation')}}
                              </option>
                          @endforeach
                          </select>
                          
                        </div>

                    </div >
                   <div class="col-sm-1">
                     <button type="submit" class="btn btn-success" >
                              Ok
                    </button>
                   </div>
                   </form>
                   @if(Session::get('function_key')->isptabadmin)
                       <a href="{{route('ptab.import')}}" class="btn btn-info" style="float:right">
                        <i class="fa fa-download"></i> Importer
                       </a>
                   @endif
                       <a href="#"  class="btn btn-default" style="margin-right: 5px; float:right">
                           Exporter
                      </a>
                   @if(Session::get('function_key')->isptabadmin)
                      <a href="#" onclick="actiondajout('action',0)"  class="btn btn-warning" style="margin-right: 5px;">
                            <strong>+</strong> Action
                      </a>
                      @endif
                </div>
                <br>
                <div class="col-sm-2">
                  <a href="#" onclick="submitValidateAction()" id="validateButton"  class="btn btn-success" style="margin-left: 15px; display: none;">
                           Valider
                </a>
                </div>
              
                <thead class="sticky-nav text-green-m1 text-uppercase text-85" >
                    <tr>

                      <th class="td-toggle-details border-0 bgc-white shadow-sm">
                       
                      </th>
                      <th class="td-toggle-details border-0 bgc-white shadow-sm">
                       Direction
                      </th>

                      <th class="td-toggle-details border-0 bgc-white shadow-sm">
                       SD / Agence
                      </th>

                       <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Action  Activité  Tâche
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Libellé
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Indicateur
                      </th>

                      <th class="td-toggle-details border-0 bgc-white shadow-sm">
                      Cible globale
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                       Responsable
                      </th>

                      <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">
                        Période d'Exécution
                      </th>

                      <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm" width="15%">
                        Statut
                      </th>

                    </tr>
                  </thead>
                <tbody class="pos-rel">
<form id="form_validateAction" method="post" action="{{route('ptab.validate')}}">
   {{ csrf_field() }} 
                      @foreach($actions as $action)
                      @php $responsable_userid = get_responsableid( $action->responsable ); @endphp
                      <tr class="d-style bgc-h-orange-l4">

                        <td>
                          @if( ($agent_function->level==3 || $agent_function->level==4 || $agent_function->isptabadmin ) && $agent_function->id != $responsable_userid )
                          <input class="checkbox" type="checkbox" id="{{$action->id}}" name="checkAction[]" value="{{$action->id}}" onclick="displayValidateButton()">
                          @endif
                        </td>

                         <td>
                          @if($action->direction_id)
                         {{getInstanceName('direction','id',$action->direction_id,'designation')}}
                         @endif
                        </td>

                        <td>
                          @if($action->sousdirection_id)
                         {{getInstanceName('sousdirection','id',$action->sousdirection_id,'designation')}}
                         @endif
                        </td>

                        <td >
                       <?php if($action->type_id==1){echo 'Action';}elseif($action->type_id==2){echo 'Activité';}else{echo 'Tâche';} ?>
                        </td>

                        <td>
                        {{$action->intitule}}
                        </td>

                        <td>
                        {{$action->indicateur}}
                        </td>

                        <td>
                        {{$action->cible_glo}}
                        </td>

                        <td>
                        {{$action->responsable}}
                        </td>

                        <td>
                        {{$action->periode_execution}}
                        </td>

                        <td>

                      <div class="btn-group">
                        @php
                        if($action->statut_final){
                          $statut=$action->statut_final;
                        }elseif($action->statut_t4){
                          $statut=$action->statut_t4;
                        }elseif($action->statut_t3){
                          $statut=$action->statut_t3;
                        }elseif($action->statut_t2){
                          $statut=$action->statut_t2;
                        }elseif($action->statut_t1){
                          $statut=$action->statut_t1;
                        }else{
                           $statut=0;
                        }

                        @endphp
                        @if($statut==3)

                        <button type="button" class="btn btn-success btn-bold opacity-2">Realisé</button>
                        <button type="button" class="px-2 btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @elseif($statut==2)
                        <button type="button" class="btn btn-info btn-bold opacity-2">Part. Realisé</button>
                        <button type="button" class="px-2 btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @elseif($statut==1)
                        <button type="button" class="btn btn-danger btn-bold opacity-2">Non Realisé</button>
                        <button type="button" class="px-2 btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @else
                        <button type="button" class="btn btn-warning btn-bold opacity-2">en attente</button>
                        <button type="button" class="px-2 btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @endif
                      <ul class="dropdown-menu" style="">

                            <li>
                              <a>
                              Livrables
                              </a>
                            </li>
                            @if($action->livrable_t1)
                            <li>
                              <a class="dropdown-item" href="#">
                              1er Trimestre
                              </a>
                              @php $autre_livrableT1=getOtherLivrable($action->id,1); @endphp
                            @foreach($autre_livrableT1 as $autre_livrable)
                            <li>
                              <a href="{{asset('docs/'.$autre_livrable->livrable)}}" target="_blank" title="Telecharger Livrable"><i class="fa fa-download"></i>
                              livrables/pièces justificatives
                             </a>
                            </li>
                            @endforeach
                            </li>
                            @endif
                            @if($action->livrable_t2)
                             <li>
                              <a class="dropdown-item" href="#">
                              2ème Trimestre
                              </a>
                              @php $autre_livrableT2=getOtherLivrable($action->id,2); @endphp
                            @foreach($autre_livrableT2 as $autre_livrable)
                            <li>
                              <a href="{{asset('docs/'.$autre_livrable->livrable)}}" target="_blank" title="Telecharger Livrable"><i class="fa fa-download"></i>
                              livrables/pièces justificatives
                             </a>
                            </li>
                            @endforeach
                            </li>
                             @endif
                            @if($action->livrable_t3)
                            <li>
                              <a class="dropdown-item" href="#">
                              3ème Trimestre
                              </a>
                              @php $autre_livrableT3=getOtherLivrable($action->id,3); @endphp
                            @foreach($autre_livrableT3 as $autre_livrable)
                            <li>
                              <a href="{{asset('docs/'.$autre_livrable->livrable)}}" target="_blank" title="Telecharger Livrable"><i class="fa fa-download"></i>
                              livrables/pièces justificatives
                             </a>
                            </li>
                            @endforeach
                            </li>
                             @endif
                            @if($action->livrable_t4)
                            <li>
                              <a class="dropdown-item" href="#">
                              4ème Trimestre
                              </a>
                              @php $autre_livrableT4=getOtherLivrable($action->id,4); @endphp
                            @foreach($autre_livrableT4 as $autre_livrable)
                            <li>
                              <a href="{{asset('docs/'.$autre_livrable->livrable)}}" target="_blank" title="Telecharger Livrable"><i class="fa fa-download"></i>
                              livrables/pièces justificatives
                             </a>
                            </li>
                            @endforeach
                            </li>
                             @endif
                            @if($action->livrable_final)
                            <li>
                              <a class="dropdown-item" href="{{asset('docs/'.$action->livrable_final)}}" target="_blank">
                               Final
                              </a>
                            </li>
                            @endif
                          
                           <div class="divider"></div>
                            @if($action->type_id==1)
                            <li>
                              <a class="dropdown-item" onclick="actiondedetail('action',{{$action->id}})" href="#">
                              Details
                              </a>
                            </li>
                             <li>
                              <a class="dropdown-item" onclick="actiondajout( 'activite',{{$action->id}} )" href="#">
                              Ajouter Activité
                              </a>
                            </li>
                            @endif
                            @if($action->type_id==2)
                            <li>
                              <a class="dropdown-item" onclick="actiondedetail('activite',{{$action->id}})" href="#">
                              Details
                              </a>
                            </li>
                             <li>
                              <a class="dropdown-item" onclick="actiondajout('tache',{{$action->id}})" href="#">
                              Ajouter Tâche
                              </a>
                            </li>
                            @endif
                            @if($action->type_id==3)
                            <li>
                              <a class="dropdown-item" onclick="actiondedetail('tache',{{$action->id}})" href="#">
                              Details
                              </a>
                            </li>
                            @endif
                           <!--  <li>
                              <a class="dropdown-item" onclick="actiondesuppression('action','id',{{$action->id}})" href="#">
                              Suprimer
                            </a>
                          </li> -->
                           
                      </ul>
                        
                      </div>
                        
                        </td>
                    </tr>
                  
                    @endforeach
                    </form>
                  </tbody>
              </table>
            </div>
             {{ $actions->links() }}
            <!-- /content-panel -->
          </div>
          <!-- /col-md-12 -->
        </div>
        <!-- /row -->
      </section>



    @endsection

    @section('scriptjs')
    <script type="text/javascript">

   function doEmpty(id)
  {
    if(id == 1){
        $('#sousdirection').val(0); 
    }else{
       $('#direction').val(0); 
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
</script>

     <script >

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

    function displayValidateButton(){
      $("#validateButton").css("display","block");
    }

    </script>

    @endsection



