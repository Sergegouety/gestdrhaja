@extends('Templates.master')

@section('titre')
    Demande List - Aej Admin
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


    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/bootstrap/dist/css/bootstrap.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/@fortawesome/fontawesome-free/css/fontawesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/@fortawesome/fontawesome-free/css/regular.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/@fortawesome/fontawesome-free/css/brands.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/@fortawesome/fontawesome-free/css/solid.css')}}">



    <!-- include vendor stylesheets used in "DataTables" page. see "/views//pages/partials/table-datatables/@vendor-stylesheets.hbs" -->
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/datatables.net-buttons-bs4/css/buttons.bootstrap4.css')}}">


    <!-- include fonts -->
    <link rel="stylesheet" type="text/css" href="{{asset('dist/css/ace-font.css')}}">



    <!-- ace.css -->
    <link rel="stylesheet" type="text/css" href="{{asset('dist/css/ace.css')}}">


    <!-- favicon -->
    <link rel="icon" type="image/png" href="{asset({'assets/favicon.png')}}" />

    <!-- "DataTables" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="{{asset('views/pages/page-inbox/@page-style.css')}}">


     <!-- "Dashboard 3" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="{{asset('dist/css/ace-themes.css')}}">

@endsection

@section('content')


<div class="body-container">
      
      
      <div class="main-container bgc-white">

        <div role="main" class="main-content">

          <div class="page-content container container-plus">
            <div class="row">
              <div class="col-12 col-sm-4 col-xl-3">
                <!-- .modal-off-sm will turn off modal features in sm+ view. So .modal is displayed without needing to toggle it -->
                <div id="aside-menu" class="modal fade modal-off-sm ace-aside aside-left">
                  <div class="modal-dialog modal-dialog-scrollable" style="max-width: 280px;">
                    <div class="modal-content brc-dark-l4 border-y-0 border-l-0 radius-l-0">

                      <div class="modal-header d-sm-none position-tr mt-n25 mr-n2 border-0" style="z-index: 111;">
                        <!-- .hide header in lg+ view -->
                        <button type="button" class="btn btn-brc-tp btn-white btn-xs btn-h-red btn-a-red text-xl" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>


                      <div class="modal-body pt-lg-1 px-2 px-sm-1 ace-scrollbar text-right">
                        <div class="pr-2 px-lg-3 pt-lg-4">

                          <div class="text-center mb-4">
                            <a href="#aside-compose" data-toggle="modal" class="btn btn-blue px-45 py-2 text-105 radius-2">
                              <i class="fa fa-pencil-alt mr-1"></i>
                              Nouveau
                            </a>
                          </div>

                          <form autocomplete="off" class="btn-group btn-group-toggle btn-group-vertical d-flex" data-toggle="buttons">
                           
                            <a href="#" class="d-style mb-1 btn py-25 btn-outline-dark btn-h-outline-blue btn-a-outline-blue btn-a-bold w-100 btn-brc-tp border-none border-l-4 radius-0 text-left">
                              <i class="fa fa-paper-plane w-3 f-n-hover"></i>
                              Envoyés
                              <input type="radio" name="inbox" />
                            </a>

                            <a href="#" class="d-style mb-1 active btn py-25 btn-outline-dark btn-h-outline-blue btn-a-outline-blue btn-a-bold w-100 btn-brc-tp border-none border-l-4 radius-l-0 radius-r-round text-left">
                              <i class="fa fa-inbox w-3 f-n-hover"></i>
                              Reçus
                              <!-- <span class="badge badge-pill px-3 badge-danger float-right">4</span> -->
                              <input type="radio" name="inbox" checked />
                            </a>

                          </form>

                          <hr class="brc-secondary-l3 mt-3 mb-4" />
                      

                        </div>

                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-8 col-xl-9 pt-3" id="message-list">
                <div class="d-flex flex-column flex-md-row pb-35 pt-2">

                  <div class="order-last order-md-first pl-1 pl-md-3 d-flex align-items-center">
                    <label class="mb-0 ">
                      <input id="select-all" type="checkbox" class="border-2 brc-secondary-m1 brc-h-orange-m1" />
                    </label>

                    <div class="dropdown ml-2 mr-3">
                      <!-- <button type="button" class="btn btn-outline-lightgrey btn-h-light-lightgrey btn-a-light-lightgrey btn-brc-tp btn-xs px-1 py-2px dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-chevron-down text-85"></i>
                      </button> -->

                      <div class="dropdown-menu dropdown-center">
                        <a class="dropdown-item m-1px px-4 py-1" href="#">
                          Tous
                        </a>

                        <a class="dropdown-item m-1px px-4 py-1" href="#">
                          Non lus
                        </a>

                        <a class="dropdown-item m-1px px-4 py-1" href="#">
                          Lus
                        </a>

                      </div>
                    </div>

                    <div id="inbox-header" class="pb-1px">
                      <h3 class="text-xl text-dark-m3 mb-0 d-inline-block">
                        Inbox
                      </h3>

                      <span class="text-grey-m1 text-md ml-2"><!-- (4 unread messages) --></span>
                    </div>

                    <div id="inbox-actions" class="d-none">
                      <div class="dropdown d-inline-block">
                        <a href="#" class="btn btn-sm btn-lighter-default btn-text-dark btn-bgc-white btn-h-outline-blue btn-a-outline-blue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Action
                          <i class="fa fa-caret-down ml-1"></i>
                        </a>
                        <div class="dropdown-menu shadow-sm dropdown-center brc-secondary-l1 radius-1 px-2px py-1">
                          <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                            <i class="fa fa-reply w-3 text-blue-d2"></i>
                            Reply
                          </a>

                          <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                            <span class="w-3 d-inline-block">
                                    <i class="fa fa-reply fa-flip-horizontal text-green-d2"></i>
                                </span>
                            Forward
                          </a>

                          <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                            <i class="fa fa-folder-open text-orange-d2 w-3"></i>
                            Archive
                          </a>

                          <div class="dropdown-divider"></div>

                          <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                            <i class="fa fa-eye w-3 text-blue-d2"></i>
                            Mark as read
                          </a>

                          <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                            <i class="fa fa-eye-slash w-3 text-green-d2"></i>
                            Mark as unread
                          </a>

                          <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                            <i class="far fa-flag w-3 text-danger-d2"></i>
                            Flag
                          </a>
                        </div>
                      </div>


                      <div class="dropdown d-inline-block">
                        <a href="#" class="btn btn-sm btn-lighter-default btn-text-dark btn-bgc-white btn-h-outline-blue btn-a-outline-blue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="far fa-folder mr-1"></i>
                          Move to
                          <i class="fa fa-caret-down ml-1"></i>
                        </a>
                        <div class="dropdown-menu shadow-sm dropdown-center brc-secondary-l1 radius-1 px-2px py-1">
                          <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                            <span class="d-inline-block w-2 h-2 border-3 brc-pink radius-round mr-1 mb-1 align-middle"></span>
                            Family
                          </a>

                          <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                            <span class="d-inline-block w-2 h-2 border-3 brc-blue radius-round mr-1 mb-1 align-middle"></span>
                            Friends
                          </a>

                          <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                            <span class="d-inline-block w-2 h-2 border-3 brc-green radius-round mr-1 mb-1 align-middle"></span>
                            Work
                          </a>

                          <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                            <span class="d-inline-block w-2 h-2 border-3 brc-orange radius-round mr-1 mb-1 align-middle"></span>
                            Other
                          </a>
                        </div>
                      </div>

                      <div class="dropdown d-inline-block">
                        <a href="#" class="btn btn-sm btn-lighter-default btn-text-dark btn-bgc-white btn-h-outline-danger btn-a-outline-danger">
                          <i class="fa fa-trash-alt text-danger mr-sm-1"></i>
                          <span class="d-none d-sm-inline">Delete</span>
                        </a>
                      </div>
                    </div>
                  </div>



                  <div class="order-first order-md-last ml-md-auto mb-4 mb-md-0">
                    <div class="input-group">
                      <div class="input-group-prepend d-sm-none" style="z-index: 222;">
                        <button type="button" class="mr-n5 btn btn-brc-tp btn-outline-dark btn-a-green btn-h-green radius-l-1 px-25 btn-sm static" data-toggle="modal" data-target="#aside-menu">
                          <i class="fa fa-bars"></i>
                        </button>
                      </div>

                    </div>
                  </div>
                </div>
                <div>
                  <hr class="brc-black-tp10 my-0" />
