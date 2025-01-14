<?php

namespace App\Imports;

use App\Models\Electeur;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ELecteurImport implements ToArray, WithHeadingRow
{
    public function array(array $data)
    {
        foreach ($data as $key => $electeur) {
             $find = DB::table("electeurs")->where("nip_ipn",$electeur['nip_ipn'])->first();
             if($find)
             {
                DB::table("electeurs")->where("nip_ipn",$electeur['nip_ipn'])
                ->update(["nom"=>$electeur['nom'],
                "prenom"=>$electeur['prenom'],
                "date_naiss"=>$electeur['date_naiss'],
                "lieu_naiss"=>$electeur['lieu_naiss'],
                "province"=>$electeur['province'],
                "commoudept"=>$electeur['commoudept'],
                "arrondissement"=>$electeur['arrondissement'],
                "siege"=>$electeur['siege'],
                "centrevote"=>$electeur['centrevote'],
                "localisation"=>$electeur['localisation']]);
             }
             else
             {
                Electeur::create([
                    "nip_ipn"=>$electeur['nip_ipn'],
                    "nom"=>$electeur['nom'],
                    "prenom"=>$electeur['prenom'],
                    "date_naiss"=>$electeur['date_naiss'],
                    "lieu_naiss"=>$electeur['lieu_naiss'],
                    "province"=>$electeur['province'],
                    "commoudept"=>$electeur['commoudept'],
                    "arrondissement"=>$electeur['arrondissement'],
                    "siege"=>$electeur['siege'],
                    "centrevote"=>$electeur['centrevote'],
                    "localisation"=>$electeur['localisation']
                ]);
             }
            
        }

        
    }
    public function chunkSize(): int
    {
        return 50000; // Taille du morceau
    }

}
