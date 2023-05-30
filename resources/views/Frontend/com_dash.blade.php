@extends('Templates.master_com')

@section('titre')
    Articles - 
@endsection

@php
$active="active";
$open="open";
$d="dashboard#";
$page="communication";
$sm="dash";

$agent_function = Session::get('function_key');

$ob_param=Session::get('ob_param');
$nom=$ob_param['nom'] ?? '';
$datedemande=$ob_param['datedemande'] ?? '';
//dd($nom,$datedemande);
@endphp

@section('stylesheet')


@endsection

@section('content')
             <!--Marquee-->
            <div class="row mt">
              <div class="col-md-12" style="background-color: white; color:#F8941E;">
                <marquee direction="scroll">
                  @foreach($articles_rh as $article_rh)
                    <strong> (DRH)</strong> {{$article_rh->titre}}
                  @endforeach

                  @foreach($articles_nl as $article_nl)
                    <strong> (Newsletter) </strong>  {{$article_nl->titre}}: 
                  @endforeach

                  @foreach($articles_mutuel as $article_mutuel)
                    <strong> (Mutuelle) </strong>  {{$article_mutuel->titre}}: 
                  @endforeach

                   @foreach($mariages as $mariage)
                    <strong> (Mariage) </strong>  {{$mariage->titre}}: 
                  @endforeach

                   @foreach($naissances as $naissance)
                    <strong> (Naissance) </strong>  {{$naissance->titre}}: 
                  @endforeach

                   @foreach($deces as $dec)
                    <strong> (Décès) </strong>  {{$dec->titre}}: 
                  @endforeach

                </marquee>
            </div>
              <!-- SERVER STATUS PANELS -->
             <!--  <div class="col-md-12 col-sm-12 mb">
                  <div class="grey-header">
                   
                  </div>
                  <div id="chartDiv" style="max-width: 740px;height: 400px;margin: 0px auto"></div>
                
              </div> -->
             
            </div>
            <br>

            <div class="row">
             <!-- /Communication DRH -->