<!-- //begin -->
@foreach($messages as $message)
                  <div role="button" class="message-item d-flex align-items-start bgc-h-primary-l4 px-2 px-md-3 py-25 radius-2px d-style pos-rel">
                    <label class="mb-0 message-select-btn">
                      <input type="checkbox" class="input-sm" />
                    </label>

                   <!--  <a href="#" class="d-none d-md-block ml-md-3 message-star-btn">
                      <i class="fa fa-star text-warning-m1"></i>
                    </a>

                    <a href="#" class="d-md-none position-br mr-1 mb-2px message-star-btn">
                      <i class="fa fa-star text-warning-m1"></i>
                    </a> -->

                    <div class="col-auto px-0 ml-2 ml-md-3 w-5 h-5 bgc-purple text-white text-90 text-600 text-center pt-15 radius-round border-2 brc-white">
                      
                    </div>


                    <div class="ml-3 d-flex flex-column flex-lg-row align-items-lg-center">
                      <div class="message-user mb-1 mb-lg-0 col-auto px-0 text-95 text-600 text-dark-m2">
                       @if($message->sender_id)
                        {{getInstanceName('users','id',$message->sender_id,'fname')}}
                         {{getInstanceName('users','id',$message->sender_id,'lname')}}
                        @endif
                        <!-- <span class="text-400 text-sm text-grey-m3 ml-1">3</span> -->
                      </div>
                      <div class="message-text ml-lg-3 ml-lg-5 pr-1 pr-lg-0 text-90 text-600 text-dark-m3 pos-rel">



                        <!-- <span class="badge bgc-red-l2 text-danger-d2 mr-1 radius-1">Urgent</span> -->

                        {{$message->sujet}}
                      </div>
                    </div>



                    <div class="message-time d-none d-lg-flex align-items-center ml-auto pl-2 col-auto text-nowrap pr-0 pl-1 text-90 text-600 text-dark-m1">
                      <i class="w-3 fa fa-paperclip ml-n35 text-blue-m1"></i>
                      {{$message->created_at}}
                    </div>
                    <div class="position-tr mt-15 w-auto message-time d-flex d-lg-none align-items-center text-nowrap  text-90 text-600 text-dark-m1">
                      <i class="w-2 mr-2px fa fa-paperclip ml-n3 text-blue-m1"></i>
                      {{$message->created_at}}
                    </div>


                    <div class="message-actions position-r mr-1 v-hover p-15 bgc-white-tp1 shadow-sm radius-2px">
                      <a href="#" class="btn btn-tp border-0 btn-text-danger btn-light-danger mr-2px px-2">
                        <i class="fa fa-trash-alt text-danger-m1 w-2"></i>
                      </a>
                      <a href="#" class="btn btn-tp border-0 btn-text-info btn-light-info px-2">
                        <i class="fa fa-reply w-2"></i>
                      </a>
                    </div>
                  </div>

                  <hr class="brc-black-tp10 my-0" />
              @endforeach
