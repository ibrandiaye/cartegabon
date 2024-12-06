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
        return DB::table("electeurs")
        ->join("centrevotes","electeurs.centrevote_id","=","centrevotes.id")
        ->select("electeurs.*","centrevotes.centrevote")
        ->where("electeurs.nom",$request->nom)->where("electeurs.prenom",$request->prenom)->where("electeurs.nip_ipn",$request->nip_ipn)->first();
    }

}
