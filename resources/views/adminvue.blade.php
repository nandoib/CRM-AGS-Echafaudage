@extends('layouts.layout')

@section('title')
    {{ Auth::user()->prenom}}
@endsection

@section('content')  

<div class="container">
    <div class="row">

        <div class="taches col-12 shadow-lg p-2">
        @if(Auth::user()->role == "admin")
        <h3 class="display-4 text-center">Les Tâches</h3>
        @else
    <h3 class="display-4 text-center">Vos Tâches</h3>
    @endif
    <div class="table-responsive">
  <table class="table table-bordered table-striped">
      <thead>
          <tr>
          <th>Date de création</th>
          <th>Client</th>
          <th>Type</th>
          <th>Commentaire</th>
          <th>A faire avant</th>
          <th>statut</th>
          <th>Valider la tache</th>
          </tr>

      </thead>
      <tbody>
                
                @foreach($taches as $tache)
          @if($tache->statut != "fait")
          <tr>
            
          
            
              <td  @if($tache->statut != "fait")
                @if($tache->datefinale < $now)
                class="bg-danger"
                @endif
                @endif>{{ \Carbon\Carbon::parse($tache->created_at)->format('j/m/Y H:i') }}</td>
              <td><a href="{{ route('vueclient',$tache->client->id) }}">{{$tache->client->Prenom}}-{{$tache->client->nom}}</td>
              <td>{{$tache->type}}</td>
              <td>{{$tache->commentaire}}</td>
              <td @if($tache->statut != "fait")
                @if($tache->datefinale < $now)
                class="bg-danger"
                @endif
                @endif>{{ \Carbon\Carbon::parse($tache->datefinale)->format('j/m/Y') }}</td>
              <td>{{$tache->statut}}</td>
              @if(Auth::user()->role != "admin")
              <td><form action="{{route('modiftache', [$tache->id])}}" method="POST">
                {{ csrf_field() }}
                        <input type="hidden" name="statut" value="fait">
            <button type="submit" class="btn btn-primary pull-right save">
                Tache faite
            </button>
        </form> </td>
        @endif
        @if (Auth::user()->role == 'admin')
            <td>{{$tache->user->prenom}}</td>
        @endif
          </tr>
          @endif
          @endforeach
          
      </tbody>
    </table>
</div>


<!-- Button trigger modal -->
      <button type="button" class="btn btn-primary m-2 p-2" data-toggle="modal" data-target="#transfert">
        Historique des tâches
    </button>
    
       <!-- Modal -->
       <div class="modal fade bd-example-modal-lg col-8" id="transfert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nouveau transfert client</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body"> 
                {{-- Contenu du modal --}}
                <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tache accomplie le </th>
                            <th>Client</th>
                            <th>Type de tache</th>
                            <th>Commentaire</th>
                        </tr>
          
                    </thead>
                    <tbody>
                        @foreach($tachesaccomplies as $tachesaccomplie)
                        
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($tachesaccomplie->updated_at)->format('j/m/Y H:i') }}</td>
                            <td><a href="{{ route('vueclient',$tachesaccomplie->client->id) }}">{{$tachesaccomplie->client->Prenom}}-{{$tachesaccomplie->client->nom}}</td>
                            <td>{{$tachesaccomplie->type}}</td>
                            <td>{{$tachesaccomplie->commentaire}}</td>
                            @if (Auth::user()->role == 'admin')
                            <td>{{$tachesaccomplie->user->prenom}}</td>
                            @endif
                        </tr>
                        @endforeach
                        
                    </tbody>
                  </table>
                </div>
              
            {{-- FIN DU CONTENU DU MODAL --}}
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        </div>
    </div>

