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
      <form autocomplete="off" class="form-login" method="POST" action="{{ route('password.update') }}">
         {{ csrf_field() }} 
        <h2 class="form-login-heading">Réinitialiser votre mot de passe</h2>

        <input type="hidden" name="token" value="{{ $token }}">
        
        <div class="login-wrap">
        <!--   <input type="email" name="email" class="form-control" placeholder="mail" autofocus>
          <br> -->
         <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
           @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <br><strong><input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Nouveau mot de passe">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror</strong>

            <br>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmer mot de passe">
          
          <hr>
          <button type="submit" class="btn" style="background-color: #f8941e; color: white">
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
  </script>
</body>

</html>