<!-- end -->

                 <!--  <hr class="brc-black-tp10 my-0" />
                  <div role="button" class="message-item d-flex align-items-start bgc-h-primary-l4 px-2 px-md-3 py-25 radius-2px d-style pos-rel">
                    <label class="mb-0 message-select-btn">
                      <input type="checkbox" class="input-sm" />
                    </label>

                    <a href="#" class="d-none d-md-block ml-md-3 message-star-btn">
                      <i class="fa fa-star text-warning-m1"></i>
                    </a>

                    <a href="#" class="d-md-none position-br mr-1 mb-2px message-star-btn">
                      <i class="fa fa-star text-warning-m1"></i>
                    </a>

                    <div class="col-auto px-0 ml-2 ml-md-3 w-5 h-5 bgc-secondary text-white text-90 text-600 text-center pt-15 radius-round border-2 brc-white">
                      Y
                    </div>


                    <div class="ml-3 d-flex flex-column flex-lg-row align-items-lg-center">
                      <div class="message-user mb-1 mb-lg-0 col-auto px-0 text-95 text-dark-m3">
                        Yahoo!
                      </div>
                      <div class="message-text ml-lg-3 ml-lg-5 pr-1 pr-lg-0 text-90  text-dark-m3 pos-rel">
                        <span class="p-1 bgc-orange radius-round d-inline-block mr-1"></span>




                        Tofu biodiesel williamsburg marfa, four loko mcsweeney
                      </div>
                    </div>



                    <div class="message-time d-none d-lg-flex align-items-center ml-auto pl-2 col-auto text-nowrap pr-0 pl-1 text-90">
                      <i class="w-3 fa fa-paperclip ml-n35 text-grey-l1"></i>
                      Aug 22
                    </div>
                    <div class="position-tr mt-15 w-auto message-time d-flex d-lg-none align-items-center text-nowrap  text-90">
                      <i class="w-2 mr-2px fa fa-paperclip ml-n3 text-grey-l1"></i>
                      Aug 22
                    </div>


                    <div class="message-actions position-r mr-1 v-hover p-15 bgc-white-tp1 shadow-sm radius-2px">
                      <a href="#" class="btn btn-tp border-0 btn-text-danger btn-light-danger mr-2px px-2">
                        <i class="fa fa-trash-alt text-danger-m1 w-2"></i>
                      </a>
                      <a href="#" class="btn btn-tp border-0 btn-text-info btn-light-info px-2">
                        <i class="fa fa-reply w-2"></i>
                      </a>
                    </div>
                  </div> -->

                  
                 

                  <hr class="brc-black-tp10 my-0" />
                </div>

                <div class="bgc-default-l4 p-3 align-items-center d-flex w-100">
                  <div>
                    Voir <span class="text-600">1</span> - <span class="text-600">10</span>
                    sur
                    <span class="text-600">100</span> messages
                  </div>

                  <div class="ml-auto">
                    <nav class="d-inline-block" aria-label="Inbox navigation">
                      <ul class="pagination align-items-center d-inline-flex mb-0">
                        <li class="page-item mr-1">
                          <a class="page-link btn py-2 px-25 btn-sm border-2 brc-sec1ondary-l1 radius-r-0 text-600 btn-bgc-white btn-lighter-secondary btn-h-default btn-a-default" href="#">
                            <i class="fa fa-chevron-left"></i>
                          </a>
                        </li>

                        <li class="page-item">
                          <a class="page-link btn py-2 px-25 btn-sm border-2 brc-sec1ondary-l1 radius-l-0 text-600 btn-bgc-white btn-lighter-secondary btn-h-default btn-a-default" href="#">
                            <i class="fa fa-chevron-right"></i>
                          </a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-8 col-xl-9 pt-3 d-none" id="message-view">
                <div class="d-flex flex-wrap py-1 pt-lg-3 pb-lg-2 mt-lg-1">
                  <a href="#" class="btn btn-lighter-primary btn-tp border-0" id="message-list-back-btn">
                    <i class="fa fa-arrow-left mr-1 text-90"></i>
                    <span class="text-dark-m3">
                    Back
                </span>
                  </a>

                  <div class="mx-auto order-last order-sm-0 mt-2 mt-sm-0">
                    <div class="dropdown d-inline-block">
                      <a href="#" class="btn btn-sm btn-lighter-default btn-text-dark btn-bgc-white btn-h-outline-blue btn-a-outline-blue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                        <i class="fa fa-caret-down ml-1"></i>
                      </a>
                      <div class="dropdown-menu shadow-sm dropdown-center brc-secondary-l1 radius-1 px-2px py-1">
                        <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                          <i class="fa fa-reply w-3 text-blue-d2"></i>
                          Reply
                        </a>

                        <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                          <span class="w-3 d-inline-block">
                                <i class="fa fa-reply fa-flip-horizontal text-green-d2"></i>
                            </span>
                          Forward
                        </a>

                        <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                          <i class="fa fa-folder-open text-orange-d2 w-3"></i>
                          Archive
                        </a>

                        <div class="dropdown-divider"></div>

                        <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                          <i class="fa fa-eye w-3 text-blue-d2"></i>
                          Mark as read
                        </a>

                        <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                          <i class="fa fa-eye-slash w-3 text-green-d2"></i>
                          Mark as unread
                        </a>

                        <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                          <i class="far fa-flag w-3 text-danger-d2"></i>
                          Flag
                        </a>
                      </div>
                    </div>


                    <div class="dropdown d-inline-block">
                      <a href="#" class="btn btn-sm btn-lighter-default btn-text-dark btn-bgc-white btn-h-outline-blue btn-a-outline-blue dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-folder mr-1"></i>
                        Move to
                        <i class="fa fa-caret-down ml-1"></i>
                      </a>
                      <div class="dropdown-menu shadow-sm dropdown-center brc-secondary-l1 radius-1 px-2px py-1">
                        <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                          <span class="d-inline-block w-2 h-2 border-3 brc-pink radius-round mr-1 mb-1 align-middle"></span>
                          Family
                        </a>

                        <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                          <span class="d-inline-block w-2 h-2 border-3 brc-blue radius-round mr-1 mb-1 align-middle"></span>
                          Friends
                        </a>

                        <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                          <span class="d-inline-block w-2 h-2 border-3 brc-green radius-round mr-1 mb-1 align-middle"></span>
                          Work
                        </a>

                        <a href="#" class="dropdown-item m-1px px-3 py-1 text-dark-m3 btn btn-lighter-dark btn-h-lighter-secondary btn-a-lighter-secondary btn-bgc-tp radius-0 text-95">
                          <span class="d-inline-block w-2 h-2 border-3 brc-orange radius-round mr-1 mb-1 align-middle"></span>
                          Other
                        </a>
                      </div>
                    </div>

                    <div class="dropdown d-inline-block">
                      <a href="#" class="btn btn-sm btn-lighter-default btn-text-dark btn-bgc-white btn-h-outline-danger btn-a-outline-danger">
                        <i class="fa fa-trash-alt text-danger mr-sm-1"></i>
                        <span class="d-none d-sm-inline">Delete</span>
                      </a>
                    </div>
                  </div>

                  <div class="d-inline-flex align-items-center">
                    <span class="mr-2">
                    4 of 151
                </span>

                    <a href="#" class="btn btn-tp border-0 btn-lighter-blue">
                      <i class="fa fa-chevron-left"></i>
                    </a>

                    <a href="#" class="btn btn-tp border-0 btn-lighter-blue">
                      <i class="fa fa-chevron-right"></i>
                    </a>
                  </div>
                </div>


                <hr class="mt-2 mt-sm-1 brc-black-tp10" />


                <div class="d-flex flex-column flex-md-row">
                  <div>
                    <h3 class="mt-2 mb-3 text-130 d-inline-flex align-items-center">
                      <i class="fa fa-star text-warning text-md align-middle"></i>
                      <span class="mx-2">
                        Message Title Goes Here
                    </span>
                      <span class="align-middle ml-1 badge bgc-default-l3 border-1 brc-default-l1 text-default-d3 text-60 radius-1">Inbox</span>
                    </h3>

                    <div class="d-flex align-items-center">
                      <img src="assets/image/avatar/avatar1.jpg" class="w-5 h-5 mx-1 radius-round p-2px bgc-white border-1 brc-grey-l1 shadow-sm" />

                      <div class="ml-2">
                        <a href="#" class="text-600">
                          Alex Ferguson
                        </a>

                        <div class="text-grey">
                          to yourname@domain.com
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="ml-auto text-right mt-2 mt-md-0">
                    <span class="text-sm text-grey mr-2">
                    Sat, Sep 19, 9:52 AM (3 days ago)
                </span>

                    <div class="d-inline-block text-nowrap">
                      <a href="#" class="btn btn-lighter-blue btn-text-blue border-0 btn-bgc-tp px-2">
                        <i class="fa fa-reply"></i>
                      </a>

                      <a href="#" class="btn btn-lighter-green btn-text-green border-0 btn-bgc-tp px-2">
                        <i class="fa fa-reply fa-flip-horizontal"></i>
                      </a>

                      <a href="#" class="btn btn-lighter-pink btn-text-pink border-0 btn-bgc-tp px-2">
                        <i class="fa fa-print"></i>
                      </a>
                    </div>
                  </div>
                </div>


                <div class="mt-4">
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                  </p>

                  <p>
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </p>

                  <p>
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                  </p>

                  <p>
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                  </p>

                  <p>
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                  </p>

                  <p>
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </p>
                </div>


                <div class="my-5">
                  <h5 class="text-dark-m3 text-600 text-105">
                    Attachments
                    <span class="text-grey text-400 text-md">(2 files, 30 MB)</span>
                  </h5>

                  <div class="row justify-content-between">
                    <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                      <ul class="list-unstyled mt-3 p-3 radius-1 bgc-secondary-l4">
                        <li class="mb-25 d-flex">
                          <i class="far fa-file-pdf text-danger text-lg w-3 mr-1"></i>
                          Document.pdf

                          <div class="ml-auto action-buttons">
                            <a href="#" class="text-blue mr-2">
                              <i class="fa fa-download"></i>
                            </a>
                            <a href="#" class="text-danger">
                              <i class="fa fa-trash-alt"></i>
                            </a>
                          </div>
                        </li>


                        <li class="d-flex">
                          <i class="fa fa-film text-green text-lg w-3 mr-1"></i>
                          Video.mp4

                          <div class="ml-auto action-buttons">
                            <a href="#" class="text-blue mr-2">
                              <i class="fa fa-download"></i>
                            </a>
                            <a href="#" class="text-danger">
                              <i class="fa fa-trash-alt"></i>
                            </a>
                          </div>
                        </li>
                      </ul>
                    </div>


                    <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                      <div class="text-center text-md-right">
                        <div role="button" class="overflow-hidden d-inline-block radius-1 pos-rel d-style">
                          <img src="/assets/image/gallery/thumb9.jpg" class="d-zoom-2" style="width: 164px;" />
                          <div class="position-tl w-100 h-100 bgc-black-tp5 v-hover">
                            <div class="position-lc text-center w-100">
                              <a href="#" class="text-white no-underline mr-2 dh-zoom-3 d-inline-block">
                                <i class="fa fa-download"></i>
                              </a>

                              <a href="#" class="text-white no-underline dh-zoom-3 d-inline-block">
                                <i class="fa fa-star"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="text-center text-md-left">
                  <a href="#" class="btn btn-white px-35 btn-h-lighter-dark">
                    <i class="fa fa-reply mr-2"></i>
                    Reply
                  </a>

                  <a href="#" class="btn btn-white px-35 btn-h-lighter-dark">
                    Forward
                    <i class="fa fa-arrow-right ml-2"></i>
                  </a>
                </div>

              </div>
            </div>



            <!-- the "compose" trigger button to show the "Compose" aside/dialog  ... only shown in small devices -->
            <div class="position-br pos-fixed mb-5 pb-3 mr-2 d-sm-none">
              <button type="button" class="shadow ml-2 btn btn-info radius-round mw-auto px-3 py-2" data-toggle="modal" data-target="#aside-compose">
                <i class="fa fa-pen mr-1"></i>
                Compose
              </button>
            </div>


            <!-- the "message compose" aside (dialog) -->
            <div class="modal modal-nb ace-aside aside-bottom aside-r aside-fade aside-offset aside-shown-above-nav" id="aside-compose" tabindex="-1" role="dialog" aria-hidden="false">

              <div class="modal-dialog modal-dialog-scrollable mr-2 my-2" style="width: 640px;" role="document">
                <div class="modal-content border-0 mb-2 radius-1 shadow">
                  <div class="modal-header bgc-dark-d3 border-0 text-white pt-25 pb-2">
                    <h5 class="text-110 py-0 my-0">
                      Nouveau Message
                    </h5>

                    <a href="#" class="action-btn text-white bgc-h-white-tp9 radius-1 px-2 py-1" data-dismiss="modal">
                      <i class="fa fa-times"></i>
                    </a>
                  </div>
                  <div class="modal-body">
                    <form autocomplete="off" class="d-flex flex-column" method="post" action="{{ route('message.send') }}" id="form_message">
                        {{ csrf_field() }} 
                        <input type="hidden" id="content_message" name="content_message" value="">
