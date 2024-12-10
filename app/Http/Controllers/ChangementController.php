<?php

namespace App\Http\Controllers;

use App\Repositories\ArrondissementRepository;
use App\Repositories\CentrevoteRepository;
use App\Repositories\ChangementRepository;
use App\Repositories\CommoudeptRepository;
use App\Repositories\ElecteurRepository;
use App\Repositories\IdentificationRepository;
use App\Repositories\ProvinceRepository;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ChangementController extends Controller
{
    protected $changementRepository;
    protected $centrevoteRepository;
    protected $commoudeptRepository;
    protected $provinceRepository;

    protected $arrondissementRepository;
    protected $identificationRepository;


    public function __construct(ChangementRepository $changementRepository,
    CentrevoteRepository $centrevoteRepository,ProvinceRepository $provinceRepository,CommoudeptRepository $commoudeptRepository,
    ArrondissementRepository $arrondissementRepository,IdentificationRepository $identificationRepository){
        $this->changementRepository =$changementRepository;
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
        $changements = $this->changementRepository->getWithIndentification();
        return view('changement.index',compact('changements'));
    }

    public function allchangementApi(){
        $changements = $this->changementRepository->getAll();
        return response()->json($changements);
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
        return view('changement.add',compact('centrevotes','provinces'));
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
        $changements = $this->changementRepository->store($request->all());
        return redirect('changement/'.$changements->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // $changement = $this->changementRepository->getById($id);

       $modification = $this->changementRepository->getByIdWithRelation($id);
       $identification = $this->identificationRepository->getByIdWithRelation($modification->identification_id);
       $qrcode = QrCode::size(50)->generate(config('app.url')."/changement/".$modification->id);
      // dd($identification);
        return view('modification',compact('modification','identification','qrcode'));
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
        $changement = $this->changementRepository->getById($id);
        return view('changement.edit',compact('changement','centrevotes'));
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
        $this->changementRepository->update($id, $request->all());
        return redirect('changement');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->changementRepository->destroy($id);
        return redirect('changement');
    }
}
