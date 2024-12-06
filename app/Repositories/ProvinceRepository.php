<?php
namespace App\Repositories;

use App\Models\Province;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class ProvinceRepository extends RessourceRepository{
    public function __construct(Province $province){
        $this->model = $province;
    }
    public function getProvinceAsc(){
        return DB::table("provinces")
        ->orderBy("province","asc")
        ->get();

    }
    public function getAllOnLy(){
        return DB::table("provinces")
        ->orderBy("province","asc")
        ->get();
    }
}
