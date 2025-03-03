<?php

namespace App\Http\Controllers;

use App\Imports\ElectImport;
use App\Models\Elect;
use App\Repositories\ArrondissementRepository;
use App\Repositories\CentrevoteRepository;
use App\Repositories\CommoudeptRepository;
use App\Repositories\ElectRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\SiegeRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelReader;

class ElectController extends Controller
{
    protected $electRepository;
    protected $centrevoteRepository;

    protected $commoudeptRepository;
    protected $provinceRepository;

    protected $siegeRepository;
    protected $arrondissementRepository;
    public function __construct(ElectRepository $electRepository,CentrevoteRepository $centrevoteRepository,CommoudeptRepository $commoudeptRepository,
    ProvinceRepository $provinceRepository,SiegeRepository $siegeRepository,ArrondissementRepository $arrondissementRepository){
        $this->electRepository           =   $electRepository;
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
    public function index(Request $request)
    {
       // $elects = $this->electRepository->getPaginate(n: 20);
      // dd("ok");
      $search = $request->input('search');
      $elects = Elect::where('nip_ipn', 'like', "%$search%")
                  ->paginate(10)
                  ->appends(['search' => $search]);

        return view('elect.index',compact('elects','search'));
    }

    public function allElectApi(){
        $elects = $this->electRepository->getAll();
        return response()->json($elects);
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
        return view('elect.add',compact('centrevotes','commoudepts','provinces','sieges','arrondissements'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $elects = $this->electRepository->store($request->all());
        return redirect('elect');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $elect = $this->electRepository->getById($id);
        return view('elect.show',compact('elect'));
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
        $elect = $this->electRepository->getById($id);
        $commoudepts = $this->commoudeptRepository->getAll();
        $provinces = $this->provinceRepository->getAll();
        $sieges = $this->siegeRepository->getAll();
        $arrondissements = $this->arrondissementRepository->getAll();
        return view('elect.edit',compact('elect','centrevotes','commoudepts','provinces','sieges','arrondissements'));
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
        $this->electRepository->update($id, $request->all());
        return redirect('elect');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->electRepository->destroy($id);
        return redirect('elect');
    }

    public function importExcel(Request $request)
{
    ini_set('max_execution_time', 99999999);
    ini_set('memory_limit', -1);

    $this->validate($request, [
        'file' => 'bail|required|file|mimes:xlsx'
    ]);

    $fichier = $request->file->move(public_path(), $request->file->hashName());
    $reader = SimpleExcelReader::create($fichier);
    $rows = $reader->getRows(); // LazyCollection

    // ⚡ CHARGER EN MÉMOIRE POUR ÉVITER LES REQUÊTES MULTIPLES
    $provinces = $this->provinceRepository->getAll()->keyBy('province');
    $sieges = $this->siegeRepository->getAllOnLy()->keyBy('siege');
    $arrondissements = $this->arrondissementRepository->getAllOnLy()->keyBy('arrondissement');

    $electeurs = [];
    $batchSize = 1000; // Réduction de la taille du lot

    foreach ($rows as $elect) {
        $province_id = $provinces[$elect['province']]->id ?? null;
        $siege_id = $sieges[$elect['siege']]->id ?? null;
        $arrondissement_id = $arrondissements[$elect['arrondissement']]->id ?? null;

        $commoudept_id = null;
        if ($province_id) {
            foreach ($provinces[$elect['province']]->commoudepts as $value) {
                if ($value->commoudept == $elect["commoudept"]) {
                    $commoudept_id = $value->id;
                    break;
                }
            }
        }

        $centrevote = $this->centrevoteRepository->getOneByProvinceAndCommuneOuDepAndcentre(
            $province_id,
            $commoudept_id,
            $elect['centrevote']
        );

        $electeurs[] = [
            "centrevote" => $elect['centrevote'],
            "province_id" => $province_id,
            "siege_id" => $siege_id,
            "commoudept_id" => $commoudept_id,
            "arrondissement_id" => $arrondissement_id,
            "centrevote_id" => $centrevote->id ?? null,
            "nip_ipn" => trim($elect['nip_ipn']),
            "nom" => $elect['nom'],
            "prenom" => $elect['prenom'],
            "date_naiss" => $elect['date_naiss'],
            "lieu_naiss" => $elect['lieu_naiss'],
            "province" => $elect['province'],
            "commoudept" => $elect['commoudept'],
            "siege" => $elect['siege'],
        ];

        // ⚡ INSÉRER PAR LOTS DE 1000 POUR ÉVITER L'ERREUR 1390
        if (count($electeurs) >= $batchSize) {
            Elect::insert($electeurs);
            $electeurs = [];
        }
    }

    // ⚡ INSÉRER LES DONNÉES RESTANTES
    if (!empty($electeurs)) {
        Elect::insert($electeurs);
    }


    $reader->close();
   // unlink($fichier);

    return redirect()->back()->with('success', 'Données importées avec succès.');
}

    public function importExcel2(Request $request)
    {


        ini_set('max_execution_time', 99999999); //10min
        ini_set('memory_limit', -1);
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
      foreach ($rows as $key => $elect) {
        $province_id            = null;
        $siege_id               = null;
        $commoudept_id          = null;
        $arrondissement_id      = null;

        foreach ($provinces as $key1 => $province) {
            if($elect["province"]==$province->province){
                $province_id = $province->id;
                foreach ($province->commoudepts as $key => $value) {
                    if($value->commoudept == $elect["commoudept"])
                    {
                       // dd( $elect["commoudept"],$value->commoudept,$value->commoudept == $elect["commoudept"]);
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
            if($value->arrondissement==$elect['arrondissement'])
            {
                $arrondissement_id = $value->id;
            }
        }

        foreach ($sieges as $key => $value) {
            if($value->siege==$elect['siege'])
            {
                $siege_id = $value->id;
            }
        }
       // dd($elect);
       $centrevote = $this->centrevoteRepository->getOneByProvinceAndCommuneOuDepAndcentre($province_id,$commoudept_id,$elect['centrevote']);
      // dd($province_id,$commoudept_id,$elect['centrevote']);
        Elect::create([
            "centrevote"=>$elect['centrevote'],
            "province_id"=>$province_id,
            "siege_id"=>$siege_id,
            "commoudept_id"=>$commoudept_id,
            "arrondissement_id"=>$arrondissement_id,
            "centrevote_id"=>$centrevote->id,
            "nip_ipn"=>$elect['nip_ipn'],
            "nom"=>$elect['nom'],
            "prenom"=>$elect['prenom'],
            "date_naiss"=>$elect['date_naiss'],
            "lieu_naiss"=>$elect['lieu_naiss'],
            "province"=>$elect['province'],
            "commoudept"=>$elect['commoudept'],
          //  "arrondissement"=>$elect['arrondissement'],
            "siege"=>$elect['siege'],
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
       $elect = $this->electRepository->getBynip_ipn($nip_ipn);
        return response()->json($elect);
    }
    public function importExcels(Request $request)
    {
        ini_set('max_execution_time', 60000); //10min
        ini_set('memory_limit', -1);
        Excel::import(new ElectImport,$request['file']);
        //  dd($data);
         return redirect()->back()->with('success', 'Données importées avec succès.');
    }

    public function countByProvince($province)
    {
        $nb = $this->electRepository->countByProvince($province);
        return response()->json($nb);
    }
    public function countByCommuneOuDepartement($commoudept)
    {
        $nb = $this->electRepository->countByCommuneOuDepartement($commoudept);
        return response()->json($nb);
    }
    public function countByArrondissement($commoudept,$arrondissement)
    {
        $nb = $this->electRepository->countByArrondissement($arrondissement,$commoudept);
        return response()->json($nb);
    }
    public function countByCentrevote($centrevote)
    {
        $nb = $this->electRepository->countByCentrevote($centrevote);
        return response()->json($nb);
    }
}
