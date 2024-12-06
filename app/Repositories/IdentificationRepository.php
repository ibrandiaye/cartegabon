<?php
namespace App\Repositories;

use App\Models\Identification;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class IdentificationRepository extends RessourceRepository{
    public function __construct(Identification $identification){
        $this->model = $identification;
    }

}
