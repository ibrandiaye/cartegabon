<?php

namespace App\Http\Controllers;

use App\Models\Commoudept;
use App\Repositories\CentrevoteRepository;
use App\Repositories\CommoudeptRepository;
use App\Repositories\ProvinceRepository;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

class CommoudeptController extends Controller
{
    protected $commoudeptRepository;
    protected $provinceRepository;
    protected $centrevoteRepository;


    public function __construct(CommoudeptRepository $commoudeptRepository, ProvinceRepository $provinceRepository,
    CentrevoteRepository $centrevoteRepository){
        $this->commoudeptRepository =$commoudeptRepository;
        $this->provinceRepository = $provinceRepository;
        $this->centrevoteRepository =$centrevoteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commoudepts = $this->commoudeptRepository->getAll();
        return view('commoudept.index',compact('commoudepts'));
    }

    public function allCommoudeptApi(){
        $commoudepts = $this->commoudeptRepository->getAll();
        return response()->json($commoudepts);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = $this->provinceRepository->getAll();
        return view('commoudept.add',compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $commoudepts = $this->commoudeptRepository->store($request->all());
        return redirect('commoudept');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commoudept = $this->commoudeptRepository->getById($id);
        return view('commoudept.show',compact('commoudept'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $provinces = $this->provinceRepository->getAll();
        $commoudept = $this->commoudeptRepository->getById($id);
        return view('commoudept.edit',compact('commoudept','provinces'));
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
        $this->commoudeptRepository->update($id, $request->all());
        return redirect('commoudept');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->commoudeptRepository->destroy($id);
        return redirect('commoudept');
    }
    public function    byProvince($province){
        $commoudepts = $this->commoudeptRepository->getByProvince($province);
        return response()->json($commoudepts);
    }
    public function importExcel(Request $request)
    {
         /*  Excel::import(new CommoudeptImport,$request['file']);
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
      $provinces = $this->provinceRepository->getAll();
      foreach ($rows as $key => $commoudept) {
        foreach ($provinces as $key1 => $province) {
            if($commoudept["province"]==$province->province){
                Commoudept::create([
                    "commoudept"=>$commoudept['commoudept'],
                    "province_id"=>$province->id
                ]);

            }
        }

    }
            // 5. On supprime le fichier uploadé
            $reader->close(); // On ferme le $reader
           // unlink($fichier);

            // 6. Retour vers le formulaire avec un message $msg
            return redirect()->back()->with('success', 'Données importées avec succès.');

    }
    public function getByProvince($province){
        $commoudepts = $this->commoudeptRepository->getByProvince($province);
        $nbCentre =  $this->centrevoteRepository->countByProvince($province);
   /*     $nbBureau =  $this->lieuvoteRepository->countByProvince($province);
        $electeurs = $this->lieuvoteRepository->sumElecteurByProvince($province);*/
        $data=array("commoudepts"=>$commoudepts,"nbCentre"=>$nbCentre/*,"nbbureau"=>$nbBureau,
    "electeur"=>$electeurs*/);
        return response()->json($data);
    }
}
