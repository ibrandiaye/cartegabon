<?php

use App\Http\Controllers\ArrondissementController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\CentrevoteController;
use App\Http\Controllers\ChangementController;
use App\Http\Controllers\CommetArrondissementController;
use App\Http\Controllers\CommoudeptController;
use App\Http\Controllers\ElectController;
use App\Http\Controllers\ElecteurController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\SiegeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
})->middleware("auth");
*/
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('province', ProvinceController::class)->middleware("auth");
Route::resource('commoudept', CommoudeptController::class)->middleware("auth");
Route::post('/importer/province',[ProvinceController::class,'importExcel'])->name("importer.province")->middleware("auth");
Route::post('/importer/commoudept',[CommoudeptController::class,'importExcel'])->name("importer.commoudept")->middleware("auth");

Route::resource('siege', SiegeController::class)->middleware("auth");
Route::resource('arrondissement', ArrondissementController::class)->middleware("auth");
Route::post('/importer/siege',[SiegeController::class,'importExcel'])->name("importer.siege")->middleware("auth");
Route::post('/importer/arrondissement',[ArrondissementController::class,'importExcel'])->name("importer.arrondissement")->middleware("auth");
Route::resource('centrevote', CentrevoteController::class)->middleware("auth");
Route::post('/importer/centrevote',[CentrevoteController::class,'importExcel'])->name("importer.centrevote")->middleware("auth");

Route::resource('electeur', ElecteurController::class)->middleware("auth");
Route::post('/importer/electeur',[ElecteurController::class,'importExcel'])->name("importer.electeur")->middleware("auth");


Route::get('/', function () {
    $electeur = null;
    $erreur = null;
    $nom = null;
    $prenom = null;
    $nip = null;
    return view('carte',compact("electeur","erreur","nom","prenom","nip"));
})->name("carte");
Route::get('/carte', function () {
    $electeur = null;
    $erreur = null;
    $nom = null;
    $prenom = null;
    $nip = null;
    return view('carte',compact("electeur","erreur","nom","prenom","nip"));
})->name("carte");
Route::post('/carte',[CarteController::class,'carte'])->name("carte.search");//->middleware("auth");

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('inscription', InscriptionController::class)->middleware("auth");
Route::resource('changement', ChangementController::class)->middleware("auth");

Route::resource('commetarrondissement', CommetArrondissementController::class)->middleware("auth");
Route::post('/importer/commetarrondissement',[CommetArrondissementController::class,'importExcel'])->name("importer.commetarrondissement")->middleware("auth");

Route::get('/commoudept/by/province/{province}',[CommoudeptController::class,'getByProvince']);

Route::get('/arrondissement/by/commoudept/{commoudept}',[ArrondissementController::class,'getByCommouDepartement']);

Route::get('/centrevote/by/commoudept/{commoudept}',[CentrevoteController::class,'getBycommoudept']);

Route::get('/centrevote/by/arrondissement/{arrondissement}/{commoudept}',[CentrevoteController::class,'getByArrondissement']);

Route::get('/electeur/by/nip_ipn/{nip_ipn}',[ElecteurController::class,'getBynip_ipn']);


Route::get('/inscriptions', function () {
    
    return view('inscription');
});

Route::get('/generer/pdf',[HomeController::class,'generatePDF'])->middleware("auth");


Route::get('/modifier/motdepasse',[UserController::class,'modifierMotDePasse'])->name("modifier.motdepasse")->middleware(['auth']);
Route::post('/update/password',[UserController::class,'updatePassword'])->name("user.password.update")->middleware(["auth"]);
Route::resource("user",controller:UserController::class)->middleware(["auth"]);


Route::resource('elect', ElectController::class)->middleware("auth");
Route::post('/importer/elect',[ElectController::class,'importExcel'])->name("importer.elect")->middleware("auth");



Route::get('/elect/by/province/{province}',[ElectController::class,'countByProvince']);

Route::get('/elect/by/commoudept/{commoudept}',[ElectController::class,'countByCommuneOuDepartement']);

Route::get('/elect/by/arrondissement/{commoudept}/{arrondissement}',[ElectController::class,'countByArrondissement']);

Route::get('/elect/by/centrevote/{centrevote}',[ElectController::class,'countByCentrevote']);
