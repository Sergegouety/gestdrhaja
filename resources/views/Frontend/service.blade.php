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
$sm="service";
@endphp

@section('content')
   <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Service</h3>
         
        <!-- row -->
        <div class="row mt">
          <div class="col-md-12">
            <div class="content-panel">
              <table class="table table-striped table-advance table-hover">
                <h4><i class="fa fa-angle-right"></i> Service</h4>
                 
                <hr>
                <thead>
                  <tr>
                    <th></th>
                     <th><i class="fa fa-bullhorn"></i>  Service</th>
                    <th><i class="fa fa-bullhorn"></i>  Sous-Direction</th>
                    <th class="hidden-phone"><i class="fa fa-question-circle"></i> Direction</th>
                    <th><i class="fa fa-bookmark"></i> Responsable</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($services as $service)
                  <tr>
                    <td>
                     
                    </td>
                    <td>
                        <span class="text-105">
                           {{$service->designation}}
                        </span>
                      </td>
                    <td>
                      @if($service->sousdirection_id)
                        {{ getInstanceName('sousdirection','id',$service->sousdirection_id,'designation') }}
                        @endif
                    </td>
                    <td class="hidden-phone">
                       @if($service->direction_id)
                        {{ getInstanceName('direction','id',$service->direction_id,'designation') }}
                        @endif
                    </td>
                    <td> {{ getResponsableName('service_id',$service->id,2) }} </td>
                    
                    <td>
                    <!--   <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                      <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button> -->
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