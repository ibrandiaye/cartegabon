<?php
namespace App\Repositories;

use App\Models\Commoudept;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class CommoudeptRepository extends RessourceRepository{
    public function __construct(Commoudept $commoudept){
        $this->model = $commoudept;
    }
    public function getAllWithProvince(){
        return Commoudept::with('province')
        ->get();
    }

    public function getByProvince($province){
        return DB::table("commoudepts")
        ->where("province_id",$province)
        ->orderBy("commoudept","asc")
        ->distinct("commoudept")
        ->get();
}
public function getAllOnLy(){
    return DB::table("commoudepts")
    ->orderBy("commoudept","asc")
    ->get();
}
}
