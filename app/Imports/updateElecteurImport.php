<?php

namespace App\Imports;

use App\Models\Electeur;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class updateElecteurImport implements ToArray, WithHeadingRow
{
    public function array(array $data)
    {
        $chunks = array_chunk($data, 1000); // Diviser les données en lots de 1000

        foreach ($chunks as $chunk) {
            $this->processChunk($chunk);
        }
    }
    protected function processChunk(array $chunk)
    {
        $updates = [];
        $inserts = [];

        foreach ($chunk as $electeur) {
            $find = DB::table("electeurs")->where("nip_ipn", $electeur['nip_ipn'])->first();
            if ($find) {
                // Échapper les apostrophes dans les valeurs
                $nom = addslashes($electeur['nom']);
                $prenom = addslashes($electeur['prenom']);
                $lieu_naiss = addslashes($electeur['lieu_naiss']);
                $province = addslashes($electeur['province']);
                $commoudept = addslashes($electeur['commoudept']);
                $arrondissement = addslashes($electeur['arrondissement']);
                $centrevote = addslashes($electeur['centrevote']);
                $localisation = addslashes($electeur['localisation']);

                $updates[] = "UPDATE electeurs SET
                    nom = \"$nom\",
                    prenom = '$prenom',
                    date_naiss = '{$electeur['date_naiss']}',
                    lieu_naiss = '$lieu_naiss',
                    province = '$province',
                    commoudept = '$commoudept',
                    arrondissement = '$arrondissement',
                    siege = '{$electeur['siege']}',
                    centrevote = '$centrevote',
                    localisation = '$localisation'
                    WHERE nip_ipn = '{$electeur['nip_ipn']}'";
            } else {
                $inserts[] = [
                    "nip_ipn" => $electeur['nip_ipn'],
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
            }
        }

        if (!empty($updates)) {
            foreach ($updates as $updateQuery) {
                DB::statement($updateQuery);
            }
        }

        if (!empty($inserts)) {
            DB::table('electeurs')->insert($inserts);
        }
    }
        public function chunkSize(): int
    {
        return 2000; // Taille du morceau
    }
}
