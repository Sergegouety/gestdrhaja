@extends('frontend.layout.main')
@section('css')
{{-- formulaire custom --}}
    <style>
        .mb-3 {
            margin-bottom: 1.6rem !important;
        }

        .mb-9 {
            margin-bottom: 5rem !important;
        }

        .mt-9 {
            margin-top: 5rem !important;
        }

        label.radio {
            cursor: pointer;
            width: 100%
        }

        label.radio input {
            position: absolute;
            top: 0;
            left: 0;
            visibility: hidden;
            pointer-events: none
        }

        label.radio span {
            padding: 7px 14px;
            border: 2px solid #eee;
            display: inline-block;
            color: #039be5;
            border-radius: 10px;
            width: 100%;
            height: 48px;
            line-height: 27px
        }

        label.radio input:checked+span {
            border-color: #039BE5;
            background-color: #81D4FA;
            color: #fff;
            border-radius: 9px;
            height: 48px;
            line-height: 27px
        }

        .form-control {
            margin-top: 10px;
            height: 48px;
            border: 2px solid #eee;
            border-radius: 10px
        }

        .form-control:focus {
            box-shadow: none;
            border: 2px solid #039BE5
        }

        .agree-text {
            font-size: 12px
        }

        .terms {
            font-size: 12px;
            text-decoration: none;
            color: #039BE5
        }

        .confirm-button {
            height: 50px;
            border-radius: 10px
        }
    </style>
@endsection
@section('content')
<!--DASHBOARD-->
	<section>
		<div class="tr-register">
			<div class="tr-regi-form">
                <div style="text-align: center;">
                    <h4>Création de compte</h4>
                    <p>C'est gratuit et ça le sera toujours.</p>
                </div>
                    @include('inc.message')
                    @include('inc.flash')
				<form class="col s12" action="{{ route('user.storeDemandeur') }}" method="POST" enctype="multipart/form-data" >
                        @csrf()
                    <div id="after-check">
                        <div class="label-control mb-3">
                            <label>Identifier :</label>
							<input type="text" class="form-control" id="matriculeaej" placeholder="numéro AEJ ou numéro Téléphone">
                        </div>
                        <div class="row">
                            <div class="input-field col-md-12 s12 align-left">
                                <button id="verif_aej" type="button" class="btn btn-warning btn-block confirm-button">
                                    Verifier numéro AEJ ou numéro Téléphone
                                </button>
                                {{-- <input type="button" id="verif_aej" value="Verifier AEJ" class="waves-effect waves-light btn-large full-btn"> --}}
                            </div>
					    </div>
                        <div id="bottomloader" style="display: none;">
                        </div>
                    </div>

					<div id="check-aej-matricule" style="display: none">
                    <div class="row">
                        <input type="hidden" name="matricule_aej" id="matricule_aej">
                        <input type="hidden" name="sexe" id="sexe">
						<div class="input-field col m6 s12 mb-3">
                            <label>Prénom <span style="color:red">*</span>:</label>
							<input type="text" name="prenom" class="form-control" id="prenom">
						</div>
						<div class="input-field col m6 s12 mb-3">
                            <label>Nom de famille <span style="color:red">*</span>:</label>
							<input type="text" name="nom" class="form-control" id="nom">
						</div>
					</div>

					<div class="row mb-3">
						<div class="input-field col s12">
                            <label>Téléphone mobile <span style="color:red">*</span>:</label>
							<input type="number" name="telephone" class="form-control" id="telephone">
						</div>
					</div>
                    <div class="row mb-3">
                        <div class="input-field col s12">
                            <label>N° CMU</label>
                            <input type="text" name="numerocmu" class="form-control" id="numerocmu">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="input-field col s12">
                            <label>Carte CMU</label>
                            <input type="file" name="cartecmu" class="form-control" id="cartecmu">
                        </div>
                    </div>
					<div class="row mb-3">
						<div class="input-field col s12">
                            <label>Email</label>
							<input type="email" name="email" class="form-control" id="email">

						</div>
					</div>
					<div class="row mb-3">
						<div class="input-field col s12">
                            <label>Mot de passe <span style="color:red">*</span>:</label>
							<input type="password" name="password" class="form-control" id="password">
						</div>
					</div>
					<div class="row mb-9">
						<div class="input-field col s12">
                            <label>Confirmer le mot de passe <span style="color:red">*</span>:</label>
							<input type="password" name="password_confirm" class="form-control" id="password_confirm">
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
                           {{--  <button class="btn btn-primary btn-block confirm-button">Confirm</button> --}}
							<input type="submit" value="Valider" class="btn btn-success btn-block confirm-button">
                        </div>
					</div>
                    </div>
				</form>
				<p>
                    Vous êtes déjà membre ?<a href="{{ route('user.index') }}"> Se connecter</a>
				</p>
			</div>
		</div>
	</section>
	<!--END DASHBOARD-->
@endsection
@section('js')
<script>
    $(function() {

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

                bottomloader.fadeIn();
                verifaej.fadeOut();

               $.ajax({
                    url:"{{ route('user.api') }}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        matricule_aej: matricule
                    },success: function( array ) {
                        //console.log(array);
                        if(array){
                            bottomloader.fadeOut();
                            aftercheck.fadeOut();
                            checkaejmatricule.fadeIn();
                            prenom.val(array[0].prenom);
                            nom.val(array[0].nom);
                            telephone.val(array[0].telephone);
                            email.val(array[0].email);
                            $('#matricule_aej').val(array[0].label);
                            $('#sexe').val(array[0].sexe);
                        } else {
                            console.log("error");
                            verifaej.fadeIn();
                            aftercheck.fadeIn();
                            bottomloader.fadeOut();
                             $('<span id="error-message">Le numéro AEJ n\'existe pas par où vérifier le format.</span>').css('color', 'red').insertAfter($('#matriculeaej'));
                        }
                    }
                });
        });
    });
</script>
@endsection
