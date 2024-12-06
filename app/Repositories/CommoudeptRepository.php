<?php
namespace App\Repositories;

use App\Models\Commoudept;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class CommoudeptRepository extends RessourceRepository{
    public function __construct(Commoudept $commoudept){
        $this->model = $commoudept;
    }
    public function getAllWithRegion(){
        return Commoudept::with('region')
        ->get();
    }

    public function getByRegion($region){
        return DB::table("commoudepts")
        ->where("region_id",$region)
        ->orderBy("commoudept","asc")

        ->get();
}
public function getAllOnLy(){
    return DB::table("commoudepts")
    ->orderBy("commoudept","asc")
    ->get();
}
}