</div>
        
        <div class="devis col-12 shadow-lg p-2 m-2 mt-2">
            @if(Auth::user()->role == "admin")
            <h2 class="display-4 text-center">Les devis de l'équipe</h2>
            @else
        <h2 class="display-4 text-center">Vos devis</h2>
        @endif
        <div class="table-responsive">
        <table class="table table-responsive table-bordered table-striped">
            <thead>
                <tr>
                <th>Date</th>
                    <th>Client</th>
                    <th>Montant</th>
                    <th>statut</th>
                    <th>temperature</th>
                    <th>Commentaire</th>
                    <th>Modifier statut</th>
                </tr>
  
            </thead> 
            <tbody>
                @foreach ($deviss as $devis)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($devis->created_at)->format('j/m/Y') }}</td>
                    <td> <a class="nav-link" href=" {{ route('vueclient',$devis->client->id) }}">{{$devis->client->Prenom}}{{$devis->client->nom}}</a></td>
                    <td>{{ $devis->montant }} </td> 
                    <td>@foreach ($devis->status as $statut)@if($loop->last){{$statut->statut}} @endif @endforeach</td>
                    <td>@foreach($devis->status as $statut) @if($loop->last){{$statut->temperature}} @endif @endforeach</td>
                    <td>{{ $devis->commentaire }}</td>
  
                    @foreach ($devis->status as $statut)@if($loop->last)  @if($statut->statut =='en cours')@if(Auth::user()->role != "admin")
                    <td>  <!-- Button trigger modal nouveau devis -->
                      <button type="button" class="btn btn-success mt-2 p-2 m-2" data-toggle="modal" data-target="#modifdevis{{$devis->id }}">
                          Réponse client
                      </button>

                      @endif @endif @endif @endforeach
                      
                      <!-- Modal -->
                      <div class="modal fade" id="modifdevis{{$devis->id }}" tabindex="-1" role="dialog" aria-labelledby="modifdevis{{$devis->id }}" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                              <h5 class="modal-title" id="modifdevis">Validation devis</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              </div>
                              <div class="modal-body">
                                  {{-- CONTENU DU MODAL --}}
                                      <form action="{{route('modifdevis', $devis->id)}}" method="POST">
                                          {{ csrf_field() }}
                          
                                      <div class="row">
                                          <div class="col-md-8">
                                              <div class="panel panel-bordered">
                                              
                                                  <input type="hidden" name="id_client" value="{{ $devis->client->id}}">
                                                  <input type="hidden" name="id_user" value="{{Auth::id()}}">                                                
                                                  <input type="hidden" name="newmontant" value="{{$devis->montant}}">                           
                                                  <input type="hidden" name="facture_ou_devis" value="devis">
          
                                                  <div class="form-group">
                                                      <label for="commentaire">Commentaire</label>
                                                      <input type='text' name="newcommentaire" placeholder="{{$devis->commentaire}}" value="{{$devis->commentaire}}">
                                                  </div>
          
          
                                                   <div class="form-group">
                                                      <label for="statut">statut</label>
                                                      <select name="newstatut">
                                                          <option value="refusé : demande nouveau devis">Refusé : demande nouveau devis </option>
                                                          <option value="refusé trop cher">Refusé : Trop cher</option>
                                                          <option value="refusé livraison trop cher">Refusé : livraison trop chère</option>
                                                          <option value="En cours">En cours</option>
                                                          <option value="validé">Validé</option>
                                                      </select>
                                                  </div>
          
                                                  <div class="form-group">
                                                      <label for="newtemperature">temperature</label>
                                                      <select name="newtemperature">
                                                          <option value="Glacial">Glacial</option>
                                                          <option value="tiède">Tiède</option>
                                                          <option value="Chaud">Chaud</option>
                                                          <option value="Brulant">Brulant</option>
                                                      </select>
                                                  </div>
  
                                                  <button type="submit" class="btn btn-primary pull-right save">
                                                      Enregistrer
                                                  </button>
  
                                              </div>
                                          </div>
                                      </div>
                                  </form>
                                  </div>
                              </td>
                      
                  </td>
                  @if(Auth::user()->role =="admin")
                  <td>{{$devis->commercial->prenom}}</td>
                  @endif
                  </tr>
                @endforeach   
                
            </tbody>
        </table>
    </div>
    </div>


        <div class="taches col-12 shadow-lg ">
           

        <div class="transfert mt-3">
            <h3 class="col-12 shadow-lg mt-5 display-4">Vos transferts</h3>

            <div class="table-responsive">
            <table class="table table-bordered table-striped mb-5">
                <thead>
                    <tr>
                        <th>Date de la demande</th>
                        <th>Demande de </th>
                        <th>Motif</th>
                        <th>Commentaire</th>
                        <th>Valider </th>
                    </tr>
      
                </thead>
                <tbody>
                    @foreach($vostransferts as $vostransfert)
                    
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($vostransfert->created_at)->format('j m Y H:i:s') }}</td>

                        <?php 
                        $reponse = DB::select(DB::raw("SELECT * FROM users WHERE id = '$vostransfert->id_user_dest'"));
                        $value = json_decode(json_encode($reponse), true);
                        $value1 =$value[0]['prenom'];
                        ?>
                        <td>{{$value1}}</td>
                        <td>{{$vostransfert->motif}}</td>
                        <td>{{ $vostransfert->commentaire }}</td>
                        <td><form action="{{route('validertransfert', $vostransfert->id)}}" method="POST">
                            {{ csrf_field() }}
            
                        <div class="row">
                            <div class="col-md-8">
                                <div class="panel panel-bordered">
                                
                                    <input type="hidden" name="id" value="{{ $vostransfert->id}}">
                                    <input type="hidden" name="valide" value="oui">
                                    
                                  

                                    <button type="submit" class="btn btn-success pull-right save">
                                        Valider
                                    </button>

                                </div>
                            </div>
                        </div>
                    </form></td>
                    </tr>
                    @endforeach
                    
                </tbody>
              </table>
            </div>



        </div>

    </div>
    </div>
    </div>
@endsection