@foreach($articles_rh as $article_rh)
             @php
              $image1=getImagePrincipale($article_rh->id);
              $contenu=strip_tags($article_rh->contenu);
             @endphp
             <div class="col-lg-6 col-md-6 col-sm-6 mb">
                <div class="content-panel pn">
                  <div id="blog-bg" 
                  style="background: url({{asset('img/new_Info.jpg')}}) no-repeat center top; 
                          margin-top: -15px;
                          background-attachment: relative;
                          background-position: center center;
                          min-height: 150px;
                          width: 80%;
                          -webkit-background-size: 100%;
                          -moz-background-size: 100%;
                          -o-background-size: 100%;
                          background-size: 100%;
                          -webkit-background-size: cover;
                          -moz-background-size: cover;
                          -o-background-size: cover;
                          background-size: cover;
                        ">
                    <!-- <div class="badge badge-popular">DRH</div> -->
                    <div class="blog-title" style="width: 92%;">{{ $article_rh->titre }}</div>
                  </div>
                  <div class="blog-text">
                    <p>{{ substr($contenu,0,160)}} ...<a href="{{route('detail.article',$article_rh->id)}}">Lire +</a></p>
                    <p><a href="{{route('list.article',$article_rh->article_type)}}">Voir tous</a></p>
                  </div>
                </div>

              </div>
           @endforeach

            <!-- /Communication Deces -->

             @foreach($deces as $dece)
             @php
              $image1=getImagePrincipale($dece->id);
              if($image1){
                    $bk_image=asset('docs/'.$image1->image_file);
                              }else{
                                $bk_image=asset('img/default.png');
                              }
              $contenu=strip_tags($dece->contenu);
             @endphp
              <div class="col-lg-6 col-md-6 col-sm-6 mb">
                <div class="content-panel pn">
                  <div id="blog-bg"
                  style="background: url({{ $bk_image }}) no-repeat center top; 
                          margin-top: -15px;
                          background-attachment: relative;
                          background-position: center center;
                          min-height: 150px;
                          width: 100%;
                          -webkit-background-size: 100%;
                          -moz-background-size: 100%;
                          -o-background-size: 100%;
                          background-size: 100%;
                          -webkit-background-size: cover;
                          -moz-background-size: cover;
                          -o-background-size: cover;
                          background-size: cover;

                        ">
                    <div class="btn btn-danger">DECES</div>
                    <div class="blog-title" style="width: 92%;">{{ $dece->titre}}</div>
                  </div>
                  <div class="blog-text">
                    <p>{{ substr($contenu,0,160)}} ...<a href="{{route('detail.article',$dece->id)}}">Lire +</a></p>
                    <p><a href="{{route('list.article',$dece->article_type)}}">Voir tous</a></p>
                  </div>
                </div>

              </div>
           @endforeach
           
             <!-- /Communication Agent -->

             @foreach($articles_agent as $article_agent)
             @php
              $image1=getImagePrincipale($article_agent->id);
              if($image1){
                    $bk_image=asset('docs/'.$image1->image_file);
                              }else{
                                $bk_image=asset('img/default.png');
                              }
              $contenu=strip_tags($article_agent->contenu);
             @endphp
              <div class="col-lg-6 col-md-6 col-sm-6 mb">
                <div class="content-panel pn">
                  <div id="blog-bg"
                  style="background: url({{ $bk_image }}) no-repeat center top; 
                          margin-top: -15px;
                          background-attachment: relative;
                          background-position: center center;
                          min-height: 150px;
                          width: 100%;
                          -webkit-background-size: 100%;
                          -moz-background-size: 100%;
                          -o-background-size: 100%;
                          background-size: 100%;
                          -webkit-background-size: cover;
                          -moz-background-size: cover;
                          -o-background-size: cover;
                          background-size: cover;

                        ">
                    <div class="btn btn-warning">{{getInstanceName('users','id',$article_agent->user_id,'nomprenoms')}}</div>
                    <div class="blog-title" style="width: 92%;">{{ $article_agent->titre}}</div>
                  </div>
                  <div class="blog-text">
                    <p>{{ substr($contenu,0,160)}} ...<a href="{{route('detail.article',$article_agent->id)}}">Lire +</a></p>
                    <p><a href="{{route('list.article',$article_agent->article_type)}}">Voir tous</a></p>
                  </div>
                </div>

              </div>
           @endforeach

           
             <!-- /Communication News letter -->

             @foreach($articles_nl as $article_nl)
             @php
              $image1=getImagePrincipale($article_nl->id);
              if($image1){
                    $bk_image=asset('docs/'.$image1->image_file);
                              }else{
                                $bk_image=asset('img/default.png');
                              }
              $contenu=strip_tags($article_nl->contenu);
             @endphp
              <div class="col-lg-6 col-md-6 col-sm-6 mb">
                <div class="content-panel pn">
                  <div id="blog-bg"
                  style="background: url({{ $bk_image }}) no-repeat center top; 
                          margin-top: -15px;
                          background-attachment: relative;
                          background-position: center center;
                          min-height: 150px;
                          width: 100%;
                          -webkit-background-size: 100%;
                          -moz-background-size: 100%;
                          -o-background-size: 100%;
                          background-size: 100%;
                          -webkit-background-size: cover;
                          -moz-background-size: cover;
                          -o-background-size: cover;
                          background-size: cover;

                        ">
                    <div class="badge badge-hot">Newsletter</div>
                    <div class="blog-title" style="width: 92%;">{{ $article_nl->titre}}</div>
                  </div>
                  <div class="blog-text">
                    <p>{{ substr($contenu,0,160)}} ...<a href="{{route('detail.article',$article_nl->id)}}">Lire +</a></p>
                    <p><a href="{{route('list.article',$article_nl->article_type)}}">Voir tous</a></p>
                  </div>
                </div>

              </div>
           @endforeach

           
              <!-- /Communication mutuelle -->
@foreach($articles_mutuel as $article_mutuel)
@php
              $image1=getImagePrincipale($article_mutuel->id);
              if($image1){
                    $bk_image=asset('docs/'.$image1->image_file);
                              }else{
                                $bk_image=asset('img/default.png');
                              }
              $contenu=strip_tags($article_mutuel->contenu);
             @endphp
              <div class="col-lg-6 col-md-6 col-sm-6 mb">
                <div class="content-panel pn">
                  <div id="blog-bg"
                  style="background: url({{ $bk_image  }}) no-repeat center top; 
                          margin-top: -15px;
                          background-attachment: relative;
                          background-position: center center;
                          min-height: 150px;
                          width: 100%;
                          -webkit-background-size: 100%;
                          -moz-background-size: 100%;
                          -o-background-size: 100%;
                          background-size: 100%;
                          -webkit-background-size: cover;
                          -moz-background-size: cover;
                          -o-background-size: cover;
                          background-size: cover;
                        ">
                    <div class="badge badge-popular">Mutuelle</div>
                    <div class="blog-title" style="width: 92%;">{{ $article_mutuel->titre}}</div>
                  </div>
                  <div class="blog-text">
                    <p>{{ substr($contenu,0,160)}} ...<a href="{{route('detail.article',$article_mutuel->id)}}">Lire +</a></p>
                    <p><a href="{{route('list.article',$article_mutuel->article_type)}}">Voir tous</a></p>
                  </div>
                </div>
              </div>
@endforeach
             
            </div>
            <!-- /row -->
            
 @endsection