<!doctype html>
<html lang="fr">
  <head>
    <title>Articles (stocks)ccccccccccccccccccccccccccccc</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
          <div class="row">
              <h1 class="titre1 offset-4 display-4">Liste des articles</h1>

              <input class="form-control mb-2" id="myInput" type="text" placeholder="Rechercher un article">
              <input class="form-control" id="myInput2" type="text" placeholder="Rechercher un article">

              <table id="example" class="table m-3 mr-5 col-11 table-bordered table-striped">
                <thead style="background-color: blue;color:white;">
                  <tr>
                    <th scope="col" class="text-center"><b>Référence</th>
                    <th scope="col" class="text-center">Désignation</th>
                    <th scope="col" class="text-center">Stock</th>
                    <th scope="col" class="text-center">Poids(kg)</th>
                    <th scope="col" class="text-center">PU HT</th>
                    <th scope="col" class="text-center">PU TTC</th>
                    <th scope="col" class="text-center">Modifier</th>
                    
                  </tr>
                </thead>
                <tbody id="myTable">
                    @foreach($articles as $article)
                  <tr>
                    <th scope="row" class="text-center">{{ $article->reference }}</th>
                    <td>{{ $article->designation }}</td>
                    <td class="text-center">{{ $article->stock }}</td>
                    <td class="text-center">{{ $article->poids }} kg</td>
                    <td class="text-center">{{ $article->prix }}€ HT</td>
                    <td class="text-center">{{ $article->prix * 1.2 }} € TTC</td>
                    <td class="text-center">                     <!-- Button modal  Modif client -->
                      <button type="button" class="btn btn-primary m-2 p-2" data-toggle="modal" data-target="#modifarticle{{$article->id}}">
                          Modifier article
                      </button>
                          
                      <!-- Modal -->
                      <div class="modal fade" id="modifarticle{{$article->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog p-5" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Modification article</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body"> 
          
                                      {{-- Contenu du modal --}}
          
                                      <form action="{{ route('modifarticle', $article->id) }}" method="POST">
                                          @csrf

                                          <div class="form-group  col-md-12 " >     
                                            <label class="control-label" for="email"><strong>Référence</strong></label>
                                            <input type="text"  name="reference" value="{{ old('reference', $article->reference) }}">      
                                          </div>
                          
                                          <div class="form-group  col-md-12 " >     
                                            <label class="control-label" for="nom"><strong>Désignation</strong></label>
                                            <input type="text"  name="designation" value="{{ old('designation', $article->designation)}}">      
                                          </div>
                    
                                          @if ($article->contenulot)
                                          <div class="form-group  col-md-12 " >     
                                            <label class="control-label" for="contenulot"><strong>Contenu du lot</strong></label>
                                            <input type="textarea" class="form-control" name="contenulot" value="{!! old('reference', $article->contenulot) !!}" rows="5">
                                          </div>
                                          @endif

                                          <div class="form-group  col-md-12 " >     
                                            <label class="control-label" for="prix"><strong>Prix</strong></label>
                                            <input type="text"  name="prix" value="{{ old('prix', $article->prix) }}">      
                                          </div>

                                          <div class="form-group  col-md-12 " >     
                                            <label class="control-label" for="poids"><strong>Poids</strong></label>
                                            <input type="text"  name="poids" value="{{ old('poids', $article->poids) }}">      
                                          </div>



                                          <div class="form-group  col-md-12 " >     
                                            <label class="control-label" for="prenom"><strong>Stock</strong></label>
                                            <input type="text"  name="stock" value="{{ old('stock', $article->stock) }}">      
                                          </div>
                  
                                          <div class="panel-footer">
                                            <button type="submit" class="btn btn-primary save">Enregistrer</button>
                                          </div>
                                        </form>
                                      
                                      {{-- FIN DU CONTENU DU MODAL --}}
                                  </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                      </div>
                              </div>
                          </div>
                      </div></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              
              <form class="col-12" method="POST" action="{{route('nouvelarticle')}}" >
                {{ csrf_field() }}
              
                <h1>Liste des article</h1>
                
                <div class="container1"></div>
                <div class="container2 offset-1"></div>
                
                </form>
                <button type="button" class="btn btn-primary add_form_field m-3">Ajouter article &nbsp; 
                <span style="font-size:16px; font-weight:bold;">+ </span>
                </button>

               <button type="button" class="btn btn-primary add_form_field_lot m-3">Ajouter lot &nbsp; 
                <span style="font-size:16px; font-weight:bold;">+ </span>
                </button>

          </div>
      </div>

    <script type="text/javascript">
        function findTotal(){
      var arr = document.getElementsByName('qty');
      var thenum= 0;
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('total').value = tot;
    }
    </script>
      <script>
        $(document).ready(function() {
        var max_fields = 20;
        var wrapper = $(".container1");
        var wrapper2 = $(".container2");
        var add_button = $(".add_form_field");
        var add_buttonlot = $(".add_form_field_lot")
        
        var x = 1;
        var y = 1;
        var z = 2;
        $(add_button).click(function(e) {
        e.preventDefault();
        

        if (x < max_fields) {
            x++;
            $(wrapper).append('<div class="row m-1"><input type="text" placeholder="Désignation" name="designation[]" class="form-control col-3 mr-1 ml-5" required><input type="number" placeholder="prix" step=".01"  class="form-control col-1 m-1" name="prix[]" required><input type="text" placeholder="Référence"  class="form-control col-1 m-1" name="reference[]" required><input type="number" placeholder="Poids (Kg)" step=".01" name="poids[]" class="form-control col-1 m-1"  required><input type="number" placeholder="Stock" class="form-control col-1 m-1" name="stock[]" required><button type="button" class="btn btn-danger delete col-1 ml-2">Supprimer</button></div>'); //add input box
            
        } else {
            alert('Vous avez attein la limite de 20 articles par devis')
        }

        if (y < 2){
            y++;
             $(wrapper2).append('<button type="submit" class="btn btn-primary pull-right save ml-5 col-5 ">Enregistrer</button>'); //add input box
        }
        });
         
        $(add_buttonlot).click(function(e) {
        e.preventDefault();
        

        if (x < max_fields) {
            x++;
            $(wrapper).append('<div class="row m-1"><input type="text" placeholder="Désignation" name="designation[]" class="form-control col-3 mr-1 ml-5" required><input type="textarea" name="contenulot[]" placeholder="Contenu du lot" class="form-control col-6"><input type="number" placeholder="prix" step=".01" class="form-control col-1 m-1" name="prix[]" required><input type="text" placeholder="Référence"  class="form-control col-1 m-1" name="reference[]" required><input type="number" placeholder="Poids (Kg)" name="poids[]" step=".01" class="form-control col-1 m-1"  required><input type="number" placeholder="Stock" class="form-control col-1 m-1" name="stock[]" required><button type="button" class="btn btn-danger delete col-1 ml-2">Supprimer</button></div>'); //add input box
            
        } else {
            alert('Vous avez attein la limite de 20 articles par devis')
        }

        if (y < 2){
            y++;
             $(wrapper2).append('<button type="submit" class="btn btn-primary pull-right save ml-5 col-5 ">Enregistrer</button>'); //add input box
        }
        });

        
        $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
        })
        });
        
        </script>

      <script>
      $(document).ready(function(){
        $("#myInput").on("keyup", function() {
          var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      });

      $(document).ready(function(){
      $("#myInput2").on("keyup", function() {
          var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });


    $(document).ready(function() {
    $('#example').DataTable();
    } );

    </script>  

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>