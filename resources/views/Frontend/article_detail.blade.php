@extends('Templates.master_com')

@section('titre')
    Articles - Detail
@endsection

@php
$active="active";
$open="open";
$d="dashboard#";
$page="communication";
$sm="dash";
@endphp

@section('content')
        <h3><i class="fa fa-angle-right"></i>{{$article->titre}}</h3>
       <br>
       @if($article->article_type!=1)
       @php
       if($image1){$image1_=asset('docs/'.$image1->image_file);}else{$image1_=asset('img/default.png');}
       if($image2){$image2_=asset('docs/'.$image2->image_file);}else{$image2_=asset('img/default.png');}
       @endphp
       @if($image1)
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
             <!--  <li data-target="#myCarousel" data-slide-to="1"></li> -->
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
             
              <div class="item active">
                <img src="{{ $image1_ }}">
              </div>
              <!-- <div class="item">
                <img src="{{ $image2_ }}" >
              </div> -->
              
            </div>

            <!-- Left and right controls -->
            <!-- <a class="left carousel-control" href="#myCarousel" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
              <span class="sr-only">Précedent</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <span class="sr-only">Suivant</span>
            </a> -->
        </div>
      @endif
      @endif

          <div class="showback">
              <h3><i class="fa fa-angle-right"></i>{{$article->titre}}</h3>
              <p>Publié le : {{format_date($article->created_at)}}</p>
              <p>
                 
                 @if($fichierjoint)
                 <embed src="{{asset('docs/'.$fichierjoint->image_file)}}" height=460 type='application/pdf'/>
                @endif
               
              </p>
               <br>
               <textarea class="wysihtml5 form-control" rows="9" >{{strip_tags($article->contenu)}}</textarea>
              
               
            </div>

 @endsection
