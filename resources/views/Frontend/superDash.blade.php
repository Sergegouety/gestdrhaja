@extends('Templates.master')

@section('titre')
    Dashboard - Aej Admin
@endsection

@php
$active="active";
$open="open";
$d="dashboard#";
$page="dashboard";
$sm="";
@endphp

@section('stylesheet')
 <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
  <script src="lib/chart-master/Chart.js"></script>
@endsection

@section('content')
<section class="wrapper">
        <div class="row">
          <div class="col-lg-12 main-chart">
                   <!-- /row -->
            <div class="row">
             <div class="col-lg-7">
              <div class="content-panel">
                <h4><i class="fa fa-angle-right"></i> ETAT DU PERSONNEL PAR DIRECTION ET CABINET</h4>
                <div class="panel-body">
                  <div id="hero-bar" class="graph"></div>
                </div>
              </div>
            </div>

             <div class="col-lg-5">
              <div class="content-panel">
                <h4><i class="fa fa-angle-right"></i> ETAT DU PERSONNEL PAR CATEGORIE</h4>
                <div class="panel-body">
                  <div id="hero-donut" class="graph"></div>
                </div>
              </div>
            </div>
          
            </div>
<br>

           <div class="row">
             <div class="col-lg-12">
              <div class="content-panel">
                <h4><i class="fa fa-angle-right"></i> ETAT DU PERSONNEL PAR AGENCE REGIONALE</h4>
                <div class="panel-body">
                  <div id="hero-bar2" class="graph"></div>
                </div>
              </div>
            </div>
          
            </div>
