<?php

namespace App\Http\Controllers;

use App\Models\CommetArrondissement;
use App\Repositories\ArrondissementRepository;
use App\Repositories\CommetArrondissementRepository;
use App\Repositories\CommoudeptRepository;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

class CommetArrondissementController extends Controller
{
    protected $commetarrondissementRepository;
    protected $commoudeptRepository;
    protected $arrondissementRepository;


    public function __construct(CommetArrondissementRepository $commetarrondissementRepository, CommoudeptRepository $commoudeptRepository,
    ArrondissementRepository $arrondissementRepository){
        $this->commetarrondissementRepository =$commetarrondissementRepository;
        $this->commoudeptRepository = $commoudeptRepository;
        $this->arrondissementRepository =$arrondissementRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commetarrondissements = $this->commetarrondissementRepository->getAll();
        return view('commetarrondissement.index',compact('commetarrondissements'));
    }

    public function allCommetArrondissementApi(){
        $commetarrondissements = $this->commetarrondissementRepository->getAll();
        return response()->json($commetarrondissements);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $commoudepts = $this->commoudeptRepository->getAll();
        $arrondissements = $this->arrondissementRepository->getAll();
        return view('commetarrondissement.add',compact('commoudepts','arrondissements'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $commetarrondissements = $this->commetarrondissementRepository->store($request->all());
        return redirect('commetarrondissement');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commetarrondissement = $this->commetarrondissementRepository->getById($id);
        return view('commetarrondissement.show',compact('commetarrondissement'));
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
        $commetarrondissement = $this->commetarrondissementRepository->getById($id);
        return view('commetarrondissement.edit',compact('commetarrondissement','commoudepts'));
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
        $this->commetarrondissementRepository->update($id, $request->all());
        return redirect('commetarrondissement');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->commetarrondissementRepository->destroy($id);
        return redirect('commetarrondissement');
    }
    public function    byCommoudept($commoudept){
        $commetarrondissements = $this->commetarrondissementRepository->getByCommoudept($commoudept);
        return response()->json($commetarrondissements);
    }
    public function importExcel(Request $request)
    {
         /*  Excel::import(new CommetArrondissementImport,$request['file']);
       //  dd($data);
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
      $commoudepts = $this->commoudeptRepository->getAll();
      $arrondissements = $this->arrondissementRepository->getAll();
      foreach ($rows as $key => $commetarrondissement) {
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
            "commoudept_id"=>$commoudept->id
        ]);

    }
            // 5. On supprime le fichier uploadé
            $reader->close(); // On ferme le $reader
           // unlink($fichier);

            // 6. Retour vers le formulaire avec un message $msg
            return redirect()->back()->with('success', 'Données importées avec succès.');

    }
}
