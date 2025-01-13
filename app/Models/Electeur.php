<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Electeur extends Model
{
    protected $fillable = [
        'nip_ipn','nom','prenom','date_naiss','lieu_naiss','centrevote_id','province','commoudept','arrondissement','siege','centrevote'
    ];

    public function centrevote()
    {
        return $this->belongsTo(Centrevote::class);
    }
}