<label>Envoyé à:</label>
                  <div class="form-group row">
                      
                     <div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1">
                     <select onchange="getSousdirection(this.value)" class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="direction">
                        <option value="">DIRECTION / BUREAU</option>
                        @foreach($directions as $direction)
                        <option value="{{ $direction->id }}">
                          {{ $direction->designation }}
                        </option>
                        @endforeach
                      </select>
                  </div>

                   <div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1">
                       <select onchange="getService(this.value)" class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="sousdirection" id="sousdirection">
                        <option value="">SOUS-DIRECTION / AGENCE</option>
                        
                      </select>
                    </div>

                  </div>

                  <div class="form-group row">
                   <div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1">
                      <select onchange="getAgent(this.value)" class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="service" id="service">
                        <option value="">SERVICE / GUICHET</option>
                       
                      </select>
                    </div>

                    <div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1">
                      <select class="mt-4 ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 radius-round border-1 angle-down" name="agent" id="agent">
                        <option value="">AGENT</option>
                        
                      </select>
                    </div>
                  </div>

                      <div class="form-group row my-2">
                        <div class="flex-grow-1 px-3">
                          <input type="text" class="px-1 brc-grey-l2 form-control border-none border-b-1 shadow-none radius-0" i1d="id-form-field-1" placeholder="sujet :" name="sujet">
                        </div>
                      </div>


                      <div class="form-group row mt-3">
                        <div class="px-3 w-100">
                          <div id="message-editor" placeholder="Type your message" class="overflow-auto text-wrap w-100" style="height: 360px; max-height: 50vh;" contenteditable="true">

                          </div>
                        </div>
                      </div>


                    </form>

                    <div id="message-editor-toolbar" class="collapse position-bl w-100">
                      <!-- wysiwyg editor will be inserted here -->
                      <!-- this is a .collapse element and will be toggeld using the below data-toggle="collapse" button -->
                    </div>
                  </div>

                  <div class="modal-footer justify-content-start bgc-secondary-l4">
                    <button type="button" class="btn btn-blue py-15 px-4 ml-2" onclick="submit_message()">
                      Send
                    </button>

                    <div class="ml-3 pl-3 border-l-1 brc-secondary-l1">
                      <a data-toggle="collapse" href="#message-editor-toolbar" class="btn btn-tp btn-white">
                        <i class="fa fa-font"></i>
                      </a>

                      <a href="#" class="btn btn-tp btn-white">
                        <i class="fa fa-paperclip"></i>
                      </a>

                      <div class="dropdown d-inline-block">
                        <a href="#" class="btn btn-tp btn-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="far fa-smile text-125"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right p-1">
                          <div class="d-flex ">
                            <a class="dropdown-item px-25" href="#">
                              <span class="fa-stack w-auto">
                                <i class="fas fa-circle text-dark fa-stack-1x text-100"></i>
                                <i class="fas fa-smile text-warning-m3 text-125 fa-stack-1x pos-rel"></i>
                            </span>
                            </a>

                            <a class="dropdown-item px-25" href="#">
                              <span class="fa-stack w-auto">
                                <i class="fas fa-circle text-dark fa-stack-1x text-100"></i>
                                <i class="fas fa-smile-beam text-warning-m3 text-125 fa-stack-1x pos-rel"></i>
                            </span>
                            </a>

                            <a class="dropdown-item px-25" href="#">
                              <span class="fa-stack w-auto">
                                <i class="fas fa-circle text-dark fa-stack-1x text-100"></i>
                                <i class="fas fa-smile-wink text-warning-m3 text-125 fa-stack-1x pos-rel"></i>
                            </span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="ml-auto">
                      <span class="text-grey-d1 text-95 mr-2">Draft saved at 9:21 pm</span>
                      <a href="#" class="btn btn-tp btn-outline-grey btn-h-lighter-danger btn-a-lighter-danger">
                        <i class="fa fa-trash"></i>
                      </a>
                    </div>
                  </div>
                </div>

             
              </div>

            </div>
          </div>

    

        </div>

        <div id="id-ace-settings-modal" class="my-1 my-lg-2 modal modal-nb ace-aside aside-right aside-offset aside-below-nav" data-backdrop="false" tabindex="-1" role="dialog" aria-hidden="true">

      
        </div><!-- .modal-aside -->
      </div>
    </div>


