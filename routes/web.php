<?php

use App\Http\Controllers\CommercialController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
Route::get('commercial', [CommercialController::class, 'index'])->name('commercial');
Route::get('pageclient', [CommercialController::class, 'pasgeclients']);
Route::get('pageappels', [CommercialController::class, 'pageappels']);
Route::get('pagedevis', [CommercialController::class, 'pagedevis']);
Route::get('pagetaches', [CommercialController::class, 'pagetaches']);
Route::get('pagestatistiques', [CommercialController::class, 'pagestatistique']);

Route::get('vueclient/{id}', [CommercialController::class, 'clientunique'])->name('vueclient');
Route::post('modifclient/{id}', [CommercialController::class, 'modifclient'])->name('modifclient');
Route::post('nouveauclient', [CommercialController::class, 'nouveauclient']);
Route::get('modifclient', [CommercialController::class, 'modifclient']);
Route::post('transfertclient/{id}', [CommercialController::class, 'transfertclient'])->name('transfertclient');
Route::post('nouveaudevis', [CommercialController::class, 'nouveaudevis'])->name('nouveaudevis');
Route::get('nouveaudevis/{id}', [CommercialController::class, 'nouveaudevisvue'])->name('nouveaudevisvue');
Route::post('modifdevis/{id}', [CommercialController::class, 'modifdevis'])->name('modifdevis');
Route::get('vuemodifdevis/{id}',[CommercialController::class, 'vuemodifdevis'])->name('vuemodifdevis');
Route::post('modifcontenudevis/{id}',[CommercialController::class, 'modifcontenudevis'])->name('modifcontenudevis');
Route::post('modiftache/{id}', [CommercialController::class, 'modiftache'])->name('modiftache');
Route::post('nouvelappel', [CommercialController::class, 'nouvelappel'])->name('nouvelappel');
Route::post('nouveaumail', [CommercialController::class, 'nouveaumail'])->name('nouveaumail');
Route::post('nouvelletache', [CommercialController::class, 'nouvelletache'])->name('nouvelletache');
Route::get('stats', [CommercialController::class, 'stats']);
Route::post('stats', [CommercialController::class, 'stats'])->name('stats');
Route::get('statsdate',[CommercialController::class, 'statsdate'])->name('statsdate');
Route::post('validertransfert/{id}', [CommercialController::class, 'validertransfert'])->name('validertransfert');
Route::post('modifarticle/{id}', [CommercialController::class, 'modifarticle'])->name('modifarticle');

Route::get('index', [CommercialController::class, 'index']);
Route::get('accueil', [CommercialController::class, 'accueil'])->name('accueil');
Route::get('articles', [CommercialController::class, 'articles'])->name('articles');
Route::post('nouvelarticle', [CommercialController::class, 'nouvelarticle'])->name('nouvelarticle');
Route::get('vuedevis/{id}',[CommercialController::class, 'vuedevis'])->name('vuedevis');
});
                