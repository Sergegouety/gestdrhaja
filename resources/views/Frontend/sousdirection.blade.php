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
$sm="sousdirection";
@endphp

@section('content')
   <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Sous-Directions</h3>
         
        <!-- row -->
        <div class="row mt">
          <div class="col-md-12">
            <div class="content-panel">
              <table class="table table-striped table-advance table-hover">
                <h4><i class="fa fa-angle-right"></i> Sous-Directions</h4>
                 <a data-toggle="modal" data-target="#sd_modal" class="btn btn-warning" style="float:right;">
                  <i class="fa fa-plus"></i> Nouvelle Sous-Direction
                 </a>
                <hr>
                <thead>
                  <tr>
                    <th></th>
                    <th><i class="fa fa-bullhorn"></i>  Sous-Direction</th>
                    <th class="hidden-phone"><i class="fa fa-question-circle"></i> Direction</th>
                    <th><i class="fa fa-bookmark"></i> Responsable</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                 @foreach($sousdirections as $sousdirection)
                  <tr>
                    <td>
                     
                    </td>
                    <td>
                      <a >{{$sousdirection->designation}}</a>
                    </td>
                    <td class="hidden-phone">
                       @if($sousdirection->direction_id)
                        {{ getInstanceName('direction','id',$sousdirection->direction_id,'designation') }}
                        @endif
                    </td>
                    <td> {{ getResponsableName('sousdirection_id',$sousdirection->id,4) }} </td>
                    
                    <td>
                     <div class="btn-group">
                      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-th"></i>
                        <span class="caret"></span>
                      </button>
                  <ul class="dropdown-menu">
                    <li><a data-toggle="modal" data-target="#sd_edit_modal" onclick="editModal({{$sousdirection->id}})" >Modifier</a></li>
                    <!-- <li><a onclick="" href="#">Désactiver</a></li> -->
                    <li class="divider"></li>
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

        <div class="modal fade" id="sd_modal" tabindex="-1" role="dialog" aria-labelledby="mySd_modal" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Nouveau Sous-Direction / Agence </h4>
                    </div>
                    <div class="modal-body">
                      <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('add.sousdirection') }}" enctype="multipart/form-data">
                              {{ csrf_field() }}
                        <div class="modal-body ace-scrollbar">

                  <div class="form-group">
                  <label class="col-sm-4 col-sm-4 control-label">Direction / Bureau 
                    <span style="color:red;">*</span>:
                  </label>
                  <div class="col-sm-8">
                   <select  class="form-control" name="direction" id="direction" required="">
                        <option value=""></option>
                        @foreach($directions as $direction)
                        <option value="{{$direction->id}}">{{$direction->designation}}</option>
                        @endforeach
                      </select>
                  </div>

                  </div>

                  <div class="form-group">
                    <label class="col-sm-4 control-label">
                     Sous-Direction / Agence <span style="color:red;">*</span>:
                    </label>
                  <div class="col-sm-8">
                    <input type="text" name="sousdirection" class="form-control" required>
                  </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">
                     Est une Agence ? <span style="color:red;">*</span>:
                    </label>
                  <div class="col-sm-8">
                    <input type="checkbox" name="is_agence">
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


               <div class="modal fade" id="sd_edit_modal" tabindex="-1" role="dialog" aria-labelledby="myEditService_modal" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Modifier Sous-Direction / Agence </h4>
                    </div>
                    <div class="modal-body">
                      <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('edit.sousdirection') }}" enctype="multipart/form-data">
                              {{ csrf_field() }}

                              <input type="hidden" name="sousdirection_id" id="sousdirection_id">
                        <div class="modal-body ace-scrollbar">

                  <div class="form-group">
                  <label class="col-sm-4 col-sm-4 control-label">Direction / Bureau 
                    <span style="color:red;">*</span>:
                  </label>
                  <div class="col-sm-8">
                   <select  class="form-control" name="direction" id="direction" required="">
                        <option value=""></option>
                        @foreach($directions as $direction)
                        <option value="{{$direction->id}}">{{$direction->designation}}</option>
                        @endforeach
                      </select>
                  </div>

                  </div>


                  <div class="form-group">
                    <label class="col-sm-4 control-label">
                     Sous-Direction / Agence <span style="color:red;">*</span>:
                    </label>
                  <div class="col-sm-8">
                    <input type="text" name="sousdirection" id="sousdirection" class="form-control" required>
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

    function editModal(id)
    {

      //alert(id);
      $('#sousdirection_id').val(id);
      var url = "{{ url('ajax/getSdById') }}/"+id;
       $.ajax(
       {
        type: "get",
        url: url,
        success: function(data)
        {
            $('select#direction').val(data.direction);  
            $('#sousdirection').val(data.designation);      
        }
      }
  );
    }

 </script>
@endsection