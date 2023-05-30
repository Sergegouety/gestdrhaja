@extends('Templates.master')

@section('titre')
    Demande List - Aej Admin
@endsection


@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="stats";
$sm="intervention_stats";
@endphp

@section('stylesheet')


    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/bootstrap/dist/css/bootstrap.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/@fortawesome/fontawesome-free/css/fontawesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/@fortawesome/fontawesome-free/css/regular.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/@fortawesome/fontawesome-free/css/brands.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/@fortawesome/fontawesome-free/css/solid.css')}}">



    <!-- include vendor stylesheets used in "DataTables" page. see "/views//pages/partials/table-datatables/@vendor-stylesheets.hbs" -->
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/datatables.net-buttons-bs4/css/buttons.bootstrap4.css')}}">


    <!-- include fonts -->
    <link rel="stylesheet" type="text/css" href="{{asset('dist/css/ace-font.css')}}">



    <!-- ace.css -->
    <link rel="stylesheet" type="text/css" href="{{asset('dist/css/ace.css')}}">


    <!-- favicon -->
    <link rel="icon" type="image/png" href="{asset({'assets/favicon.png')}}" />

    <!-- "DataTables" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="{{asset('views/pages/table-datatables/@page-style.css')}}">

     <!-- "Dashboard 3" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="{{asset('dist/css/ace-themes.css')}}">

@endsection

@section('content')

