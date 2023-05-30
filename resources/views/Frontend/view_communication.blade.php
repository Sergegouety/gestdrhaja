@extends('Templates.list_master')

@section('titre')
    Demande List - Aej Admin
@endsection

@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="communication";
$sm="com";

$agent_function = Session::get('function_key');
$direction_id=$agent_function->direction_id;
$sousdirection_id=$agent_function->sousdirection_id;
$service_id=$agent_function->service_id;
$agent_level=$agent_function->level;
$isdocadmin=$agent_function->isdocadmin;
$user_id=Auth::id();

$ob_param=Session::get('ob_param');
$nom=$ob_param['nom'] ?? '';
$datedemande=$ob_param['datedemande'] ?? '';
//dd($nom,$datedemande);
@endphp

@section('stylesheet')


@endsection

@section('content')

<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Articles</h3>

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

                  <form method="get" action="{{ route('view.communication') }}" >
                     {{ csrf_field() }} 

                    <div class="form-group">
                        <label class="col-sm-1 control-label">Recherche:</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control" name="nom" value="{{$nom}}"/>
                        </div>

                        <label class="col-sm-1 control-label">date:</label>
                        <div class="col-sm-2">
                          <input type="date" class="form-control" name="datepub" value="{{format_date2($datedemande)}}"/>
                        </div>
                    </div >
                    <div class="col-sm-2">
                     <button type="submit" class="btn btn-success" >
                              Rechercher
                    </button>
                   </div>
                   </form>

                       <!-- <a href="{{ route('export.conge',$ob_param) }}" class="btn" style="float:right;color:green">
                        <i class="fa fa-download"></i> Exporter
                       </a> -->
                   
                      <a href="{{route('new.communication')}}"  class="btn btn-warning">
                            Nouveau
                      </a>

                </div>
               
                <hr>
                <thead class="sticky-nav text-green-m1 text-uppercase text-85">
                    <tr>

                      <th class="td-toggle-details border-0 bgc-white shadow-sm">
                       
                      </th>

                       <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Date
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Type
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Auteur
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Titre
                      </th>

                      <!-- <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Resumé
                      </th> -->

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                       Contenu
                      </th>

                       <th style="width:15%">
                        Statut
                      </th>

                    </tr>
                  </thead>
                <tbody class="pos-rel">

                 @foreach($communications as $communication)
                    <tr class="d-style bgc-h-orange-l4">

                      <td class="pl-3 pl-md-4 align-middle pos-rel">
                       
                      </td>

                      <td class="pl-3 pl-md-4 align-middle pos-rel">
                        {{format_date($communication->date_publication)}}
                      </td>

                      <td>
                        @if($communication->article_type==1)
                        Ressources Humaines
                        @elseif($communication->article_type==2)
                         Newsletter
                         @elseif($communication->article_type==3)
                         Mutuelle
                         @else
                         Agent
                         @endif
                      </td>

                      <td>
                        {{getInstanceName('users','id',$communication->user_id,'nomprenoms')}}
                      </td>

                      <td>
                        <span class="text-105">
                          {{$communication->titre}}
                        </span>
                      </td>

                      <!-- <td class="text-grey">
                       
                        {{substr($communication->resume,0, 100)}}
                      </td> -->

                       <td class="text-grey">
                        
                      {!! substr($communication->contenu,0, 200) !!}
                      </td>


                      <td>
                        <div class="btn-group">
                          @if($communication->state==1)
                        <button type="button" class="btn btn-warning btn-bold opacity-2">en attente</button>
                        <button type="button" class="px-2 btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @elseif($communication->state==2)
                           <button type="button" class="btn btn-theme03 btn-bold opacity-5">Accepté</button>
                            <button type="button" class="px-2 btn btn-theme03 dropdown-toggle dropdown-toggle-split opacity-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @elseif($communication->state==3)
                           <button type="button" class="btn btn-success btn-bold opacity-5">Validé</button>
                            <button type="button" class="px-2 btn btn-success dropdown-toggle dropdown-toggle-split opacity-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @elseif($communication->state==4)
                           <button type="button" class="btn btn-success btn-bold opacity-5">Publié</button>
                            <button type="button" class="px-2 btn btn-success dropdown-toggle dropdown-toggle-split opacity-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                           @else
                           <button type="button" class="btn btn-danger btn-bold opacity-2">Retiré</button>
                           <button type="button" class="px-2 btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                           @endif
                           <ul class="dropdown-menu" style="">

                         @if($sousdirection_id==12)
                          <li>
                            <a class="dropdown-item" onclick="updatestatus({{$communication->id}},2)" href="#">
                            Accepter
                            </a>
                          </li>
                          @endif
                          @if($direction_id==4 && $sousdirection_id==0)
                          <li>
                            <a class="dropdown-item" onclick="updatestatus({{$communication->id}},3)" href="#">
                            Valider
                            </a>
                          </li>
                          @endif
                          @if($communication->state==3)
                           <li>
                            <a class="dropdown-item" onclick="updatestatus({{$communication->id}}, 4)" href="#">
                            Publier
                            </a>
                          </li>
                          @endif
                          @if($user_id == $communication->user_id)
                             <div class="dropdown-divider"></div>
                           <li>
                            <a class="dropdown-item" onclick="updatestatus({{$communication->id}}, 0)">Désactiver</a>
                          </li>
                          @if($communication->state < 2 )
                          <li>
                            <a class="dropdown-item" href="{{route('edit.article',$communication->id)}}">
                            Modifier
                            </a>
                          </li>
                          @endif
                          @endif
                            <div class="dropdown-divider"></div>
                           
                          </ul>
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
      </section>



    @endsection

     @section('scriptjs')
    
     <script >
  function updatestatus(id,opt)
    {
      //alert(id); alert(opt);
      if(opt==2){
        rep = confirm("Voulez-vous accepter cet article pour publication ?");
      }else if(opt==3){
        rep = confirm("Voulez-vous valider cet article pour publication ?");
      }else if(opt==4){
        rep = confirm("Voulez-vous PUBLIER cet article ?");
      }else{
        rep = confirm("Voulez-vous désactiver cet article?");
      }
      url = "{{url('/communication/update/state')}}/"+id+"/"+opt;

      if(rep == true)
      {
          window.location.href = url;
      }

    }
    </script>
     
    @endsection



