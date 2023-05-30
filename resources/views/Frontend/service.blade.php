@extends('Templates.list_master')

@section('titre')
    Direction List - Aej Admin
@endsection

@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="parametre";
$sm="service";
@endphp

@section('content')
   <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Services</h3>

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
                <h4><i class="fa fa-angle-right"></i> Services</h4>
                 <a data-toggle="modal" data-target="#service_modal" class="btn btn-warning" style="float:right;">
                  <i class="fa fa-plus"></i> Nouveau service
                 </a>
                <hr>
                <thead>
                  <tr>
                    <th></th>
                     <th><i class="fa fa-bullhorn"></i>  Service</th>
                    <th><i class="fa fa-bullhorn"></i>  Sous-Direction</th>
                    <th class="hidden-phone"><i class="fa fa-question-circle"></i> Direction</th>
                    <th><i class="fa fa-bookmark"></i> Responsable</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($services as $service)
                  <tr>
                    <td></td>
                    <td>
                        <span class="text-105">
                           {{$service->designation}}
                        </span>
                    </td>

                    <td>
                      @if($service->sousdirection_id)
                        {{ getInstanceName('sousdirection','id',$service->sousdirection_id,'designation') }}
                        @endif
                    </td>

                    <td class="hidden-phone">
                       @if($service->direction_id)
                        {{ getInstanceName('direction','id',$service->direction_id,'designation') }}
                        @endif
                    </td>

                    <td> {{ getResponsableName('service_id',$service->id,2) }} </td>
                    
                    <td>
                      <div class="btn-group">
                      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-th"></i>
                        <span class="caret"></span>
                      </button>
                  <ul class="dropdown-menu">
                    <li><a data-toggle="modal" data-target="#service_edit_modal" onclick="editModal({{$service->id}})" >Modifier</a></li>
                    <!-- <li><a onclick="" href="#">Désactiver</a></li> -->
                    <li class="divider"></li>
                  </ul>
                </div>
                    <!--   <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                      <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button> -->
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

        <div class="modal fade" id="service_modal" tabindex="-1" role="dialog" aria-labelledby="myService_modal" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Nouveau Service / Guichet </h4>
                    </div>
                    <div class="modal-body">
                      <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('add.service') }}" enctype="multipart/form-data">
                              {{ csrf_field() }}
                        <div class="modal-body ace-scrollbar">

                  <div class="form-group">
                  <label class="col-sm-4 col-sm-4 control-label">Direction / Bureau 
                    <span style="color:red;">*</span>:
                  </label>
                  <div class="col-sm-8">
                   <select  class="form-control" name="direction" id="direction" onchange="getSousdirection(this.value)" required="">
                        <option value=""></option>
                        @foreach($directions as $direction)
                        <option value="{{$direction->id}}">{{$direction->designation}}</option>
                        @endforeach
                      </select>
                  </div>

                  </div>

                  <div class="form-group">
                  <label class="col-sm-4 col-sm-4 control-label">Sous-direction / Agences 
                    <span style="color:red;">*</span>:
                  </label>
                  <div class="col-sm-8">
                   <select  class="form-control" name="sousdirection" id="sousdirection" required="">
                        <option value=""></option>
                        
                      </select>
                  </div>

                  </div>

                  <div class="form-group">
                    <label class="col-sm-4 control-label">
                     Nom du service / Guichet <span style="color:red;">*</span>:
                    </label>
                  <div class="col-sm-8">
                    <input type="text" name="service" class="form-control" required>
                  </div>
                </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">fermer</button>
                        <button class="btn btn-success" id="ajouter">Ajouter</button>
                      </div>

                    </form>
                      
                    </div>
                    
                  </div>
                </div>
              </div>

              <div class="modal fade" id="service_edit_modal" tabindex="-1" role="dialog" aria-labelledby="myEditService_modal" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Modifier Service / Guichet </h4>
                    </div>
                    <div class="modal-body">
                      <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('edit.service') }}" enctype="multipart/form-data">
                              {{ csrf_field() }}

                              <input type="hidden" name="service_id" id="service_id">
                        <div class="modal-body ace-scrollbar">

                  <div class="form-group">
                  <label class="col-sm-4 col-sm-4 control-label">Direction / Bureau 
                    <span style="color:red;">*</span>:
                  </label>
                  <div class="col-sm-8">
                   <select  class="form-control" name="direction" id="direction" onchange="getSousdirection(this.value)" required="">
                        <option value=""></option>
                        @foreach($directions as $direction)
                        <option value="{{$direction->id}}">{{$direction->designation}}</option>
                        @endforeach
                      </select>
                  </div>

                  </div>

                  <div class="form-group">
                  <label class="col-sm-4 col-sm-4 control-label">Sous-direction / Agences 
                    <span style="color:red;">*</span>:
                  </label>
                  <div class="col-sm-8">
                   <select  class="form-control" name="sousdirection" id="sousdirection" required="">
                        <option value=""></option>
                        @foreach($sousdirections as $sousdirection)
                        <option value="{{$sousdirection->id}}">{{$sousdirection->designation}}</option>
                        @endforeach
                      </select>
                  </div>

                  </div>

                  <div class="form-group">
                    <label class="col-sm-4 control-label">
                     Nom du service / Guichet <span style="color:red;">*</span>:
                    </label>
                  <div class="col-sm-8">
                    <input type="text" name="service" id="service" class="form-control" required>
                  </div>
                </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">fermer</button>
                        <button class="btn btn-success" id="ajouter">Modifier</button>
                      </div>

                    </form>
                      
                    </div>
                    
                  </div>
                </div>
              </div>


      </section>
@endsection
@section('scriptjs')
 <script >

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
            //$('select#agent').html(data.html_two);       
        }
      }
  );
    }

    function editModal(id)
    {

      //alert(id);
      $('#service_id').val(id);
      var url = "{{ url('ajax/getServiceById') }}/"+id;
       $.ajax(
       {
        type: "get",
        url: url,
        success: function(data)
        {
            $('select#direction').val(data.direction);  
            $('select#sousdirection').val(data.sousdirection); 
            $('#service').val(data.designation);      
        }
      }
  );
    }

 </script>
@endsection