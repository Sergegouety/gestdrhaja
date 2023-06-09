<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>Gestion - DRHAJA</title>

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
  <style type="text/css">
    body {
 /* background-image: url("img/login1.png"); /* The image used */
 /* background-position: center; /* Center the image */
 /* background-repeat: no-repeat; /* Do not repeat the image */
 /* background-size: cover; /* Resize the background image to cover the entire container */*/
}
  </style>

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
     <!--  <div style="text-align: center;">
      <h1 style="font-size: 82px; color: #f8941e;">GEST - DRHAJA</h1>
      <span style="font-size: 22px; color:#00a650;"><strong>BIENVENUE SUR L'APPLICATION DE GESTION <br>DE LA DRHAJA DE L'AGENCE EMPLOI JEUNES</strong></span>
    </div> -->
      <form autocomplete="off" class="form-login" method="post" action="{{ route('doLog') }}">
         {{ csrf_field() }}
        <h2 class="form-login-heading">Connexion</h2>
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


        <div class="login-wrap">
          <input type="email" name="email" class="form-control" placeholder="mail" autofocus>
          <br>
          <input type="password" name="password" class="form-control" placeholder="mot de passe">
          <br>
          {!! Captcha::img() !!}
         <input type="text" id="captcha" name="captcha" placeholder="Captcha" required>


          <hr>
          <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i> Se connecter</button>
          <hr>

          <a class="btn btn-warning btn-block" href="{{ route('password.request') }}" style="text-decoration: none; color: white;">
                    <strong>Mot de passe oublié</strong>
                </a>

        </div>

        <div style="text-align: center;">
         <img src="{{asset('img/logo_aej.png')}}" class="img-circle" width="120">
         </div>

      </form>

    </div>
  </div>


  <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <!--BACKSTRETCH-->
  <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  <script type="text/javascript" src="lib/jquery.backstretch.min.js"></script>
  <script>
    $.backstretch("img/login.png", {
      speed: 500,
    });

  </script>
</body>

</html>
