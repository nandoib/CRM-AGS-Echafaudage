<!DOCTYPE html>
<html>
<head>
    <title>Devis : {{$devis->client->nom}} {{$devis->client->Prenom}}</title>


<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @media print 
        {
          .table {
            border: 0.5px solid #000000;
            }
            .table-bordered > thead > tr > th,
            .table-bordered > tbody > tr > th,
            .table-bordered > tfoot > tr > th,
            .table-bordered > thead > tr > td,
            .table-bordered > tbody > tr > td,
            .table-bordered > tfoot > tr > td {
            border: 0.5px solid #000000;
            padding:5px;
            }
            .footer{
                bottom:0;
            }

            .main{height: 92;}
            .footer{height:8%;}
           

          .infoclient{margin-top:-120px !important;}

          .font-weight-bolder{font-weight:bolder;}
          
          .no-print{
              display: none;
          }

          .bgcol{
              background-color: #999;
          }

          body{
              padding-top: 1px;
              background: transparent;
          }
        }

        body { padding-bottom: 70px; }

        .infos
        {
            font-size:12px;
            margin-left: 15% !important;
            margin:-30px;
        }

        .imagefooter
        {
            margin-bottom:10px;
            margin-left:15px;
        }

        .black{
            color:#000000;
        }

        .table th {
            background-color: #00a69c !important;
            color:white;
        }

        .font-weight-bolder{font-weight:bolder;}

        .nomclient{
            font-size: 15px;
            font-weight: 500;
        }
        body,table{
            font-size:15px;
            font-family: sans-serif;
            font-weight: 500;
        }
        .numerodevis{
            margin-top:25px;
            font-size: 19px;
            font-weight: bold;
        }
        #vert{
            background-color: #5ed2bf !important;
        }
        .nomclient{font-size:25px;
        font-weight: 500;}

        .titreags{margin-bottom: -15px;}

  @media print {
    .table th {
      background-color: #00a69c !important;
      color:white;
    }
  }
        </style>
</head>
<body>

<div class="container-fluid">
    <div class="main">
    <div class="row">
        <div class="image col-5 ml-5 mt-5">
            <img src="https://www.ags-echafaudage.fr/wp-content/uploads/2021/03/newsite-1.png" class="img-fluid" alt="Responsive image">
        </div>
        <div class="numerodevis col-6">
            @foreach($devis->status as $statut)
            @if($statut->statut == "validé")
            <h2 class=" numerodevis text-right mt-5 m-3">Facture n° {{$devis->id}} du {{ \Carbon\Carbon::parse($devis->updated_at)->format('j/m/Y') }}</h2>
            @else 
            @if($loop->last)
            <h2 class=" numerodevis text-right mt-5 m-3">Devis n° {{$devis->id}} du {{ \Carbon\Carbon::parse($devis->created_at)->format('j/m/Y') }}</h2>
            @endif
            @endif
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="infoags ml-5 mt-2 ">
            <p><h2 class="titreags font-weight-bolder">AGS ÉCHAFAUDAGE</h2><br/>
            Route de Carling <br/> 
            57500 SAINT-AVOLD<br/> 
            Email : commercial@ags-grp.fr <br/>
            Tel : (33) 03 87 00 35 22 </p>
        </div>

        <div class="infoclient offset-7 mt-2 ">
            <p><h2 class="nomclient">{{ $devis->client->nom}} {{ $devis->client->Prenom }}</h2>
           {{ $devis->client->adresse}}<br/>
          {{ $devis->client->telephone }}</p>
        </div>
    </div>

    
