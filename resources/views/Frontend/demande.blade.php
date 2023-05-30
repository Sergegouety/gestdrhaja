@extends('Templates.list_master')

@section('titre')
    Demande List - Aej Admin
@endsection


@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="conges";
$sm="demande";

$agent_function = Session::get('function_key');

$ob_param=Session::get('ob_param');
$nom=$ob_param['nom'] ?? '';
$datedemande=$ob_param['datedemande'] ?? '';
//dd($agent_function);
@endphp

@section('stylesheet')



@endsection

@section('content')

<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Congés</h3>

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

                  <form method="get" action="{{ route('super.demande') }}" >
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

                       <a href="{{ route('export.conge',$ob_param) }}" class="btn" style="float:right;color:green">
                        <i class="fa fa-download"></i> Exporter
                       </a>
                   
                      <a href="{{route('nouvel.demande')}}"  class="btn btn-warning">
                            Nouveau
                      </a>

                </div>
               
                <hr>
                <thead class="sticky-nav text-green-m1 text-uppercase text-85">
                    <tr>

                      <th class="td-toggle-details border-0 bgc-white shadow-sm">
                       
                      </th>

                       <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Date de demande
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                        Demandeur
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Objet
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                       Intérimaire
                      </th>

                      <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">
                        Date de départ
                      </th>

                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Date de retour
                      </th>
                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Durée
                      </th>
                      <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Justif
                      </th>

                       <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
                         Commentaire
                      </th>
                       <th class="border-0 bgc-white bgc-h-yellow-l3 shadow-sm">
                        Statut
                      </th>

                    </tr>
                  </thead>
                <tbody class="pos-rel">

                     @foreach($demandes as $demande)
                     @php
                     if($demande->interim){ $int= getInstanceName('users','id',$demande->interim,'nomprenoms'); }else{ $int= '';}

                     @endphp

                    <tr class="d-style bgc-h-orange-l4">

                      <td class="pl-3 pl-md-4 align-middle pos-rel">
                        
                      </td>

                      <td>
                        <span class="text-105">
                         {{ format_date($demande->date_demande) }}
                        </span>
                       
                      </td>

                      <td>
                        <span class="text-105">
                           {{$demande->nomprenoms}}
                        </span>
                        <div class="text-95 text-secondary-d1">
                        </div>
                      </td>

                      <td class="text-grey">
                        {{ $demande->objet }}
                        <div><span class='badge bgc-orange-d1 text-white badge-sm'></span></div>
                      </td>

                       <td class="text-grey">
                       
                        {{ $int }}
                       
                        <div><span class='badge bgc-orange-d1 text-white badge-sm'></span></div>
                      </td>

                       <td>
                        <span class="text-105">
                         {{ format_date($demande->date_depart) }}
                        </span>
                      </td>

                       <td>
                        <span class="text-105">
                         {{ format_date($demande->date_retour) }}
                        </span>
                       
                      </td>

                      <td>
                        <span class="text-105">
                         {{ $demande->duree }} Jour.s
                        </span>
                       
                      </td>
                      <td>
                        <span class="text-105">
                          @if($demande->justificatif)
                          <a href="{{asset($demande->justificatif)}}" target="_blank" class="btn" style="color:green"><i class="fa fa-download"></i></a>
                         
                         @endif
                        </span>
                       
                      </td>
                      <td>
                         <div class="btn-group">
                            <button type="button" class="btn btn-default btn-bold opacity-2">Commentaire</button>
                            <button type="button" class="px-2 btn btn-default dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                              <i class="fa fa-caret-down"></i>
                            </button>
                            <ul class="dropdown-menu" style="">
                            @if($demande->observation_cs)
                            <li>
                              <a class="dropdown-item" data-toggle="modal" data-target="#commentaireModal" onclick="commentview('1','{{ $demande->observation_cs }}')">
                              chef de service
                              </a>
                           </li>
                           @endif
                            @if($demande->observation_sd)
                           <li>
                              <a class="dropdown-item" data-toggle="modal" data-target="#commentaireModal" onclick="commentview('2','{{ $demande->observation_sd }}')">
                              Sous - Directeur
                              </a>
                           </li>
                           @endif
                            @if($demande->observation_d)
                           <li>
                              <a class="dropdown-item" data-toggle="modal" data-target="#commentaireModal" onclick="commentview('3','{{ $demande->observation_d }}')">
                              Directeur
                              </a>
                           </li>
                           @endif
                            @if($demande->observation_sdrh)
                           <li>
                              <a class="dropdown-item" data-toggle="modal" data-target="#commentaireModal" onclick="commentview('4','{{ $demande->observation_sdrh }}')">
                              Sous - Directeur RH
                              </a>
                           </li>
                           @endif
                            @if($demande->observation_drh)
                           <li>
                              <a class="dropdown-item" data-toggle="modal" data-target="#commentaireModal" onclick="commentview('5','{{ $demande->observation_drh }}')">
                              DRHAJA
                              </a>
                           </li>
                           @endif
                            @if($demande->observation_admin)
                           <li>
                              <a class="dropdown-item" data-toggle="modal" data-target="#commentaireModal" onclick="commentview('6','{{ $demande->observation_admin }}')">
                              Administrateur
                              </a>
                           </li>
                           @endif
                          </ul>
                        </div>
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
                         <button type="button" class="btn btn-info btn-bold opacity-2">Accordé</button>
                          <button type="button" class="px-2 btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                          @elseif($demande->state==3)
                           <button type="button" class="btn btn-primary btn-bold opacity-5">Accepté</button>
                            <button type="button" class="px-2 btn btn-primary dropdown-toggle dropdown-toggle-split opacity-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @elseif($demande->state==4)
                           <button type="button" class="btn btn-theme03 btn-bold opacity-5">Validé</button>
                            <button type="button" class="px-2 btn btn-theme03 dropdown-toggle dropdown-toggle-split opacity-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @elseif($demande->state==5)
                           <button type="button" class="btn btn-success btn-bold opacity-5">Validé Def.</button>
                            <button type="button" class="px-2 btn btn-success dropdown-toggle dropdown-toggle-split opacity-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            <i class="fa fa-caret-down"></i>
                          </button>
                           @else
                           <button type="button" class="btn btn-danger btn-bold opacity-2">Ajouné</button>
                           <button type="button" class="px-2 btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                          <i class="fa fa-caret-down"></i>
                        </button>
                           @endif
                           <!-- verification des chef de service -->
                          <ul class="dropdown-menu" style="">
                            @if($demande->demandeur_id != Auth::id())

                            @if($agent_function->level==2 && $demande->state < 2 )
                            <li>
                            <a class="dropdown-item" onclick="commentdemande('{{$demande->id}}','{{ $demande->objet }}','{{$int}}','{{ $demande->objet_absence }}','{{ format_date($demande->date_depart)}}','{{ format_date($demande->date_retour) }}','1')" href="#" data-toggle="modal" data-target="#myModal">
                            Accorder
                            </a>
                          </li>
                          @endif

                          <!-- Acceptation des Sous directeurs -->
                          @if(($agent_function->level==3) && $demande->state < 3)
                          <li>
                            <a class="dropdown-item" onclick="commentdemande('{{$demande->id}}','{{ $demande->objet }}','{{$int}}','{{ $demande->objet_absence }}','{{ format_date($demande->date_depart)}}','{{ format_date($demande->date_retour) }}','2')" href="#" data-toggle="modal" data-target="#myModal" >
                            Accepter
                            </a>
                          </li>
                          @endif
                         
                          <!-- Acceptation facultatif des  directeurs -->
                          @if(($agent_function->level==4) && $agent_function->direction_id==$demande->direction_id )
                          <li>
                            <a class="dropdown-item" onclick="commentdemande('{{$demande->id}}','{{ $demande->objet }}','{{$int}}','{{ $demande->objet_absence }}','{{ format_date($demande->date_depart)}}','{{ format_date($demande->date_retour) }}','3')" href="#" data-toggle="modal" data-target="#myModal">
                            Accepter
                            </a>
                          </li>
                          @endif

                           <!-- Validation du Sous directeur des RH -->
                           @if( ($agent_function->iscpadmin==1 && $agent_function->level==3) && 
                            ($demande->state==3 || ($demande->state==1 && $agent_function->sousdirection_id==0) ) 
                            )
                          <li>
                            <a class="dropdown-item" onclick="commentdemande('{{$demande->id}}','{{ $demande->objet }}','{{$int}}','{{ $demande->objet_absence }}','{{ format_date($demande->date_depart)}}','{{ format_date($demande->date_retour) }}','4')" href="#" href="#" data-toggle="modal" data-target="#myModal">
                            Valider
                            </a>
                          </li>
                          @endif

                          <!-- Validation du Sous directeur des RH -->
                           @if( $agent_function->level==6)
                          <li>
                            <a class="dropdown-item" onclick="commentdemande('{{$demande->id}}','{{ $demande->objet }}','{{$int}}','{{ $demande->objet_absence }}','{{ format_date($demande->date_depart)}}','{{ format_date($demande->date_retour) }}','6')" href="#" href="#" data-toggle="modal" data-target="#myModal">
                            Valider
                            </a>
                          </li>
                          @endif
                          
                          <!-- Validation du secretaire du Sous directeur des RH -->
                          @if( ($agent_function->iscpadmin==1 && $agent_function->isassistant==1) && ($demande->state==3 || ($demande->state==1 && $agent_function->sousdirection_id==0) ) 
                            )
                          <li>
                            <a class="dropdown-item" onclick="commentdemande('{{$demande->id}}','{{ $demande->objet }}','{{$int}}','{{ $demande->objet_absence }}','{{ format_date($demande->date_depart)}}','{{ format_date($demande->date_retour) }}','4')" href="#" href="#" data-toggle="modal" data-target="#myModal">
                            Valider
                            </a>
                          </li>
                          @endif
                          
                          <!-- Validation du directeur des RHAJA -->
                          @if(($agent_function->iscpadmin==1 && $agent_function->level==4 ) && $demande->state==4)
                          <li>
                            <a class="dropdown-item" onclick="commentdemande('{{$demande->id}}','{{ $demande->objet }}','{{$int}}','{{ $demande->objet_absence }}','{{ format_date($demande->date_depart)}}','{{ format_date($demande->date_retour) }}','5')" href="#" href="#" data-toggle="modal" data-target="#myModal">
                            Valider Def.
                            </a>
                          </li>
                          @endif
                          <!-- Validation du secretaire du  directeur des RHAJA -->
                          @if(($agent_function->iscpadmin==4 && $agent_function->isassistant==1 ) && $demande->state==4)
                          <li>
                            <a class="dropdown-item" onclick="commentdemande('{{$demande->id}}','{{ $demande->objet }}','{{$int}}','{{ $demande->objet_absence }}','{{ format_date($demande->date_depart)}}','{{ format_date($demande->date_retour) }}','5')" href="#" data-toggle="modal" data-target="#myModal">
                            Valider Def.
                            </a>
                          </li>
                          @endif
                          @endif
                          @if(Auth::id()==$demande->demandeur_id && $demande->state <= 2)
                          <div class="dropdown-divider"></div>
                           <li>
                            <a href="{{route('demande.detail',$demande->id)}}" class="dropdown-item"  >Modifier</a>
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
           {{ $demandes->links() }}
            <!-- /content-panel -->
          </div>
          <!-- /col-md-12 -->
        </div>
        <!-- /row -->
      </section>



            <div class="modal fade" id="commentaireModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Commentaire <span class="u_comment"></span> </h4>
                    </div>
                    <div class="modal-body">

                      <form class="form-horizontal m-t-10 p-20 p-b-0">
                            
                        <div class="modal-body ace-scrollbar">

                        <div class="form-group">

                        <label class="col-sm-4 col-sm-4 control-label">Commentaire :
                        </label>
                        <div class="col-sm-8">
                          <textarea class="form-control" id="commentaire" name="commentaire" rows="4" readonly></textarea>
                        </div>

                        </div>

                      </div>

                  
                    </form>
                      
                    </div>
                    
                  </div>
                </div>
              </div>



            <!-- With scrollbars inside -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Demande de congé / Autorisation d'absence</h4>
                    </div>
                    <div class="modal-body">

                      <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" enctype="multipart/form-data" action="{{ route('update.demande.commentaire') }}">
                             {{ csrf_field() }} 
                  <div class="modal-body ace-scrollbar">

                  <input type="hidden" name="demande_id" id="demande_id" value="">
                  <input type="hidden" name="level_id" id="level_id" value="">
        
                  <div class="form-group">

                    <label class="col-sm-4 col-sm-4 control-label">OBJET <span style="color:red;">*</span>:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="objet_" name="objet_" disabled  />
                  </div>
                  </div>

                  <div class="form-group">

                  <label class="col-sm-4 col-sm-4 control-label" for="motif_">MOTIF :</label>
                  <div class="col-sm-8">         
                     <input type="text" class="form-control" id="motif_" name="motif_" disabled  />
                  </div>
                  
                  </div>

                  <div class="form-group">
                   
                  <label class="col-sm-4 control-label">INTERIMAIRE <span style="color:red;">*</span>:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="interimaire_" name="interimaire_" disabled  />
                  </div>

                </div>

                <div class="form-group">
                  
                  <label class="col-sm-4 col-sm-4 control-label">DATE DE DEPART <span style="color:red;">*</span>: <span style="color:green;">(inclus)</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="datedepart_" name="datedepart_" disabled />
                         
                  </div>

                  </div>

                   <div class="form-group">

                  <label class="col-sm-4 col-sm-4 control-label">RETOUR PREVUE <span style="color:red;">*</span>: <span style="color:green;">(Reprise effective de service)</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="dateretour_" name="dateretour_" disabled />
                          
                  </div>

                  </div>

                  <div class="form-group">

                  <label class="col-sm-4 col-sm-4 control-label">Statut 
                    <span style="color:red;">*</span>:
                  </label>
                  <div class="col-sm-8">
                   <select  class="form-control" name="state_id" id="state_id" required="">
                        <option value=""></option>
                         @if(($agent_function->level==2) )
                        <option value="2">Accorder</option>
                        @endif
                        @if( $agent_function->level==3 )
                        <option value="3">Accepter</option>
                        @endif
                         @if( $agent_function->level==4 )
                        <option value="3">Accepter</option>
                        @endif
                         @if( $agent_function->level==6 )
                        <option value="4">Valider</option>
                        @endif
                        @if(($agent_function->direction_id==4 && $agent_function->level==3 ) )
                        <option value="4">Valider</option>
                        @endif
                        @if(($agent_function->sousdirection_id==12 && $agent_function->isassistant==1 ) )
                        <option value="4">Valider</option>
                        @endif
                        @if(($agent_function->direction_id==4 && $agent_function->level==4 ) )
                        <option value="5">Valider Def.</option>
                        @endif
                        @if(($agent_function->direction_id==4 && $agent_function->sousdirection_id=='' && $agent_function->isassistant==1 ) )
                        <option value="5">Valider Def.</option>
                        @endif
                        <option value="-1">Ajourner</option>
                      </select>
                  </div>

                  </div>
 
                  <div class="form-group">

                  <label class="col-sm-4 col-sm-4 control-label">Commentaire 
                    <span style="color:red;">*</span>:
                  </label>
                  <div class="col-sm-8">
                    <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                  </div>

                  </div>

                </div>
  
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-success" id="ajouter">Ajouter</button>
                </div>
                </form>
                      
                    </div>
                    
                  </div>
                </div>
              </div>
            

    @endsection

     @section('scriptjs')
    
     <script >
      function commentdemande(demande_id,objet_,interimaire_,motif_,datedepart_,dateretour_,level_id)
    {
      
          $("#demande_id").val(demande_id);
          $("#objet_").val(objet_);
          $("#interimaire_").val(interimaire_);
          $("#motif_").val(motif_);
          $("#datedepart_").val(datedepart_);
          $("#dateretour_").val(dateretour_);
          $("#level_id").val(level_id);

    }

    function commentview(id,comment)
    {

          $("#commentaire").val(comment);
          if(id==1){
            $('.u_comment').html("du <span style='text-align:center'><strong> Chef(fe) de service </strong></span>");
          }
          if(id==2){
            $('.u_comment').html("du <span style='text-align:center'><strong> Sous-Direct.(eur/trice) </strong></span>");
          }
          if(id==3){
            $('.u_comment').html("du <span style='text-align:center'><strong> Direct.(eur/trice) </strong></span>");
          }
          if(id==4){
            $('.u_comment').html("du <span style='text-align:center'><strong> Sous-Direteur des RH </strong></span>");
          }
          if(id==5){
            $('.u_comment').html("de la <span style='text-align:center'><strong> DRHAJA </strong></span>");
          }
          if(id==6){
            $('.u_comment').html("de l' <span style='text-align:center'><strong> ADMINISTRATEUR </strong></span>");
          }
          

    }

  function deleteMember(id,opt)
    {
      //alert(id); alert(opt);
      rep = confirm("Voulez-vous Valider cette demande?");
      url = "{{url('/demande/update/state')}}/"+id+"/"+opt;

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


   <script>

     function choice() {
    if ($('input[type=radio][id=objetautre]').is(':checked')) 
            {
                $('#objetautre1').css("display", "block");
            }
            else
            {
                $('#objetautre1').css("display", "none");
            }
    }

    
    function chooseMotif() {
      var selectedMotif = document.getElementById("motif").value;
          //alert(selectedMotif);
          if(selectedMotif=='ABSENCE'){
             $('#absence').css("display", "block");
          }
          else
          {
             $('#absence').css("display", "none");
          }
    }

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

  function getAgent(id)
  {

    //alert(id);
    
    var url = "{{ url('ajax/agent/show/') }}/"+id;
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
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


  function getInterimaire(id)
  {

    //alert(id);
    
    var url = "{{ url('ajax/interimaire/show') }}/"+id;
     $.ajax(
     {
      type: "get",
      url: url,
      success: function(data)
      {
          $('select#interim').html(data.html_first);   
      }
    }
);
  }

   $("#dateretour,#datedepart").change(function(){
        var dateretour = $("#dateretour").val();
        var datedepart = $("#datedepart").val();
        var start = moment(dateretour, "YYYY-MM-DD");
        var end = moment(datedepart, "YYYY-MM-DD");
        var nbrejourouvrable = moment.duration(start.diff(end)).asDays();
        var nbrejour;
        
        if(isNaN(nbrejourouvrable)){ nbrejourouvrable= ""}
        // console.log(nbrejourouvrable);
        $("#nbrejourouvrable").val(nbrejourouvrable);
    });

   function validateDateDepart(depart){
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      var yyyy = today.getFullYear();
      today = yyyy + '-' + mm + '-' + dd;
      retour =  $("#dateretour").val();
      // console.log(retour);
      

      if(retour){


        if (depart >= retour || depart <= today) { 
                                $('#ajouter').attr('disabled','true');
                                $("#err_datedepart").css("display","block");
                              }else{

                                $("#err_datedepart").css("display","none");
                                  $('#dateretour').removeAttr('disabled');
                                  $('#ajouter').removeAttr('disabled');

                              }



               }
      else{

        if (depart <= today) {

                           $("#err_datedepart").css("display","block");
                           $('#dateretour').attr('disabled','true');
                           $('#ajouter').attr('disabled','true');

                            }else{

                                  $("#err_datedepart").css("display","none");
                                  $('#dateretour').removeAttr('disabled');
                                  $('#ajouter').removeAttr('disabled');

                                 }

            }


      }

  function validateDateRetour(retour){
         depart =  $("#datedepart").val();
        //console.log(depart);
      
      if (retour <= depart) {
            $("#err_dateretour").css("display","block");
            $('#ajouter').attr('disabled','true');

         }
      else{
            $("#err_dateretour").css("display","none");
            $("#err_datedepart").css("display","none");
            $('#ajouter').removeAttr('disabled');

           }

      }


  </script>
     
    @endsection



