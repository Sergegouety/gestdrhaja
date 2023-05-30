@extends('Templates.form_master')

@section('titre')
    Noouveau Agent
@endsection

@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="parametre";
$sm="agent";
@endphp

@section('content')
<section class="wrapper">
       <!--  <h3><i class="fa fa-angle-right"></i> Form Components</h3> -->
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt">
          <div class="col-lg-12">
            <div class="form-panel">
              <h4 class="mb"> Nouvelle filiation de {{$agent->nomprenoms}} ( {{$agent->fonction}} ) </h4>
              <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" enctype="multipart/form-data" action="{{ route('add.filiation') }}">
                             {{ csrf_field() }} 
                  <input type="hidden" class="form-control" name="user_id" value="{{ $agent->id }}" />
                <div class="form-group">
                  <label class="col-sm-1 col-sm-2 control-label">Nom :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="nom" required=""/>
                  </div>
                 
                  <label class="col-sm-1 col-sm-2 control-label">Prénom :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="prenom" required=""/>
                  </div>
                </div>
<br>
                <div class="form-group">

                  <label class="col-sm-2 col-sm-2 control-label">Date de naissance:</label>
                  <div class="col-sm-2">
                    <input type="date" class="form-control" id="naissance" name="naissance" required=""/>
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label"> Tel 1:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="tel1" />
                  </div>

                  <label class="col-sm-1 col-sm-2 control-label"> Tel 2:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="tel2" />
                  </div>

                </div>
<br>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label"> Type de filiation:</label>
                  <div class="col-sm-2">
                    <select onchange="displayacte(this.value)" class="form-control" name="filiation" required="">
                        <option value="1">Pére</option>
                        <option value="2">Mère</option>
                        <option value="3">Conjoint</option>
                        <option value="4">Enfant</option>
                    </select>
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label">Type de Pièce:</label>
                  <div class="col-sm-2">
                    <select class="form-control" name="piece" >
                        <option value="1">CNI</option>
                        <option value="2">Passeport</option>
                        <option value="3">Permis de conduire</option>
                        <option value="4">Attestation d'identité</option>
                      </select>
                  </div>

                  <label class="col-sm-1 col-sm-2 control-label"> N°:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="numero"/>
                  </div>
                 
                </div>
<br>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Pièce d'identité:</label>
                  <div class="col-sm-4">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner pièce</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="cni">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                      <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                    </div>
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label">Photo:</label>
                  <div class="col-sm-4">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner photo</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="photo">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                      <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                      
                    </div>
                  </div>
                </div>

                <div class="form-group" style="display: none;" id="acte_mariage">
                  <label class="col-sm-2 col-sm-2 control-label">Acte de mariage:</label>
                  <div class="col-sm-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner l'acte de mariage</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="acte_mariage">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                      <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                    </div>
                  </div>
                </div>

                <div class="form-group" style="display: none;" id="acte_naissance">
                  <label class="col-sm-2 col-sm-2 control-label">Acte de Naissance:</label>
                  <div class="col-sm-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner l'acte de naissance</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="acte_naissance">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                      <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                    </div>
                  </div>
                </div>

                  <div class="modal-footer">
                   <!--  <button type="button" class="btn btn-warning" data-dismiss="modal">
                      Fermer
                    </button> -->

                    <button type="submit" class="btn btn-success">
                      Ajouter
                    </button>
                  </div>
               
            </div>
          </div>
          <!-- col-lg-12-->
        </div>
       
      </section>

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


   function displayacte(id)
  {
       if (id == 3) {
              $("#acte_mariage").css("display","block");
              $("#acte_naissance").css("display","none");
            }else if (id == 4) {
              $("#acte_mariage").css("display","none");
              $("#acte_naissance").css("display","block");
          }else{
             $("#acte_mariage").css("display","none");
             $("#acte_naissance").css("display","none");
          }

  }

  </script>

    @endsection