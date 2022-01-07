@extends('layouts.layout')

@section('title')
    stats
@endsection

@section('content')  

<form action="{{route('stats')}}" method="POST">
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-bordered">
                

                <div class="form-group offset-5 col-5">
                    <label>Entre le </label>
                    <input type="date" class="form-control" name="datedepart">
                </div>
                
                <div class="form-group offset-5 col-5">
                    <label>et le  </label>
                    <input type="date" class="form-control" name="datefin">
                </div>
            
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary pull-right save offset-5">
        Enregistrer
    </button>
</form> 
<br/>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var jobs = {!! json_encode($devis_validescount) !!};

        var data = google.visualization.arrayToDataTable([
          ['Devis', 'repartition'],
          ['En cours',   <?php echo json_encode($devis_encourscount); ?>],
          ['Validé',     <?php echo json_encode($devis_validescount); ?>],
          ['Refusé : Trop cher',  <?php echo json_encode($devis_refus_tropchercount); ?>],
          ['Refusé : Livraison trop chère',  <?php echo json_encode($devis_refus_livraisoncount); ?>],
          ['Demande nouveau devis', <?php echo json_encode($devis_demande_nouveau_deviscount); ?>],
        ]);

        var options = {
          title:" <?php echo json_encode($nouveaux_deviscount); ?> Devis ",
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
    

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
         ['Element', 'Nombre', { role: 'style' }],
         ['Nouveau clients', <?php echo json_encode($nouveauclientscount); ?>, '#b87333'],            // RGB value
         ['appels',<?php echo json_encode($appelscount); ?>, 'silver'],            // English color name
         ['mails', <?php echo json_encode($mailscount); ?>, 'gold'],
         ['Taches', <?php echo json_encode($totale_tachescount); ?>, 'color: #e5e4e2' ], // CSS-style declaration
         ['Taches accomplies', <?php echo json_encode($tachesfaitescount); ?>, 'color: #e5e4e2' ], // CSS-style declaration
         ['Taches non faite', <?php echo json_encode($tachespasfaitescount); ?>, 'color: #e5e4e2' ], // CSS-style declaration

      ]);

        var options = {
          chart: {
            title: 'Statistiques pour la période',
            subtitle: '',
          },
          is3D: true,
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>



<div class="container">
<div class="row">
<h1 class="text-center display-4">Statistiques pour la période du : {{ \Carbon\Carbon::parse($date_depart)->format('j m Y ') }} au {{ \Carbon\Carbon::parse($date_fin)->format('j m Y ') }} </h1>
<div id="piechart_3d" class="mt-5" style="width: 600px; height: 500px;"></div>
<div id="columnchart_material" class="mt-5" style="width: 700px; height: 500px;"></div>
</div>


<div class="stats mt-5 mb-5">

  <table id="example" class="table table-striped table-bordered table-sm">
                
                <thead>
                  <tr>
                    <th>Nouveaux clients</th>
                    <th>Appels</th>
                    <th>mails</th>
                    <th>Taches</th>
                    <th>Taches accomplies (%)</th>
                    <th>Devis</th>
                    <th>Devis signés </th>
                    <th>Devis signé (%)</th>
                  
                  </tr>
                </thead>
                <tbody id="myTable">
                  <tr>
                    <td>{{$nouveauclientscount}}</td>
                    <td>{{$appelscount}}</td>
                    <td>{{$mailscount}}</td>
                    <td>{{$totale_tachescount}}</td>
                    <td><?php $stat_tache = round($stat_tachesfaites); echo $stat_tache ?>%</td>
                    <td>{{$nouveaux_deviscount}}</td>
                    <td>{{$devis_validescount}}</td>
                    <td><?php $stat_devis = round($stat_signaturedevis); echo $stat_devis; ?> %</td>
                  </tr>
              </table>
</div>
@endsection