<div role="main" class="main-content">
    <div class="page-content container container-plus">
            <div class="page-header mb-2 pb-2 flex-column flex-sm-row align-items-start align-items-sm-center py-25 px-1">
              <h1 class="page-title text-orange-d2 text-140 font-bolder">
                Interventions
                <small class="page-info text-dark-m3">
                  <i class="fa fa-angle-double-right text-80"></i>
                </small>
              </h1>

              <div class="page-tools mt-3 mt-sm-0 mb-sm-n1">
                <!-- dataTables search box will be inserted here dynamically -->
              </div>
            </div>

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

            <div class="card bcard h-auto">
              <form autocomplete="off" class="border-t-3 brc-green-m2">

                <table id="datatable" class="d-style w-100 table text-dark-m1 text-95 border-y-1 brc-black-tp11 collapsed">
                  <!-- add `collapsed` by default ... it will be removed by default -->
                  <!-- thead with .sticky-nav -->
                  <thead class="sticky-nav text-green-m1 text-uppercase text-85">
                    <tr>

                      <th class="td-toggle-details border-0 bgc-white shadow-sm">
                       
                      </th>
                      

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Demandeur
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Direction
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Materiel
                      </th>

                      <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">
                        Panne
                      </th>


                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        StatuS
                      </th>

                    </tr>
                  </thead>

                  <tbody class="pos-rel">

                     @foreach($interventions as $intervention)
                     @php

                     @endphp

                    <tr class="d-style bgc-h-orange-l4">

                      <td class="pl-3 pl-md-4 align-middle pos-rel">
                        
                      </td>
                      

                      <td>
                        <span class="text-105">
                           @if($intervention->user_id)
                           {{ getInstanceName('users','id',$intervention->user_id,'lname') }}
                            {{ getInstanceName('users','id',$intervention->user_id,'fname') }}
                           @endif
                        </span>
                        <div class="text-95 text-secondary-d1">
                         
                        </div>
                      </td>

                      <td class="text-grey">
                       
                        <div><span class='badge bgc-orange-d1 text-white badge-sm'></span></div>
                      </td>

                      <td>
                        <span class="text-105">
                      @if($intervention->materiel_id)
                           {{ getInstanceName('design_materiel','id',$intervention->materiel_id,'designation') }}
                           @endif
                        </span>
                       
                      </td>

                       <td>
                        <span class="text-105">
                      {{ $intervention->description }}
                        </span>
                       
                      </td>

                    

                       <td>

                        <div class="btn-group mb-1">
                          @if($intervention->state==1)
                        <button type="button" class="btn btn-yellow btn-bold opacity-2">Defectueux</button>
                        <button type="button" class="px-2 btn btn-yellow dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                         @else
                         <button type="button" class="btn btn-blue btn-bold opacity-2">Fonctionnel</button>
                          <button type="button" class="px-2 btn btn-blue dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                           @endif
                           
                        <div class="dropdown-menu" style="">
                          <!-- <a class="dropdown-item" onclick="deleteMember( {{$intervention->id}}, 0 )" href="#">Modifier</a> -->
                          <a class="dropdown-item" href="{{route('intervention.detail',$intervention->id)}}">Details</a>
                          
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" onclick="addIntervention({{$intervention->materiel_id}},{{$intervention->id}})" data-toggle="modal" data-target="#modalWithScroll3" href="#" >Rapport</a>
                        
                        </div>
                       
                      </div>

                        <div class="text-95 text-secondary-d1">
                         
                        </div>
                      </td>

                    </tr>

                    @endforeach
                    
                  </tbody>
                </table>

              </form>
            </div>
          </div>
        </div>



            <!-- With scrollbars inside -->
            <div class="modal fade" id="modalWithScroll2" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title text-orange-d2">
                       Demande d'intervention
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">

                  <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('add.intervention') }}">
                             {{ csrf_field() }}
                         <input type="hidden" name="user_id" value="{{Auth::id()}}" />
                        

                <div class="modal-body ace-scrollbar">
                    

                    <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0">
                      
                      </button>
                    </div>

                    <div class="col-sm-9 input-floating-label text-blue-d2 brc-blue-m1">
                       <select class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="materiel_id" required="">
                        <option >Matériels</option>
                        @foreach($mymateriel as $materiel)
                        <option value="{{ $materiel->id }}">{{ $materiel->designation }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0">
                      
                    </div>

                    <div class="col-sm-9 input-floating-label text-blue-d2 brc-blue-m1">
                      <textarea class="form-control" name="description" id="id-textarea-autosize" placeholder="Decrivez la panne svp" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 100px;"></textarea>
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
                       Rapport d'intervention
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">

                  <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('add.rapport') }}">
                             {{ csrf_field() }}
                <input type="hidden" name="materiel_id" id="materiel_id" />
                <input type="hidden" name="intervention_id" id="intervention_id" />
                <input type="hidden" name="user_id" value="{{Auth::id()}}" />
                        

                <div class="modal-body ace-scrollbar">
                    

                   

                  <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-1 col-form-label text-sm-right pr-0">
                      
                    </div>

                    <div class="col-sm-10 input-floating-label text-blue-d2 brc-blue-m1">
                      <textarea class="form-control" name="commentaire" id="id-textarea-autosize1" placeholder="Inscrire le Rapport svp" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 100px;" required=""></textarea>
                    </div>

                  </div>

                   <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-1 col-form-label text-sm-right pr-0">
                      
                    </div>

                    <div class="col-sm-8 input-floating-label text-blue-d2 brc-blue-m1">
                       <select class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="materiel_state" required>
                        <option value="">Etat (après intervention)</option>
                        <option value="1">Defectueux</option>
                        <option value="2">Fonctionnel</option>
                       
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-1 col-form-label text-sm-right pr-0">
                      
                    </div>

                    <div class="col-sm-8 input-floating-label text-blue-d2 brc-blue-m1">
                       <select class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="materiel_state" required>
                        <option value="">Besoin (Matériel informatique)</option>
                        <option value="1">Defectueux</option>
                        <option value="2">Fonctionnel</option>
                       
                      </select>
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
    
    <!-- include common vendor scripts used in demo pages -->
    <script src="{{asset('node_modules/jquery/dist/jquery.js')}}"></script>
    <script src="{{asset('node_modules/popper.js/dist/umd/popper.js')}}"></script>
    <script src="{{asset('node_modules/bootstrap/dist/js/bootstrap.js')}}"></script>



    <!-- include vendor scripts used in "DataTables" page. see "/views//pages/partials/table-datatables/@vendor-scripts.hbs" -->
    <script src="{{asset('node_modules/datatables/media/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-colreorder/js/dataTables.colReorder.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-select/js/dataTables.select.js')}}"></script>


    <script src="{{asset('node_modules/datatables.net-buttons/js/dataTables.buttons.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-buttons-bs4/js/buttons.bootstrap4.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-buttons/js/buttons.html5.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-buttons/js/buttons.print.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-buttons/js/buttons.colVis.js')}}"></script>

     <script src="{{ asset('node_modules/tiny-date-picker/dist/date-range-picker.js') }}"></script>
    <script src="{{ asset('node_modules/moment/moment.js') }}"></script>
    <script src="{{ asset('node_modules/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js') }}"></script>


    <script src="{{asset('node_modules/datatables.net-responsive/js/dataTables.responsive.js')}}"></script>



    <!-- include ace.js -->
    <script src="{{asset('dist/js/ace.js')}}"></script>



    <!-- demo.js is only for Ace's demo and you shouldn't use it -->
    <script src="{{asset('app/browser/demo.js')}}"></script>

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

    function getLivraison(id,title,qt,materiel_id,demandeur_id,total_livre,instock,detail_id) {

          $("#modal_title").html(title);
          $("#nbr_demande").val(qt);
          $("#nbr_demande1").val(qt);
          $("#materiel").val(materiel_id);
          $("#demande_id").val(id);
          $("#detail_id").val(id);
          $("#demandeur_id").val(demandeur_id);
          $("#cartons").val(total_livre);
          $("#instock").val(instock);
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

      $("#link_section").append('<div class="form-group row" id="sec_'+x+'"><div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0"><button type="button" class="btn btn-warning remove_element radius-round" id="'+x+'" onclick="removeElement('+x+')"><span class="fa fa-minus"></span></button></div><div class="col-sm-8 input-floating-label text-blue-d2 brc-blue-m1"><select class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="materiel[]" required=""><option >Matériels</option>@foreach($materiels as $materiel)<option value="{{ $materiel->id }}">{{ $materiel->designation }}</option>@endforeach</select></div></div><div class="form-group row" id="sec1_'+x+'"><div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0"></div><div class="col-sm-9 input-floating-label text-blue-d2 brc-blue-m1"><input type="text" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="cartons[]"required=""/><span class="floating-label text-grey-m3">Quantité</span></div></div>');
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

function addIntervention(materiel_id,intervention_id) {
          $("#materiel_id").val(materiel_id);
          $("#intervention_id").val(intervention_id);
    }

</script>



    <!-- "DataTables" page script to enable its demo functionality -->
    <script src="{{asset('views/pages/table-datatables/@demande-script.js')}}"></script>

    @endsection



