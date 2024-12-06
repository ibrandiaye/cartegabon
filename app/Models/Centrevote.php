<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centrevote extends Model
{
    protected $fillable = [
        'centrevote','siege_id','province_id','commoudept_id','arrondissement_id'
    ];
    public function commoudept()
    {
        return $this->belongsTo(Commoudept::class);
    }
}
