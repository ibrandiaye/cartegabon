<?php

namespace App\Http\Controllers;

use App\Repositories\ArrondissementRepository;
use App\Repositories\CentrevoteRepository;
use App\Repositories\CommoudeptRepository;
use App\Repositories\InscriptionRepository;
use App\Repositories\ProvinceRepository;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    protected $inscriptionRepository;
    protected $centrevoteRepository;
    protected $commoudeptRepository;
    protected $provinceRepository;

    protected $arrondissementRepository;


    public function __construct(InscriptionRepository $inscriptionRepository,
    CentrevoteRepository $centrevoteRepository,ProvinceRepository $provinceRepository,CommoudeptRepository $commoudeptRepository,
    ArrondissementRepository $arrondissementRepository){
        $this->inscriptionRepository =$inscriptionRepository;
        $this->centrevoteRepository =$centrevoteRepository;
        $this->arrondissementRepository = $arrondissementRepository;
        $this->provinceRepository = $provinceRepository;
        $this->commoudeptRepository = $commoudeptRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inscriptions = $this->inscriptionRepository->getAll();
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
        $inscriptions = $this->inscriptionRepository->store($request->all());
        return redirect('inscription');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inscription = $this->inscriptionRepository->getById($id);
        return view('inscription.show',compact('inscription'));
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
