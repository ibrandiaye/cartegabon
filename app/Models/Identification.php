<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identification extends Model
{
    protected $fillable = [
        'profession','tel','type_piece','num_piece','province','commoudept','arrondissement'/*,'electeur_id'*/,
        'prenom','nom','lieunaiss','datenaiss',"domcile",'nip'
    ];
}
