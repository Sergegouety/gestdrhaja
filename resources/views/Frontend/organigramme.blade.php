@extends('Templates.list_master')

@section('titre')
    Organigramme - Aej Admin
@endsection


@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="recherche";
$sm="organigramme";
@endphp


@section('stylesheet')

@endsection

@section('content')
<section class="wrapper">
        <h3><i class="fa fa-angle-right"></i>Organigramme</h3>
         
        <!-- row -->
        <div class="row mt">
          <div class="content-panel">

            <div class="position-relative" align="right" style="padding-right:5px">
                      
                   <img src="{{asset('img/organigramme.png')}}">
                      
            </div>
          </div>
  
        </div>
        <!-- /row -->
      </section>

    @endsection

    @section('scriptjs')
    @endsection