<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Repositories\ProvinceRepository;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

class ProvinceController extends Controller
{
    protected $provinceRepository;

    public function __construct(ProvinceRepository $provinceRepository){
        $this->provinceRepository =$provinceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = $this->provinceRepository->getAll();
        return view('province.index',compact('provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('province.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $provinces = $this->provinceRepository->store($request->all());
        return redirect('province');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $province = $this->provinceRepository->getById($id);
        return view('province.show',compact('province'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $province = $this->provinceRepository->getById($id);
        return view('province.edit',compact('province'));
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
        $this->provinceRepository->update($id, $request->all());
        return redirect('province');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->provinceRepository->destroy($id);
        return redirect('province');
    }
    public function    allProvinceapi(){
        $provinces = $this->provinceRepository->getAllOnLy();
        return response()->json($provinces);
    }
    public function importExcel(Request $request)
{

   /*   $data =  Excel::import(new ProvinceImport,$request['file']);
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
    $status = Province::insert($rows->toArray());

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
