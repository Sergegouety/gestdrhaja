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

$page = request('page');
$ses_page = Session::put('ses_page',$page);

$agent_function = Session::get('function_key');
//dd($agent_function);

$ob_param=Session::get('ob_param');
$nom=$ob_param['nom'] ?? '';
$direction_=$ob_param['direction'] ?? 0;
$sousdirection_=$ob_param['sousdirection'] ?? 0;
$level = $agent_function->level;
$isptabadmin = $agent_function->isptabadmin;
$annee=$ob_param['annee'] ?? 2023;
//dd($annee);
//dd($nom,$datedemande);


$search_name = permit_search_name($isptabadmin,$level);
$search_direction = permit_search_direction($isptabadmin,$level);
$search_sdirection = permit_search_sdirection($isptabadmin,$level);
//dd($search_name,$search_sdirection,$search_direction);

$ajout = is_activve(1);
$desactive = is_activve(2);
$retire = is_activve(3);
$modif = is_activve(4);
$supprime = is_activve(5);

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
                        @if($search_name)
                        <div class="col-sm-2">
                          <input type="text" placeholder="Nom ou Prénoms" class="form-control" name="nom" value="{{$nom}}"/>
                        </div>
                        @endif

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
                        <div class="col-sm-3">
                           <select class="form-control" name="sousdirection" id="sousdirection">
                            <option value="">Sous-Direction / Agence</option>
                            @foreach($sousdirections as $sousdirection)
                             <option <?php if($sousdirection_==$sousdirection->id){ echo 'selected';} ?> value="{{ $sousdirection->id }}">
                              {{ $sousdirection->designation }}
                          </option>
                          @endforeach
                          </select>
                        </div>
                        @endif

                    </div >
                   <div class="col-sm-1">
                     <button type="submit" class="btn btn-success" >
                              Ok
                    </button>
                   </div>
                   <div class="btn-group" style="padding-right:100px">
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-th"></i>
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li>@if(Session::get('function_key')->isptabadmin)
                       <a href="{{route('ptab.import')}}">
                        <i class="fa fa-download"></i> Importer
                       </a>
                   @endif
                 </li>
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
                   </form>
                </div>
                <br>
                <div class="col-sm-2">
                  <a href="#" onclick="submitValidateAction()" id="validateButton"  class="btn btn-success" style="margin-left: 15px; display: none;">
                           Valider
                </a>
                </div>
