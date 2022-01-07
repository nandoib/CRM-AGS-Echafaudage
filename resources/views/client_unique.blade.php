@extends('layouts.layout')

@section('title')
    {{ $client->prenom}} {{ $client->nom}}
@endsection

@section('content')  

    <div class="container">
        <div class="row">
        
            <h1 class="text-center col-12 display-3"> Client :{{$client->nom}} {{$client->Prenom}}</h1>

            <!-- Button modal Informations client -->
            <button type="button" class="btn btn-primary m-2 p-2" data-toggle="modal" data-target="#infos">
                Informations client
            </button>
                
            <!-- Modal -->
            <div class="modal fade" id="infos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog p-5" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nouveau transfert client</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"> 

                            {{-- Contenu du modal --}}
                            <h2 class="col-12">Informations client</h2>
                            <p class="mt-5"><b>Nom :</b> {{ $client->nom }}<br/></p>
                            <p>Prenom : {{ $client->Prenom }} <br/></p>
                            <p>Adresse : {{ $client->adresse }} <br/></p>
                            <p>Téléphone : {{ $client->telephone }}  <br/></p>
                            <p>Source : {{ $client->source}}<br/></p>
                            <p>Temperature : {{ $client->temperature }} <br/></p> 
                            <p>Enregistré le :{{ \Carbon\Carbon::parse($client->created_at)->format('j m, Y H') }} par {{ $client->createur->prenom}}<br/><p>
                    
                            

                                <!-- Button modal  Modif client -->
            <button type="button" class="btn btn-primary m-2 p-2" data-toggle="modal" data-target="#modifclient">
                Modifier client
            </button>
                
            <!-- Modal -->
            <div class="modal fade" id="modifclient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog p-5" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modification client</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"> 

                            {{-- Contenu du modal --}}

                            <form action="{{ route('modifclient', $client->id) }}" method="POST">
                                @csrf
                                <div class="form-group  col-md-12 " >     
                                  <label class="control-label" for="nom"><strong>Nom</strong></label>
                                  <input type="text"  name="nom" value="{{ old('nom', $client->nom)}}">      
                                </div>
          
                                <div class="form-group  col-md-12 " >     
                                  <label class="control-label" for="prenom"><strong>Prenom</strong></label>
                                  <input type="text"  name="prenom" value="{{ old('prenom', $client->Prenom) }}">      
                                </div>
          
                                <div class="form-group  col-md-12 " >     
                                  <label class="control-label" for="email"><strong>Email</strong></label>
                                  <input type="text"  name="email" value="{{ old('email', $client->email) }}">      
                                </div>
                  
                        
                                <div class="form-group  col-md-12 " >     
                                  <label class="control-label" for="adresse"><strong>Adresse</strong></label>
                                  <input type="text"  name="adresse" value="{{ old('adresse', $client->adresse) }}">      
                                </div>
                  
                                <div class="form-group  col-md-12 " >     
                                  <label class="control-label" for="telephone"><strong>Téléphone</strong></label>
                                  <input type="text"  name="telephone" value="{{ old('telephone', $client->telephone) }}">      
                                </div>
                  
                                <div class="form-group">
                                    <label for="commentaire">commentaire</label>
                                    <textarea class="form-control" required name="commentaire" value="{{ old('commentaire', $client->commentaire) }}" id="commentaire" rows="2"></textarea>
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
            {{-- FIN DU MODAL INFORMATION CLIENT --}}
                           
                            {{-- FIN DU CONTENU DU MODAL --}}
                        </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            </div>
                    </div>
                </div>
            </div>
            {{-- FIN DU MODAL INFORMATION CLIENT --}}


            <!-- Boutton modal transfert client-->
            <button type="button" class="btn btn-primary m-2 p-2" data-toggle="modal" data-target="#transfertclient">
                Transfert client
            </button>
                            
            <!-- Modal -->
            <div class="modal fade" id="transfertclient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nouveau transfert client</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body modal-xl"> 

                            {{-- Contenu du modal --}}
                            <div class="container mt-3 col-3 p-5 ">
                                

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary m-2 p-2" data-toggle="modal" data-target="#transfert">
                                    Demande de transfert
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
                                                 <form method="POST" action="{{route('transfertclient', [$client->id])}}" >
                                                    {{ csrf_field() }}
                                    
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="panel panel-bordered">
                                                                @php 
                                                                    $userdest = DB::select(DB::raw("SELECT * FROM client_user WHERE id_client = '$client->id' AND valide = 'oui'   ORDER BY created_at DESC LIMIT 1"));
                                                                    $valuedest = json_decode(json_encode($userdest), true);
                                                                    $usernamedest = DB::select(DB::raw("SELECT * FROM users WHERE id = '".$valuedest[0]['id_user_exp']."'  "));
                                                                    $usernamefinaldest = json_decode(json_encode($usernamedest), true);
                                                                @endphp
                                                                <input type="hidden" name="id_client" value="{{$client->id }}">
                                                                <input type="hidden" name="valide" value="en cours">
                                                                <input type="hidden" name="id_user_exp" value="{{Auth::id()}}">
                                                           

                                                                <div class="form-group">
                                                                    <label for="email">Nouveau commercial</label>
                                                                    <select class="form-select" aria-label="Default select example" name="id_user_dest">
                                                                        <option selected>Selectionner le commercial</option>
                                                                        @foreach ($users as $user)
                                                                        
                                                                        <option value="{{ $user->id}}">{{ $user->prenom }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="email">motif</label>
                                                                    <select class="form-select" aria-label="Default select example" name="motif">
                                                                        <option selected>Selectionner le motif</option>
                                                                        <option value="client déja connu">client déja connu</option>
                                                                        <option value="absence">absence</option>
                                                                        <option value="pas le temps">Pas le temps</option>
                                                                        <option value="Prise de contact :Facebook">Prise de contact :Facebook</option>
                                                                        <option value="Prise de contact :Annonce Facebook">Prise de contact : Annonce Facebook</option>
                                                                        <option value="Prise de contact :Télephone">Prise de contact : Téléphone</option>
                                                                        <option value="Tentative de commande site">Tentative commande site </option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="commentaire">commentaire</label>
                                                                    <textarea class="form-control" required name="commentaire" id="commentaire" rows="2"></textarea>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div> 
                                    
                                                    <button type="submit" class="btn btn-primary pull-right save">
                                                        Enregistrer
                                                    </button>
                                                </form>
                                                {{-- FIN DU CONTENU DU MODAL --}}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="table-responsive">
                                <table class="table table-bordered table-striped shadow-lg">
                                    <thead>
                                        <tr>
                                        <th>Date de la demande</th>
                                        <th>Motif</th>
                                        <th>Ancien commercial</th>
                                        <th>Nouveau commercial</th>
                                        <th>Demande validée</th>
                                        <th>commentaire</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                      
                                    @php 
                                        //On recupere tout les enrengistrement en BDD pour le client avec son id
                                        $userdest = DB::select(DB::raw("SELECT * FROM client_user WHERE id_client = '$client->id' ORDER BY created_at DESC "));
                                        $valuedest = json_decode(json_encode($userdest), true);
                                    @endphp

                                    <?php
                                        foreach($valuedest as $test)
                                    {?>
                                    <tr>
                                        <td> {{ \Carbon\Carbon::parse($test['created_at'])->format('j m, Y H:i:s') }} </td>
                                        <td> <?php echo $test['motif']; ?> </td>

                                        <?php
                                            $iduserexp = $test['id_user_exp'];
                                            $iduserdest = $test['id_user_dest'];
                                        
                                            $usernameexp = DB::select(DB::raw("SELECT prenom FROM users WHERE id ='$iduserexp'"));
                                            $usernamefinalexp = json_decode(json_encode($usernameexp), true);
                                        ?>
                                            
                                        <td><?php echo $usernamefinalexp[0]['prenom']; ?> </td>
                                        <?php
                                            $usernamedest = DB::select(DB::raw("SELECT prenom FROM users WHERE id ='$iduserdest'"));
                                            $usernamefinaldest = json_decode(json_encode($usernamedest), true);
                                        ?>
                        
                                        <td><?php echo $usernamefinaldest[0]['prenom']; ?></td>
                                        <td><?php echo $test['valide']; ?></td>
                                        <td><?php echo $test['commentaire']; ?></td>
                                    </tr> 
                                    <?php
                                        }   
                                    ?>
                    
                                </table>
                            </div>
                            </div>
                        </div>
                        {{-- FIN DU CONTENU DU MODAL --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

           
            <h3 class="display-4 col-12 text-center mt-5">Devis</h3>

            <a name="" id="" class="btn btn-primary" href="{{ route('nouveaudevisvue', [$client->id]) }}" role="button">Nouveau devis</a>
           

            <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th></th> 
                        <th>Date du devis</th>
                        <th>commercial</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Temperature</th>
                        <th>commentaire</th>
                        @if (Auth::user()->role != "admin")
                            <th>Réponse client</th>     
                        @endif
                    </tr>
                </thead>
                <tbody id="myTable">

                @foreach ($deviss as $devis)
                    <tr>
                        @foreach($devis->status as $statut) @if($loop->last) @if($statut->statut != "validé")

                        <td><a href="{{route('vuemodifdevis', $devis->id)}}">Modifier</a></td>
                        @endif
                        @endif
                        @endforeach
                        <td><a href="{{ route('vuedevis', $devis->id) }}">{{ $devis->created_at }}</a></td>
                        <td><a href="{{ route('vuedevis', $devis->id) }}"> {{ $devis->commercial->prenom }}</a></td>
                        <td>{{ $devis->montant }} € TTC</td> 
                        <td>@foreach($devis->status as $statut){{$statut->statut}} ({{ \Carbon\Carbon::parse($statut->created_at)->format('j m, Y') }}) @if($statut->statut == "En cours")<?php $statutvalide="1"?>@endif<br/> @endforeach</td>
                        <td>@foreach($devis->status as $statut){{$statut->temperature}}<br/> @endforeach</td>
                        <td>{{ $devis->commentaire }}</td>

                        @if(Auth::user()->role != "admin")
                        @foreach($devis->status as $statut) @if($loop->last) @if($statut->statut != "validé")
                        
                
                            <td>  <!-- Button trigger modal nouveau devis -->
                                <button type="button" class="btn btn-success mt-2 p-2 m-2" data-toggle="modal" data-target="#modifdevis{{$devis->id }}">
                                    Réponse client
                                </button>
                    
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
                                            
                                                                <input type="hidden" name="id_client" value="{{$client->id}}">
                                                                <input type="hidden" name="id_user" value="{{Auth::id()}}">                                                                                           
                                                                <input type="hidden" name="facture_ou_devis" value="devis">
                                                                <div class="form-group">
                                                                    <label for="commentaire">commentaire</label>
                                                                    <textarea class="form-control"  name="commentaire" id="commentaire" rows="3"></textarea>
                                                                </div>
            
                                                                <div class="form-group">
                                                                    <label for="statut">statut</label>
                                                                    <select name="newstatut">
                                                                        <option value="refusé : demande nouveau devis">Refusé : demande nouveau devis</option>
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
                                        </div>
                                    </div>
                                </div>
                            </td> 
                            @endif
                           
                           @endif
                           @endforeach
                        @endif
                    </tr>
                @endforeach        
            </table>
        </div>

<div class="row">

            <div class="col-5 appels shadow-lg border m-1 pt-5 pb-5 mb-5">
                <h3 class="display-4 text-center">Appels</h3>

            
            <!-- Button trigger modal nouvel appel -->
            <button type="button" class="btn btn-primary mt-2 p-2 m-2" data-toggle="modal" data-target="#nouvelappel">
                Nouvel appel
            </button>
    
            <!-- Modal -->
            <div class="modal fade" id="nouvelappel" tabindex="-1" role="dialog" aria-labelledby="nouvelappel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="nouvelappel">Nouvel appel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- CONTENU DU MODAL --}}
                            <form action="{{route('nouvelappel')}}" method="POST">
                                {{ csrf_field() }}
        
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="panel panel-bordered">
                            
                                            <input type="hidden" name="id_client" value="{{$client->id}}">
                                            <input type="hidden" name="id_user" value="{{Auth::id()}}">
                    
                                            <div class="form-group">
                                                <label for="motif">Sujet</label>
                                                <input type="text" name="motif">
                                            </div>

                                            <div class="form-group">
                                                <label for="entrant_ou_sortant">Entrant ou sortant</label>
                                                <select name="entrant_ou_sortant">
                                                    <option value="Entrant">Entrant</option>>
                                                    <option value="Sortant">Sortant</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="commentaire">commentaire</label>
                                                <textarea class="form-control"  name="commentaire" id="commentaire" rows="3"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="température">temperature</label>
                                                <select name="temperature">
                                                    <option value="Glacial">Glacial</option>
                                                    <option value="tiède">Tiède</option>
                                                    <option value="Chaud">Chaud</option>
                                                    <option value="Brulant">Brulant</option>
                                                </select>
                                            </div>
                                
                                        </div>
                                    </div>
                                
                                    <button type="submit" class="btn btn-primary pull-right save">
                                        Enregistrer
                                    </button>
                                </div>
                            </form> 
                            {{-- FIN CONTENU MODAL --}}
            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        

        
        <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date de l'appel</th>
                    <th>commercial</th>
                    <th>sujet</th>
                    <th>commentaire</th>
                    <th>entrant ou sortant</th>
                    <th>temperature</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appels as $appel)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($appel->created_at)->format('j m, Y H:i:s') }}</td>
                        <td>{{$appel->user->prenom}}</td>
                        <td>{{$appel->motif}}</td>
                        <td>{{$appel->commentaire}}</td>
                        <td>{{$appel->entrant_ou_sortant}}</td>
                        <td>{{$appel->temperature}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    </div>


 <div class="mails col-5 shadow-lg border offset-1 pt-5 pb-5 mb-5">
    <h3 class="display-4 offset-2">Mails</h3>
       
        <!-- Button trigger modal nouveau mail -->
        <button type="button" class="btn btn-primary mt-2 p-2 m-2" data-toggle="modal" data-target="#nouveaumail">
        Nouveau mail
        </button>

        <!-- Modal -->
        <div class="modal fade" id="nouveaumail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nouveau mail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- CONTENU DU MODAL --}}
                        <form action="{{route('nouveaumail')}}" method="POST">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="panel panel-bordered">
                                        <input type="hidden" name="id_client" value="{{$client->id}}">
                                        <input type="hidden" name="id_user" value="{{Auth::id()}}">

                                        <div class="form-group">
                                            <label for="entrant_ou_sortant">Entrant ou sortant</label>
                                            <select name="entrant_ou_sortant">
                                                <option value="Entrant">Entrant</option>>
                                                <option value="Sortant">Sortant</option>
                                            </select>
                                        </div>
                
                                        <div class="form-group">
                                            <label for="objet">Sujet</label>
                                            <input type="text" name="objet">
                                        </div>

                                        <div class="form-group">
                                            <label for="commentaire">commentaire</label>
                                            <textarea class="form-control" required name="commentaire" id="commentaire" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <button type="submit" class="btn btn-primary pull-right save">
                                Enregistrer
                            </button>
                        </form> 
                        {{-- FIN CONTENU MODAL --}}
    
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date du mail</th>
                    <th>commercial</th>
                    <th>sujet</th>
                    <th>commentaire</th>
                    <th>entrant ou sortant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mails as $mail)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($mail->created_at)->format('j m, Y H:i:s') }}</td>
                        <td>{{$mail->user->prenom}}</td>
                        <td>{{$mail->objet}}</td>
                        <td>{{$mail->commentaire}}</td>
                        <td>{{$mail->entrant_ou_sortant}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>

    <h3 class="display-4 text-center">Taches</h3>

        <!-- Button trigger modal nouvelle tache -->
        <button type="button" class="btn btn-primary mt-2 p-2 m-2" data-toggle="modal" data-target="#nouvelletache">
            Nouvelle tache
        </button>

        <!-- Modal -->
        <div class="modal fade" id="nouvelletache" tabindex="-1" role="dialog" aria-labelledby="nouvelletache" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nouvelletache">Nouvelle tache</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- CONTENU DU MODAL --}}
                        <form action="{{route('nouvelletache')}}" method="POST">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="panel panel-bordered">
                
                                        

                                        @if(Auth::user()->role == 'admin')
                                        <div class="form-group">
                                            <label for="commercial">Commercial</label>
                                            <select name="id_user">
                                                @foreach ($users as $user)
                                                @if($user->role != "admin")
                                                    <option value="{{$user->id}}">{{$user->prenom}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        @else 
                                        <input type="hidden" name="id_user" value="{{Auth::id()}}">
                                        @endif
                                        <input type="hidden" name="id_client" value="{{$client->id}}">

                                        
        
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select name="type">
                                                <option value="Mail">Mail</option>>
                                                <option value="Appel">Appel</option>
                                                <option value="Devis">Devis</option>
                                                <option value="Relance devis">Relance devis</option>
                                                <option value="Facture">Facture</option>
                                            </select>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="commentaire">Détails</label>
                                            <textarea class="form-control" required name="commentaire" id="commentaire" rows="4"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="datefinale">Tache à effectuer avant le </label>
                                            <input type='date' name="datefinale">
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <button type="submit" class="btn btn-primary pull-right save">
                                Enregistrer
                            </button>
                        </form> 
                        {{-- FIN CONTENU MODAL --}}

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</div>

    <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Date de création</th>
                <th>commercial</th>
                <th>type</th>
                <th>commentaire</th>
                <th>a faire avant le </th>
                <th>statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($taches as $tache)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($tache->created_at)->format('j m, Y H:i') }}</td>
                    <td>{{$tache->user->prenom}}</td>
                    <td>{{$tache->type}}</td>
                    <td>{{$tache->commentaire}}</td>
                    <td>{{$tache->datefinale}}</td>
                    <td>{{$tache->statut}}</td>
                </tr>
            @endforeach
    
        </tbody>
    </table>
</div>

</div>
    <script>
    $(document).ready(function(){
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    });
    </script>

@endsection