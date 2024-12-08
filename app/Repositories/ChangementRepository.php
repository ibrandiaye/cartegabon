<?php
namespace App\Repositories;

use App\Models\Changement;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class ChangementRepository extends RessourceRepository{
    public function __construct(Changement $changement){
        $this->model = $changement;
    }

    public function getWithIndentification()
    {
        return DB::table("changements")
        ->join("identifications","changements.identification_id","=","identifications.id")
        ->select("identifications.*","changements.id as changement")
        ->get();
    }

    public function getByIdWithRelation($id)
    {
        return DB::table("changements")
        ->join("centrevotes","changements.centrevote_id","=","centrevotes.id")

        ->join("provinces","centrevotes.province_id","=","provinces.id")
        ->join("commoudepts","centrevotes.commoudept_id","=","commoudepts.id")
        ->leftJoin("arrondissements","centrevotes.arrondissement_id","=","arrondissements.id")

        ->select("changements.*","provinces.province","commoudepts.commoudept","arrondissements.arrondissement","centrevotes.centrevote")
        ->where("changements.id",$id)
        ->first();
    }
    public function count()
    {
        return DB::table("changements")
      
        ->count();
    }
}
