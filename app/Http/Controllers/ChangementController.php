<?php

namespace App\Http\Controllers;

use App\Repositories\CentrevoteRepository;
use App\Repositories\ChangementRepository;
use App\Repositories\ElecteurRepository;
use Illuminate\Http\Request;

class ChangementController extends Controller
{
    protected $changementRepository;
    protected $electeurRepository;
    protected $centrevoteRepository;


    public function __construct(ChangementRepository $changementRepository, ElecteurRepository $electeurRepository,
    CentrevoteRepository $centrevoteRepository){
        $this->changementRepository         =   $changementRepository;
        $this->electeurRepository         =   $electeurRepository;
        $this->centrevoteRepository           =   $centrevoteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $changements = $this->changementRepository->getAllCentre();
        return view('changement.index',compact('changements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $electeurs = $this->electeurRepository->getAll();
        $centrevotes = $this->centrevoteRepository->getAll();
     //   $electeurs = $this->electeurRepository->getAll();
        return view('changement.add',compact('electeurs','centrevotes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $changements = $this->changementRepository->store($request->all());
        return redirect('changement');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $changement = $this->changementRepository->getById($id);
        return view('changement.show',compact('changement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $electeurs = $this->electeurRepository->getAll();
        $changement = $this->changementRepository->getById($id);
        return view('changement.edit',compact('changement','electeurs'));
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
