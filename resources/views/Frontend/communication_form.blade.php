@extends('Templates.form_master')

@section('titre')
    Noouvelle Communication
@endsection

@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="communication";
$sm="com";
@endphp
@section('stylesheet')
<link href="{{asset('lib/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}" rel="stylesheet" />
@endsection
@section('content')
<section class="wrapper">
       <!--  <h3><i class="fa fa-angle-right"></i> Form Components</h3> -->
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt">
          <div class="col-lg-12">
            <div class="form-panel">
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
              <h4 class="mb"> Nouvel Article</h4>
              <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" enctype="multipart/form-data" action="{{ route('add.article') }}">
                             {{ csrf_field() }} 
                <input type="hidden" value="{{Auth::id()}}" class="form-control" name="user_id"/>
               
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label"> <h4>Auteur <span style="color:red">*</span>:</h4></label>
                  <div class="col-sm-3">
                    <select class="form-control" name="article_type" required onchange="displayType(this.value)">
                        <option value=""></option>
                      @if(Session::get('function_key')->isredact==10 || Session::get('function_key')->isredact==1)
                          <option value="1">Ressources Humaines</option>
                      @endif
                      @if(Session::get('function_key')->isredact==10 || Session::get('function_key')->isredact==2)
                          <option value="2">Newsletter</option>
                      @endif
                      @if(Session::get('function_key')->isredact==10 || Session::get('function_key')->isredact==3)
                          <option value="3">Mutuelle</option>
                      @endif
                         <option value="4">Agent</option>
                    </select>
                  </div>

                  <label class="col-sm-1 col-sm-1 control-label" id="type_label" style="display:none"> <h4>Type:</h4></label>
                  <div class="col-sm-2" id="type_div" style="display:none">
                    <select class="form-control" id="type_event" name="type_event" required>
                          <option value="2">Mariage</option>
                          <option value="3">Naissance</option>
                          <option value="4">Décès</option>
                    </select>
                  </div>
                </div>
                <br>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label"><h4>Titre <span style="color:red">*</span> :</h4></label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" name="titre" required=""/>
                  </div>
                </div>
                  
               <!--  <div class="form-group">
                  <label class="col-sm-2 control-label"><h4>Resumé :</h4></label>
                  <div class="col-sm-7">
                    <textarea class="form-control" name="resume"></textarea>
                  </div>
              </div> -->
              <br>
              <div class="form-group">
                  <label class="col-sm-2 control-label"><h4>Contenu <span style="color:red">*</span> :</h4></label>
                  <div class="compose-editor col-sm-5">
                   <textarea class="wysihtml5 form-control" name="contenu" rows="9" required></textarea>
                  </div>
            </div>

<br>
                <div class="form-group">
                  <label class="col-sm-3 col-sm-3 control-label">Image Principale (png,jpg,jpeg):</label>
                  <div class="col-sm-3">
                     @php
                     $image=asset('img/non_disponible.jpg') ;
                     @endphp
                    <div class="col float-md-left">
                        <div class="thumbnail" type="file">
                            <img src="{{$image}}" id="image_id1" height="150" width="135" onclick="chooseFile();">
                        </div>
                        <div class="choose_file">
                            <span>Choisir une photo</span>
                            <input name="image1" id="image1" type="file" accept="image/*" />
                        </div>
                    </div>
                  </div>

                  <!-- <label class="col-sm-2 col-sm-2 control-label">Image 2 (png,jpg,jpeg):</label>
                  <div class="col-sm-3">
                    @php
                       $image=asset('img/non_disponible.jpg') ;
                     @endphp
                    <div class="col float-md-left">
                        <div class="thumbnail" type="file">
                            <img src="{{$image}}" id="image_id2" height="150" width="135" onclick="chooseFile2();">
                        </div>
                        <div class="choose_file">
                            <span>Choisir une photo</span>
                            <input name="image2" id="image2" type="file" accept="image/*" />
                        </div>
                    </div>
                   
                  </div> -->

                </div>
                <br/>

                  <div class="form-group">
                  <label class="col-sm-3 col-sm-3 control-label">Joindre fichier (pdf): </label>
                  <div class="col-sm-4">
                     @php
                      $image=asset('img/non_disponible.jpg') ;
                     @endphp
                    <div class="col float-md-left">
                        <div class="thumbnail" type="file">
                            <embed onclick="chooseFile3();" id="image_id3" src="" type='application/pdf'  />
                        </div>
                        <div class="choose_file">
                            <span>Choisir un fichier</span>
                            <input name="image3" id="image3" type="file" accept="pdf" />
                        </div>
                    </div>
                     
                  </div>

                </div>

                  <div class="modal-footer">
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

  <script type="text/javascript" src="{{asset('lib/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}"></script>
  <script type="text/javascript" src="{{asset('lib/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}"></script>
  <script type="text/javascript">
    //wysihtml5 start
    $('.wysihtml5').wysihtml5();

    //wysihtml5 end
  </script>
    
<script>
//



 function displayType(id)
  {


    if (id == 1) {
              $("#type_event").append('<option value="1">Retraite</option><option value="5">Promotion</option><option value="6">Démission</option><option value="7">Licensement</option><option value="8">Fin de contrat</option><option value="9">Note d\'information</option><option value="10">Recrutement</option><option value="11">Mise à disposition</option><option value="12">Mise à disponibilité</option><option value="13">Congé maladie (longue durée)</option>');
              $("#type_label").css("display","block");
              $("#type_div").css("display","block");
              
          }else {
             $("#type_label").css("display","block");
              $("#type_div").css("display","block");
              $('#type_event option[value="1"]').remove();
              $('#type_event option[value="5"]').remove();
              $('#type_event option[value="6"]').remove();
              $('#type_event option[value="7"]').remove();
              $('#type_event option[value="8"]').remove();
              $('#type_event option[value="9"]').remove();
              $('#type_event option[value="10"]').remove();
              $('#type_event option[value="11"]').remove();
              $('#type_event option[value="12"]').remove();
              $('#type_event option[value="13"]').remove();
          }
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

  <script>
        function chooseFile() {
            $("#image1").click();
        }

        function chooseFile2() {
            $("#image2").click();
        }

        function chooseFile3() {
            $("#image3").click();
        }
 </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image_id1').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image1").change(function(){
            readURL(this);
        });
    </script>

     <script>
        
     function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image_id2').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

         $("#image2").change(function(){
            readURL2(this);
        });
    </script>

    <script>
        
     function readURL3(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image_id3').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

         $("#image3").change(function(){
            readURL3(this);
        });
    </script>

    @endsection