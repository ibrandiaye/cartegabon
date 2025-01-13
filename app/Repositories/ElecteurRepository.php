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
        return DB::table(table: "electeurs")
       // ->join("centrevotes","electeurs.centrevote_id","=","centrevotes.id")
       // ->select("electeurs.*","centrevotes.centrevote")
        ->where("nom",$request->nom)
        ->where("prenom",$request->prenom)
        ->where("nip_ipn",$request->nip_ipn)
        ->first();
    }

    public function getBynip_ipn($nip)
    {
        return DB::table(table: "electeurs")
        ->join("centrevotes","electeurs.centrevote_id","=","centrevotes.id")
        ->select("electeurs.*","centrevotes.centrevote","centrevotes.province_id","centrevotes.commoudept_id","centrevotes.arrondissement_id")
        ->where("electeurs.nip_ipn",$nip)
        ->first();

    }

}
