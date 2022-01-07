<!DOCTYPE html>
<html>
<head>
    <title>Devis : {{$devis->client->nom}} {{$devis->client->Prenom}} </title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

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

          .infoclient{margin-top:-100px; font-weight: bold;}
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
            #vert{
                background-color: #00a69c !important;
            }
        }
        .titrepage{
            margin-left:30%;
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

        @media print 
        {
            .table th {
            background-color: #00a69c !important;
            color:white;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
    <!-- Container wrapper -->
    <div class="container-fluid">
      <!-- Toggle button -->
      <button
        class="navbar-toggler"
        type="button"
        data-mdb-toggle="collapse"
        data-mdb-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <i class="fas fa-bars"></i>
      </button>
  
      <!-- Collapsible wrapper -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Navbar brand -->
        <a class="navbar-brand mt-2 mt-lg-0" href="{{route('accueil')}}">
          <img
            src="https://www.ags-echafaudage.fr/wp-content/uploads/elementor/thumbs/newsite-2-p8gqb7j1kdv2juwlwiobs6nc490dxgft5thp6wv1oq.png"
            height="15"
            alt=""
            loading="lazy"
          />
        </a>
        <!-- Left links -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{route('accueil')}}">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('commercial')}}">Clients</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('articles')}}">Articles(stock)</a>
          </li>
        
          <li class="nav-item">
            <a class="nav-link" href="{{route('statsdate')}}">Mes statistiques</a>
          </li>
        </ul>
        <!-- Left links -->
      </div>

        <!-- Avatar -->
      
        <ul
          class="dropdown-menu dropdown-menu-end"
          aria-labelledby="navbarDropdownMenuLink"
        >
          <li>
            <a class="dropdown-item" href="#">Logout</a>
          </li>
        </ul>
      </div>
      <!-- Right elements -->
    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->

