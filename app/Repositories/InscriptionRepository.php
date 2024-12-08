<?php
namespace App\Repositories;

use App\Models\Inscription;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class InscriptionRepository extends RessourceRepository{
    public function __construct(Inscription $inscription){
        $this->model = $inscription;
    }

    public function getWithIndentification()
    {
        return DB::table("inscriptions")
        ->join("identifications","inscriptions.identification_id","=","identifications.id")
        ->select("identifications.*","inscriptions.id as inscription")
        ->get();
    }

    
    public function getByIdWithRelation($id)
    {
        return DB::table("inscriptions")
        ->join("centrevotes","inscriptions.centrevote_id","=","centrevotes.id")

        ->join("provinces","centrevotes.province_id","=","provinces.id")
        ->join("commoudepts","centrevotes.commoudept_id","=","commoudepts.id")
        ->leftJoin("arrondissements","centrevotes.arrondissement_id","=","arrondissements.id")

        ->select("inscriptions.*","provinces.province","commoudepts.commoudept","arrondissements.arrondissement","centrevotes.centrevote")
        ->where("inscriptions.id",$id)
        ->first();
    }

    public function count()
    {
        return DB::table("inscriptions")
      
        ->count();
    }


}
