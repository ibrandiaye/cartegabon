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
        //        ->where("electeurs.nom",$request->nom)->where("electeurs.prenom",$request->prenom)->where("electeurs.nip_ipn",$request->nip_ipn)->first();

        $erreur  ="";
        if(empty($request->nom) ||empty($request->prenom) || empty($request->nip_ipn) )
        {
            return redirect()->back()->with(["error"=>"Toutes les Champs sont obligatoires"])->withInput();
        }
        $electeur = $this->electeurRepository->search($request);
       // dd($electeur);
       if(empty($electeur))
        $erreur = "Aucun résultat ne correspond à votre recherche sur le fichier électoral.<br>Réessayez, vérifier les informations saisies";

        return view("carte",compact("electeur","erreur"));

    }
}
