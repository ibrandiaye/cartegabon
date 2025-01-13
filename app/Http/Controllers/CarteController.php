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
       
        if((empty($request->nom) && empty($request->prenom)) || empty($request->nip_ipn) )
        {
            return redirect()->back()->with(["error"=>" le Champ NIP et le nom ou le prenom doivent être  renseignés"])->withInput();
        }
        $electeur = $this->electeurRepository->search($request);
       // dd($electeur);
       $nom = $request->nom;
       $prenom = $request->prenom;
       $nip = $request->nip_ipn;
       if(empty($electeur))
       {
        $erreur = "Aucun résultat ne correspond à votre recherche sur le fichier électoral.<br>Réessayez, vérifier les informations saisies";
        $nom = $request->nom;
        $prenom = $request->prenom;
        $nip = $request->nip_ipn;
       }
       else
       {
        $nom = "";
        $prenom = "";
        $nip = "";
       }

        return view("carte",compact("electeur","erreur","nom","prenom","nip"));

    }
}
