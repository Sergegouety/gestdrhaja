@extends('Templates.master_com')

@section('titre')
    Articles - Liste
@endsection

@php
$active="active";
$open="open";
$d="dashboard#";
$page="communication";
$sm="dash";
@endphp

@section('content')
            <div class="row mt">
              <div class="col-md-12" style="background-color: white; color:#F8941E;">
                <marquee direction="scroll">
                  @foreach($articles_rh as $article_rh)
                    <strong>(DRH) {{$article_rh->titre}}: </strong> {{$article_rh->resume}}.
                  @endforeach

                  @foreach($articles_nl as $article_nl)
                    <strong>(Newsletter) {{$article_nl->titre}}: </strong> {{$article_nl->resume}}.
                  @endforeach

                  @foreach($articles_mutuel as $article_mutuel)
                    <strong>(Mutuelle) {{$article_mutuel->titre}}: </strong> {{$article_mutuel->resume}}.
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
             
            </div>
            <br>
  
            <!-- /row -->
            <div class="row">
             <!-- /Communication DRH -->
             @foreach($articles as $article)
             @php
             if($article->article_type==1){$bk_image=asset('img/new_Info.jpg');}else{
               $image1=getImagePrincipale($article->id);
               //dd($image1);
                   if($image1){
                    $bk_image=asset('docs/'.$image1->image_file);
                              }else{
                                $bk_image=asset('img/default.png');
                              }
                      $contenu=strip_tags($article->contenu);
               
             }
             
             
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
                    
                      @if($article->article_type==1)
                      <!-- <div class="badge badge-popular"> DRH </div> -->
                      @elseif($article->article_type==2) 
                      <div class="badge badge-hot">Newsletter</div>
                      @elseif($article->article_type==3) 
                      <div class="badge badge-popular">Mutuelle</div>
                      @endif

                    @if($article->article_type==4) 
                    <div class="btn btn-warning">{{getInstanceName('users','id',$article->user_id,'nomprenoms')}}</div>
                    @endif
                    <div class="blog-title" style="width: 92%;">{{$article->titre}}</div>
                  </div>
                  <div class="blog-text">
                    <p>{{substr($contenu,0,160)}} <a href="{{route('detail.article',$article->id)}}">Lire +</a></p>
                  </div>
                </div>
              </div>
              @endforeach

            </div>
             
@endsection