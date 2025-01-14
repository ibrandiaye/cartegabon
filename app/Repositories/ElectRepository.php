<?php
namespace App\Repositories;

use App\Models\Elect;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class ElectRepository extends RessourceRepository{
    public function __construct(Elect $elect){
        $this->model = $elect;
    }

    public function search($request)
    {
        $requete = DB::table(table: "elects");
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
    /*    return DB::table(table: "elects")
       // ->join("centrevotes","elects.centrevote_id","=","centrevotes.id")
       // ->select("elects.*","centrevotes.centrevote")
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
    public function count()
{
    return DB::table("elects")
  
    ->count();
}
public function countByProvince($province)
{
    return DB::table("elects")
    ->where("province_id",$province)
    ->count();
}
public function countByCommuneOuDepartement($commoudept_id)
{
    return DB::table("elects")
    ->where("commoudept_id",$commoudept_id)
    ->count();
}
public function countByArrondissement($arrondissement_id,$commoudept_id)
{
    return DB::table("elects")
    ->where("arrondissement_id",$arrondissement_id)
    ->where("commoudept_id",$commoudept_id)
    ->count();
}
public function countByCentrevote($centrevote)
{
    return DB::table("elects")
    ->where("centrevote_id",$centrevote)
    ->count();
}

}
