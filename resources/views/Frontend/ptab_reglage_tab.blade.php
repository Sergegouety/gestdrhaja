@extends('Templates.list_master')

@section('titre')
    Demande List - Aej Admin
@endsection


@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="evaluation";
$sm="reglage";

$agent_function = Session::get('function_key');

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
        <h3><i class="fa fa-angle-right"></i>Periode Reglage</h3>

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

                  
                       
                   
                      <a href="{{route('reglage.form')}}"   class="btn btn-warning" style="margin-right: 5px;">
                            Nouvelle Periode
                      </a>
                </div>
               
                <hr>
                <thead class="sticky-nav text-green-m1 text-uppercase text-85" >
                    <tr>

                      <th class="td-toggle-details border-0 bgc-white shadow-sm">
                       
                      </th>

                       <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Collecte
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Trimestre
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Date Début
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Date Fin
                      </th>

                      <th class="td-toggle-details border-0 bgc-white shadow-sm">
                       Statut
                      </th>
                      

                    </tr>
                  </thead>
                <tbody class="pos-rel">

                      @foreach($periodes as $periode)

                     

                      <tr class="d-style bgc-h-orange-l4">

                        <td>
                        </td>

                        <td >
                        @if($periode->grade==1)
                        Tâches
                        @elseif($periode->grade==2)
                        Activités
                        @elseif($periode->grade==3)
                        Actions
                         @elseif($periode->grade==4)
                        Extrant
                        @else
                        Axe Stratégique
                        @endif
                        </td>

                        <td>
                          @if($periode->trimestre==1)
                        1er trimestre
                        @elseif($periode->trimestre==2)
                        2ème trimestre
                        @elseif($periode->trimestre==3)
                        3ème trimestre
                        @else
                        4ème trimestre
                        @endif
                        </td>

                        <td>
                        {{format_date($periode->date_debut)}}
                        </td>
                        <td>
                        {{format_date($periode->date_fin)}}
                        </td>

                        <td>

                      <div class="btn-group">
                        @if($periode->state==0)
                        <button type="button" class="btn btn-danger btn-bold opacity-2">Desactivé</button>
                        <button type="button" class="px-2 btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @else
                        <button type="button" class="btn btn-success btn-bold opacity-2">Activé</button>
                        <button type="button" class="px-2 btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @endif
                          <ul class="dropdown-menu" style="">
                          @if($periode->state==0)
                        <li>
                          <a class="dropdown-item" onclick="periodestate({{$periode->id}},1)" href="#">
                          Activer
                          </a>
                        </li>
                        @else
                        <li>
                          <a class="dropdown-item" onclick="periodestate({{$periode->id}},0)" href="#">
                          Désactiver
                          </a>
                        </li>
                        @endif
                        <!-- <li>
                          <a class="dropdown-item" onclick="periodestate('action','id',{{$periode->id}})" href="#">
                          Supprimer
                        </a>
                      </li> -->
                      <li>
                          <a href="{{route('reglage.ptab.edit',$periode->id)}}" class="dropdown-item">
                          Modifier
                          </a>
                        </li>
                           
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
      </section>



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

  function periodestate(periode_id,periode_state)
    {
      //alert(table); alert(champ); alert(value);
      rep = confirm("Voulez-vous modifier?");
      url = "{{url('/periode/changestate')}}/"+periode_id+"/"+periode_state;

      if(rep == true)
      {
          window.location.href = url;
      }

    }


    function updatedemande(demande_id,demandeur_name,demandeur_id,demande_motif,interimaire,date_demande,date_depart,date_retour,demande_state) {
alert(demandeur_id);
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

    </script>

    @endsection



