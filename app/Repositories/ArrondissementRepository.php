<?php
namespace App\Repositories;

use App\Models\Arrondissement;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class ArrondissementRepository extends RessourceRepository{
    public function __construct(Arrondissement $arrondissement){
        $this->model = $arrondissement;
    }
    public function getArrondissementAsc(){
        return DB::table("arrondissements")
        ->orderBy("arrondissement","asc")
        ->get();

    }
    public function getAllOnLy(){
        return DB::table("arrondissements")
        ->orderBy("arrondissement","asc")
        ->get();
    }

    public function getByCommouDepartement($commoudepartement)
    {
        return DB::table("commet_arrondissements")
        ->join("arrondissements","commet_arrondissements.arrondissement_id","=","arrondissements.id")
        ->join("commoudepts","commet_arrondissements.commoudept_id","=","commoudepts.id")
        ->distinct()
        ->select("arrondissements.*")
        ->where("commet_arrondissements.commoudept_id",$commoudepartement)
        ->get();
    }
}
