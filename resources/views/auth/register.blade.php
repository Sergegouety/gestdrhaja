@extends('frontend.layout.main')
@section('content')
    <!--====== BANNER ==========-->
    <section>
       <!-- Breadcrumbs Start -->
            <div class="rs-breadcrumbs img1" style="background: url('{{ asset('frontend/assets/images/guichet1/image-connexion.png') }}');">
                <div class="container">
                    <div class="breadcrumbs-inner">
                        <h1 class="page-title">
                         Création de compte
                        </h1>
                        <span class="sub-text">
                            C'est gratuit et ça le sera toujours.
                       </span>
                        <ul class="breadcrumbs-area">
                           <li title="Accueil">
                               <a class="active"  href="{{url('/')}}">Accueil</a>
                           </li>
                          <li>Création de compte</li>
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
                        <div class="requset-contact">
                            <div class="sec-title mb-40 md-mb-30" style="text-align: center;">
                                <h2 class="title title2">
                                   Création de compte
                                </h2>
                            </div>
                            @include('inc.message')
                            @include('inc.flash')
                            <form class="col s12 ess-form-register" action="{{ route('user.storeDemandeur') }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                <div class="row" style="text-align: center;">
                                     <div class="col-lg-2 col-sm-6 mb-30">
                                     </div>
                                     <div class="col-lg-8 col-sm-6 mb-30">
                                        <span class="wpcf7-form-control-wrap">
                                            <input type="text" id="matriculeaej" name="email" placeholder="Numéro AEJ ou numéro téléphone" required="">
                                        </span>
                                     </div>
                                     <div class="col-lg-2 col-sm-6 mb-30">
                                     </div>
                                </div>
                                <div class="row" style="text-align: center;">
                                    <div class="col-lg-2 col-sm-6 mb-30">
                                     </div>
                                    <div class="col-lg-8 col-sm-6 mb-30">
                                        <button id="verif_aej" class="btn-numeroaej">
                                            Verifier numéro AEJ ou numéro Téléphone
                                        </button>
                                    </div>
                                     <div class="col-lg-2 col-sm-6 mb-30" style="">
                                     </div>
                                </div>

                                <div id="bottomloader" style="display: none; text-align: center; color:#00a650;">
                                    Vérification en cour ...
                                </div>

                                <div id="check-aej-matricule" style="display: none">
                                    <div class="row">
                                        <input type="hidden" name="matricule_aej" id="matricule_aej">
                                        <input type="hidden" name="sexe" id="sexe">
                                        <input type="hidden" name="age" id="age">
                                        <div class="col-lg-6 col-sm-6 mb-30">
                                            <label>Nom</label>
                                            <span class="wpcf7-form-control-wrap">
                                                <input type="text" id="nom" name="nom" required="" readonly>
                                            </span>
                                        </div>

                                        <div class="col-lg-6 col-sm-6 mb-30">
                                            <label>Prénom (s)</label>
                                            <span class="wpcf7-form-control-wrap">
                                                <input type="text" id="prenom" name="prenom" required="" readonly>
                                            </span>
                                        </div>

                                        <div class="col-lg-6 col-sm-6 mb-30">
                                            <label>Téléphone</label>
                                            <span class="wpcf7-form-control-wrap">
                                                <input type="text" id="telephone" name="telephone" required="" readonly>
                                            </span>
                                        </div>

                                        <div class="col-lg-6 col-sm-6 mb-30">
                                            <label>Numéro CMU</label>
                                            <span class="wpcf7-form-control-wrap">
                                                <input type="text" id="numerocmu" name="numerocmu" placeholder="N° CMU">
                                            </span>
                                        </div>

                                        <div class="col-lg-6 col-sm-6 mb-30">
                                            <label>Joindre votre carte CMU</label>
                                            <span class="wpcf7-form-control-wrap">
                                                <input type="file" id="cartecmu" name="cartecmu" placeholder="Joindre votre carte CMU">
                                            </span>
                                        </div>

                                        <div class="col-lg-6 col-sm-6 mb-30">
                                                <label>Type pièces : <span style="color:rgb(243, 79, 79)">*</span></label>
                                                <span class="wpcf7-form-control-wrap">
                                                {!! Form::select('typepieceidentite_id', $typepieces, null, [
                                                    'placeholder' => 'Selectionner Type pièces',
                                                    'data-msg' => 'Veuiller renseigner type pièces',
                                                    'class' => 'ess-is-required',
                                                    'id' => 'typepieceidentite_id'
                                                ]) !!}
                                                </span>
                                        </div>
                                         <div class="col-lg-6 col-sm-6 mb-30">
                                            <label>Numéro pièce d'identité <span style="color:rgb(243, 79, 79)">*</span> </label>
                                            <span class="wpcf7-form-control-wrap">
                                                <input type="text"  data-msg="Veuiller renseigner numéro pièce" class="ess-is-required" id="numeropiece" name="numeropiece" placeholder="N° pièce d'identité">
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-30">
                                            <label>Joindre votre pièce d'identité<span style="color:rgb(243, 79, 79)">*</span> </label>
                                            <span class="wpcf7-form-control-wrap">
                                                <input type="file" id="filepiece" data-msg="Veuiller joindre une pièce d'identité" class="ess-is-required" name="filepiece" placeholder="Joindre votre pièce d'identité">
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-30">
                                            <label>Adresse mail <span style="color:rgb(243, 79, 79)">*</span></label>
                                            <span class="wpcf7-form-control-wrap">
                                                <input type="text" id="email" data-msg="Veuiller saisir un mail valide" name="email"  class="ess-is-required" placeholder="Adresse mail" required="">
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-30">
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-30">
                                            <label>Mot de passe </label>
                                            <span class="wpcf7-form-control-wrap">
                                                <input type="password" id="password" name="password" placeholder="Mot de passe" required="">
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-30">
                                            <label>Confirmer le mot de passe</label>
                                            <span class="wpcf7-form-control-wrap">
                                                <input type="password" id="password_confirm" name="password_confirm" placeholder="Confirmer le mot de passe" required="">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="services-btn">
                                            <p class="submit-btn">
                                                <button type="submit" class="btn-numeroaej">
                                                    Valider
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </form>
                            <br>
                            <p>
                               Vous avez déjà un compte
                                <a href="{{ route('user.index') }}">
                                    Cliquez ici !!!
                                </a>
				            </p>
                            </div>
                        </div>
                    </div>
            </div>
    </section>
