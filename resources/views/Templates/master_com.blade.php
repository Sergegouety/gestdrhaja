<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>@yield('titre')</title>

  <!-- Favicons -->
  <link href="i{{asset('mg/favicon.png')}}" rel="icon">
  <link href="{{asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="{{asset('lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <!--external css-->
  <link href="{{asset('lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="{{asset('css/zabuto_calendar.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('lib/gritter/css/jquery.gritter.css')}}" />
  <!-- Custom styles for this template -->
  <link href="{{asset('css/style.css')}}" rel="stylesheet">
  <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet">
  <script src="{{asset('lib/chart-master/Chart.js')}}"></script>
 @yield('stylesheet')
  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->
</head>

<body>
  <section id="container">
    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header orange-bg">
      <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
      <!--logo start-->
      <a href="#" class="logo"><b>DRH<span>AJA</span></b></a>
      <!--logo end-->
      @include('Templates.notification')
      <div class="top-menu">
        <ul class="nav pull-right top-menu">
           <li><a class="logout" href="{{ route('Logout') }}">Deconnexion</a></li>
        </ul>
      </div>
    </header>
    <!--header end-->
    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    @include('Templates.aside')
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-9 main-chart">
            <!-- /Content -->
             @yield('content')
            <!-- /Content -->
          </div>

          <!-- Anniversaires -->
          <div class="col-lg-3 ds" style="background-color: white;">
            <h4 class="centered mt btn btn-primary">ANNIVERSAIRE(S) DU JOUR</h4>
            <!-- First Activity -->

            @if(count($anniversaires)>0)
            @foreach($anniversaires as $anniversaire)
            <?php 
              if($anniversaire->sousdirection_id != 0){ $sd= getInstanceName('sousdirection','id',$anniversaire->sousdirection_id,'designation') ;} else{ $sd='';}
              ?>
             <div class="desc">
              <div class="thumb">
                <img class="img-circle" src="{{asset('img/cake.png')}}" width="35px" height="35px" align="">
              </div>
              <div class="details">
                <p>
                  <a >{{$anniversaire->nomprenoms}}</a><br/>
                  <a >{{$anniversaire->telephone1}}</a><br/>
                  <strong>{{$anniversaire->fonction}}</strong><br/>
                  <a><strong>{{$sd}}</strong></a>
                  
                </p>
              </div>
            </div>
            @endforeach
            @else
            <div class="desc">
              <div class="thumb">
                <img class="img-circle" src="{{asset('img/cake.png')}}" width="35px" height="35px" align="">
              </div>
              <div class="details">
                <p>
                  <a ></a><br/>
                  <strong>Aucun anniversaire ce jour</strong><br/>
                  <a ></a>
                </p>
              </div>
            </div>
            
            @endif

            @if(count($mariages)>0)
             <h4 class="centered mt btn btn-warning" >MARIAGE(S)</h4>
            <!-- First Activity -->
           
            @foreach($mariages as $mariage)
             <div class="desc">
              <div class="thumb">
                <img class="img-circle" src="{{asset('img/user.png')}}" width="35px" height="35px" align="">
              </div>
              <div class="details">
                <p>
                  <a >{{$mariage->titre}}</a><br/>
                  <strong>{{$mariage->contenu}}</strong><br/>
                </p>
              </div>
            </div>
            @endforeach
            @endif

            @if(count($naissances)>0)
            <h4 class="centered mt btn btn-success">NAISSANCE(S)</h4>
            <!-- First Activity -->
            @foreach($naissances as $naissance)
             <div class="desc">
              <div class="thumb">
                <img class="img-circle" src="{{asset('img/user.png')}}" width="35px" height="35px" align="">
              </div>
              <div class="details">
                <p>
                  <a >{{$naissance->titre}}</a><br/>
                  <strong>{{$naissance->contenu}}</strong><br/>
                </p>
              </div>
            </div>
            @endforeach
            @endif
             
             @if(count($deces)>0)
            <h4 class="centered mt btn btn-danger">DECES</h4>
            <!-- First Activity -->
            @foreach($deces as $dec)
             <div class="desc">
              <div class="thumb">
                <img class="img-circle" src="{{asset('img/user.png')}}" width="35px" height="35px" align="">
              </div>
              <div class="details">
                <p>
                  <a >{{$dec->titre}}</a><br/>
                  <strong>{{$dec->contenu}}</strong><br/>
                </p>
              </div>
            </div>
            @endforeach
            @endif

             <h4 class="centered mt btn btn-info">ANNIVERSAIRE(S) DU MOIS</h4>
            <!-- First Activity -->
            @foreach($monthanniversaires as $monthanniversaire)
             <div class="desc">
              <div class="thumb">
                <img class="img-circle" src="{{asset('img/cake.png')}}" width="35px" height="35px" align="">
              </div>
              <div class="details">
                <p>
                  <a >{{$monthanniversaire->nomprenoms}}</a><br/>
                  <muted>{{$monthanniversaire->fonction}}</muted><br/>
                  <a >{{$monthanniversaire->telephone1}}</a>
                </p>
              </div>
            </div>
            @endforeach
            <!-- CALENDAR-->
            <!-- <div id="calendar" class="mb">
              <div class="panel green-panel no-margin">
                <div class="panel-body">
                  <div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
                    <div class="arrow"></div>
                    <h3 class="popover-title" style="disadding: none;"></h3>
                    <div id="date-popover-content" class="popover-content"></div>
                  </div>
                  <div id="my-calendar"></div>
                </div>
              </div>
            </div> -->
            <!-- / calendar -->
          </div>
          <!-- /col-lg-3 -->
        </div>
        <!-- /row -->
      </section>
    </section>
    <!--main content end-->
    <!--footer start-->
    <footer class="site-footer">
      <div class="text-center">
        <p>
          &copy; Copyright <strong>Agence Emploi Jeunes 2021</strong>. Tous droits reservés
        </p>
        <div class="credits">
         
        </div>
        <a href="index.html#" class="go-top">
          <i class="fa fa-angle-up"></i>
          </a>
      </div>
    </footer>
    <!--footer end-->
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="{{asset('lib/jquery/jquery.min.js')}}"></script>

  <script src="{{asset('lib/bootstrap/js/bootstrap.min.js')}}"></script>
  <script class="include" type="text/javascript" src="{{asset('lib/jquery.dcjqaccordion.2.7.js')}}"></script>
  <script src="{{asset('lib/jquery.scrollTo.min.js')}}"></script>
  <script src="{{asset('lib/jquery.nicescroll.js')}}" type="text/javascript"></script>
  <script src="{{asset('lib/jquery.sparkline.js')}}"></script>
  <!--common script for all pages-->
  <script src="{{asset('lib/common-scripts.js')}}"></script>
  <script type="text/javascript" src="{{asset('lib/gritter/js/jquery.gritter.js')}}"></script>
  <script type="text/javascript" src="{{asset('lib/gritter-conf.js')}}"></script>
  <!--script for this page-->
  <script src="{{asset('lib/sparkline-chart.js')}}"></script>
  <script src="{{asset('lib/zabuto_calendar.js')}}"></script>
  <script src="https://code.jscharting.com/latest/jscharting.js"></script>
  
  <script src="lib/sparkline-chart.js"></script>
  <script src="lib/zabuto_calendar.js"></script>
  <script src="{{asset('lib/raphael/raphael.min.js')}}"></script>
  <script src="{{asset('lib/morris/morris.min.js')}}"></script>
  
  <script type="application/javascript">
    $(document).ready(function() {
      $("#date-popover").popover({
        html: true,
        trigger: "manual"
      });
      $("#date-popover").hide();
      $("#date-popover").click(function(e) {
        $(this).hide();
      });

      $("#my-calendar").zabuto_calendar({
        action: function() {
          return myDateFunction(this.id, false);
        },
        action_nav: function() {
          return myNavFunction(this.id);
        },
        ajax: {
          url: "show_data.php?action=1",
          modal: true
        },
        legend: [{
            type: "text",
            label: "Special event",
            badge: "00"
          },
          {
            type: "block",
            label: "Regular event",
          }
        ]
      });
    });

    function myNavFunction(id) {
      $("#date-popover").hide();
      var nav = $("#" + id).data("navigation");
      var to = $("#" + id).data("to");
      console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
    }
  </script>
  <script type="text/javascript">
    
    $(document).ready(function() {
      var unique_id = $.gritter.add({
        // (string | mandatory) the heading of the notification
        title: 'La Direction des Ressources Humaines et des Affaires Juridiques et Administratives',
        // (string | mandatory) the text inside the notification
        text: 'souhaite un JOYEUX ANNIVERSAIRE au(x) collaborateur(s) :',
        // (bool | optional) if you want it to fade out on its own or just sit there
        sticky: false,
        // (int | optional) the time you want it to be alive for before fading out
        time: 10000,
        // (string | optional) the class name you want to apply to that specific message
        class_name: 'my-sticky-class'
      });
@foreach($anniversaires as $anniversaire)
<?php 
if($anniversaire->sousdirection_id != 0){ 
  $sd= getInstanceName('sousdirection','id',$anniversaire->sousdirection_id,'designation');
   } else{ $sd='';}
  $nom=addslashes($anniversaire->nomprenoms);
?>
      var unique_id = $.gritter.add({
        // (string | mandatory) the text inside the notification
        text: '<strong>{{$nom}}</strong><br/>{{$anniversaire->fonction}}<br/><a>{{$anniversaire->telephone1}}</a>',
         // (string | optional) the image to display on the left
        image: "{{asset('img/cake.png')}}",
        // (bool | optional) if you want it to fade out on its own or just sit there
        sticky: false,
        // (int | optional) the time you want it to be alive for before fading out
        time: 10000,
        // (string | optional) the class name you want to apply to that specific message
        class_name: 'my-sticky-class'
      });
@endforeach
      return false;
    });
  </script>
  @yield('scriptjs')
</body>

</html>
