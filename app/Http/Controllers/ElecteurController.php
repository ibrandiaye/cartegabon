<?php

namespace App\Http\Controllers;

use App\Imports\ELecteurImport;
use App\Models\Electeur;
use App\Repositories\ArrondissementRepository;
use App\Repositories\CentrevoteRepository;
use App\Repositories\CommoudeptRepository;
use App\Repositories\ElecteurRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\SiegeRepository;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;
use Maatwebsite\Excel\Facades\Excel;

class ElecteurController extends Controller
{
    protected $electeurRepository;
    protected $centrevoteRepository;

    protected $commoudeptRepository;
    protected $provinceRepository;

    protected $siegeRepository;
    protected $arrondissementRepository;
    public function __construct(ElecteurRepository $electeurRepository,CentrevoteRepository $centrevoteRepository,CommoudeptRepository $commoudeptRepository,
    ProvinceRepository $provinceRepository,SiegeRepository $siegeRepository,ArrondissementRepository $arrondissementRepository){
        $this->electeurRepository           =   $electeurRepository;
        $this->centrevoteRepository         =   $centrevoteRepository;
        $this->siegeRepository              =   $siegeRepository;
        $this->arrondissementRepository     =   $arrondissementRepository;
        $this->provinceRepository           =   $provinceRepository;
        $this->commoudeptRepository         =   $commoudeptRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $electeurs = $this->electeurRepository->getPaginate(500);
        return view('electeur.index',compact('electeurs'));
    }

    public function allElecteurApi(){
        $electeurs = $this->electeurRepository->getAll();
        return response()->json($electeurs);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $centrevotes = $this->centrevoteRepository->getAll();
        $commoudepts = $this->commoudeptRepository->getAll();
        $provinces = $this->provinceRepository->getAll();
        $sieges = $this->siegeRepository->getAll();
        $arrondissements = $this->arrondissementRepository->getAll();
        return view('electeur.add',compact('centrevotes','commoudepts','provinces','sieges','arrondissements'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $electeurs = $this->electeurRepository->store($request->all());
        return redirect('electeur');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $electeur = $this->electeurRepository->getById($id);
        return view('electeur.show',compact('electeur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $centrevotes = $this->centrevoteRepository->getAll();
        $electeur = $this->electeurRepository->getById($id);
        $commoudepts = $this->commoudeptRepository->getAll();
        $provinces = $this->provinceRepository->getAll();
        $sieges = $this->siegeRepository->getAll();
        $arrondissements = $this->arrondissementRepository->getAll();
        return view('electeur.edit',compact('electeur','centrevotes','commoudepts','provinces','sieges','arrondissements'));
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
        $this->electeurRepository->update($id, $request->all());
        return redirect('electeur');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->electeurRepository->destroy($id);
        return redirect('electeur');
    }

    public function importExcel1(Request $request)
    {
        $this->validate($request, [
            'file' => 'bail|required|file|mimes:xlsx'
        ]);

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
      foreach ($rows as $key => $commoudept) {
        $province_id            = null;
        $siege_id               = null;
        $commoudept_id          = null;
        $arrondissement_id      = null;

        foreach ($provinces as $key1 => $province) {
            if($commoudept["province"]==$province->province){
                $province_id = $province->id;
                foreach ($province->commoudepts as $key => $value) {
                    if($value->commoudept == $commoudept["commoudept"]);
                    {
                        $commoudept_id = $value->id;
                    }
                }
               /* Commoudept::create([
                    "commoudept"=>$commoudept['commoudept'],
                    "province_id"=>$province->id
                ]);*/

            }
        }

        foreach ($arrondissements as $key => $value) {
            if($value->arrondissement==$commoudept['arrondissement'])
            {
                $arrondissement_id = $value->id;
            }
        }

        foreach ($sieges as $key => $value) {
            if($value->siege==$commoudept['siege'])
            {
                $siege_id = $value->id;
            }
        }

        Electeur::create([
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

    public function getBynip_ipn($nip_ipn)
    {
       $electeur = $this->electeurRepository->getBynip_ipn($nip_ipn);
        return response()->json($electeur);
    }
    public function importExcel(Request $request)
    {
        ini_set('max_execution_time', 60000); //10min
        ini_set('memory_limit', -1);
        Excel::import(new ELecteurImport,$request['file']);
        //  dd($data);
         return redirect()->back()->with('success', 'Données importées avec succès.');
    }
}
