<?php

namespace App\Http\Controllers;

use App\Imports\CentrevoteImport;
use App\Models\Centrevote;
use App\Repositories\ArrondissementRepository;
use App\Repositories\CentrevoteRepository;
use App\Repositories\CommoudeptRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\SiegeRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelReader;

class CentrevoteController extends Controller
{
    protected $centrevoteRepository;
    protected $commoudeptRepository;
    protected $provinceRepository;

    protected $siegeRepository;
    protected $arrondissementRepository;
    public function __construct(CentrevoteRepository $centrevoteRepository, CommoudeptRepository $commoudeptRepository,
    ProvinceRepository $provinceRepository,SiegeRepository $siegeRepository,ArrondissementRepository $arrondissementRepository){
        $this->centrevoteRepository         =   $centrevoteRepository;
        $this->commoudeptRepository         =   $commoudeptRepository;
        $this->siegeRepository              =   $siegeRepository;
        $this->arrondissementRepository     =   $arrondissementRepository;
        $this->provinceRepository           =   $provinceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $centrevotes = $this->centrevoteRepository->getAllCentre();
        return view('centrevote.index',compact('centrevotes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $commoudepts = $this->commoudeptRepository->getAll();
        $provinces = $this->provinceRepository->getAll();
        $sieges = $this->siegeRepository->getAll();
        $arrondissements = $this->arrondissementRepository->getAll();
     //   $commoudepts = $this->commoudeptRepository->getAll();
        return view('centrevote.add',compact('commoudepts','provinces','sieges','arrondissements'));
    }
    public function allCentrevoteApi(){
        $centrevotes = $this->centrevoteRepository->getAllOnly();
        return response()->json($centrevotes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $centrevotes = $this->centrevoteRepository->store($request->all());
        return redirect('centrevote');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $centrevote = $this->centrevoteRepository->getById($id);
        return view('centrevote.show',compact('centrevote'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $commoudepts = $this->commoudeptRepository->getAll();
        $centrevote = $this->centrevoteRepository->getById($id);
        return view('centrevote.edit',compact('centrevote','commoudepts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->centrevoteRepository->update($id, $request->all());
        return redirect('centrevote');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->centrevoteRepository->destroy($id);
        return redirect('centrevote');
    }
    public function importExcel(Request $request)
    {
        Excel::import(new CentrevoteImport,$request['file']);
        //  dd($data);
         return redirect()->back()->with('success', 'Données importées avec succès.');
    }
    public function importExcels(Request $request)
    {
       /* $this->validate($request, [
            'file' => 'bail|required|file|mimes:xlsx'
        ]);*/

        // 2. On déplace le fichier uploadé vers le dossier "public" pour le lire
        $fichier = $request->file->move(public_path(), $request->file->hashName());

        // 3. $reader : L'instance Spatie\SimpleExcel\SimpleExcelReader
        $reader = SimpleExcelReader::create($fichier);

        // On récupère le contenu (les lignes) du fichier
        $rows = $reader->getRows();

        // $rows est une Illuminate\Support\LazyCollection

        // 4. On insère toutes les lignes dans la base de données
      //  $rows->toArray());
      $provinces        = $this->provinceRepository->getAll();
      $sieges           = $this->siegeRepository->getAllOnLy();
      $arrondissements  = $this->arrondissementRepository->getAllOnLy();
      $commoudepts      = $this->commoudeptRepository->getAllOnLy();
      foreach ($rows as $key => $commoudept) {
        $siege_id               = null;
        $province_id            = null;
        $commoudept_id          = null;
        $arrondissement_id      = null;

        foreach ($provinces as $key1 => $province) {



            if($commoudept["province"]==$province->province){
                $province_id = $province->id;


               /* Commoudept::create([
                    "commoudept"=>$commoudept['commoudept'],
                    "province_id"=>$province->id
                ]);*/

            }
        }


        foreach ($commoudepts as $key => $value) {

            //dd($value->commoudept, $this->cleanString($commoudept["commoudept"]));

            $chaine = $this->cleanString($commoudept["commoudept"]);
            if($value->commoudept == $chaine)
            {
                dd($value->commoudept== $chaine);
                $commoudept_id = $value->id;

            }

        }
        dd( $commoudept_id);



        foreach ($sieges as $key => $value) {
            if($value->siege==$this->cleanString($commoudept['siege']))
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
            // 5. On supprime le fichier uploadé
            $reader->close(); // On ferme le $reader
           // unlink($fichier);

            // 6. Retour vers le formulaire avec un message $msg
            return redirect()->back()->with('success', 'Données importées avec succès.');
    }
   /* public function getBycommoudept($commoudept){
        $centrevotes = $this->centrevoteRepository->getByCommoudept($commoudept);
        $nbCentre =  $this->centrevoteRepository->countByCommoudept($commoudept);
       /* $nbBureau =  $this->lieuvoteRepository->countByCommoudept($commoudept);
        $electeurs = $this->lieuvoteRepository->sumByCommoudept($commoudept);*/
       // $data=array("centrevotes"=>$centrevotes,"nbCentre"=>$nbCentre/*,"nbbureau"=>$nbBureau,
   // "electeur"=>$electeurs*/);
    //    return response()->json($data);
    //}

    public function getBycommoudept($commoudept){
        $centrevotes = $this->centrevoteRepository->getByCommoudept($commoudept);
        return response()->json($centrevotes);

    }
    public function getByArrondissement($arrondissement,$commoudept){
        $centrevotes = $this->centrevoteRepository->getByArrondissement($arrondissement,$commoudept);
        return response()->json($centrevotes);

    }

    private function cleanString($value)
    {
        return str_replace("\u{A0}", ' ', $value);
    }
}
