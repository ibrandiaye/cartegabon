<?php

namespace App\Http\Controllers;

use App\Models\Siege;
use App\Repositories\SiegeRepository;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

class SiegeController extends Controller
{
    protected $siegeRepository;

    public function __construct(SiegeRepository $siegeRepository){
        $this->siegeRepository =$siegeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sieges = $this->siegeRepository->getAll();
        return view('siege.index',compact('sieges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('siege.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sieges = $this->siegeRepository->store($request->all());
        return redirect('siege');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $siege = $this->siegeRepository->getById($id);
        return view('siege.show',compact('siege'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $siege = $this->siegeRepository->getById($id);
        return view('siege.edit',compact('siege'));
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
        $this->siegeRepository->update($id, $request->all());
        return redirect('siege');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->siegeRepository->destroy($id);
        return redirect('siege');
    }
    public function    allSiegeapi(){
        $sieges = $this->siegeRepository->getAllOnLy();
        return response()->json($sieges);
    }
    public function importExcel(Request $request)
{

   /*   $data =  Excel::import(new SiegeImport,$request['file']);
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
    $status = Siege::insert($rows->toArray());

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