<div class="container-fluid">
    <div class="row ml-5">
        <h1 class="titrepage col-12 text-center ml-5 mb-5">Modification devis n°{{$devis->id}}  {{$devis->client->Prenom}}- {{$devis->client->nom}}</h1>
    </div>
    
        <form class="col-12" method="POST" action="{{route('modifcontenudevis', $devis->id)}}">
            {{ csrf_field() }}
            <input type="hidden" name="idclient" value="{{$devis->client->id}}">
            <input type="hidden" name="facture_ou_devis" value="devis">
            <h1>Liste des articles</h1>
    
    <table class="table table-striped table-bordered col-10 ml-5">
        <thead>
            
            <tr>
                <th>N°</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Désignation</th></th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <?php $count="0";?>


        <tbody class="container1">
          <?php
            $articles= DB::select(DB::raw("SELECT * FROM article_devisfacture WHERE devisfacture_id = '$devis->id'"));
            $articlesarray = json_decode(json_encode($articles), true);
          ?>
   
    @foreach ($articlesarray as $articlearray)
    <?php
    $custom_article = 0;
    $count = $count + 1;

    if($articlearray['article_id'] == null){
        $custom_article=1;
    }

    if($custom_article != 1){
        $article_id = $articlearray['article_id'];
        $article1 = DB::select(DB::raw("SELECT * FROM articles WHERE id = '$article_id'"));
        $article = json_decode(json_encode($article1), true);
    }?>


    @if($custom_article == 1)

    <tr>
      <td>{{$count}}</td>
      <td><input onblur="findTotal()" type="number" name="quantite[]" value="{{ old('quantite[]',  $articlearray['quantite']) }}" class="form-control ml-5 col-10 offset-2" required></td>
      <td><input onblur="findTotal()" type="text" class="ml-3 col-10 form-control"  name="prix[]" step=". 01" value="{{old("prix[]", $articlearray['prix'])}}"></td>
      <td><input onblur="findTotal()" type="text" class="ml-3 col-10" name="article[]" value="{{old("article[]", $articlearray['designation'])}}"></td>
      <td><button type="button" class="btn btn-danger delete ml-2">Supprimer</button></td>
    </tr>

    @else

    <tr>
      <td>{{$count}}</td>
      
      <td><input onblur="findTotal()" type="number" name="quantite[]" value="{{ old('quantite',  $articlearray['quantite']) }}" class="form-control ml-5 col-10 offset-2" required></td>
      <td><input onblur="findTotal()" type="text" class="ml-3 col-10 form-control"  name="prix[]" step=". 01" value="{{old("prix[]", $article['0']['prix'])}}"></td>

      <td><select onblur="findTotal()" class="custom-select ml-3 col-10" name="article[]" required>
        <option selected value="{{$article['0']['id']}}">{!! $article['0']['designation'] !!} -{{$article['0']['prix'] }} </option>
          
          @foreach($articlesbdd as $articlebdd)
          
          <option value="{{ $articlebdd->id}}">{!! $articlebdd->designation !!} -- {{$articlebdd->prix}}€</option>@endforeach 
        </select></td>

      <td><button type="button" class="btn btn-danger delete ml-2">Supprimer</button></td>
    </tr>
    @endif
    @endforeach


      </tbody>
    </table>

    <button type="button" class="btn btn-primary add_form_field m-3 offset-5">Ajouter article &nbsp; 
        <span style="font-size:16px; font-weight:bold;">+ </span>
    </button>

    <div class="border rounded offset-6 col-5 p-2 pl-4">
        <div class="row">
            <input onblur="findTotal()" type="text" step=". 01" name="remise" id="remise" class="ml-1 m-3 form-control col-10" placeholder="Remise commerciale" value="{{old('remise', $devis->remise)}}">
        </div>

        <div class="row">
            <div class="col-8">
                <p>Total HT</p>
            </div>
    
            <div class="total col-4" id="total"></div>
        </div>
      
        <div class="row">
            <div class="col-8">
                <p>Total T.T.C</p>
            </div>
    
            <div class="totalttc col-4" id="totalttc"></div>
        </div>
    </div>

    
    <div class="form-group col-6 ml-5">
        <label for="formGroupExampleInput">Commentaire</label>
        <input type="text" class='form-control' name="commentaire" placeholder="commentaire" value="{{old('commentaire', $devis->commentaire)}}">
      </div>
      <div class="form-group col-6 ml-5">
        <label for="formGroupExampleInput2">temperature</label>
        <select class="custom-select" name="temperature">
            <option>Froid</option>
            <option>Tiède</option>
            <option>Chaud</option>
            <option>Brulant</option>
          </select>
      </div>

        <div class="container2 offset-1"></div>
        <button type="submit" onclick="findTotal()" class="offset-3 btn btn-primary pull-right save ml-5 col-5 mt-2 ">Enregistrer</button>

        </div>
    </form>

    <script type="text/javascript">
        function findTotal(){
            var arr = document.getElementsByName('prix[]');  
            var quantite = document.getElementsByName('quantite[]');
            var remise = document.getElementById('remise'); 
            var tot=0; 
            for(var i=0;i<arr.length;i++){
                if(parseFloat(arr[i].value))
                    tot += parseFloat(arr[i].value)*quantite[i].value-remise.value;
            }
            document.getElementById('total').innerHTML = tot;

            var totalht = document.getElementById('total').innerHTML;
            document.getElementById('totalttc').innerHTML = totalht*1.2;
        }
    </script>

<script>
          
    $(document).ready(function() {
        findTotal();
        
    var max_fields = 100;
    var wrapper = $(".container1");
    var wrapper2 = $(".container2");
    var add_button = $(".add_form_field");
    
    var x = 1;
    var y = 1;
    var z = 2;
    $(add_button).click(function(e) {
    e.preventDefault();
    

    if (x < max_fields) {
        x++;
        $(wrapper).append('<tr><td><div id="numero"></div></td><td><input type="number" name="quantite[]" placeholder="Quantité" class="form-control ml-5 col-10 offset-2" required></td><td><input onblur="findTotal()" type="text" class="ml-3 form-control"  name="prix[]" step=". 01" placeholder="Prix"></td><td> <select class="custom-select ml-3 col-10" name="article[]" required>@foreach($articles as $article)<option value="{{ $article->id}}">{{ $article->designation }} -- {{$article->prix}}€</option>@endforeach</select></td><td> <button type="button" onclick="findTotal()" class="btn btn-danger delete ml-2">Supprimer</button></td></tr>'); //add input box     
    } else {
        alert('You Reached the limits')
    }
    });
    
    $(wrapper).on("click", ".delete", function(e) {
    e.preventDefault();
    $(this).parent().parent().remove();
    x--;
    })
    });


    $(function(){
        setInterval(findTotal, 20);
        });

    
</script>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>