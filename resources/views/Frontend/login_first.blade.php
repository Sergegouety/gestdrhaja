<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>Reinitialisation de mot de passe</title>

  <!-- Favicons -->
  <link href="{{asset('img/favicon.png')}}" rel="icon">
  <link href="{{asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="{{asset('lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <!--external css-->
  <link href="{{asset('lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="{{asset('css/style.css')}}" rel="stylesheet">
  <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet">

  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->
</head>

<body>
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
  <div id="login-page">
    <div class="container">
      <div style="text-align: center;">
      <h1 style="font-size: 82px; color: #f8941e;">GEST - DRHAJA</h1>
      <span style="font-size: 22px; color:#00a650;"><strong>BIENVENUE SUR L'APPLICATION DE GESTION <br>DE LA DRHAJA DE L'AGENCE EMPLOI JEUNES</strong></span>
    </div>
      <form autocomplete="off" class="form-login" method="POST" action="{{ route('new.password') }}">
         {{ csrf_field() }}

         @if (session('success'))
             <div class="form-group ">
              <div class="col-xs-12">
                <div class="alert alert-success">
                       {{ session('success') }}
                </div>
              </div>
            </div>
        @endif
         @if (session('error'))
             <div class="form-group ">
              <div class="col-xs-12">
                <div class="alert alert-danger">
                       {{ session('error') }}
                </div>
              </div>
            </div>
        @endif
        
        <h2 class="form-login-heading">Réinitialiser votre mot de passe</h2>

        <input type="hidden" name="user_id" value="{{ $agent->id }}">

        <div class="login-wrap">
        <!--   <input type="email" name="email" class="form-control" placeholder="mail" autofocus>
          <br> -->
         <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email ?? old('email') }}" required autocomplete="email" autofocus>
           @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>

                </span>
            @enderror
            <br><strong>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Nouveau mot de passe" onkeyup="validatePassword(this.value)">
                <br/>
                <span style="display: block; color:red" id="non_majuscule">
                        <input type="checkbox" ><label>Au moins une lettre Majuscule</label>
                </span>
                <span style="display: none; color:green" id="majuscule">
                        <input type="checkbox"  checked><label>Au moins une lettre Majuscule</label>
                </span>
                <br/>
                <span style="display: block; color:red" id="non_chiffre">
                        <input type="checkbox"><label>Au moins 1 chiffre</label>
                </span>
                <span style="display: none; color:green" id="chiffre">
                        <input type="checkbox"  checked><label>Au moins 1 chiffre</label>
                </span>
                <br/>
                <span style="display: block; color:red" id="non_longueur">
                        <input type="checkbox"><label>Au moins 8 carractères</label>
                </span>
                <span style="display: none; color:green" id="longueur">
                        <input type="checkbox"  checked><label>Au moins 8 carractères</label>
                </span>


            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </strong>

            <br>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmer mot de passe" onkeyup="activeSubmit()">
            <span style="display: none; color:red" id="pwdrepeat">
             <label>Repetez le mot de passe svp !</label>
        </span>

          <hr>
          <button type="submit" class="btn" style="background-color: #f8941e; color: white" disabled id="btn_submit">
            {{ __('Réinitialiser votre mot de passe') }}
        </button>
          <hr>

          <div style="text-align: center;">
         <img src="{{asset('img/logo_aej.png')}}" class="img-circle" width="120">
         </div>

        </div>

      </div>


      </form>

    </div>
  </div>

  <!-- js placed at the end of the document so the pages load faster -->
  <script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('lib/bootstrap/js/bootstrap.min.js')}}"></script>
  <!--BACKSTRETCH-->
  <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  <script type="text/javascript" src="{{asset('lib/jquery.backstretch.min.js')}}"></script>
  <script>
    $.backstretch("{{asset('img/login-bg.jpg')}}", {
      speed: 500
    });

    function validatePassword(password) {


                                         // Au moins une lettre majuscule
                                        if (!/[A-Z]/.test(password)) { $('#majuscule').css("display","none");$('#non_majuscule').css("display","block");}else{$('#majuscule').css("display","block");$('#non_majuscule').css("display","none");}

                                        // Au moins un chiffre
                                        if (!/\d/.test(password)) { $('#chiffre').css("display","none");$('#non_chiffre').css("display","block");}else{$('#chiffre').css("display","block");$('#non_chiffre').css("display","none");}

                                         //Minimum 8 caractères
                                        if (password.length < 8) { $('#longueur').css("display","none");$('#non_longueur').css("display","block");}else{$('#longueur').css("display","block");$('#non_longueur').css("display","none");}

                                        if (!/^(?=.*[A-Z])(?=.*\d).{8,}$/.test(password)) { $('#password-confirm').attr('disabled','true')}else{ $('#password-confirm').removeAttr('disabled');}


                                        }

function activeSubmit() {
//alert('test');
                        var password_confirmation = $('#password-confirm').val();
                        var password_new = $('#password').val();

                        if(password_confirmation == password_new){$('#btn_submit').removeAttr('disabled'); $('#pwdrepeat').css("display","none");}

                       }


  </script>
</body>

</html>
