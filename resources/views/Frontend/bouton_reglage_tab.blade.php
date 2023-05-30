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
$sm="bouton";

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
        <h3><i class="fa fa-angle-right"></i>Bouton Reglage</h3>

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
               
                <hr>
                <thead class="sticky-nav text-green-m1 text-uppercase text-85" >
                    <tr>

                      <th class="td-toggle-details border-0 bgc-white shadow-sm">
                       
                      </th>

                       <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Bouton
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Description
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Statut
                      </th>

                    </tr>
                  </thead>
                <tbody class="pos-rel">

                      @foreach($boutons as $bouton)

                     

                      <tr class="d-style bgc-h-orange-l4">
                        <td>
                          
                        </td>
 
                        <td>
                          {{ $bouton->bouton}}
                        </td>

                        <td >
                        {{ $bouton->description}}
                        </td>
                        <td>
                        @if($bouton->state==1)
                        <button class="btn btn-success" onclick="activeButon({{$bouton->id}},0)">Actif</button>
                        @else
                         <button class="btn btn-danger" onclick="activeButon({{$bouton->id}},1)">Inactif</button>
                        @endif
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

  function activeButon(id,state)
    {
      //alert(table); alert(champ); alert(value);
      if(state == 1){ rep = confirm("Voulez-vous Activer le bouton ?");}
      if(state == 0){ rep = confirm("Voulez-vous Désactiver le bouton ?");}
     
      url = "{{url('/bouton/changestate')}}/"+id+"/"+state;

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



