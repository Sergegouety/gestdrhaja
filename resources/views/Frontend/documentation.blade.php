@extends('Templates.list_master')

@section('titre')
    Demande List - Aej Admin
@endsection


@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="document";
$sm="demande";
$agent_function = Session::get('function_key');
$direction_id=$agent_function->direction_id;
$sousdirection_id=$agent_function->sousdirection_id;
$service_id=$agent_function->service_id;
$agent_level=$agent_function->level;
$isdocadmin=$agent_function->isdocadmin;
//dd($agent_function);
$ob_param=Session::get('ob_param');
$nom=$ob_param['nom'] ?? '';
$datedemande=$ob_param['datedemande'] ?? '';

@endphp

@section('stylesheet')


@endsection

@section('content')

<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Documents</h3>
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

                  <form method="get" action="{{ route('super.documentation') }}" >
                     {{ csrf_field() }} 

                    <div class="form-group">
                        <label class="col-sm-1 control-label">Recherche:</label>
                        <div class="col-sm-2">
                          <input type="text" class="form-control" name="nom" value="{{$nom}}"/>
                        </div>

                        <label class="col-sm-1 control-label">date:</label>
                        <div class="col-sm-2">
                          <input type="date" class="form-control" name="datedemande" value="{{format_date2($datedemande)}}"/>
                        </div>
                    </div >
                    <div class="col-sm-2">
                     <button type="submit" class="btn btn-success" >
                              Rechercher
                    </button>
                   </div>
                   </form>

                       <a href="{{ route('export.documentation',$ob_param) }}" class="btn" style="float:right;color:green">
                        <i class="fa fa-download"></i> Exporter
                       </a>
                   
                      <a href="{{route('nouvelle.demande.document')}}"  class="btn btn-warning">
                            Nouveau
                      </a>

                </div>
               
                <hr>
                <thead>
                 <tr>
                      <th class="td-toggle-details border-0 bgc-white shadow-sm">
                      </th>
                      <th >
                        Date 
                      </th>
                      <th >
                        Demandeur
                      </th>
                      
                      <th >
                        Document
                      </th>
                      <th >
                        Exemplaire
                      </th>
                      <th >
                        Motif
                      </th>
                      <th >
                        Statut
                      </th>
                    </tr>
                </thead>
                <tbody>
                 
                 @foreach($demandes as $demande)
                     
                    <tr class="d-style bgc-h-orange-l4">

                      <td class="pl-3 pl-md-4 align-middle pos-rel">
                        
                      </td>
             
                      <td>
                         {{format_date($demande->date)}}
                      </td>
                      
                      <td>
                        <span class="text-105">
                           @if($demande->id)
                           {{ getInstanceName('users','id',$demande->id,'nomprenoms') }}
                           @endif
                        </span>
                        <div class="text-95 text-secondary-d1">
                         
                        </div>
                      </td>
                      

                      <td>
                        <span class="text-105">
                      @if($demande->document_id)
                           {{ getInstanceName('documentation','id',$demande->document_id,'designation') }}
                           @endif
                        </span>
                       
                      </td>

                       <td>
                        <span class="text-105">
                      {{ $demande->nbr_doc }}
                        </span>
                       
                      </td>

                      <td>
                        <span class="text-105">
                      {{ $demande->description }}
                        </span>
                       
                      </td>
  
                       <td>

                        <div class="btn-group">
                          @if($demande->state==1)
                        <button type="button" class="btn btn-warning btn-bold opacity-2">en attente</button>
                        <button type="button" class="px-2 btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @elseif($demande->state==2)
                         <button type="button" class="btn btn-theme02 btn-bold opacity-2">Transmis à la DRHAJA</button>
                          <button type="button" class="px-2 btn btn-theme02 dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @elseif($demande->state==3)
                         <button type="button" class="btn btn-theme03 btn-bold opacity-2">Transmis à l'Admin.</button>
                          <button type="button" class="px-2 btn btn-theme03 dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                         @elseif($demande->state==4)
                         <button type="button" class="btn btn-theme btn-bold opacity-2">Signé</button>
                          <button type="button" class="px-2 btn btn-theme dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                         @elseif($demande->state==5)
                         <button type="button" class="btn btn-success btn-bold opacity-2">Transmis au Serv. courrier</button>
                          <button type="button" class="px-2 btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                         @elseif($demande->state==6)
                         <button type="button" class="btn btn-success btn-bold opacity-2">Doc. Livré</button>
                          <button type="button" class="px-2 btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                         @else
                         <button type="button" class="btn btn-danger btn-bold opacity-2">Annulé</button>
                          <button type="button" class="px-2 btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @endif
                           
                        <ul class="dropdown-menu" style="">
                         <!-- les service responsables du traitement des demandes -->
                          @if($sousdirection_id==12 || $sousdirection_id==13)
                           @if($demande->state==1)
                          <li>
                            <a class="dropdown-item" onclick="demande_stateupdate( {{$demande->docId}}, 2 )" href="#" title="Transmettre à la DRHAJA">Transmettre à la DRHAJA
                            </a>
                          </li>
                          @endif
                          @if($demande->state==5)
                          <li>
                          <a class="dropdown-item" onclick="demande_stateupdate( {{$demande->docId}}, 6 )" href="#" title="Livré au demandeur">Livrer
                         </a>
                         </li>
                         @endif
                         @if($demande->state==1 || $demande->state==5)
                         <li>
                          <a class="dropdown-item" onclick="demande_stateupdate( {{$demande->docId}}, 0 )" href="#" title="Livré au demandeur">Annuler
                          </a>
                        </li>
                        @endif
            
                      @endif
                            <!-- Bureau de la drhaja  -->
                          @if($direction_id==4 && $sousdirection_id==0)
                           @if($demande->state==2)
                          <li>
                            <a class="dropdown-item" onclick="demande_stateupdate( {{$demande->docId}}, 3 )" href="#" title="Transmettre à l'Administrateur">Transmettre à l'Admin
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item" onclick="demande_stateupdate( {{$demande->docId}}, 4 )" href="#" title="Transmettre au service courrier">Signer
                          </a>
                        </li>
                        @endif
                        @if($demande->state==4)
                         <li>
                          <a class="dropdown-item" onclick="demande_stateupdate( {{$demande->docId}}, 5 )" href="#" title="Livré au demandeur">Transmettre au Serv. courrier
                         </a>
                        </li>
                        @endif
                         @if($demande->state==2)
                         <li>
                          <a class="dropdown-item" onclick="demande_stateupdate( {{$demande->docId}}, 0 )" href="#" title="Livré au demandeur">Annuler
                          </a>
                        </li>
                        @endif
                         @endif
                           <!-- Bureau de l'administrateur  -->
                          @if($direction_id==9 && $sousdirection_id==0)
                           @if($demande->state==3)
                          <li>
                            <a class="dropdown-item" onclick="demande_stateupdate( {{$demande->docId}}, 4 )" href="#" title="Transmettre au service courrier">Signer
                          </a>
                        </li>
                        @endif
                        @if($demande->state==4)
                         <li>
                          <a class="dropdown-item" onclick="demande_stateupdate( {{$demande->docId}}, 5 )" href="#" title="Livré au demandeur">Transmettre au Serv. courrier
                         </a>
                        </li>
                        @endif
                         @if($demande->state==3)
                         <li>
                          <a class="dropdown-item" onclick="demande_stateupdate( {{$demande->docId}}, 0 )" href="#" title="Livré au demandeur">Annuler
                          </a>
                        </li>
                        @endif
                         @endif

                         @if($demande->state==0)
                        <li>
                          <a class="dropdown-item" onclick="demande_stateupdate( {{$demande->docId}}, 1 )" href="#" title="Restauré la demande">Restauré
                          </a>
                        </li>
                         @endif
                        </ul>
                       
                      </div>

                        <div class="text-95 text-secondary-d1">
                         
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
      </section>



        <div class="modal fade" id="modalWithScroll2" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title text-blue-d2">
                      Demande de document
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">

                  <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('add.demandeDocument') }}">
                             {{ csrf_field() }}
                         <input type="hidden" name="user_id" value="{{Auth::id()}}" />

                <div class="modal-body ace-scrollbar">
                    

                    <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0">
                      <button type="button" onclick="addElement()" class="btn btn-success radius-round">
                             <span class="fa fa-plus"></span>
                      </button>
                    </div>

                    <div class="col-sm-8 input-floating-label text-blue-d2 brc-blue-m1">
                       <select class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="document_id[]" required="">
                        @foreach($documents as $document)
                        <option value="{{ $document->id }}">{{ $document->designation }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0">
                      
                    </div>

                    <div class="col-sm-9 input-floating-label text-blue-d2 brc-blue-m1">
                      <input type="number" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="nbr_doc[]"required=""/>
                      <span class="floating-label text-grey-m3">
                        Nbre exemplaire
                    </span>
                    </div>
                  </div>

                  <div id="link_section" >
                    
                  </div>


                  </div>


                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                      Fermer
                    </button>

                    <button type="submit" class="btn btn-primary">
                      Ajouter
                    </button>
                  </div>
                 </form>
               </div>
                </div>
              </div>
            </div>



            <!-- With scrollbars inside -->
            <div class="modal fade" id="modalWithScroll" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title text-orange-d2">
                       Demande de document
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">

                  <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('add.demandeDocument') }}">
                             {{ csrf_field() }}
                         <input type="hidden" name="user_id" value="{{Auth::id()}}" />
                        

                <div class="modal-body ace-scrollbar">

                  <div class="form-group row">
                    <div class="col-sm-2 col-form-label text-sm-right pr-0">
                    
                    </div>

                    <div class="col-sm-9 col-12">
                      <select multiple id="form-field-chosen-2" class="chosen-select form-control" name="document_id[]" required="">
                        @foreach($documents as $document)
                        <option value="{{ $document->id }}">{{ $document->designation }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0">
                      
                    </div>

                    <div class="col-sm-9 input-floating-label text-blue-d2 brc-blue-m1">
                      <textarea class="form-control" name="description" id="id-textarea-autosize" placeholder="Commentaire" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 100px;"></textarea>
                    </div>

                  </div>

                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                      Fermer
                    </button>

                    <button type="submit" class="btn btn-success">
                      Ajouter
                    </button>
                  </div>
                 </form>
               </div>
                </div>
              </div>
            </div>



            <div class="modal fade" id="modalWithScroll3" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title text-orange-d2">
                      Traitement de la demande
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">

                  <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('document.send') }}" ENCTYPE="multipart/form-data">
                             {{ csrf_field() }}
                
                <input type="hidden" name="demandeur_id" id="demandeur_id" value="0" />
                <input type="hidden" name="intervention_id" id="intervention_id" value="0" />
                <input type="hidden" name="user_id" value="{{Auth::id()}}" value="" />
                        

                <div class="modal-body ace-scrollbar">

                  <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-1 col-form-label text-sm-right pr-0">
                      
                    </div>

                    <div class="col-sm-8 input-floating-label text-blue-d2 brc-blue-m1">
                       <select class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="materiel_state" required>
                        <option value="">Statu traitement</option>
                        <option value="1">Livré</option>
                        <option value="2">Refuser</option>
                       
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-1 col-form-label text-sm-right pr-0">
                      
                    </div>

                    <div class="col-sm-10 input-floating-label text-blue-d2 brc-blue-m1">
                       <input type="file" class="" id="" name="fichier"/>
                    </div>

                  </div>
                    
                  <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-1 col-form-label text-sm-right pr-0">
                      
                    </div>

                    <div class="col-sm-10 input-floating-label text-blue-d2 brc-blue-m1">
                      <textarea class="form-control" name="commentaire" id="id-textarea-autosize1" placeholder="Commentaire" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 100px;" required=""></textarea>
                    </div>

                  </div>


                  </div>


                  <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                      Fermer
                    </button>

                    <button type="submit" class="btn btn-success">
                      Ajouter
                    </button>
                  </div>
                 </form>
               </div>
                </div>
              </div>
            </div>


            <div id="up_comment_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog"> 
                        <div class="modal-content">    
                           
                           <div class="modal-header">
                    <h5 class="modal-title text-green-d1" id="modal_title"></h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                                        
                  </div>

                      </div> 
                  </div>

    @endsection

    @section('scriptjs')
   

     <script >
      ////////////////////////
  // Datetimepicker plugin
  $('#id-timepicker').datetimepicker({
    icons: {
      time: 'far fa-clock text-green-d1 text-120',
      date: 'far fa-calendar text-blue-d1 text-120',

      up: 'fa fa-chevron-up text-secondary',
      down: 'fa fa-chevron-down text-secondary',
      previous: 'fa fa-chevron-left text-secondary',
      next: 'fa fa-chevron-right text-secondary',

      today: 'far fa-calendar-check text-purple-d1 text-120',
      clear: 'fa fa-trash-alt text-orange-d2 text-120',
      close: 'fa fa-times text-danger text-120'
    },

    // sideBySide: true,

    toolbarPlacement: "top",

    allowInputToggle: true,
    // showClose: true,
    // showClear: true,
    showTodayButton: true,


    //"format": "HH:mm:ss"
  })

  //***** NOTE *******//
  // the above `date/time` picker plugin was designed for BS3.
  // To make it work with BS4, the following piece of code is required
  $('#id-timepicker')
  .on('dp.show', function() {
    $(this).find('.collapse.in').addClass('show')
    $(this).find('.table-condensed').addClass('table table-borderless')

    $(this).find('[data-action][title]').tooltip() // enable tooltip
  })

  // now listen to the `.collapse` events inside this datetimepicker accordion (one `.collapse` is for timepicker, the other one is for datepicker)
  // then add or remove the old `in` BS3 class so the plugin works correctly
  $(document)
  .on('show.bs.collapse', '.bootstrap-datetimepicker-widget .collapse', function() {
    $(this).addClass('in')
  }).on('hide.bs.collapse', '.bootstrap-datetimepicker-widget .collapse', function() {
    $(this).removeClass('in')
  })

  function deleteMember(id,opt)
    {
      rep = confirm("Voulez-vous Valider cette demande?");

      url = "{{url('/demande/update/state')}}/"+id+"/"+opt;

      if(rep == true)
      {
          window.location.href = url;
      }

    }

    function demande_stateupdate(id,opt)
    {
      if(opt==2){
        rep = confirm("Voulez-vous Transmettre le document à la DRHAJA ?");
      }else  if(opt==3){
        rep = confirm("Voulez-vous Transmettre le document à l'Administrateur ?");
      }else  if(opt==4){
        rep = confirm("Ce document a t-il été signé ?");
      }else  if(opt==5){
        rep = confirm("Voulez-vous Transmettre au Serv. courrier ?");
      }else  if(opt==6){
        rep = confirm("Ce document a t-il été livré ?");
      }else  if(opt==1){
               alert("Voulez-vous restauré ce document ?");
        rep = confirm("Après la restauration, il devra être confirmé par le service compétant !");
      }else{
        rep = confirm("Voulez-vous annulé la demande ?");
      }
      

      url = "{{url('/documentation/update/state')}}/"+id+"/"+opt;

      if(rep == true)
      {
          window.location.href = url;
      }

    }

    function traitement_send(demandeur_id,intervention_id) {
 //alert(demandeur_id);
          $("#intervention_id").val(intervention_id);
          $("#demandeur_id").val(demandeur_id);

    }

    </script>

     <script >
      ////////////////////////
  // Datetimepicker plugin
  $('#id-timepicker2').datetimepicker({
    icons: {
      time: 'far fa-clock text-green-d1 text-120',
      date: 'far fa-calendar text-blue-d1 text-120',

      up: 'fa fa-chevron-up text-secondary',
      down: 'fa fa-chevron-down text-secondary',
      previous: 'fa fa-chevron-left text-secondary',
      next: 'fa fa-chevron-right text-secondary',

      today: 'far fa-calendar-check text-purple-d1 text-120',
      clear: 'fa fa-trash-alt text-orange-d2 text-120',
      close: 'fa fa-times text-danger text-120'
    },

    // sideBySide: true,

    toolbarPlacement: "top",

    allowInputToggle: true,
    // showClose: true,
    // showClear: true,
    showTodayButton: true,

    //"format": "HH:mm:ss"
  })

  //***** NOTE *******//
  // the above `date/time` picker plugin was designed for BS3.
  // To make it work with BS4, the following piece of code is required
  $('#id-timepicker2')
  .on('dp.show', function() {
    $(this).find('.collapse.in').addClass('show')
    $(this).find('.table-condensed').addClass('table table-borderless')

    $(this).find('[data-action][title]').tooltip() // enable tooltip
  })

  // now listen to the `.collapse` events inside this datetimepicker accordion (one `.collapse` is for timepicker, the other one is for datepicker)
  // then add or remove the old `in` BS3 class so the plugin works correctly
  $(document)
  .on('show.bs.collapse', '.bootstrap-datetimepicker-widget .collapse', function() {
    $(this).addClass('in')
  }).on('hide.bs.collapse', '.bootstrap-datetimepicker-widget .collapse', function() {
    $(this).removeClass('in')
  })

    </script>

    <script>

    var x = 1;

    function addElement()
   {

    x++;

      $("#link_section").append('<div class="form-group row" id="sec_'+x+'"><div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0"><button type="button" class="btn btn-warning remove_element radius-round" id="'+x+'" onclick="removeElement('+x+')"><span class="fa fa-minus"></span></button></div><div class="col-sm-8 input-floating-label text-blue-d2 brc-blue-m1"><select class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="document_id[]" required="">@foreach($documents as $document)<option value="{{ $document->id }}">{{ $document->designation }}</option>@endforeach</select></div></div><div class="form-group row" id="sec1_'+x+'"><div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0"></div><div class="col-sm-9 input-floating-label text-blue-d2 brc-blue-m1"><input type="number" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="nbr_doc[]"required=""/><span class="floating-label text-grey-m3"> Nbre exemplaire</span></div></div>');
   }


      function removeElement(id)
      {
          $('#sec_'+id).remove();
          $('#sec1_'+id).remove();  
           x--;
      }

 function addDocElement(num,name)
   {
      $("#doc_"+num).append('<div class="form-control col-xs-12 col-sm-5" id="file'+num+'"><input type="file" id="id-input-file-2" name="'+name+'" required/></div>');
   }

    function removeDocElement(id)
      {
          $(id).remove();  
      }


</script>

   
    
  </body>

    @endsection



