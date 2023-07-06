@extends('Templates.list_master')

@section('titre')
    Agent List - Aej Admin
@endsection


@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="recherche";
$sm="agent";

$ob_param=Session::get('ob_param');
$naissance=$ob_param['naissance'] ?? '';
$prisedeservice=$ob_param['prisedeservice'] ?? '';
$retraite=$ob_param['retraite'] ?? '';
$genre=$ob_param['genre'] ?? '';
$matrimoniale=$ob_param['matrimoniale'] ?? '';
$diplome_=$ob_param['diplome'] ?? '';
$niveauetude_=$ob_param['niveauetude'] ?? '';
$categorie_=$ob_param['categorie'] ?? '';
$statut=$ob_param['statut'] ?? '';
$fonction_=$ob_param['fonction'] ?? '';
$direction_=$ob_param['direction'] ?? '';
$sousdirection_=$ob_param['sousdirection'] ?? '';
$service_=$ob_param['service'] ?? '';
$nomprenoms=$ob_param['nomprenoms'] ?? '';
//dd($ob_param);
//$myarray = array('data' => $ob_param);
@endphp

@section('stylesheet')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Recherche Agents</h3>
         
        <!-- row -->
        <div class="row mt">
          <div class="content-panel">

            <div class="position-relative" align="right" style="padding-right:5px">
                      
                   <form method="get" action="{{ route('search.agent') }}" >
                     {{ csrf_field() }} 

                    <div class="form-group">

                      <label class="col-sm-2 control-label">Date de Naissance:</label>
                      <div class="col-sm-2">
                        <input type="date" class="form-control" name="naissance" value="{{$naissance}}" />
                      </div>

                      <label class="col-sm-2 control-label">Prise de service :</label>
                      <div class="col-sm-2">
                        <input type="date" class="form-control" name="prisedeservice" value="{{$prisedeservice}}" />
                      </div>

                       <label class="col-sm-2 control-label">Départ Retraite:</label>
                      <div class="col-sm-2">
                        <select class="form-control" name="retraite">
                          <option value=""></option>
                                <option value="2020" <?php if($retraite=='2020'){ echo 'selected'; } ?> >2020</option>
                                <option value="2021" <?php if($retraite=='2021'){ echo 'selected'; } ?> >2021</option>
                                <option value="2022" <?php if($retraite=='2022'){ echo 'selected'; } ?> >2022</option>
                                <option value="2023" <?php if($retraite=='2023'){ echo 'selected'; } ?>>2023</option>
                                <option value="2024" <?php if($retraite=='2024'){ echo 'selected'; } ?>>2024</option>
                                <option value="2025" <?php if($retraite=='2025'){ echo 'selected'; } ?>>2025</option>
                                <option value="2026" <?php if($retraite=='2026'){ echo 'selected'; } ?>>2026</option>
                                <option value="2027" <?php if($retraite=='2027'){ echo 'selected'; } ?>>2027</option>
                                <option value="2028" <?php if($retraite=='2028'){ echo 'selected'; } ?>>2028</option>
                                <option value="2029" <?php if($retraite=='2029'){ echo 'selected'; } ?>>2029</option>
                                <option value="2030" <?php if($retraite=='2030'){ echo 'selected'; } ?>>2030</option>
                        </select>
                      </div>
                </div>
                <br><br><br>
                <div class="form-group">

                     <label class="col-sm-2 control-label"> genre:</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="genre">
                          <option value=""></option>
                            <option value="M" <?php if($genre=='M'){ echo 'selected'; } ?> >Masculin</option>
                             <option value="F" <?php if($genre=='F'){ echo 'selected'; } ?>>Feminin</option>
                        </select>
                      </div>

                      <label class="col-sm-2 control-label"> Sit. matrimoniale:</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="matrimoniale">
                            <option value=""></option>
                            <option value="CELIBATAIRE" <?php if($matrimoniale=='CELIBATAIRE'){ echo 'selected'; } ?> >Célibataire</option>
                            <option value="CONCUBINAGE" <?php if($matrimoniale=='CONCUBINAGE'){ echo 'selected'; } ?> >Concubinage</option>
                            <option value="MARIE" <?php if($matrimoniale=='MARIE'){ echo 'selected'; } ?> >Marié.e</option>
                            <option value="VEU" <?php if($matrimoniale=='VEU'){ echo 'selected'; } ?> >Veuf.ve</option>
                            <option value="DIVORCE" <?php if($matrimoniale=='DIVORCE'){ echo 'selected'; } ?> >Divorcé.e</option>
                        </select>
                      </div>
 
                </div >
                <br><br><br>
                <div class="form-group">

                     <label class="col-sm-2 control-label">Diplôme :</label>
                      <div class="col-sm-4">
                        <select class="js-example-basic-multiple form-control" name="diplome[]" multiple >
                          <option value=""></option>
                           @foreach($diplomes as $diplome)
                          <option <?php if($diplome_){multiple_selected($diplome_,$diplome->diplome);} ?> value="{{$diplome->diplome}}" >{{$diplome->diplome}}</option>
                          @endforeach
                        </select>
                      </div>

                      <label class="col-sm-2 control-label">Niveau d'étude:</label>
                      <div class="col-sm-4">
                        <select class="js-example-basic-multiple form-control" name="niveauetude[]" multiple>
                          <option value=""></option>
                            @foreach($niveauetudes as $niveauetude)
                            <option <?php if($niveauetude_){multiple_selected($niveauetude_,$niveauetude->name);} ?> value="{{$niveauetude->name}}">{{$niveauetude->name}}</option>
                            @endforeach
                        </select>
                      </div>

                </div>
                 <br><br><br>
                 <div class="form-group">

                     <label class="col-sm-2 control-label">Catégorie:</label>
                      <div class="col-sm-4">
                        <select class="form-control js-example-basic-multiple" multiple name="categorie[]">
                          <option value=""></option>
                           @foreach($categories as $categorie)
                            <option <?php if($categorie_){multiple_selected($categorie_,$categorie->designation);} ?> value="{{$categorie->designation}}">{{$categorie->designation}}</option>
                            @endforeach
                        </select>
                      </div>

                      <label class="col-sm-2 control-label">Statut :</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="statut">
                          <option value=""></option>
                           <option value="FONCTIONNAIRE" <?php if($statut=='FONCTIONNAIRE'){ echo 'selected'; } ?>>Fonctionnaire</option>
                          <option value="CONTRACTUEL" <?php if($statut=='CONTRACTUEL'){ echo 'selected'; } ?>>Contractuel</option>
                        </select>
                      </div>

                </div>
                <br><br><br>
                <div class="form-group">

                      <label class="col-sm-2 control-label">Fonction:</label> 
                      <div class="col-sm-4">
                        <select class="form-control js-example-basic-multiple " name="fonction[]" multiple>
                          <option value=""></option>
                          @foreach($fonctions as $fonction)
                          <option <?php if($fonction_){multiple_selected($fonction_,$fonction->fonction);} ?>  value="{{$fonction->fonction}}">{{$fonction->fonction}}</option>
                          @endforeach
                        </select>
                      </div>

                      <label class="col-sm-2 control-label">direction:</label>
                      <div class="col-sm-4">
                        <select onchange="getSousdirection(this.value)" class="form-control js-example-basic-multiple" multiple name="direction[]">
                          <option value=""></option>
                          @foreach($directions as $direction)
                          <option <?php if($direction_){multiple_selected($direction_,$direction->id);} ?> value="{{$direction->id}}">{{$direction->designation}}</option>
                          @endforeach
                        </select>
                      </div>

                </div>
                <br><br><br>
                <div class="form-group">

                      <label class="col-sm-2 control-label">sousdirection :</label>
                      <div class="col-sm-4">
                        <select onchange="getService(this.value)" class="form-control js-example-basic-multiple" multiple name="sousdirection[]" id="sousdirection">
                            <option value=""></option>
                            @foreach($sousdirections as $sousdirection)
                          <option <?php if($sousdirection_){multiple_selected($sousdirection_,$sousdirection->id);} ?> value="{{$sousdirection->id}}">{{$sousdirection->designation}}</option>
                          @endforeach
                        </select>
                      </div>

                      <label class="col-sm-2 control-label">service:</label>
                      <div class="col-sm-4">
                        <select  class="form-control js-example-basic-multiple" name="service[]" id="service" multiple>
                          <option value=""></option>
                           @foreach($services as $service)
                          <option <?php if($service_){ multiple_selected($service_,$service->id); } ?> value="{{$service->id}}">{{$service->designation}}</option>
                          @endforeach
                        </select>
                      </div>

                </div>
                <br><br><br>
                <div class="form-group">

                      <label class="col-sm-2 control-label">Nom / Matricule:</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="nomprenoms" value="{{$nomprenoms}}"/>
                      </div>

                      <label class="col-sm-4 control-label"></label>
                      <div class="col-sm-2">
                        <button type="submit" class="btn btn-success" >
                              Rechercher
                       </button>
                      </div>

                </div>
                
                <br><br>

                </form>
                      
                </div>
          </div>
              <br>  
          <div class="col-md-12">
            <div class="content-panel">
              @if($ob_param)
               <span class="btn btn-default" style="float:left; padding:5px; margin: 5px;">
                           Nombre de résultat: ({{ $countagents }}) trouvé
              </span>
              @endif
              <a href="{{route('nouveau.agent')}}"  class="btn btn-warning" style="float:right; padding:5px; margin: 5px;">
                            Nouvel Agent
              </a>
             <a href="{{ route('export.searchagent',$ob_param) }}" class="btn" style="float:right;color:green">
                        <i class="fa fa-download"></i> Exporter
              </a>
              <table class="table table-striped table-advance table-hover">
                
                <thead>
                  <tr>
                    <th></th>
                    <th> Nom & Prénoms</th>
                    <th> Matricule</th>
                    <th>Fonction</th>
                    <th>Direction</th>
                    <th> Sous-direction</th>
                    <th>Service</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                 @foreach($agents as $agent)
                  <tr>
                    <td></td>
                    <td> {{$agent->nomprenoms}}</td>
                    <td>{{$agent->matricule}}</td>
                    <td>{{$agent->fonction}}</td>
                    <td> @if($agent->direction_id )
                      {{getInstanceName('direction','id',$agent->direction_id,'designation')}}
                      @endif </td>
                    <td> @if($agent->sousdirection_id)
                  {{getInstanceName('sousdirection','id',$agent->sousdirection_id,'designation')}} 
                  @endif</td>
                    <td> @if($agent->service_id)
                  {{getInstanceName('service','id',$agent->service_id,'designation')}}
                  @endif</td>
                    <td width=12%>
                      <div class="btn-group">
                          <button type="button" class="btn btn-theme03">Action</button>
                          <button type="button" class="btn btn-theme03 dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('agent.profil', Illuminate\Support\Facades\Crypt::encrypt($agent->id) )}}">Détail</a></li>
                            <li><a href="{{ route('nouvel.filiation',$agent->id) }}">Filiation</a></li>
                            <li><a href="{{ route('nouveau.document',$agent->id) }}">Documents</a></li>
                            <li><a href="{{ route('nouvelle.fonction',$agent->id) }}">Nouvelle fonction</a></li>
                            <li class="divider"></li>
                           <!--  <li><a href="#">Supprimer</a></li> -->
                          </ul>
                        </div>
                    </td>
                  </tr>
              @endforeach
                </tbody>
              </table>
            </div>
             {{ $agents->links() }}
            <!-- /content-panel -->
          </div>
          <!-- /col-md-12 -->
        </div>
        <!-- /row -->
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

  </script>

    @endsection