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
$sm="sousdirection";
@endphp

@section('content')
   <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Sous-Directions</h3>
         
        <!-- row -->
        <div class="row mt">
          <div class="col-md-12">
            <div class="content-panel">
              <table class="table table-striped table-advance table-hover">
                <h4><i class="fa fa-angle-right"></i> Sous-Directions</h4>
                 
                <hr>
                <thead>
                  <tr>
                    <th></th>
                    <th><i class="fa fa-bullhorn"></i>  Sous-Direction</th>
                    <th class="hidden-phone"><i class="fa fa-question-circle"></i> Direction</th>
                    <th><i class="fa fa-bookmark"></i> Responsable</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                 @foreach($sousdirections as $sousdirection)
                  <tr>
                    <td>
                     
                    </td>
                    <td>
                      <a >{{$sousdirection->designation}}</a>
                    </td>
                    <td class="hidden-phone">
                       @if($sousdirection->direction_id)
                        {{ getInstanceName('direction','id',$sousdirection->direction_id,'designation') }}
                        @endif
                    </td>
                    <td> {{ getResponsableName('sousdirection_id',$sousdirection->id,4) }} </td>
                    
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