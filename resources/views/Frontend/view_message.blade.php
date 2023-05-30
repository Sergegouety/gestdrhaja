@extends('Templates.master_message')

@section('titre')
     Message Reçus
@endsection

@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="messagerie";
$sm="inbox";
@endphp

@section('content')

      <section class="wrapper">
        <!-- page start-->
        <div class="row mt">
          <div class="col-sm-3">
             <section class="panel">
              <div class="panel-body">
                <a href="{{route('nouveau.message')}}" class="btn btn-compose">
                  <i class="fa fa-pencil"></i>  Nouveau Message
                  </a>
                <ul class="nav nav-pills nav-stacked mail-nav">
                  <li ><a href="{{ route('inbox') }}"> <i class="fa fa-inbox"></i> Messages réçus <!-- <span class="label label-theme pull-right inbox-notification">3</span> --></a></li>
                  <li><a href="{{ route('message.sent') }}"> <i class="fa fa-envelope-o"></i>Messages Envoyés</a></li>
                </ul>
              </div>
            </section>
            
          </div>
          <div class="col-sm-9">
            <section class="panel">
              <header class="panel-heading wht-bg">
                <h4 class="gen-case">
                    Voir Message
                    <!-- <form action="#" class="pull-right mail-src-position">
                      <div class="input-append">
                        <input type="text" class="form-control " placeholder="Search Mail">
                      </div>
                    </form> -->
                  </h4>
              </header>
              <div class="panel-body ">
                <div class="mail-header row">
                  <div class="col-md-8">
                    <h4 class="pull-left"> {{$messages->sujet}} </h4>
                  </div>
                 <!--  <div class="col-md-4">
                    <div class="compose-btn pull-right">
                      <a href="mail_compose.html" class="btn btn-sm btn-theme"><i class="fa fa-reply"></i> Reply</a>
                      <button class="btn  btn-sm tooltips" data-original-title="Print" type="button" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-print"></i> </button>
                      <button class="btn btn-sm tooltips" data-original-title="Trash" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-trash-o"></i></button>
                    </div>
                  </div>
                </div> -->
                <div class="mail-sender">
                  <div class="row">
                    <div class="col-md-8">
                      <img src="img/ui-zac.jpg" alt="">
                      <strong> @if($messages->sender_id)
                          {{ getInstanceName('users','id',$messages->sender_id,'nomprenoms')}}
                          @endif
                       </strong>
                      <span></span> à
                      <strong>@if($messages->state==2)
                        {{getMessageDestination($messages->destinataire_id)}}
                           @else
                           moi
                           @endif
                      </strong>
                    </div>
                    <div class="col-md-4">
                      <p class="date"> {{format_date($messages->created_at)}}</p>
                    </div>
                  </div>
                </div>
                <div class="view-mail">
                   <textarea class="wysihtml5 form-control" rows="9" >{{$messages->contenu}}</textarea>
                   <br>
                  <p>
                    <a class="btn btn-success" href="{{asset('docs/'.$messages->document)}}" style="color: white;" target="_blank">télécharger document</a>
                  </p>
                </div>
                <!-- <div class="attachment-mail">
                  <p>
                    <span><i class="fa fa-paperclip"></i> 2 attachments — </span>
                    <a href="#">Download all attachments</a> |
                    <a href="#">View all images</a>
                  </p>
                  <ul>
                    <li>
                      <a class="atch-thumb" href="#">
                        <img src="img/instagram.jpg">
                        </a>
                      <a class="name" href="#">
                        IMG_001.jpg
                        <span>20KB</span>
                        </a>
                      <div class="links">
                        <a href="#">View</a> -
                        <a href="#">Download</a>
                      </div>
                    </li>
                    <li>
                      <a class="atch-thumb" href="#">
                        <img src="img/weather.jpg">
                        </a>
                      <a class="name" href="#">
                        IMG_001.jpg
                        <span>20KB</span>
                        </a>
                      <div class="links">
                        <a href="#">View</a> -
                        <a href="#">Download</a>
                      </div>
                    </li>
                  </ul>
                </div> -->
                <!-- <div class="compose-btn pull-left">
                  <a href="mail_compose.html" class="btn btn-sm btn-theme"><i class="fa fa-reply"></i> Reply</a>
                  <button class="btn btn-sm "><i class="fa fa-arrow-right"></i> Forward</button>
                  <button class="btn  btn-sm tooltips" data-original-title="Print" type="button" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-print"></i> </button>
                  <button class="btn btn-sm tooltips" data-original-title="Trash" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-trash-o"></i></button>
                </div> -->
              </div>
            </section>
          </div>
        </div>
      </section>
      <!-- /wrapper -->
 

    @endsection
