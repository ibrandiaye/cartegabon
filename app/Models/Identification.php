<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identification extends Model
{
    protected $fillable = [
        'profession','tel','type_piece','num_piece','province_id','commoudept_id','arrondissement_id'/*,'electeur_id'*/,
        'prenom','nom','lieunaiss','datenaiss',"domicile",'nip','handicap'
    ];
}
