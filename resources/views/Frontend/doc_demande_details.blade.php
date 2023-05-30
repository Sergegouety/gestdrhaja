@extends('Templates.master')

@section('titre')
    Demande List - Aej Admin
@endsection


@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="mat_info";
$sm="intervention";
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
              <h1 class="page-title text-primary-d2 text-140">
                Detail Document
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

            
                                <div class="row">
                                 <div class="card-body p-0 p-md-3">
                                    <table class="table table-striped-success table-borderless text-dark-m1 mb-0" id="responsive-table">
                                      <thead>
                                        <tr class="bgc-warning-d2 text-white">
                                          <th>Nom & Prénoms</th>
                                          <th>Document</th>
                                          <th>Action</th>
                                          <th>Date</th>
                                          <th>Demandé le</th>
                                        </tr>
                                      </thead>
                                      <tbody class="bgc-success-d2">
                                       
                                      @foreach($details as $detail)
                                      
                                        <tr>
                                          <td>
                                            @if($detail->id)
                                            {{ getInstanceName('users','id',$detail->id,'lname') }}
                                            {{ getInstanceName('users','id',$detail->id,'fname') }}
                                            @endif
                                          </td>
                                          <td>
                                             @if($detail->document_id)
                                           {{getInstanceName('documentation','id',$detail->document_id,'designation')}}
                                            @endif
                                          </td>
                                          <td colspan="2">
                                           @if($detail->state==2)
                                           <button type="button" class="btn btn-blue btn-bold opacity-2">Transmis le : {{ $detail->created_at }}</button>
                                           @endif
                                            @if($detail->state==3)
                                           <button type="button" class="btn btn-green btn-bold opacity-2">Livré le:  {{ $detail->created_at }}</button>
                                           @endif
                                            
                                          </td>
                                           <td>
                                          {{ $detail->date }}
                                           </td>
                                        </tr>
                                      @endforeach
                                        
                                      </tbody>
                                      <br>
                                    </table>
                                 </div>
                                </div>
                              </div>
          </div>
        

            <!-- With scrollbars inside -->
          

            <div id="up_comment_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog"> 
                        <div class="modal-content">    
                           
                           <div class="modal-header">
                    <h5 class="modal-title text-green-d1" id="modal_title"></h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                      <form class="form-horizontal p-20" role="form" method="post"  action="{{ route('add.stock') }}" > 
                          {{ csrf_field() }}  
                         <input type="hidden" name="user_id" value="{{Auth::id()}}" />
                         <input type="hidden" name="demandeur_id" id="demandeur_id" value="" />
                         <input type="hidden" name="demande_id" id="demande_id" value="" />
                         <input type="hidden" name="detail_id" id="detail_id" value="" />
                         <input type="hidden" name="state" value="{{Auth::user()->grade_id}}" />
                         <input type="hidden" name="materiel" id="materiel"/>
                         <input type="hidden" name="type_stock" value="2" />

                <div class="modal-body ace-scrollbar">

                  <div class="form-group row">
                      <div class="mb-1 mb-sm-0 col-sm-3 col-form-label text-sm-right pr-0">
                      
                     </div>
                          
                      <div class="col-sm-9 input-group date" id="id-timepicker2">
                        <input type="text" name="end_time" value="" class="form-control" id="id_time_el" required="" />
                        <div class="input-group-addon input-group-append">
                          <div class="input-group-text">
                            <i class="far fa-clock"></i>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-3 col-form-label text-sm-right pr-0">
                      
                    </div>

                    <div class="col-sm-9 input-floating-label text-blue-d2 brc-blue-m1">
                      <input type="text" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="instock" name="instock" value="0" disabled="" />
                      <span class="floating-label text-grey-m3">
                       En stock
                    </span>
                    </div>
                  </div>
                    

                   <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-3 col-form-label text-sm-right pr-0">
                      
                    </div>

                    <div class="col-sm-9 input-floating-label text-blue-d2 brc-blue-m1">
                      <input type="hidden" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="nbr_demande" name="cartons_d" value="0" required=""/>
                      <input type="text" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="nbr_demande1" name="" value="0" required="" disabled=""/>
                      <span class="floating-label text-grey-m3">
                        Quantité démandée
                    </span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-3 col-form-label text-sm-right pr-0">
                      
                    </div>

                    <div class="col-sm-9 input-floating-label text-blue-d2 brc-blue-m1">
                      <input type="text" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="cartons" name="cartons" value="0"  required=""/>
                      <span class="floating-label text-grey-m3">
                        Quantité Livrée
                    </span>
                    </div>
                  </div>

                  <!-- <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-3 col-form-label text-sm-right pr-0">
                      <label for="id-form-field-3" class="mb-0">
                        Qt Unitaire :
                      </label>
                    </div>

                    <div class="col-sm-9 input-floating-label text-blue-d2 brc-blue-m1">
                      <input type="text" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-3" name="unitaire" required=""/>
                      <span class="floating-label text-grey-m3">
                        Qt Unitaire
                    </span>
                    </div>
                  </div> -->

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
          $("#detail_id").val(detail_id);
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

 function addDocElement(num,name)
   {
      $("#doc_"+num).append('<div class="form-control col-xs-12 col-sm-5" id="file'+num+'"><input type="file" id="id-input-file-2" name="'+name+'" required/></div>');
   }

    function removeDocElement(id)
      {
          $(id).remove();  
      }


</script>



    <!-- "DataTables" page script to enable its demo functionality -->
    <script src="{{asset('views/pages/table-datatables/@demande-script.js')}}"></script>

    @endsection



