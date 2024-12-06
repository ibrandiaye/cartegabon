<?php
namespace App\Repositories;

use App\Models\Inscription;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class InscriptionRepository extends RessourceRepository{
    public function __construct(Inscription $inscription){
        $this->model = $inscription;
    }

}
