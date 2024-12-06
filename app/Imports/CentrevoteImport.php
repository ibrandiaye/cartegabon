<?php

namespace App\Imports;

use App\Models\Centrevote;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CentrevoteImport implements ToArray, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function array(array $data)
    {
        $provinces        = DB::table("provinces")->get();;
        $sieges           = DB::table("sieges")->get();;
        $arrondissements  = DB::table("arrondissements")->get();;
        $commoudepts      = DB::table("commoudepts")->get();;


        foreach ($data as $key => $commoudept) {
            $siege_id               = null;
            $province_id            = null;
            $commoudept_id          = null;
            $arrondissement_id      = null;

            foreach ($provinces as $key1 => $province) {



                if($commoudept["province"]==$province->province){
                    $province_id = $province->id;


                }
            }


            foreach ($commoudepts as $key => $value) {

                //dd($value->commoudept, $this->cleanString($commoudept["commoudept"]));

                $chaine = $commoudept["commoudept"];
                if($value->commoudept == $chaine)
                {
                   // dd($value->commoudept== $chaine);
                    $commoudept_id = $value->id;

                }

            }
          //  dd( $commoudept_id);



            foreach ($sieges as $key => $value) {
                if($value->siege==$commoudept['siege'])
                {
                    $siege_id = $value->id;
                }
            }
            foreach ($arrondissements as $key => $value) {
                if($value->arrondissement==$commoudept['arrondissement'])
                {
                    $arrondissement_id = $value->id;
                }
            }
            //dd($province_id );

            Centrevote::create([
                "centrevote"=>$commoudept['centrevote'],
                "province_id"=>$province_id,
                "siege_id"=>$siege_id,
                "commoudept_id"=>$commoudept_id,
                "arrondissement_id"=>$arrondissement_id,
            ]);

        }

       // dd($data);
}
}
