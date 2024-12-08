<?php

namespace App\Imports;

use App\Models\CommetArrondissement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CommetArrondissementImport implements ToArray, WithHeadingRow
{
    public function array(array $data)
    {
        $arrondissements = DB::table("arrondissements")->get();
        $commoudepts= DB::table("commoudepts")->get();
        foreach ($data as $key => $commetarrondissement) {
          $commoudept_id = null;
          $arrondissement_id = null;
          foreach ($commoudepts as $key1 => $commoudept) {
              if($commetarrondissement["commoudept"]==$commoudept->commoudept){
  
                  $commoudept_id = $commoudept->id;
              }
          }
          foreach ($arrondissements as $key1 => $arrondissement) {
              if($commetarrondissement["arrondissement"]==$arrondissement->arrondissement){
  
                  $arrondissement_id = $arrondissement->id;
              }
          }
          CommetArrondissement::create([
              "arrondissement_id"=>$arrondissement_id,
              "commoudept_id"=>$commoudept_id
          ]);
  
      }
    }   
}
