<?php
namespace App\Repositories;

use App\Models\CommetArrondissement;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class CommetArrondissementRepository extends RessourceRepository{
    public function __construct(CommetArrondissement $commetarrondissement){
        $this->model = $commetarrondissement;
    }

}
