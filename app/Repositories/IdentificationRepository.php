<?php
namespace App\Repositories;

use App\Models\Identification;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class IdentificationRepository extends RessourceRepository{
    public function __construct(Identification $identification){
        $this->model = $identification;
    }

    public function getByIdWithRelation($id)
    {
        return DB::table("identifications")
        ->join("provinces","identifications.province_id","=","provinces.id")
        ->join("commoudepts","identifications.commoudept_id","=","commoudepts.id")
        ->leftJoin("arrondissements","identifications.arrondissement_id","=","arrondissements.id")

        ->select("identifications.*","provinces.province","commoudepts.commoudept","arrondissements.arrondissement")
        ->where("identifications.id",$id)
        ->first();
    }


}
