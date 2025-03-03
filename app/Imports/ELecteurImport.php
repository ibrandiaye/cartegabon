<?php

namespace App\Imports;

use App\Models\Electeur;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ElecteurImport implements ToCollection, WithHeadingRow
{
    protected $batchSize = 5000; // Insérer par lot de 5000 lignes pour éviter les erreurs

    public function collection($rows)
    {
        $electeurs = [];

        foreach ($rows as $electeur) {
            $electeurs[] = [
                "nip_ipn" => trim($electeur['nip_ipn']),
                "nom" => $electeur['nom'],
                "prenom" => $electeur['prenom'],
                "date_naiss" => $electeur['date_naiss'],
                "lieu_naiss" => $electeur['lieu_naiss'],
                "province" => $electeur['province'],
                "commoudept" => $electeur['commoudept'],
                "arrondissement" => $electeur['arrondissement'],
                "siege" => $electeur['siege'],
                "centrevote" => $electeur['centrevote'],
                "localisation" => $electeur['localisation']
            ];

            // Insérer en lot pour améliorer la performance
            if (count($electeurs) >= $this->batchSize) {
                Electeur::insert($electeurs);
                $electeurs = []; // Réinitialiser
            }
        }

        // Insérer les dernières données restantes
        if (!empty($electeurs)) {
            Electeur::insert($electeurs);
        }
    }
}

/*namespace App\Imports;

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
        return 10000; // Taille du morceau
    }

}*/