@endsection
@section('js')
<script>
    $(function() {

         $('form').find('button[type="submit"]').attr('disabled', false);

         $('[name="password"], [name="password_confirm"]').on('keyup change', function () {
            if ($('[name="password"]').val() !== $('[name="password_confirm"]').val()) {
                $('#error-message').fadeOut().remove();
                $('<span id="error-message">Les mots de passe ne correspondent pas.</span>').css('color', 'red').insertAfter($('[name="password_confirm"]'));
                $('form').find('button[type="submit"]').attr('disabled', true);
            } else {
                $('#error-message').fadeOut();
                $('form').find('button[type="submit"]').attr('disabled', false);
            }
        });

        $('#verif_aej').click(function () {

                var checkaejmatricule   = $('#check-aej-matricule');
                var aftercheck          = $('#after-check');
                let matricule           = $('#matriculeaej').val();
                var prenom              = $('#prenom');
                var nom                 = $('#nom');
                var telephone           = $('#telephone');
                var email               = $('#email');
                var bottomloader        = $('#bottomloader');
                var verifaej            = $('#verif_aej');
                var numeropiece         = $('#numeropiece');
                var age                 = $('#age');

                bottomloader.fadeIn();
                verifaej.fadeOut();

                 $('#error-message').empty();
                 $('#savenewaej').empty();

               $.ajax({
                    url:"{{ route('user.api') }}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        matricule_aej: matricule
                    },success: function( array ) {
                        //console.log(array);
                        if(array[0]){
                            bottomloader.fadeOut();
                            aftercheck.fadeOut();
                            checkaejmatricule.fadeIn();
                            prenom.val(array[0].prenom);
                            nom.val(array[0].nom);
                            telephone.val(array[0].telephone);
                            email.val(array[0].email);
                            $('#matricule_aej').val(array[0].label);
                            $('#sexe').val(array[0].sexe);
                            numeropiece.val(array[0].numerocni);
                            age.val(array[0].age);
                        } else {
                            console.log(array);
                            verifaej.fadeIn();
                            aftercheck.fadeIn();
                            bottomloader.fadeOut();

                            if(array.matricule == false){
                                $('<span id="error-message">Le numéro AEJ ou le numéro téléphone existe déjà</span>').css('color', 'red').insertAfter($('#matriculeaej'));
                            } else {
                                var span = `<span id="error-message">Le numéro AEJ ou le numéro téléphone n\'existe pas ou vérifier le format.</span>`;
                                var div = `<p id="savenewaej"><a href="https://www.agenceemploijeunes.ci/site/demandeur_inscription">Cliquez ici</a> <span>pour l'obtention d'un numéro AEJ ou d'un numéro téléphone valide </span></p>`;
                                $(span).css('color', 'red').insertAfter($('#matriculeaej'));
                                $(div).css('font-size', '16').insertAfter('#error-message');
                            }

                        }
                    }
                });
        });
    });
</script>
@endsection