<table class="table m-3 mr-5 col-11 table-bordered">
  <thead id="vert">
    <tr>
      <th scope="col" class="text-center"><b>N°</th>
      <th scope="col" class="text-center">Désignation</th>
      <th scope="col" class="text-center">Qté</th>
      <th scope="col" class="text-center">PU HT</th>
      <th scope="col" class="text-center">Total H.T</b></th>
      <th scope="col" class="text-center">Total T.T.C</th> 
    </tr>
  </thead>
  <tbody>

    <?php
    $count = 1;
    $poidstotal = 0;
    $prixtotalht = 0;
    $prixtotalttc = 0;
    $tva = 0;
    $remise= 0;
    $poidstotal= 0;
    
    $articles= DB::select(DB::raw("SELECT * FROM article_devisfacture WHERE devisfacture_id = '$devis->id'"));
    $articlesarray = json_decode(json_encode($articles), true);
    ?>
   
    @foreach ($articlesarray as $articlearray)
    <?php
    $custom_article = 0;

    if($articlearray['article_id'] == null){
        $custom_article=1;
    }

    if($custom_article != 1){
        $article_id = $articlearray['article_id'];
        $article1 = DB::select(DB::raw("SELECT * FROM articles WHERE id = '$article_id'"));
        $article = json_decode(json_encode($article1), true);
    }?>

    <tr>
      <th scope="row" class="text-center">{{$count}}</th>
      @if($custom_article == 1)
      <td>{{ $articlearray['designation'] }}</td>
      
      <td class="text-center">{{ $articlearray['quantite']}}</td>
      <td class="text-center">{{ $articlearray['prix']}}</td>
      <td class="text-center">{{ $articlearray['quantite']*$articlearray['prix'] }}</td>
      <td class="text-center">{{ $articlearray['quantite']*$articlearray['prix']*1.2 }}</td>

      <?php 
        $count = $count + 1;
       $poidstotal += $articlearray['poids']*$articlearray['quantite'];
       $prixtotalht += $articlearray['prix']* $articlearray['quantite'];
        $prixtotalttc += $articlearray['prix']*1.2*$articlearray['quantite']-$devis->remise;
       $tva = $prixtotalttc - $prixtotalht;
       ?>

    </tr>
    @else 

    <td>{{ $article['0']['designation']}}</td>
    <td class="text-center">{{ $articlearray['quantite']}}</td>
      
    <td class="text-center">{{ $articlearray['prix']}}</td>
    <td class="text-center">{{ $articlearray['quantite']*$article['0']['prix'] }}</td>
    <td class="text-center">{{ $articlearray['quantite']*$article['0']['prix']*1.2 }}</td>
    <?php 
      $count = $count + 1;
     $poidstotal += $article['0']['poids']*$articlearray['quantite'];
     $prixtotalht += $articlearray['prix']* $articlearray['quantite'];
     $prixtotalttc +=  $articlearray['prix']*1.2*$articlearray['quantite']-$devis->remise;
     $tva = $prixtotalttc - $prixtotalht;
     ?>
  </tr>

    @endif


    @endforeach

    @if ($devis->remise)
    <tr>
        <th scope="row" class="text-center">{{$count}}</th>
      <td>Remise commerciale</td>
      <td class="text-center"> </td>
      <td class="text-center"> </td>
      <td class="text-center"> </td>
      <td class="text-center">- {{$devis->remise}} €</td>
    </tr>
    @endif

  </tbody>
</table>


<div class="total border rounded offset-6 col-5 p-2 pl-4">

    <div class="row">
        <div class="col-8">
            <p>Poids total</p>
        </div>

        <div class="col-4"><p>{{$poidstotal}} Kg</p></div>
    </div>
    
    <div class="row">
        <div class="col-8">
            <p>Total H.T</p>
        </div>

        <div class="col-4"><p>{{$prixtotalht}} €</p></div>
    </div>

    
    <div class="row">
        <div class="col-8">
            <p>Total Net H.T</p>
        </div>

        <div class="col-4"><p>{{$prixtotalht}} €</p></div>
    </div>

    <div class="row">
        <div class="col-8">
            <p>TVA</p>
        </div>

        <div class="col-4"><p>{{$tva}} €</p></div>
    </div>
    
    @if ($devis->remise)
    <div class="row">
        <div class="col-8">
            <p>Remise</p>
        </div>

        <div class="col-4"><p>-{{$devis->remise}} €</p></div>
    </div>
    @endif

    <div class="row">
        <div class="col-8">
            <p><b>Total T.T.C</b></p>
        </div>

        <div class="col-4"><p><b>{{$prixtotalttc}} €</b></p></div>
    </div>

    <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col" class="text-center">% TVA</th>
            <th scope="col" class="text-center">Base</th>
            <th scope="col" class="text-center">Total TVA</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>20.00 %</td>
            <td>{{$prixtotalht}} €</td>
            <td>{{$tva}} €</td>
          </tr>
        </tbody>
    </table>

</div>


@foreach($devis->status as $statut)
            @if($statut->statut == "validé")
            @else 
            @if($loop->last)
            <div class="validite ml-5"><p>Validité du devis : {{ \Carbon\Carbon::parse($devis->created_at)->addMonths(1)->format('j/m/Y') }}</p></div>
            @endif
            @endif
            @endforeach


<div class="paiement ml-5"><p>Paiement comptant : Virement / Chèque de banque / CB (voir bas de page)<br/>
    Dans le cas d'une livraison, le client est le seul responsable du déchargement de la marchandise.</p>
</div>

<div class="siteweb ml-5">www.ags-echafaudage.fr</div>

@foreach($devis->status as $statut)
            @if($statut->statut == "validé")
            @else 
            @if($loop->last)
            <div class="signature border border-dark rounded col-11 m-5 ml-2 p-3"><b>Devis n° {{$devis->id}}</b><br/>Signature client, précédée de la mention "lu et approuvé".
            @endif
            @endif
            @endforeach


</div>
</div>
<div class="footer">
    <hr class="black">

    <div class="row">
        <div class="imagefooter col-1">
            <img src="https://www.ags-echafaudage.fr/wp-content/uploads/2021/07/newsite.png" alt="Responsive image">
        </div>
    </div>
    <div class="row">
        <div class="col-11">
            <div class="infos text-center">SARL AGS ECHAFAUDAGE au capital de 100000 € - Tel : (33) 03 87 00 35 22 - Email : commercial@ags-grp.fr</div><br/>
            <div class="infos text-center">SIRET : 889788758 00015 - TVA intracommunautaire : FR06 889 788 758</div><br/>
            <div class="infos text-center">IBAN Crédit Mutuel : FR76 1027 8020 0100 0215 9310 233</div><br/>
        </div>
    </div>
</div>

</div>
</body>
</html>