<br>
            <!--custom chart end-->
            <div class="row mt">
              <!-- SERVER STATUS PANELS -->
              <div class="col-lg-6">
              <div class="content-panel">
                <h4><i class="fa fa-angle-right"></i> ETAT DU PERSONNEL PAR DIRECTION ET GENRE</h4>
                <div class="panel-body text-center">
                  <canvas id="bar" height="300" width="400"></canvas>
                </div>
              </div>
            </div>
              <!-- /col-md-4-->
              <div class="col-lg-6">
              <div class="content-panel">
                <h4><i class="fa fa-angle-right"></i> ETAT DU PERSONNEL PAR DIRECTION ET STATUT</h4>
                <div class="panel-body text-center">
                  <canvas id="line" height="300" width="400"></canvas>
                </div>
              </div>
            </div>
              
            </div>
           <!--  Pyramide des ages  -->
           <div class="row mt">
            <div class="col-lg-12" id="chartDiv" style="height: 300px;margin: 0px auto">
            </div>
          </div>
           <!--  Pyramide des ages  -->
            <br>
            <!-- /row -->
            <div class="row">
              <div class="col-md-6 col-sm-6 mb">
                <div class="white-panel pn">
                  <div class="white-header">
                    <h5>STATUT</h5>
                  </div>
                  <canvas id="serverstatus05" height="120" width="120"></canvas>
                  <script>
                    var doughnutData = [{
                        value: {{round(($contractuel / $total)*100,1)}},
                        color: "#ed9a09"
                      },
                      {
                        value: {{round(($fonctionnaire / $total)*100,1)}},
                        color: "#21f705"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus05").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <h5>{{round(($contractuel / $total)*100,1)}}% Contractuel</h5>
                  <h5>{{round(($fonctionnaire / $total)*100,1)}}% Fonctionnaire</h5>
                </div>
              </div>
              <!-- /col-md-4 -->
              <!--/ col-md-4 -->
              <div class="col-md-6 col-sm-6 mb">
                <div class="green-panel pn">
                  <div class="green-header">
                    <h5>GENRE</h5>
                  </div>
                  <canvas id="serverstatus06" height="120" width="120"></canvas>
                  <script>
                    var doughnutData = [{
                        value: {{round(($genre_max / $total)*100,1)}},
                        color: "#4287f5"
                      },
                      {
                        value: {{round(($genre_fem / $total)*100,1)}},
                        color: "#f542d4"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus06").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <h5>{{round(($genre_max / $total)*100,1)}} % Hommes</h5>
                  <h5>{{round(($genre_fem / $total)*100,1)}} % Femmes</h5>
                </div>
              </div>
              <!-- /col-md-4 -->
            </div>
            <!-- /row -->
          </div>
          <!-- /col-lg-9 END SECTION MIDDLE -->
          <!-- **********************************************************************************************************************************************************
              RIGHT SIDEBAR CONTENT
              *********************************************************************************************************************************************************** -->
          
          <!-- /col-lg-3 -->
        </div>
        <!-- /row -->
      </section>
@endsection

@section('scriptjs')

<script src="lib/sparkline-chart.js"></script>
<script src="lib/zabuto_calendar.js"></script>
<script src="{{asset('lib/raphael/raphael.min.js')}}"></script>
<script src="{{asset('lib/morris/morris.min.js')}}"></script>
<script src="https://code.jscharting.com/latest/jscharting.js"></script>
  
  <script type="application/javascript">
    var barChartData = {
        labels : ["DOP","DPF","DMG","DRHAJA","DIC","DESSE","DAICG","ADMIN. ADJ","ADMIN"],
        datasets : [
            {
                fillColor : "rgba(255, 0, 0, 0.2)",
                strokeColor : "rgba(255, 0, 0, 0.2)",
                data : [{{$dop_f}},{{$dpf_f}},{{$dmg_f}},{{$drhaja_f}},{{$dic_f}},{{$desse_f}},{{$daicg_f}},{{$admin_adjoin_f}},{{$admin_f}}]
            },
            {
                fillColor : "rgba(151,187,205,0.5)",
                strokeColor : "rgba(151,187,205,1)",
                data : [{{$dop_m}},{{$dpf_m}},{{$dmg_m}},{{$drhaja_m}},{{$dic_m}},{{$desse_m}},{{$daicg_m}},{{$admin_adjoin_m}},{{$admin_m}}]
            }
        ]

    };

      var lineChartData = {
        labels : ["DOP","DPF","DMG","DRHAJA","DIC","DESS","DAICG","ADMIN. ADJ","ADMIN"],
        datasets : [
            {
                fillColor : "rgba(220,220,220,0.5)",
                strokeColor : "rgba(220,220,220,1)",
                pointColor : "rgba(220,220,220,1)",
                pointStrokeColor : "#fff",
                data : [{{$dop_contractuel}},{{$dpf_contractuel}},{{$dmg_contractuel}},{{$drhaja_contractuel}},{{$dic_contractuel}},{{$desse_contractuel}},{{$daicg_contractuel}},{{$admin_adjoin_contractuel}},{{$admin_contractuel}}]
            },
            {
                fillColor : "rgba(151,187,205,0.5)",
                strokeColor : "rgba(151,187,205,1)",
                pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#fff",
                data : [{{$dop_fonct}},{{$dpf_fonct}},{{$dmg_fonct}},{{$drhaja_fonct}},{{$dic_fonct}},{{$desse_fonct}},{{$daicg_fonct}},{{$admin_adjoin_fonct}},{{$admin_fonct}}]
            }
        ],
      options: {
                responsive: true,
                plugins: {
                  legend: {
                    position: 'top',
                  },
                  title: {
                    display: true,
                    text: 'Chart.js Line Chart'
                  }
                }
              },

    };

    new Chart(document.getElementById("bar").getContext("2d")).Bar(barChartData);
    new Chart(document.getElementById("line").getContext("2d")).Line(lineChartData);

 // Nori//////////////////////////////////////

       Morris.Bar({
        element: 'hero-bar',
        data: [
          {device: 'DOP', geekbench: {{$dop}} },
          {device: 'DPF', geekbench: {{$dpf}} },
          {device: 'DMG', geekbench: {{$dmg}} },
          {device: 'DRHAJA', geekbench: {{$drhaja}} },
          {device: 'DIC', geekbench: {{$dic}} },
          {device: 'DESSE', geekbench: {{$desse}} },
          {device: 'DAICG', geekbench: {{$daicg}} },
          {device: 'CAB. ADMIN. ADJ', geekbench: {{$admin_adjoin}} },
          {device: 'CAB. ADMIN', geekbench: {{$admin}} }
        ],
        xkey: 'device',
        ykeys: ['geekbench'],
        labels: ['Employés'],
        barRatio: 0.4,
        xLabelAngle: 35,
        hideHover: 'auto',
        barColors: ['#f5b540']
      });

       Morris.Bar({
        element: 'hero-bar2',
        data: [
          {device: 'Abengourou', geekbench: {{$abengourou}} },
          {device: 'Abobo', geekbench: {{$abobo}} },
          {device: 'Aboisso', geekbench: {{$aboisso}} },
          {device: 'Adjamé', geekbench: {{$Adjame}} },
          {device: 'Béoumi', geekbench: {{$beoumi}} },
          {device: 'Bouaké', geekbench: {{$bouake}} },
          {device: 'Daloa', geekbench: {{$daloa}} },
          {device: 'Daoukro', geekbench: {{$daoukro}} },
          {device: 'Dimbokro', geekbench: {{$dimbokro}} },
          {device: 'Gagnoa', geekbench: {{$gagnoa}} },
          {device: 'Guiglo', geekbench: {{$guiglo}} },
          {device: 'Korhogo', geekbench: {{$korhogo}} },
          {device: 'Man', geekbench: {{$Man}} },
          {device: 'Odiéné', geekbench: {{$odiene}} },
          {device: 'Prestige', geekbench: {{$prestige}} },
          {device: 'San Pedro', geekbench: {{$sanpedro}} },
          {device: 'Soubré', geekbench: {{$soubre}} },
          {device: 'Treichville', geekbench: {{$treichville}} },
          {device: 'Yamoussoukro', geekbench: {{$yamoussoukro}} },
          {device: 'Yopougon', geekbench: {{$yopougon}} }
        ],
        xkey: 'device',
        ykeys: ['geekbench'],
        labels: ['Employés'],
        barRatio: 0.4,
        xLabelAngle: 35,
        hideHover: 'auto',
        barColors: ['#64f540']
      });


      Morris.Donut({
        element: 'hero-donut',
        data: [
          {label: 'Agent de Maitrise', value: {{round(($ag_maitrise / $total)*100,1)}} },
          {label: 'Employe', value: {{round(($employe / $total)*100,1)}} },
          {label: 'Cadre', value: {{round(($cadre / $total)*100,1)}} },
          {label: 'Cadre Junior', value: {{round(($cadrejunior / $total)*100,1)}} },
          {label: 'Cadre Moyen', value: {{round(($cadremoyen / $total)*100,1)}} },
          {label: 'Cadre Sup', value: {{round(($cadresup / $total)*100,1)}} }
        ],
          colors: ['#f7ba02', '#2980b9', '#34495e','#f542d4', '#57f542', '#f7021f'],
        formatter: function (y) { return y + "%" }
      });


      // Nori//////////////////////////////////////


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

  // JS 
var chart = JSC.chart('chartDiv', { 
  debug: true, 
  type: 'horizontal column', 
  title_label_text: 'PYRAMIDE DES AGES', 
  yAxis: { 
    scale_type: 'stacked', 
    defaultTick_label_text:''
  }, 
  xAxis: { 
    label_text: 'Age', 
    crosshair_enabled: true
  }, 
  defaultTooltip_label_text: 
    'Ages %xValue:<br><b>%points</b>', 
  defaultPoint_tooltip: 
    '%icon {Math.abs(%Value)}', 
  legend_template: 
    '%name %icon {Math.abs(%Value)}', 
  series: [ 
    { 
      name: 'Homme', 
      points: { 
        mapTo: 'x,y', 
        data: [  
                ['65-69', -{{$trancheM6569}}], 
                ['60-64', -{{$trancheM6064}}],
                ['55-59', -{{$trancheM5559}}], 
                ['50-54', -{{$trancheM5054}}], 
                ['45-49', -{{$trancheM4549}}],
                ['40-44', -{{$trancheM4044}}], 
                ['35-39', -{{$trancheM3539}}], 
                ['30-34', -{{$trancheM3034}}], 
                ['25-29', -{{$trancheM2529}}],
                ['20-24', -{{$trancheM2024}}],
        ] 
      } 
    }, 
    { 
      name: 'Femme',
      color: "#f700ff", 
      points: { 
        mapTo: 'x,y', 
        data: [ 
                ['65-69', {{$trancheF6569}}], 
                ['60-64', {{$trancheF6064}}], 
                ['55-59', {{$trancheF5559}}], 
                ['50-54', {{$trancheF5054}}], 
                ['45-49', {{$trancheF4549}}], 
                ['40-44', {{$trancheF4044}}], 
                ['35-39', {{$trancheF3539}}], 
                ['30-34', {{$trancheF3034}}], 
                ['25-29', {{$trancheF2529}}], 
                ['20-24', {{$trancheF2024}}],
        ] 
      } 
    } 
  ] 
}); 
  </script>

 
@endsection