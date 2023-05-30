@extends('Templates.form_master')

@section('titre')
    ptab reglage
@endsection


@php
use Carbon\Carbon;

$current = Carbon::now();
$active="active";
$open="open";
$show="show";
$d="#";
$page="evaluation";
$sm="reglage";


@endphp

@section('stylesheet')

@endsection

@section('content')

<section class="wrapper">
       <!--  <h3><i class="fa fa-angle-right"></i> Form Components</h3> -->
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt">
          <div class="col-lg-12">
            <div class="form-panel">
              <h4 class="mb">Paramètres </h4>
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
              <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('update.periode') }}">
                             {{ csrf_field() }} 
                  <div class="modal-body ace-scrollbar">
                  <input type="hidden"  name="periode_id" value="{{$periode->id}}">
                   <div class="form-group row" >
                    <label class="col-sm-2 col-sm-2 control-label">Date début</label>
                    <div class="col-sm-4">
                     <input class="form-control" type="date" name="datedebut" value="{{format_date2($periode->date_debut)}}" required>
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label">Date de fin</label>
                    <div class="col-sm-4">
                     <input class="form-control" type="date" name="datedefin" value="{{format_date2($periode->date_fin)}}" required>
                    </div>
                  </div>
                  <br>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">
                     Collecte <span style="color:red;">*</span>:
                    </label>
                  <div class="col-sm-4">
                    <select class="form-control"  name="grade" id="grade" required>
                         <option value=""></option>
                         <option value="1" <?php if($periode->grade == 1){echo 'selected';} ?> >Tâche</option>
                         <option value="2" <?php if($periode->grade == 2){echo 'selected';} ?>>Activités</option>
                         <option value="3" <?php if($periode->grade == 3){echo 'selected';} ?>>Action</option>
                         <option value="4" <?php if($periode->grade == 4){echo 'selected';} ?>>Extrant</option>
                         <option value="5" <?php if($periode->grade == 5){echo 'selected';} ?>>Axe Stratégique</option>
                          
                    </select>
                  </div>

                <label class="col-sm-2 col-sm-2 control-label" for="objetabsence">Observation :</label>
                    <div class="col-sm-4">
                    <textarea class="form-control" name="observation">{{$periode->periode}}</textarea>
                  </div>

                </div>
              
<br>
               <div class="form-group">
                    <label class="col-sm-2 control-label">
                      Période <span style="color:red;">*</span>:
                    </label>
                  <div class="col-sm-4">
                    <select class="form-control"  name="trimestre" id="trimestre" required>
                         <option value=""></option>
                         <option value="1" <?php if($periode->trimestre == 1){echo 'selected';} ?>>1er Trimestre</option>
                         <option value="2" <?php if($periode->trimestre == 2){echo 'selected';} ?>>2ème Trimestre</option>
                         <option value="3" <?php if($periode->trimestre == 3){echo 'selected';} ?>>3ème Trimestre</option>
                          <option value="4" <?php if($periode->trimestre == 4){echo 'selected';} ?>>4ème Trimestre</option>
                    </select>
                  </div>

               </div>
                

                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-warning" data-dismiss="modal">
                      Fermer
                    </button> -->

                    <button type="submit" class="btn btn-success" id="Modifier">
                      Modifier
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
  justif=$("#justif").val();
  if(justif==2){ $("#justif").css("display","block");}else{$("#justif").css("display","none");}

   function displayJustification(id)
  {

       if (id == 2) {
              $("#justif").css("display","block");
            }else {
                  $("#justif").css("display","none");
                  }

  }
</script>

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



