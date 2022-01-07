@extends('layouts.layout')

@section('title')
    {{ Auth::user()->prenom}}
@endsection

@section('content')  
<div class="container">
              @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary m-2 p-2" data-toggle="modal" data-target="#transfert">
            Nouveau client
        </button>
        
           <!-- Modal -->
           <div class="modal fade" id="transfert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nouveau transfert client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body"> 
                    {{-- Contenu du modal --}}

                    <form action="{!! url('nouveauclient') !!}" method="POST">
                      @csrf
                
                      <input  type="hidden" class="form-control" name="id_createur" value="1">
                      <input  type="hidden" class="form-control" name="valide" value="oui">
        
                      <div class="form-group  col-md-12 " >     
                        <label class="control-label" for="nom"><strong>Nom</strong></label>
                        <input type="text"  name="nom">      
                      </div>

                      <div class="form-group  col-md-12 " >     
                        <label class="control-label" for="prenom"><strong>Prenom</strong></label>
                        <input type="text"  name="prenom">      
                      </div>

                      <div class="form-group  col-md-12 " >     
                        <label class="control-label" for="email"><strong>Email</strong></label>
                        <input type="text"  name="email">      
                      </div>
        
              
                      <div class="form-group  col-md-12 " >     
                        <label class="control-label" for="adresse"><strong>Adresse</strong></label>
                        <input type="text"  name="adresse">      
                      </div>
        
                      <div class="form-group  col-md-12 " >     
                        <label class="control-label" for="telephone"><strong>Téléphone</strong></label>
                        <input type="text"  name="telephone">      
                      </div>
        
                      <div class="form-group  col-md-12 " >     
                        <label class="control-label" for="commentaire"><strong>Commentaire</strong></label>
                        <input type="text"  name="commentaire">      
                      </div>
        
                      <div class="form-group  col-md-12 " >     
                        <label class="control-label" for="source"><strong>Source</strong></label>
                        <select name="source" id="source" class="form-control" required>
                            <option value="site web">Site Web</option>
                            <option value="téléphone">Téléphone</option>
                            <option value="direct">Direct</option>
                            <option value="reseaux sociaux">Reseaux sociaux</option>
                        </select>
                      </div>
        
                      <div class="form-group  col-md-12 ">     
                        <label class="control-label" for="temperature"><strong>Temperature</strong></label>
                        <select name="temperature" id="temperature" class="form-control" required>
                            <option value="glacial">Glacial</option>
                            <option value="froid">Froid</option>
                            <option value="tiède">tiède</option>
                            <option value="chaud">chaud</option>
                            <option value="brulant">brulant</option>
                        </select>
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
        </div>

            <div class="container mt-3">
              <input class="form-control mb-2" id="myInput" type="text" placeholder="Rechercher un client">
              <input class="form-control" id="myInput2" type="text" placeholder="Rechercher un client">

              <br>
              <table id="example" class="table table-striped table-bordered table-sm">
                
                <thead>
                  <tr>
                    <th></th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Source</th>
                    <th>Temperature</th>
                    <th>Commercial</th>
                   
                    
                  </tr>
                </thead>
                <tbody id="myTable">
                    @foreach($clients as $client)  
                    
                   <tr>
                    <td><i class=""><a class="fas fa-hand-point-right nav-link" href=" {{ route('vueclient',$client->id) }}"></i></td>
                    <td>{{ $client->nom }}</td>
                    <td>{{ $client->Prenom }}</td>
                    <td>{{ $client->adresse }}</td>
                    <td>{{ $client->telephone}}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->source }}</td>
                    <td>{{ $client->temperature }}</td>
                    <td>
                    
                     @php 
                    $reponse = DB::select(DB::raw("SELECT * FROM client_user WHERE id_client = '$client->id' AND valide = 'oui' ORDER BY created_at DESC LIMIT 1 "));

                    $value = json_decode(json_encode($reponse), true);
                    $value1 =$value[0]['id_user_dest'];
                   
                      $username = DB::select(DB::raw("SELECT * FROM users WHERE id = '$value1'"));

                    $usernamefinal = json_decode(json_encode($username), true);
                    
                    @endphp

                   {{ $usernamefinal[0]['prenom'] }}

                    
                    </td>
                  </tr>
                  @endforeach
              </table>
            </div></div>
    
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
           @endsection