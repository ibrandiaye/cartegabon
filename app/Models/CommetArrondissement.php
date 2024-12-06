<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommetArrondissement extends Model
{
    use HasFactory;
    protected $fillable = [
        'commoudept_id','arrondissement_id',];

        public function arrondissement()
        {
            return $this->belongsTo(Arrondissement::class);
        }
        public function commoudept()
        {
            return $this->belongsTo(Commoudept::class);
        }
}
