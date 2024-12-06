<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'province'
    ];
    public function commoudepts()
    {
        return $this->hasMany(Commoudept::class);
    }


}
