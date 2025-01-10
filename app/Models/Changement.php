<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Changement extends Model
{
    protected $fillable = [
        'identification_id','electeur_id','centrevote_id'];
}
