<?php
namespace App\Repositories;

use App\Models\Centrevote;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class CentrevoteRepository extends RessourceRepository{
    public function __construct(Centrevote $centrevote){
        $this->model = $centrevote;
    }
    public function nbCentreVote(){
        return   DB::table('centrevotes')
        ->count();
        //->get();


    }
    public function getAllCentre(){
        return Centrevote::with('commoudept')
        ->get();
    }
    public function getByCommoudept($commoudept){
        return DB::table("centrevotes")
        ->where("commoudept_id",$commoudept)
        ->orderBy("centrevote","asc")
        ->get();
    }
    public function getByArrondissement($arrondissement){
        return DB::table("centrevotes")
        ->where("arrondissement_id",$arrondissement)
        ->orderBy("centrevote","asc")
        ->get();
    }
public function getAllOnly(){
    return DB::table("centrevotes")->get();
}



public function countByProvinces($provinces){
    return DB::table("centrevotes")
    ->join("commoudepts","centrevotes.commoudept_id","=","commoudepts.id")
    ->join("provinces","commoudepts.province_id","=","provinces.id")
    ->where("provinces.id",$provinces)
    ->count();
}
public function countByCommoudept($commoudept){
    return DB::table("centrevotes")
    ->join("commoudepts","centrevotes.commoudept_id","=","commoudepts.id")
    ->where("commoudepts.id",$commoudept)
    ->count();
}


}
