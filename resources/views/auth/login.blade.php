@extends('frontend.layout.main')
@section('content')
    <!--====== BANNER ==========-->
    <section>
       <!-- Breadcrumbs Start -->
            <div class="rs-breadcrumbs img1" style="background: url('{{ asset('frontend/assets/images/guichet1/image-connexion.png') }}');">
                <div class="container">
                    <div class="breadcrumbs-inner">
                        <h1 class="page-title">
                         Connectez-vous
                        </h1>
                        <span class="sub-text">
                            C'est gratuit et ça le sera toujours.
                       </span>
                        <ul class="breadcrumbs-area">
                           <li title="Accueil">
                               <a class="active"  href="{{url('/')}}">Accueil</a>
                           </li>
                          <li>Connexion</li>
                       </ul>
                    </div>
                </div>
            </div>
            <!-- Breadcrumbs End -->
    </section>

    <!--====== TOUR DETAILS ==========-->
    <section>
        <div class="rs-about about-style1 bg1 pt-120 pb-120 md-pt-80 md-pb-80">
                <div class="rs-contact contact-style2">
                    <div class="container">
                        <div class="requset-contact" style="text-align: center;">
                            <div class="sec-title mb-40 md-mb-30">
                                <h2 class="title title2">
                                    Connectez-vous
                                </h2>
                            </div>
                                @include('inc.message')
                                @include('inc.flash')
                            <form class="col s12" action="{{ route('user.login') }}" method="POST" style="text-align: center;">
                                @csrf()
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 mb-30">
                                </div>
                                <div class="col-lg-6 col-sm-6 mb-30">
                                    <span class="wpcf7-form-control-wrap">
                                        <input type="text" id="email" name="email" placeholder="Votre adresse email" required="">
                                    </span>
                                </div>
                                <div class="col-lg-3 col-sm-6 mb-30">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 mb-30">
                                </div>
                                <div class="col-lg-6 col-sm-6 mb-30">
                                    <span class="wpcf7-form-control-wrap">
                                        <input type="password" id="your-address" name="password" placeholder="***************" required="">
                                    </span>
                                </div>
                                <div class="col-lg-3 col-sm-6 mb-30">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="services-btn">
                                        <p class="submit-btn">
                                            <input type="submit" value="Connexion" class="Submit Services Request">
                                        </p>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <br>
                            <p>
                                <a href="{{ route('password.request') }}">
                                    <strong>Mot de passe oublié</strong>
                                </a>
                                | Vous êtes un nouvel utilisateur ?
                                <a href="{{ route('user.enregistrer') }}">
                                    <strong>Enregistrez vous</strong>
                                </a>
                                |
                                <a style="color: blue;" href="https://www.agenceemploijeunes.ci/site/demandeur_inscription">
                                    <strong>Cliquez ici</strong>
                                </a>
                                pour obtenir un numéro AEJ
				            </p>
                            </div>
                        </div>
                    </div>
            </div>
    </section>
@endsection
