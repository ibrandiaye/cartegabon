<?php

namespace App\Http\Controllers;

use App\Repositories\ArrondissementRepository;
use App\Repositories\CentrevoteRepository;
use App\Repositories\CommoudeptRepository;
use App\Repositories\IdentificationRepository;
use App\Repositories\InscriptionRepository;
use App\Repositories\ProvinceRepository;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InscriptionController extends Controller
{
    protected $inscriptionRepository;
    protected $centrevoteRepository;
    protected $commoudeptRepository;
    protected $provinceRepository;

    protected $arrondissementRepository;

    protected $identificationRepository;

    public function __construct(InscriptionRepository $inscriptionRepository,
    CentrevoteRepository $centrevoteRepository,ProvinceRepository $provinceRepository,CommoudeptRepository $commoudeptRepository,
    ArrondissementRepository $arrondissementRepository,IdentificationRepository $identificationRepository){
        $this->inscriptionRepository =$inscriptionRepository;
        $this->centrevoteRepository =$centrevoteRepository;
        $this->arrondissementRepository = $arrondissementRepository;
        $this->provinceRepository = $provinceRepository;
        $this->commoudeptRepository = $commoudeptRepository;
        $this->identificationRepository = $identificationRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inscriptions = $this->inscriptionRepository->getWithIndentification();
        return view('inscription.index',compact('inscriptions'));
    }

    public function allInscriptionApi(){
        $inscriptions = $this->inscriptionRepository->getAll();
        return response()->json($inscriptions);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $centrevotes = $this->centrevoteRepository->getAll();
        $provinces = $this->provinceRepository->getAllOnLy();
        return view('inscription.add',compact('centrevotes','provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $identification = $this->identificationRepository->store($request->all());
        $request->merge(["identification_id"=>$identification->id]);
        $inscriptions = $this->inscriptionRepository->store($request->all());
        return redirect('inscription/'.$inscriptions->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      //  $inscription = $this->inscriptionRepository->getById($id);
      $inscription = $this->inscriptionRepository->getByIdWithRelation($id);
      //dd($inscription->identification_id);
      $identification = $this->identificationRepository->getByIdWithRelation($inscription->identification_id);
      //dd($identification);
    //  $qrcode = QrCode::size(50)->generate(config('app.url')."/inscription/".$inscription->id);
    $qrcode = QrCode::size(50)->generate('https://drive.google.com/file/d/1QtgnjemtuAseHvmHJbReCRiFRbPOUWXe/view');

        return view('inscription',compact('inscription','identification','qrcode'));
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
        $inscription = $this->inscriptionRepository->getById($id);
        return view('inscription.edit',compact('inscription','centrevotes'));
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
        $this->inscriptionRepository->update($id, $request->all());
        return redirect('inscription');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->inscriptionRepository->destroy($id);
        return redirect('inscription');
    }
}
