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
@endphp

@section('stylesheet')


    

@endsection

@section('content')

<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Documents</h3>
         
        <!-- row -->
        <div class="row mt">
          <div class="col-md-12">
            <div class="content-panel">
              <table class="table table-striped table-advance table-hover">
                 <div class="position-relative" align="right" style="padding-right:5px">
                   
                      <button class="btn btn-success"  data-toggle="modal" data-target="#myModal">
                            Ajouter
                      </button>

                </div>
               
                <hr>
                <thead>
                  <tr>
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
                    <td> {{$agent->fname}} {{$agent->lname}}</td>
                    <td>{{$agent->matricul}}</td>
                    <td> @if($agent->grade_id)
                        {{ getInstanceName('grade','id',$agent->grade_id,'name') }}
                        @endif
                         </td>
                    <td> @if($agent->direction_id)
                        {{ getInstanceName('direction','id',$agent->direction_id,'designation') }}
                        @endif </td>
                    <td> @if($agent->sousdirection_id)
                        {{ getInstanceName('sousdirection','id',$agent->sousdirection_id,'designation') }}
                        @endif</td>
                    <td> @if($agent->service_id)
                        {{ getInstanceName('service','id',$agent->service_id,'designation') }}
                        @endif</td>
                    <td width=12%>
                      <div class="btn-group">
                          <button type="button" class="btn btn-theme03">Action</button>
                          <button type="button" class="btn btn-theme03 dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Détail</a></li>
                            <li><a href="{{route('filiation.list')}}">Filiation</a></li>
                            <li><a href="{{route('filiation.list')}}">Documents</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Supprimer</a></li>
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

      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                      Hi there, I am a Modal Example for Dashio Admin Panel.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </div>
         </div>

            <!-- With scrollbars inside -->
            <div class="modal fade" id="modalWithScroll2" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable modal-lg col-md-6" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title text-orange-d2">
                      Nouvel Agent
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">

                  <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('add.agent') }}">
                             {{ csrf_field() }} 

                  <div class="modal-body ace-scrollbar">

                    <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-1 col-form-label text-sm-right pr-0">
                      <label  class="mb-0">
                        Nom :
                      </label>
                    </div>

                    <div class="col-sm-3 input-floating-label text-blue-d2 brc-blue-m1">
                      <input type="text" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="nom" required=""/>
                      <span class="floating-label text-grey-m3">
                        Nom
                    </span>
                    </div>

                    <div class="mb-1 mb-sm-0 col-sm-1 col-form-label text-sm-right pr-0">
                      <label  class="mb-0">
                        Prénom :
                      </label>
                    </div>

                    <div class="col-sm-5 input-floating-label text-blue-d2 brc-blue-m1">
                      <input type="text" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="prenom" required=""/>
                      <span class="floating-label text-grey-m3">
                        Prénom
                    </span>
                    </div>

                  </div>
<br>
                  <div class="form-group row">

                    <div class="mb-1 mb-sm-0 col-sm-1 col-form-label text-sm-right pr-0">
                      <label  class="mb-0">
                        Matricule :
                      </label>
                    </div>

                     <div class="col-sm-3 input-floating-label text-blue-d2 brc-blue-m1">
                      <input type="text" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="matricule" />
                      <span class="floating-label text-grey-m3">
                        Matricule
                    </span>
                    </div>

                     <div class="mb-1 mb-sm-0 col-sm-1 col-form-label text-sm-right pr-0">
                      <label  class="mb-0">
                        Email :
                      </label>
                    </div>

                     <div class="col-sm-3 input-floating-label text-blue-d2 brc-blue-m1">
                      <input type="email" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="email"/>
                      <span class="floating-label text-grey-m3">
                        Email
                    </span>
                    </div>

                    <div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0">
                      <label  class="mb-0">
                        Date de début :
                      </label>
                    </div>

                     <div class="col-sm-2 input-floating-label text-blue-d2 brc-blue-m1">
                       <input type="date" class="form-control" id="datedebut" name="datedebut" placeholder="" required>
                      
                    </div>

                  </div>

   

                  <div class="form-group row">

                     <div class="col-sm-2 input-floating-label text-blue-d2 brc-blue-m1">
                      <select class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="sexe" required="">
                        <option value="">Sexe</option>
                        <option value="1">Masculin</option>
                         <option value="2">Feminin</option>
                      </select>
                    </div>
                   

                    <div class="col-sm-4 input-floating-label text-blue-d2 brc-blue-m1">
                      <select class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="usertype" required="">
                        <option value="">Type utilisateur</option>
                        <option value="1">Administrateur</option>
                         <option value="2">Utilisateur</option>
                      </select>
                    </div>


                    <div class="col-sm-2 input-floating-label text-blue-d2 brc-blue-m1"  id="divPlateforme">
                      <select class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="contrat" required="" onchange="displaydatefin(this.value)">
                        <option value="">Contrat</option>
                        <option value="1">FONCTIONNAIRE</option>
                        <option value="2">CDI</option>
                        <option value="3">CDD</option>
                      </select>
                    </div>


                    <div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0" style="display: none;" id="divlabelfin">
                      <label  class="mb-0">
                        Date de fin :
                      </label>
                    </div>

                     <div class="col-sm-2 input-floating-label text-blue-d2 brc-blue-m1" style="display: none;" id="divinputfin">
                       <input type="date" class="form-control" id="datedefin" name="datedefin">
                    </div>

                  </div>

                  <div class="form-group row">

                     <div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1">
                      <select  class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="level" required="" >
                        <option value="">Function</option>
                        @foreach($grades as $grade)
                         <option value="{{$grade->id}}">{{$grade->name}}</option>
                         @endforeach
                      </select>
                    </div>

                     <div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1">
                     <select onchange="getSousdirection(this.value)" class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="direction" required="">
                        <option value="">DIRECTION / ADMINISTRATION</option>
                        @foreach($directions as $direction)
                        <option value="{{ $direction->id }}">
                          {{ $direction->designation }}
                        </option>
                        @endforeach
                      </select>
                  </div>

                  </div>


                  <div class="form-group row">
                   
                    <div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1">
                       <select onchange="getService(this.value)" class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="sousdirection" id="sousdirection">
                        <option value=""> SOUS-DRECTION / AGENCE</option>
                        
                      </select>
                    </div>
                 
                    <div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1">
                      <select class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="service" id="service">
                        <option value="">SERVICE / GUICHET</option>
                        <!-- @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->designation }}</option>
                        @endforeach -->
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



    @endsection

     @section('scriptjs')
    
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
          $('select#sousdirection').html(data.html_first);        
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
      }
    }
);
  }


   function displaydatefin(id)
  {
       if (id == 3) {
              $("#divlabelfin").css("display","block");
              $("#divinputfin").css("display","block");
            }else {
              $("#divlabelfin").css("display","none");
              $("#divinputfin").css("display","none");
                  }
  }

  </script>

    @endsection



