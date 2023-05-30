@extends('Templates.master_message')

@section('titre')
    Noouveau Message
@endsection

@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="messagerie";
$sm="inbox";
@endphp

@section('stylesheet')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />s
@endsection

@section('content')
      <section class="wrapper">
        <!-- page start-->
        <div class="row mt">
          <div class="col-sm-3">
            <section class="panel">
              <div class="panel-body">
                <a class="btn btn-compose">
                  <i class="fa fa-pencil"></i>  Nouveau Message
                </a>
                <ul class="nav nav-pills nav-stacked mail-nav">
                  <li class=""><a href="{{ route('inbox') }}"> <i class="fa fa-inbox"></i> Messages réçus  <!-- <span class="label label-theme pull-right inbox-notification">3</span> --></a></li>
                  <li><a href="{{ route('message.sent') }}"> <i class="fa fa-envelope-o"></i> Messages Envoyés</a></li>
                </ul>
              </div>
            </section>
          
          </div>
          <div class="col-sm-9">
            <section class="panel" >
              <header class="panel-heading wht-bg">
                <h4 class="gen-case">
                    Nouveau Message
                  </h4>
              </header>
              <div class="panel-body">
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
                <div class="compose-mail">
                  <form autocomplete="off" class="d-flex flex-column" method="post" enctype="multipart/form-data" action="{{ route('message.send') }}" id="form_message">
                        {{ csrf_field() }} 
                       
                    <div class="form-group">
                      <label class="col-sm-1 control-label">à :</label>
                      <div class="col-sm-5">
                       <select onchange="getSousdirection(this.value)" class="form-control" name="direction">
                        <option value="">DIRECTION / BUREAU</option>
                        @foreach($directions as $direction)
                        <option value="{{ $direction->id }}">
                          {{ $direction->designation }}
                        </option>
                        @endforeach
                      </select>
                      </div>
                      <label class="col-sm-1 control-label"></label>
                      <div class="col-sm-4">
                       <select onchange="getService(this.value)" class="form-control" name="sousdirection" id="sousdirection">
                        <option value="">Sous-direction / Agence :</option>
                        
                      </select>
                      </div>

                    </div>
                    <div class="form-group">
                      <label class="col-sm-1 control-label">Service:</label>
                      <div class="col-sm-5">
                       <select onchange="getAgent(this.value)" class="form-control" name="service" id="service">
                        <option value="">Service / Guichet :</option>
                       
                      </select>
                      </div>
                      <label class="col-sm-2 control-label">Agent:</label>
                      <div class="col-sm-4">
                      <select class="form-control js-example-basic-multiple" name="agent[]" id="agent" multiple>
                        

                      </select>
                      </div>

                    </div>
                    
                    
                    <div class="form-group">
                      <label for="sujet" class="">Sujet:</label>
                      <input type="text" tabindex="1" id="sujet" name="sujet" class="form-control" required>
                    </div>
                    <div class="compose-editor">
                      <textarea class="wysihtml5 form-control" rows="9" name="content_message" required></textarea>
                      <input type="file" name="mail_doc" class="default">
                    </div>
                 
  
                    <div class="compose-btn">
                      <button type="submit" class="btn btn-theme btn-sm"><i class="fa fa-check"></i> Envoyé</button>
                      <!-- <button class="btn btn-sm"><i class="fa fa-times"></i> Retour</button> -->
                      <!-- <button class="btn btn-sm">Draft</button> -->
                    </div>
                  </form>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>
      <!-- /wrapper -->
    @endsection

@section('scriptjs')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
     <script>

        $(document).ready(function() {
          $('.js-example-basic-multiple').select2();
          });

        $(document).ready(function() {
          $('.js-example-basic-single').select2();
          });

    </script>

    <script>

      function submit_message(){

        var editor=$("#message-editor").text();
        $("#content_message").val(editor);
        
        document.getElementById("form_message").submit();// Form submission
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
      
    </script>

 @endsection