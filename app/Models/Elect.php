<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elect extends Model
{
    use HasFactory;
    protected $fillable = [
        'nip_ipn','nom','prenom','date_naiss','lieu_naiss','centrevote_id','province','commoudept',
        'arrondissement','siege','centrevote','localisation','arrondissement_id','commoudept_id','province_id','siege_id'
    ];

}
