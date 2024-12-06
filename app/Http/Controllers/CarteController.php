<?php

namespace App\Http\Controllers;

use App\Repositories\ElecteurRepository;
use Illuminate\Http\Request;

class CarteController extends Controller
{

    protected $electeurRepository;

    public function __construct(ElecteurRepository $electeurRepository){
        $this->electeurRepository =$electeurRepository;
    }


    public function carte(Request $request)
    {
        $electeur = $this->electeurRepository->search($request);
       // dd($electeur);
       $erreur = "Aucun résultat ne correspond à votre recherche sur le fichier électoral.<br>Réessayez, vérifier les informations saisies";

        return view("carte",compact("electeur","erreur"));

    }
}
