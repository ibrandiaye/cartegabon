<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commoudept extends Model
{

    protected $fillable = [
        'commoudept','siege_id','province_id'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
