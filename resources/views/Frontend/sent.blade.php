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
                  <li ><a href="{{ route('inbox') }}"> <i class="fa fa-inbox"></i> Messages réçus</a></li>
                  <li class="active"><a href="#"> <i class="fa fa-envelope-o"></i>Messages Envoyés</a></li>
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
                        <td class="view-message  inbox-small-cells">
                          @if($message->document)
                          <i class="fa fa-paperclip"></i>
                          @endif
                        </td>
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