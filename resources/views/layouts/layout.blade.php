<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> @yield('title')</title>
    <meta ...>
   
    <!-- CSS + Font -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
         <!-- Fonts -->
         <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

         <!-- Styles -->
         <link rel="stylesheet" href="{{ asset('css/app.css') }}">
 
         <!-- Scripts -->
         <script src="{{ asset('js/app.js') }}" defer></script>
         @yield('style')
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
                
   @yield('content')

  <footer>
 
  </footer>

  <!--  Scripts-->
  <script src="{{asset('js/jquery.js')}}"></script>

  @yield('scripts')   
</body>
</html>