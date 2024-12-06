<?php

namespace App\Http\Controllers;

use App\Models\Arrondissement;
use App\Repositories\ArrondissementRepository;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

class ArrondissementController extends Controller
{
    protected $arrondissementRepository;

    public function __construct(ArrondissementRepository $arrondissementRepository){
        $this->arrondissementRepository =$arrondissementRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrondissements = $this->arrondissementRepository->getAll();
        return view('arrondissement.index',compact('arrondissements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('arrondissement.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arrondissements = $this->arrondissementRepository->store($request->all());
        return redirect('arrondissement');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $arrondissement = $this->arrondissementRepository->getById($id);
        return view('arrondissement.show',compact('arrondissement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arrondissement = $this->arrondissementRepository->getById($id);
        return view('arrondissement.edit',compact('arrondissement'));
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
        $this->arrondissementRepository->update($id, $request->all());
        return redirect('arrondissement');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->arrondissementRepository->destroy($id);
        return redirect('arrondissement');
    }
    public function    allArrondissementapi(){
        $arrondissements = $this->arrondissementRepository->getAllOnLy();
        return response()->json($arrondissements);
    }
    public function importExcel(Request $request)
{

   /*   $data =  Excel::import(new ArrondissementImport,$request['file']);
 //   dd($data);

    return redirect()->back()->with('success', 'Données importées avec succès.'); */
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
    $status = Arrondissement::insert($rows->toArray());

    // Si toutes les lignes sont insérées
    if ($status) {

        // 5. On supprime le fichier uploadé
        $reader->close(); // On ferme le $reader
       // unlink($fichier);

        // 6. Retour vers le formulaire avec un message $msg
        return back()->withMsg("Importation réussie !");

    } else { abort(500); }
}
}
