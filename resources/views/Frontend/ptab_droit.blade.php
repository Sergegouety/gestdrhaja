@extends('Templates.list_master')

@section('titre')
    Agent List - Aej Admin
@endsection


@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="evaluation";
$sm="agent_droit";

$nom=Session::get('nom');
@endphp
@section('stylesheet')

@endsection

@section('content')

<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Agents</h3>
         
        <!-- row -->
        <div class="row mt">
          <div class="col-md-12">
            <div class="content-panel">
              <table class="table table-striped table-advance table-hover">
                <div class="position-relative" align="right" style="padding-right:5px">
                      
                   <!-- <form method="get" action="{{ route('super.agent') }}" >
                     {{ csrf_field() }} 

                    <div class="form-group">
                        <label class="col-sm-1 col-sm-2 control-label">Recherche:</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control" name="nom" value=" {{Session::get('nom')}}"/>
                        </div>
                    </div >
                    <div class="col-sm-2">
                     <button type="submit" class="btn btn-success" >
                              Rechercher
                    </button>
                   </div>
                   </form> -->

                       <!-- <a href="{{ url('export/agent?nom='.$nom) }}" class="btn" style="float:right;color:green">
                        <i class="fa fa-download"></i>Exporter
                       </a>
                      <a href="{{route('nouveau.agent')}}"  class="btn btn-warning">
                            Nouveau
                      </a> -->
                </div>
                <hr>
                <thead>
                  <tr>
                    <th></th>
                    <th> Nom & Prénoms</th>
                    <!-- <th> Matricule</th> -->
                    <th>Fonction</th>
                    <th>Direction ou Agence géré(s) par l'agent</th>
                    
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                 @foreach($agents as $agent)
                 @php
                  
                  $gdirections = ptab_gestion_direction($agent->id);
                  $gagences = ptab_gestion_agence($agent->id);
                @endphp
                  <tr>
                    <td></td>
                    <td> {{$agent->nomprenoms}}</td>
                    <!-- <td>{{$agent->matricule}}</td> -->
                    <td>{{$agent->fonction}}</td>
                    <td>  
                      @foreach($gdirections as $gdir )
                       <span class="btn btn-success" style="margin:3px">
                        {{getInstanceName('direction','id',$gdir->structure,'designation')}}
                       </span>
                       @endforeach
                      @foreach($gagences as $gagence )
                       <span class="btn btn-warning" style="margin:3px; color: black;">
                        {{getInstanceName('sousdirection','id',$gagence->structure,'designation')}}
                       </span>
                       @endforeach
                    </td>

                    <td width=12%>
                      <div class="btn-group">
                          <button type="button" class="btn btn-theme03">Action</button>
                          <button type="button" class="btn btn-theme03 dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                          <ul class="dropdown-menu" role="menu">
                            @if(ptab_gestion_rigth($agent->user_id))
                            <li>
                              <a href="#" onclick="delete_droit( '{{$agent->user_id}}','{{addslashes($agent->nomprenoms)}}')">Spprimer tous les droits
                              </a>
                            </li>
                            @else
                            <li>
                              <a href="#" data-toggle="modal" data-target="#myModal" onclick="open_droit( '{{$agent->user_id}}','{{addslashes($agent->nomprenoms)}}' )">Ajouter des droits
                              </a>
                            </li>
                            @endif
                            <!-- <li>
                              <a href="#" data-toggle="modal" data-target="#myModal" onclick="open_droit( '{{$agent->user_id}}','{{addslashes($agent->nomprenoms)}}' )">Modifier les droits
                              </a>
                            </li> -->
                            
                          </ul>
                        </div>
                    </td>
                  </tr>
              @endforeach
                </tbody>
              </table>
            </div>
            
            <!-- /content-panel -->
          </div>
          <!-- /col-md-12 -->
        </div>
        <!-- /row -->

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body">
                      <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('add.droit') }}">
                             {{ csrf_field() }}
                             <input type="hidden" value="" id="user_id" name="user_id" />
                            <label>Direction :</label><br>
                             @foreach($directions as $direction)
                             <div class="btn btn-success btn-sm" style="margin:5px">
                                <input name="direction[]" type="checkbox" value="{{$direction->id}}">
                                <span class="">{{$direction->designation}}</span>
                            </div>
                            @endforeach
                            <br><br>
                           <label>Sous direction :</label><br>
                            @foreach($sousdirections as $sousdirection)
                              <div class="btn btn-success btn-sm" style="margin:5px">
                                <input name="sd[]" type="checkbox" value="{{$sousdirection->id}}">
                                <span class="">{{$sousdirection->designation}}</span>
                            </div>
                            @endforeach
                          <br><br>
                           <label>Admin :</label><br>
                           <div class="btn btn-success btn-sm" style="margin:5px">
                                <input name="admin" type="checkbox" value="1">
                                <span class="">admin PTAB</span>
                            </div>
                      
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">fermer</button>
                      <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                  </form>
                  </div>
                </div>
              </div>
      </section>

    @endsection

@section('scriptjs')

<script type="text/javascript">

  function open_droit(id,nom){
    $('#myModalLabel').html(nom);
    $('#user_id').val(id);
  }

  function delete_droit(id,nom){
   rep = confirm("Voulez-vous supprimer tous les droits de " + nom +" ?");
   var url = "{{ url('ajax/delete_right') }}/"+id;
   //alert(rep)
   if(rep){

     $.ajax({type: "get",url: url, } );
     location.reload();

   }
   
  }
</script>


@endsection



