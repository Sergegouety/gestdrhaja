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
$sm="conge_stats";
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
                Statistiques Attributions
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

            <div class="card bgc-orange-m3 shadow-sm" id="card-3" draggable="false">
                    <div class="card-header card-header-sm">
                      
                   <form method="post" action="{{ route('get.stat.conge') }}">
                     {{ csrf_field() }} 

                    <div class="row">

                      <div class="col-md-3 mb-3">
                        <label for="diplome">Direction / Bureau :</label>
                            <select onchange="getSousdirection(this.value)" class="chosen-select form-control custom-select" name="direction">
                                <option value="">---------</option>
                                @foreach($directions as $direction)
                                <option value="{{ $direction->id }}" @php if($direction_id==$direction->id){echo 'selected';} @endphp>{{ $direction->designation }}</option>
                                @endforeach
                            </select>
                    </div>

                     <div class="col-md-3 mb-3">
                        <label for="diplome">Sous-Direction / Agence :</label>
                            <select onchange="getService(this.value)"  class="chosen-select form-control custom-select" name="sousdirection" id="sousdirection">
                                <option value="">---------</option>
                                @foreach($sousdirections as $sousdirection)
                                <option value="{{ $sousdirection->id }}" @php if($sousdirection_id==$sousdirection->id){echo 'selected';} @endphp>{{ $sousdirection->designation }}</option>
                                @endforeach
                            </select>
                    </div>

                     <div class="col-md-3 mb-3">
                        <label for="diplome">Service / Guichet :</label>
                            <select id="service" class="chosen-select form-control custom-select" name="service">
                              <option value="">---------</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}" @php if($service_id==$service->id){echo 'selected';} @endphp >{{ $service->designation }}</option>
                                @endforeach
                            </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="materiel">Motif :</label>
                            <select id="materiel" class="chosen-select form-control custom-select" name="motif">
                               <option value="">---------</option>
                               <option value="CONGE">Congé</option>
                               <option value="ABSENCE">Absence</option>
                              
                               
                            </select>
                    </div>

                    </div>
                    <div class="float-left">
                     <button type="submit" class="btn btn-success" >
                              Rechercher
                    </button>
                  </div>
                      
                   </form>
                      
                    </div><!-- /.card-header -->

                   
                  </div>
<br>
            <div class="card bcard overflow-hidden shadow">
                  <div class="card-body p-3px bgc-green-d2">
                    <div class="radius-1 table-responsive">
                      <table class="table table-striped table-bordered table-hover brc-black-tp10 mb-0 text-grey">
                        <thead class="brc-transparent">
                          <tr class="bgc-green-d2 text-white">
                            <th>Agent</th>
                            <th>Congé/Absence</th>
                            <th>Durée</th>
                            <th>Date de départ</th>
                            <th>Date de reprise</th>
                            <th>Intérim</th>
                            <th>Statu</th>
                          </tr>
                        </thead>

                        <tbody>
                          @foreach($conges as $conge)
                          <tr class="bgc-h-orange-l3">
                            <td class="text-dark">
                              {{ $conge->fname}} {{ $conge->lname}}
                            </td>

                            <td class="text-info-m1">
                              {{ $conge->motif}}
                            </td>

                            <td class="text-dark">
                            
                            </td>

                            <td class="text-dark">
                             {{ $conge->date_depart}}
                            </td>

                            <td class="text-dark">
                             {{ $conge->date_retour}}
                            </td>
                            <td class="text-dark">
                             {{ $conge->interim}}
                            </td>
                            <td class="text-dark">
                              @if($conge->state==1)
                                <button type="button" class="btn btn-yellow btn-bold opacity-2">en attente</button>
                              @elseif($conge->state==2)
                                <button type="button" class="btn btn-blue btn-bold opacity-2">Validé</button>
                              @elseif($conge->state==2)
                                <button type="button" class="btn btn-green btn-bold opacity-2">Accepté</button>
                              @else
                                <button type="button" class="btn btn-red btn-bold opacity-2">Rejeté</button>
                              @endif
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div><!-- ./table-responsive -->
                  </div><!-- /.card-body -->
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

                      <!-- <form class="form-horizontal p-20" role="form" method="post"  action="{{ route('add.stock') }}" > 
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

                   <div class="form-group row">
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

                     </form> -->

                                        
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

</script>

<script>

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
        //console.log(data);
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
        //console.log(data);
          $('select#service').html(data.html_first);
           $('select#agent').html(data.html_two);              
      }
    }
);
  }

  function getAgent(id)
  {

    //alert(id);
    
    var url = "{{ url('ajax/agent/show') }}/"+id;
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
        console.log(data);
          $('select#agent').html(data.html_first);        
      }
    }
);
  }


   function displayPlateforme(id)
  {

       if (id == 1) {
              $("#divPlateforme").css("display","block");
            }else {
                  $("#divPlateforme").css("display","none");
                  }

  }



  </script>



    <!-- "DataTables" page script to enable its demo functionality -->
    <script src="{{asset('views/pages/table-datatables/@demande-script.js')}}"></script>

    @endsection