<br><br>
<form id="form_validateAction" method="post" action="{{route('ptab.validate')}}">
@foreach($actions as $action)
   @php $responsable_userid = get_responsableid( $action->responsable ); @endphp
                <div class="col-lg-4 col-md-4 col-sm-6">

                <div class="showback">
                  <div class="btn-group" style="float: right;">
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-th"></i>
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                     @if($action->type_id == 1)
                    <li><a onclick="actiondedetail('action',{{$action->id}})" href="#">Voir Détail</a></li>

                    @if($desactive && $action->state == null && ($level > 3 || Session::get('function_key')->isptabadmin))
                    <li><a data-toggle="modal" data-target="#arretModal" onclick="actionarreter({{$action->id}},{{$action->type_id}},-1)" href="#">Désactiver</a></li>
                    @endif

                    
                    @if($retire && $action->state != -3 && $action->state != -4 && ($level > 3 || Session::get('function_key')->isptabadmin))
                    <li><a data-toggle="modal" data-target="#arretModal" onclick="actionarreter({{$action->id}},{{$action->type_id}},-3)" href="#">Rétirer</a></li>
                    @endif
                     
                     @elseif($action->type_id == 2)
                    <li><a onclick="actiondedetail('activite',{{$action->id}})" href="#">Voir Détail</a></li>
                    
                     @if($desactive && $action->state == null && ($level > 2 || Session::get('function_key')->isptabadmin))
                    <li><a data-toggle="modal" data-target="#arretModal" onclick="actionarreter({{$action->id}},{{$action->type_id}},-1)" href="#">Désactiver</a></li>
                    @endif

                    @if($retire && $action->state != -3 && $action->state != -4 && ($level > 2 || Session::get('function_key')->isptabadmin))
                    <li><a data-toggle="modal" data-target="#arretModal" onclick="actionarreter({{$action->id}},{{$action->type_id}},-3)" href="#">Rétirer</a></li>
                    @endif
                    
                     @else
                    <li><a onclick="actiondedetail('tache',{{$action->id}})" href="#">Voir Détail</a></li>
                     
                     @if($desactive && $action->state == null && ($level > 1 || Session::get('function_key')->isptabadmin))
                    <li><a data-toggle="modal" data-target="#arretModal" onclick="actionarreter({{$action->id}},{{$action->type_id}},-1)" href="#">Désactiver</a></li>
                    @endif

                    @if($retire && $action->state != -3 && $action->state != -4 && ($level > 1 || Session::get('function_key')->isptabadmin))
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
                <!-- <div class="btn-group" style="float: right;">
                  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-download"></i>
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Voir Détail</a></li>
                    <li><a href="#">Désactiver</a></li>
                    <li><a href="#">Supprimer</a></li>
                  </ul>
                </div> -->
                <h4>@if( ( $agent_function->level==3 || $agent_function->level==4 || $agent_function->isptabadmin ) && $agent_function->id != $responsable_userid )
                          <!-- <input class="checkbox" type="checkbox" id="{{$action->id}}" name="checkAction[]" value="{{$action->id}}" onclick="displayValidateButton(this.value)" style="width: 20px; height: 20px;"> -->
                          @endif
                
                <?php 
                if($action->type_id==1){
                  @$ref = getInstanceName('master_action','id',$action->reference_matrice,'ref');
                  echo 'Action : '.$ref;
                }elseif($action->type_id==2){
                  @$ref = getInstanceName('master_activite','id',$action->reference_matrice,'ref');
                  echo 'Activité : '.$ref;
                }else{
                  @$ref = getInstanceName('master_tache','id',$action->reference_matrice,'ref');
                  echo 'Tâche: '.$ref;} 
                ?>
                <?php if($action->state == -2){ echo '<span class="badge bg-important">DESACTIVEE</span>';} ?> 
                <?php if($action->state == -1){ echo '<span class="badge bg-warning">Désactivation en attente</span>';} ?> 
                <?php if($action->state == -3){ echo '<span class="badge bg-warning">Retrait en attente</span>';} ?>
                <?php if($action->state == -4){ echo '<span class="badge bg-important">RETIREE</span>';} ?> 
                </h4>
                <br>
                <button type="button" class="btn btn-warning btn-lg btn-block">{{$action->responsable}}</button><br>
                <label>Libellé :</label>
                <textarea class="form-control round" rows="4" readonly>{{$action->intitule}}</textarea><br>
                <label>Indicateur :</label>
                <textarea class="form-control round" rows="3" readonly>{{$action->indicateur}}</textarea><br>
                <label>Cible globale :</label>
                <textarea class="form-control round" rows="2" readonly>{{$action->cible_glo}}</textarea><br>
                <!-- a ajouté apres -->
               <!--  <h6><i class="fa fa-angle-right"></i>Total Activité: <span class="badge bg-success"></span></h6>
                <h6><i class="fa fa-angle-right"></i>Total Tâche: <span class="badge bg-success">12</span></h6> -->
              </div>
            </div>
@endforeach
</form>

                <!-- <thead class="sticky-nav text-green-m1 text-uppercase text-85" >
                    <tr>

                      <th class="td-toggle-details border-0 bgc-white shadow-sm"></th>
                      <th class="td-toggle-details border-0 bgc-white shadow-sm"></th>
                      <th class="td-toggle-details border-0 bgc-white shadow-sm">
                       Direction
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
                  </thead> -->
                <!-- <tbody class="pos-rel">
