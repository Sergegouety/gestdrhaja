@extends('frontend.layout.main')

@section('css')
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
<section>
		<div class="tr-register">
			<div class="tr-regi-form">
                <div style="text-align: center;">
                    <h4>Connectez-vous</h4>
                    <p>C'est gratuit et ça le sera toujours.</p>
                </div>

                @include('inc.message')
                @include('inc.flash')

				<form class="col s12" action="{{ route('user.login') }}" method="POST">
                    @csrf()
					<div class="row mb-3">
						{{-- <div class="input-field col s12"> --}}
                            <label class="label-control">Email: </label>
							<input type="text" name="email" class="form-control">
						{{-- </div> --}}
					</div>
					<div class="row mb-3">
						{{-- <div class="input-field col s12"> --}}
                            <label class="label-control">Mot de passe: </label>
							<input type="password" name="password" class="form-control">
						{{-- </div> --}}
					</div>
					<div class="row">
						<div class="input-field col s12">
						<input type="submit" value="Connexion" class="btn btn-success btn-block confirm-button"> </div>
					</div>
				</form>
				<p>
                    <a href="{{ route('password.request') }}">mot de passe oublié</a>
                    | Vous êtes un nouvel utilisateur ?
                    <a href="{{ route('user.enregistrer') }}">
                        Enregistrez vous
                    </a>
				</p>
            </div>
		</div>
	</section>
@endsection
@section('js')
<script>

</script>
@endsection
