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
              <h4 class="mb"> Nouveaux Document de {{$agent->nomprenoms}} ( {{$agent->fonction}} )</h4>
              <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" enctype="multipart/form-data" action="{{ route('add.document') }}">
                             {{ csrf_field() }} 
                    <input type="hidden" class="form-control" name="user_id" value="{{ $agent->id }}" />
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label"> Type de Document:</label>
                  <div class="col-sm-3">
                    <select onchange="displayacte(this.value)" class="form-control" name="file_type" required="">
                        <option value="1">Document à l’embauche</option>
                        <option value="8">Fiche de poste</option>
                        <option value="2">Document de relation de travail</option>
                        <option value="3">Document de santé</option>
                        <option value="4">Document de formation</option>
                        <option value="5">Document de banque</option>
                        <option value="7">Document de sanction disciplinaire</option>
                        <option value="6">Autres</option>
                    </select>
                  </div>
                </div>
<div style="display: none;" id="document_autre">
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Nom du document:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="file_name"/>
                  </div>

                </div>

                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Document:</label>
                  <div class="col-sm-4">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="doc">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                    </div>
                  </div>

                </div>
</div>
<div style="display: block;" id="document_embauche">
  
                <div class="form-group" >
                  <label class="col-sm-2 col-sm-2 control-label">Contrat de travail:</label>
                  <div class="col-sm-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner contrat</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="contrat_travail">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                    </div>
                  </div>
                </div>

                <div class="form-group" >
                  <label class="col-sm-2 col-sm-2 control-label">Prise de service:</label>
                  <div class="col-sm-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner certificat</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="prise_service">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                    </div>
                  </div>
                </div>

                <div class="form-group" >
                  <label class="col-sm-2 col-sm-2 control-label">Note de service:</label>
                  <div class="col-sm-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner note de service</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="note_service">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                    </div>
                  </div>
                </div>
<hr>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Curiculum vitae:</label>
                  <div class="col-sm-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner cv</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="cv">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Dernier diplôme:</label>
                  <div class="col-sm-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner le diplôme</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="diplome">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                    </div>
                  </div>
                </div>
<hr>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Photo d'Identité:</label>
                  <div class="col-sm-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner la photo</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="photo">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Carte d'Identité:</label>
                  <div class="col-sm-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner CNI</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="cni">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Passeport:</label>
                  <div class="col-sm-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner passeport</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="passeport">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Extrait de naissance:</label>
                  <div class="col-sm-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner l'extrait</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="extrait_naissance">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Certificat de nationalité:</label>
                  <div class="col-sm-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner le certificat</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="certif_nationalite">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Casier judiciaire:</label>
                  <div class="col-sm-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <span class="btn btn-success btn-file">
                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selectionner le casier</span>
                      <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                      <input type="file" class="default" name="casier_judiciaire">
                      </span>
                      <span class="fileupload-preview" style="margin-left:5px;"></span>
                    </div>
                  </div>
                </div>
           </div> 

            <div class="modal-footer">
              <!-- <button type="button" class="btn btn-warning" data-dismiss="modal">
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
       if (id == 1) {
              $("#document_embauche").css("display","block");
               $("#document_autre").css("display","none");
              
          }else{
             $("#document_embauche").css("display","none");
             $("#document_autre").css("display","block");
          }

  }

  </script>

    @endsection