<form id="form_validateAction" method="post" action="{{route('ptab.validate')}}">
         {{ csrf_field() }} 
         @php $i = 1; @endphp
                      @foreach($actions as $action)
                      @php $responsable_userid = get_responsableid( $action->responsable ); @endphp
                      <tr class="d-style bgc-h-orange-l4">

                        
                        <td>
                          @if( ($agent_function->level==3 || $agent_function->level==4 || $agent_function->isptabadmin ) && $agent_function->id != $responsable_userid )
                          <input class="checkbox" type="checkbox" id="{{$action->id}}" name="checkAction[]" value="{{$action->id}}" onclick="displayValidateButton()">
                          @endif
                        </td>
                        <td>{{$i}}</td>
                        
                         <td>
                         {{getInstanceName('direction','id',$action->direction_id,'designation')}}
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
                            @if($agent_function->isptabvue==1)
                            <li></li>
                            @else
                            <li>
                              <a class="dropdown-item" onclick="actiondedetail('action',{{$action->id}})" href="#">
                              Details
                              </a>
                            </li>
                            @endif
                             <li>
                              <a class="dropdown-item" onclick="actiondajout( 'activite',{{$action->id}} )" href="#">
                              Ajouter Activité
                              </a>
                            </li>
                            @endif
                            @if($action->type_id==2)
                            @if($agent_function->isptabvue==1)
                            <li></li>
                            @else
                            <li>
                              <a class="dropdown-item" onclick="actiondedetail('action',{{$action->id}})" href="#">
                              Details
                              </a>
                            </li>
                            @endif
                             <li>
                              <a class="dropdown-item" onclick="actiondajout('tache',{{$action->id}})" href="#">
                              Ajouter Tâche
                              </a>
                            </li>
                            @endif
                            @if($action->type_id==3)
                            @if($agent_function->isptabvue==1)
                            <li></li>
                            @else
                            <li>
                              <a class="dropdown-item" onclick="actiondedetail('action',{{$action->id}})" href="#">
                              Details
                              </a>
                            </li>
                            @endif
                            @endif
                          
                           
                      </ul>
                        
                       
                      </div>
                        
                        </td>

                    </tr>
                    @php $i++; @endphp
                    @endforeach
                    </form>
                  </tbody> -->
              </table>
            </div>
             {{ $actions->links() }}
            <!-- /content-panel -->
          </div>
          <!-- /col-md-12 -->
        </div>
        <!-- /row -->
        <div class="row mt">
          <div class="col-lg-12">
            <div class="content-panel">
              <h4><i class="fa fa-angle-right"></i> No More Table</h4>
              <section id="no-more-tables">
                <table class="table table-bordered table-striped table-condensed cf">
                  <thead class="cf">
                    <tr>
                      <th>ref.</th>
                      <th>Intitule</th>
                      <th class="numeric">Indicateur</th>
                      <th class="numeric">Change</th>
                      <th class="numeric">Change %</th>
                      <th class="numeric">Open</th>
                      <th class="numeric">High</th>
                      <th class="numeric">Low</th>
                      <th class="numeric">Volume</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td data-title="Code">AAC</td>
                      <td data-title="Company">AUSTRALIAN AGRICULTURAL COMPANY LIMITED.</td>
                      <td class="numeric" data-title="Price">$1.38</td>
                      <td class="numeric" data-title="Change">-0.01</td>
                      <td class="numeric" data-title="Change %">-0.36%</td>
                      <td class="numeric" data-title="Open">$1.39</td>
                      <td class="numeric" data-title="High">$1.39</td>
                      <td class="numeric" data-title="Low">$1.38</td>
                      <td class="numeric" data-title="Volume">9,395</td>
                    </tr>
                    
                  </tbody>
                </table>
              </section>
            </div>
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
      alert(val);
      $("#validateButton").css("display","block");
    }

    </script>

    @endsection



