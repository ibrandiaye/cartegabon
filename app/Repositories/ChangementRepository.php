<?php
namespace App\Repositories;

use App\Models\Changement;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class ChangementRepository extends RessourceRepository{
    public function __construct(Changement $changement){
        $this->model = $changement;
    }

}
