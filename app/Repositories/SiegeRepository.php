<?php
namespace App\Repositories;

use App\Models\Siege;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class SiegeRepository extends RessourceRepository{
    public function __construct(Siege $siege){
        $this->model = $siege;
    }
    public function getSiegeAsc(){
        return DB::table("sieges")
        ->orderBy("siege","asc")
        ->get();

    }
    public function getAllOnLy(){
        return DB::table("sieges")
        ->orderBy("siege","asc")
        ->get();
    }
}
