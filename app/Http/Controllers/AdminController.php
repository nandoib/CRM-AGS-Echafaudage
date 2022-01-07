<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;

class AdminController extends Controller
{
    public function index()
    {
        return view('adminvue');
    }

    public function nouveauclient(ClientRequest $request)
    {
        $users = User::all();
        $nouveauclient= new Client();

        $nouveauclient->id_createur = $request->id_createur;
        $nouveauclient->adresse = $request->adresse;
        $nouveauclient->nom = $request->nom;
        $nouveauclient->prenom = $request->prenom;
        $nouveauclient->source = $request->source;
        $nouveauclient->temperature = $request->temperature;
        $nouveauclient->telephone = $request->telephone;
        $nouveauclient->commentaire = $request->commentaire; 
        $nouveauclient->save();

        return view('adminvue',compact($users));
    }




}
