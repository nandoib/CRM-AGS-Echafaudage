<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Devisfacture;
use App\Models\Appel;
use App\Models\Mail;
use App\Models\Statutdevis;
use App\Models\Tache;
use App\Models\User;
use App\Models\Article;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CommercialController extends Controller
{
    public function index()
    {
        //$commercial_id = Auth::user()->id;
        $user=Auth::id();
        
        $clients = Client::orderBy('created_at', 'DESC')->get();
      
        $deviss = Devisfacture::where('facture_ou_devis', 'devis')
        ->get();

        $factures = Devisfacture::where('facture_ou_devis', 'facture')
        ->get();

        return view('commercialvue', compact('clients','deviss','factures',));
    }

    public function pageclients()
    {
        $clients = Client::all();

        return view ('pageclients', compact($clients));
    }

 
    public function pagedevis()
    {
        $clients = Client::all();
        //$deviss = Devisfacture::where('facture_ou_devis', 'devis')
        //->get();

       // $factures = Devisfacture::where('facture_ou_devis', 'facture')
        //->get();

        return view('pagedevis', compact('clients','deviss','factures'));
    }

   

    public function pagestatistiques()
    {
        return view('pagestatistiques');
    }

    public function nouveauclient(Request $request){

       // $this->validate($request, [
         //   'nom' => 'bail|unique:App\Models\Client,nom'
        //]);

        $userid = Auth::id();
       
        $nouveauclient= new Client();
        $nouveauclient->id_createur = $userid;
        $nouveauclient->adresse = $request->adresse;
        $nouveauclient->nom = $request->nom;
        $nouveauclient->email = $request->email;
        $nouveauclient->prenom = $request->prenom;
        $nouveauclient->source = $request->source;
        $nouveauclient->temperature = $request->temperature;
        $nouveauclient->telephone = $request->telephone;
        $nouveauclient->commentaire = $request->commentaire; 
        
        $nouveauclient->save();
        $nouveauclient->users()->attach($userid ,['id_user_exp'=>$userid,'valide'=>$request->valide,'commentaire'=>'creation','motif'=>'creation']);
        return redirect(route('vueclient', ['id' =>$nouveauclient->id]));
    }

    public function modifclient(Request $request, $id)
    {
        $client= Client::find($id);
        $client->adresse = $request->adresse;
        $client->nom = $request->nom;
        $client->email = $request->email;
        $client->prenom = $request->prenom;
        $client->source = $request->source;
        $client->temperature = $request->temperature;
        $client->telephone = $request->telephone;
        $client->commentaire = $request->commentaire; 
        
        $client->save();

        return redirect(route('vueclient', ['id' =>$client->id]));
    }

    public function nouvelletache(Request $request)
    {
        $tache= new Tache();
        $tache->id_client = $request->id_client;
        $tache->id_user = $request->id_user;
        $tache->datefinale  = $request->datefinale;
        $tache->type = $request->type;
        $tache->commentaire = $request->commentaire; 
        $tache->save();

        return redirect(route('vueclient', ['id' =>$tache->client->id]));
    }

    public function modiftache(request $request, $id)
    {
        $tache = Tache::find($id);
        $tache->statut = $request->statut;
        $tache->save();

        return redirect(route('vueclient', ['id' =>$tache->client->id]));
    }

    public function modiftachecommercial(Request $request, $id)
    {
        $tache= Tache::find($id);
        $tache->finish_time =$request->finish_hour;
        $tache->valide= 1;
        $tache->save();

        return redirect('index');
    }

    public function nouvelappel(Request $request)
    {
        $appel= new Appel();
        $appel->id_client=$request->id_client;
        $appel->id_user=$request->id_user;
        $appel->motif=$request->motif;
        $appel->entrant_ou_sortant=$request->entrant_ou_sortant;
        $appel->commentaire = $request->commentaire;
        $appel->temperature = $request->temperature;
        $appel->save();

        return redirect(route('vueclient', ['id' =>$appel->client->id]));
    }

    public function nouveaumail(Request $request)
    {
        $mail= new Mail();
        $mail->id_client = $request->id_client;
        $mail->id_user = $request->id_user;
        $mail->objet = $request->objet;
        $mail->entrant_ou_sortant = $request->entrant_ou_sortant;
        $mail->commentaire = $request->commentaire;
        $mail->save();

        return redirect(route('vueclient', ['id' =>$mail->client->id]));
    }

    public function nouveaudevisvue($id)
    {
        $client = Client::find($id);
        
        $articles = Article::all();

        return view('creationdevis', compact('client','articles'));
    }

    public function nouveaudevis(Request $request)
    {
        $userid=Auth::id();

        $devis= new Devisfacture();
        $devis->facture_ou_devis = $request->facture_ou_devis;
        $devis->commentaire = $request->commentaire;
        $devis->montant = 0;
        $devis->id_user=$userid;
        $devis->id_client=$request->idclient;
        $devis->remise=$request->remise;

        $devis->save();

        $totalttc=0;

        for($i=0; $i<count($request->quantite); $i++)
       {

        //on verifie si i: s'agit d'un article custom (si custom $article[$i] est null)
        if ($request->article[$i]){
            $devis->articles()->attach($request->article[$i],['quantite'=>$request->quantite[$i],'prix'=>$request->prix[$i]]);
            $totalttc = $totalttc + $request->prix[$i]*$request->quantite[$i]*1.2;
        }
        else {
            DB::insert('INSERT into article_devisfacture (designation,devisfacture_id,quantite,prix,poids) VALUES (?,?,?,?,?)', [$request->article1[$i], $devis->id,$request->quantite[$i],$request->prix[$i],$request->poids[$i]]);
            $totalttc = $totalttc + $request->prix[$i]*$request->quantite[$i]*1.2;
        }
        }   


       $totalttc = $totalttc - $request->remise;

       $devis->montant = $totalttc;
       $devis->save();

        $statutdevis = new Statutdevis();
        $statutdevis->statut="en cours";
        $statutdevis->temperature=$request->temperature;
        $statutdevis->id_devis=$devis->id;
        $statutdevis->save();

        $now=Carbon::now();

        $now_plus_one_week = $now->addWeek(1);
        
        $tache = new Tache();
        $tache->id_client = $request->idclient;
        $tache->id_user = $userid;
        $tache->datefinale  = $now_plus_one_week;
        $tache->type = "Appel";
        $tache->commentaire = "Relance client suite création devis"; 
        $tache->save();

        return redirect(route('vueclient', ['id' =>$tache->client->id]));
    }

    public function modifdevis(Request $request, $id)
    {
        $devis = Devisfacture::find($id);
        
        $devis->facture_ou_devis = $request->facture_ou_devis;
        $devis->commentaire = $request->newcommentaire;
        $devis->id_user=$request->id_user;
        $devis->id_client=$request->id_client;

        $devis->save(); 
        
        $oldstatut = Statutdevis::where('id_devis', $devis->id)
        ->latest('created_at');

        $oldstatut->delete();

        $statutdevis = new Statutdevis();
        $statutdevis->statut=$request->newstatut;
        $statutdevis->temperature=$request->newtemperature;
        $statutdevis->id_devis=$devis->id;
        $statutdevis->save();

        if ($request->newstatut =="validé"){
            $devis->facture_ou_devis = "facture";
            $devis->save();
        }

        return redirect(route('vueclient', ['id' =>$devis->client->id]));
    }

    public function modifcontenudevis($id, Request $request){
        $devis = Devisfacture::find($id);
        
        $totalTTC = 0;

        DB::table('article_devisfacture')->where('devisfacture_id', $id)->delete();
   
        for($i=0; $i<count($request->quantite); $i++)
        {
         $devis->articles()->attach($request->article[$i],['quantite'=>$request->quantite[$i],'prix'=>$request->prix[$i]]);
         $totalTTC = $totalTTC + $request->quantite[$i]*$request->prix[$i]*1.2;
        }
        $totalTTC = $totalTTC-$request->remise;

        $devis->commentaire = $request->commentaire;
        $devis->montant = $totalTTC;
        $devis->remise = $request->remise;

        $devis->save();

    }

    public function vuemodifdevis($id){
        $devis = Devisfacture::find($id);
        $articlesbdd = Article::all();

        return view('modifdevis', compact('devis','articlesbdd'));
    }
        
        
    public function transfertclient(Request $request,$id)
    {
        
        $client= Client::find($id);
        
        //DB::insert('insert into client_user (id_user_exp,id_user_dest,id_client,commentaire,valide,motif) values (?, ?,?,?,?,?)', ["$request->id_user_exp", "$request->id_user_dest","$id","'$request->commentaire'",'En cours',"'$request->motif'"]);
        if( Auth::user()->role == "admin")
        {
            $valide = "oui";
        }
        else 
        {
            $valide = "en cours";
        }
        
        $client->users()->attach($request->id_user_dest,['id_user_exp'=>$request->id_user_exp,'valide'=>$valide,'commentaire'=>$request->commentaire, 'motif'=>$request->motif]);

        return redirect(route('vueclient', ['id' =>$client->id]));
    }

    public function clientunique($id)
    {
        $commercial_id = Auth::user()->id;
        $client = Client::find($id);

        $commercial = DB::select(DB::raw("SELECT * FROM client_user WHERE id_client = '$client->id' AND valide = 'oui' ORDER BY created_at  LIMIT 1 "));

        $value = json_decode(json_encode($commercial), true);
        $value1 =$value[0]['id_user_dest'];

        if($value1 == $commercial_id){
            $droit_motif_devis = true;
        }
        else{
            $droit_motif_devis = false;
        }
        $appels = Appel::where('id_client',$client->id)->get();
        
        $mails=Mail::where('id_client',$client->id)->get();
        $users = User::all();

        $deviss = Devisfacture::where('id_client', $id)
        ->get();

        $factures = Devisfacture::where('facture_ou_devis', 'facture')
        ->where('id_client', $id)
        ->get();

        $taches = Tache::where('id_client', $id)
        ->get();

        return view('client_unique', compact('deviss','factures','users','mails','appels','taches'),['client'=>$client,'droit_modif_devis'=>$droit_motif_devis]);
    }

    public function modifarticle($id, Request $request)
    {
        $article = Article::find($id);

        $article->designation = $request->designation;
        $article->prix = $request->prix;
        $article->reference = $request->reference;
        $article->poids = $request->poids;
        $article->stock = $request->stock;
        if($request->contenulot)
        {
            $article->contenulot = $request->contenulot;
        }

        $article->save();

        return redirect(route('articles'));
    }

    public function accueil()
    {
        $commercial_id = Auth::id();
        
        $now = Carbon::now()->toDateString();
        

        //script pour mettre un commercial aux clients quand ils viennent d'être enregistrés
        //$clients = Client::all();
        //foreach($clients as $client){
        //$client->users()->attach('1',['id_user_exp'=>'1','valide'=>'oui','commentaire'=>'création', 'motif'=>'creation']);
         //}
            
         if(Auth::user()->role == "admin"){
             $deviss =Devisfacture::all();
         }else{
             $deviss=Devisfacture::where('id_user', $commercial_id)
            ->get();}

        
            if(Auth::user()->role == "admin"){
                $taches= Tache::orderBy('datefinale')
                ->get();
            }else{
                $taches= Tache::where('id_user',$commercial_id)
                ->orderBy('datefinale')
                ->get();
               }
   

        $taches_jour = Tache::where('id_user',$commercial_id)
        ->whereDate('datefinale', '=', $now)
        ->orderBy('created_at', 'DESC')
        ->get();

        if(Auth::user()->role == "admin"){
            $tachesaccomplies = Tache::
            where('statut', 'fait')
            ->orderBy('updated_at', 'DESC')
            ->get();
        }else{
            $tachesaccomplies = Tache::where('id_user',$commercial_id)
            ->where('statut', 'fait')
            ->orderBy('updated_at', 'DESC')
            ->get();
        }
    
        $vostransferts = DB::select(DB::raw("SELECT * FROM client_user WHERE id_user_dest = '$commercial_id' AND valide = 'En cours' ORDER BY created_at"));

        return view('adminvue', compact('deviss','taches','tachesaccomplies','vostransferts','now'));
    }

    public function statsdate()
    {
        return view('statsdate');
    }

    public function validertransfert($id)
    {
        $transfert = DB::select(DB::raw("SELECT * FROM client_user WHERE id = '$id'"));
        
        $value = json_decode(json_encode($transfert), true);
        $value1 =$value[0]['id'];

        DB::statement("UPDATE client_user SET client_user.valide = 'oui' where client_user.id = '$value1'");

        return redirect(route('accueil'));
    }

    public function stats(request $request)
    {
  
        if(!empty($request)){
       
        $date_depart = $request->datedepart;
        $date_fin= $request->datefin;}
        
        else{
            return  redirect(route('statsdate'));
        }

        $nouveaux_clients = Client::whereDate('created_at', '>=', $date_depart)
        ->whereDate('created_at', '<=', $date_fin)
        ->get();

        $nouveauclientscount = $nouveaux_clients->count();

        $nouveaux_devis = Devisfacture::whereDate('created_at', '>=', $date_depart)
        ->whereDate('created_at', '<=', $date_fin)
        ->get();

        $nouveaux_deviscount=$nouveaux_devis->count();
        
        $devis_valides = Devisfacture::whereHas('status', function($q) {
            $q->where('statut', 'valide');
        })
        ->whereDate('created_at', '>=', $date_depart)
        ->whereDate('created_at', '<=', $date_fin)
        ->get();

        $devis_validescount = $devis_valides->count();

        $devis_demande_nouveau_devis = Devisfacture::whereHas('status', function($q) {
            $q->where('statut', 'Refusé : demande nouveau devis');
        })
        ->whereDate('created_at', '>=', $date_depart)
        ->whereDate('created_at', '<=', $date_fin)
        ->get();
        
        $devis_demande_nouveau_deviscount = $devis_demande_nouveau_devis->count();

        $devis_refus_tropcher = Devisfacture::whereHas('status', function($q) {
            $q->where('statut', 'refusé trop cher');
        })
        ->whereDate('created_at', '>=', $date_depart)
        ->whereDate('created_at', '<=', $date_fin)
        ->get();

        $devis_refus_tropchercount = $devis_refus_tropcher->count();
        

        $devis_refus_livraison= Devisfacture::whereHas('status', function($q) {
            $q->where('statut', 'Refusé : livraison trop chère');
        })
        ->whereDate('created_at', '>=', $date_depart)
        ->whereDate('created_at', '<=', $date_fin)
        ->get();

        $devis_refus_livraisoncount = $devis_refus_livraison->count();

        $devis_encours= Devisfacture::whereHas('status', function($q) {
            $q->where('statut', 'En cours');
        })
        ->whereDate('created_at', '>=', $date_depart)
        ->whereDate('created_at', '<=', $date_fin)
        ->get();

        $devis_encourscount = $devis_encours->count();

        $totale_taches= Tache::whereDate('created_at', '>=', $date_depart)
        ->whereDate('created_at', '<=', $date_fin)
        ->get();

        $totale_tachescount =$totale_taches->count();

        $tachesfaites = Tache::whereDate('created_at', '>=', $date_depart)
        ->whereDate('created_at', '<=', $date_fin)
        ->where('statut', 'fait')
        ->get();

        $tachesfaitescount = $tachesfaites->count();

        $tachespasfaites = Tache::whereDate('created_at', '>=', $date_depart)
        ->whereDate('created_at', '<=', $date_fin)
        ->where('statut', 'à faire')
        ->get();

        $appels = Appel::whereDate('created_at', '>=', $date_depart)
        ->whereDate('created_at', '<=', $date_fin)
        ->get();

        $appelscount = $appels->count();

        $mails = Mail::whereDate('created_at', '>=', $date_depart)
        ->whereDate('created_at', '<=', $date_fin)
        ->get();

        $mailscount = $mails->count();

        $tachespasfaitescount = $tachespasfaites->count();

        if($totale_tachescount > 0 ){
        $stat_tachesfaites =  $tachesfaitescount/$totale_tachescount  * 100;}
        else{
            $stat_tachesfaites = 0;
        }

        if($nouveaux_deviscount > 0){
        $stat_signaturedevis = $devis_validescount / $nouveaux_deviscount *100;
        }
        else{
            $stat_signaturedevis = 0;
        }

        return view('stats', compact('date_depart','date_fin','nouveaux_clients','nouveaux_devis','totale_taches','devis_valides', 'totale_taches','tachesfaites','tachespasfaites','nouveauclientscount','stat_tachesfaites','totale_tachescount','nouveaux_deviscount','devis_validescount','stat_signaturedevis','appels','appelscount','mails','mailscount','devis_encourscount','devis_refus_livraisoncount','devis_refus_tropchercount','devis_demande_nouveau_deviscount','tachesfaitescount','tachespasfaitescount'));
    }

    public function articles()
    {
        $articles = Article::orderBy('designation')->get(); 

        return view('articles', compact('articles'));
    }

    public function nouvelarticle(Request $request)
    {
       for($i=0; $i<count($request->stock); $i++)
       {
        $article = new Article;
        $article->designation = $request->designation[$i];
        $article->prix = $request->prix[$i];
        if($request->contenulot){
        $article->contenulot = $request->contenulot[$i];
        }
        $article->stock = $request->stock[$i];
        $article->reference = $request->reference[$i];
        $article->poids = $request->poids[$i];
        $article->save();
       }

       return redirect(route('articles'));
    }

    public function vuedevis($id){
        $devis=Devisfacture::find($id);
        
        //Pour voir la table pivot on fait : foreach ($devis->articles as $article{$article->pivot->quantite (pour voir les donnée de la table pivot
        // et $article->designation pour voir les données de la table article (en passant par les devis))})
        
        return view('devis', compact('devis'));
    }

}