@endsection

     @section('scriptjs')
    
    <!-- include common vendor scripts used in demo pages -->
    <script src="{{asset('node_modules/jquery/dist/jquery.js')}}"></script>
    <script src="{{asset('node_modules/popper.js/dist/umd/popper.js')}}"></script>
    <script src="{{asset('node_modules/bootstrap/dist/js/bootstrap.js')}}"></script>



    <!-- include vendor scripts used in "DataTables" page. see "/views//pages/partials/table-datatables/@vendor-scripts.hbs" -->
    <script src="{{asset('node_modules/datatables/media/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-colreorder/js/dataTables.colReorder.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-select/js/dataTables.select.js')}}"></script>


    <script src="{{asset('node_modules/datatables.net-buttons/js/dataTables.buttons.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-buttons-bs4/js/buttons.bootstrap4.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-buttons/js/buttons.html5.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-buttons/js/buttons.print.js')}}"></script>
    <script src="{{asset('node_modules/datatables.net-buttons/js/buttons.colVis.js')}}"></script>

     <script src="{{ asset('node_modules/tiny-date-picker/dist/date-range-picker.js') }}"></script>
    <script src="{{ asset('node_modules/moment/moment.js') }}"></script>
    <script src="{{ asset('node_modules/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js') }}"></script>


    <script src="{{asset('node_modules/datatables.net-responsive/js/dataTables.responsive.js')}}"></script>



    <!-- include ace.js -->
    <script src="{{asset('dist/js/ace.js')}}"></script>



    <!-- demo.js is only for Ace's demo and you shouldn't use it -->
    <script src="{{asset('app/browser/demo.js')}}"></script>



    <!-- "DataTables" page script to enable its demo functionality -->
    <script src="{{asset('views/pages/page-inbox/@page-script.js')}}"></script>

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



