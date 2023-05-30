@extends('Templates.form_master')

@section('titre')
    Noouveau Agent
@endsection

@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="evaluation";
$sm="ptab";
@endphp

@section('content')
<section class="wrapper">
       <!--  <h3><i class="fa fa-angle-right"></i> Form Components</h3> -->
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt">
          <div class="col-lg-12">
            <div class="form-panel">
              <h4 class="mb"> Importer PTAB</h4>

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

              <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('ptab.import_in') }}" enctype="multipart/form-data">
                             {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{Auth::id()}}" />

                <div class="modal-body ace-scrollbar">

                  <div class="form-group">
                    <label class="col-sm-3 control-label">
                     AXE STRATEGIQUE <span style="color:red;">*</span>:
                    </label>
                  <div class="col-sm-3">
                    <select class="form-control" name="axe" id="axe" required="">
                         <option value="1">
                          Effet 1 : La qualité et l’efficacité des services rendus aux demandeurs d’emploi et aux entreprises se sont améliorées
                         </option>
                          

                    </select>
                  </div>

                  <label class="col-sm-3 control-label">EXTRANT <span style="color:red;">*</span>:
                  </label>
                  <div class="col-sm-3">
                    <select class="js-example-basic-single form-control" name="extrant" id="extrant" required="">
                          <option value="1">Extrant 1.4 : Les programmes (offres de services) de l’Agence Emploi Jeunes répondent suffisamment aux attentes des demandeurs d'emploi </option>
                    </select>
                  </div>

                </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">
                      DIRECTION / BUREAU <span style="color:red;">*</span>:
                    </label>
                  <div class="col-sm-3">
                    <select class="form-control" onchange="getSousdirection(this.value)" name="direction" id="direction" required="">
                         <option value=""></option>
                           @foreach($directions as $direction)
                         <option value="{{ $direction->id }}">
                          {{ $direction->designation }}
                          </option>
                          @endforeach
                    </select>
                  </div>

                  <label class="col-sm-3 control-label">SOUS-DIRECTION / AGENCE:
                  </label>
                  <div class="col-sm-3">
                    <select class="js-example-basic-single form-control" name="sousdirection" id="sousdirection">
                          <option value=""></option>
                    </select>
                  </div>

                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                     PTAB <span style="color:red;">*</span>:
                    </label>
                  <div class="col-sm-3">
                    <input type="file" name="ptab_file" class="form-control" required>
                  </div>


                </div>



                  </div>


                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">
                      retour
                    </button> -->

                    <button type="submit" class="btn btn-primary">
                      Importer
                    </button>
                  </div>
                 </form>
            </div>
          </div>
          <!-- col-lg-12-->
        </div>
       
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
@endsection