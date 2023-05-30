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
                  <li class="active"><a> <i class="fa fa-inbox"></i> Messages réçus <!-- <span class="label label-theme pull-right inbox-notification">3</span> --></a></li>
                  <li><a href="{{ route('message.sent') }}"> <i class="fa fa-envelope-o"></i>Messages Envoyés</a></li>
                </ul>
              </div>
            </section>
            
          </div>
          <div class="col-sm-9">
            <section class="panel" style="height:450px">
              <header class="panel-heading wht-bg">
                
              </header>
              <div class="panel-body minimal">
                
                <div class="table-inbox-wrap ">
                  <table class="table table-inbox table-hover">
                    <tbody>
                      @foreach($messages as $message)
                       <tr class="unread">
                        <td class="inbox-small-cells">
                        </td>
                        <td class="inbox-small-cells"></td>
                        <td class="view-message  dont-show">
                          @if($message->sender_id)
                          <a href="{{route('view.messages',$message->id)}}">
                          {{ getInstanceName('users','id',$message->sender_id,'nomprenoms')}}
                        </a>
                        @endif
                        </td>
                        <td class="view-message "><a href="{{route('view.messages',$message->id)}}">{{$message->sujet}} - {{$message->contenu}}</a></td>
                        <td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i></td>
                        <td class="view-message  text-right">{{format_date($message->created_at)}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>


@endsection