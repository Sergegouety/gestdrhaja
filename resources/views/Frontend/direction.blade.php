@extends('Templates.list_master')

@section('titre')
    Direction List - Aej Admin
@endsection

@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="parametre";
$sm="direction";
@endphp

@section('content')
   <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Directions</h3>
         
        <!-- row -->
        <div class="row mt">
          <div class="col-md-12">
            <div class="content-panel">
              <table class="table table-striped table-advance table-hover">
                <h4><i class="fa fa-angle-right"></i> Directions</h4>
                 
                <hr>
                <thead>
                  <tr>
                    <th></th>
                    <th><i class="fa fa-bullhorn"></i> Direction</th>
                    <th class="hidden-phone"><i class="fa fa-question-circle"></i> Description</th>
                    <th><i class="fa fa-bookmark"></i> Directeur</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($directions as $direction)
                  <tr>
                    <td>
                     
                    </td>
                    <td>
                      <a >{{$direction->designation}}</a>
                    </td>
                    <td class="hidden-phone">{{$direction->description}}</td>
                    <td>{{ getResponsableName('direction_id',$direction->id,5) }} </td>
                    
                    <td>
                      <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                      <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                    </td>
                  </tr>
                  @endforeach
                 
                </tbody>
              </table>
            </div>
            <!-- /content-panel -->
          </div>
          <!-- /col-md-12 -->
        </div>
        <!-- /row -->
      </section>
@endsection



