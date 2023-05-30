@extends('Templates.list_master')

@section('titre')
    Agent List - Aej Admin
@endsection


@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="parametre";
$sm="agent";

$nom=Session::get('nom');
@endphp
@section('stylesheet')

@endsection

@section('content')

<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Agents</h3>

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
                      
                   <form method="get" action="{{ route('super.agent') }}" >
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
                   </form>

                       <a href="{{ url('export/agent?nom='.$nom) }}" class="btn" style="float:right;color:green">
                        <i class="fa fa-download"></i>Exporter
                       </a>
                      <a href="{{route('nouveau.agent')}}"  class="btn btn-warning">
                            Nouveau
                      </a>
                </div>
                <hr>
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
                    <td>  
                      @if($agent->direction_id )
                      {{getInstanceName('direction','id',$agent->direction_id,'designation')}}
                      @endif 
                </td>
                    <td>
                    @if($agent->sousdirection_id)
                  {{getInstanceName('sousdirection','id',$agent->sousdirection_id,'designation')}} 
                  @endif
                </td>
                    <td>
                    @if($agent->service_id)
                  {{getInstanceName('service','id',$agent->service_id,'designation')}}
                  @endif
                </td>
                    <td width=12%>
                      <div class="btn-group">
                          <button type="button" class="btn btn-theme03">Action</button>
                          <button type="button" class="btn btn-theme03 dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('agent.profil',Illuminate\Support\Facades\Crypt::encrypt($agent->id))}}">Détail</a></li>
                            <li><a href="{{route('nouvel.filiation',$agent->id)}}">Filiation</a></li>
                            <li><a href="{{route('nouveau.document',$agent->id)}}">Documents</a></li>
                            <li><a href="#" onclick="ajouterdroitdelecture({{$agent->id}})">Droit de lecture</a></li>
                            <li class="divider"></li>
                            <!-- <li><a href="#">Supprimer</a></li> -->
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
    <script type="text/javascript">
      function ajouterdroitdelecture(id){
     //alert(id);
             
      rep = confirm("Voulez-vous ajouter le droit de lecture du PTAB ?");
      url = "{{url('droit/lecture')}}/"+id;

      if(rep == true)
      {
          window.location.href = url;
      }


  }
    </script>

    @endsection



