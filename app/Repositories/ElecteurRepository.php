<?php
namespace App\Repositories;

use App\Models\Electeur;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class ElecteurRepository extends RessourceRepository{
    public function __construct(Electeur $electeur){
        $this->model = $electeur;
    }

    public function search($request)
    {
        $requete = DB::table(table: "electeurs");
        if($request->nip_ipn )
        {
            $requete = $requete->where("nip_ipn",$request->nip_ipn);
            if($request->nom)
            {
                $requete = $requete->where("nom",$request->nom);
            }
            if($request->prenom)
            {
                $requete = $requete->where("prenom",$request->prenom);
            }
            return $requete->first();
        }
        else
        {
            return null;
        }
    /*    return DB::table(table: "electeurs")
       // ->join("centrevotes","electeurs.centrevote_id","=","centrevotes.id")
       // ->select("electeurs.*","centrevotes.centrevote")
        ->where("nom",$request->nom)
        ->where("prenom",$request->prenom)
        ->where("nip_ipn",$request->nip_ipn)
        ->first();*/
    }

    public function getBynip_ipn($nip)
    {
        return DB::table(table: "elects")
        ->join("centrevotes","elects.centrevote_id","=","centrevotes.id")
        ->select("elects.*","centrevotes.centrevote","centrevotes.province_id","centrevotes.commoudept_id","centrevotes.arrondissement_id")
        ->where("elects.nip_ipn",$nip)
        ->first();

    }

    public function truncateTable()
    {
        return DB::table('electeurs')->truncate();
    }
    public function truncateChangement()
    {
        return DB::table('changements')->truncate();
    }
    public function truncateInscription()
    {
        return DB::table('inscriptions')->truncate();
    }
  

}
