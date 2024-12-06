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
}
