<?php

namespace App\Http\Controllers;

use App\Repositories\CentrevoteRepository;
use App\Repositories\ChangementRepository;
use App\Repositories\InscriptionRepository;
use App\Repositories\ProvinceRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     protected $centrevoteRepository;
     protected $inscriptionRepository;
     protected $changementRepository;
     protected $provinceRepository;

    public function __construct(CentrevoteRepository $centrevoteRepository,InscriptionRepository $inscriptionRepository,
    ChangementRepository $changementRepository,ProvinceRepository $provinceRepository)
    {
        $this->middleware('auth');

        $this->centrevoteRepository = $centrevoteRepository;
        $this->inscriptionRepository = $inscriptionRepository;
        $this->changementRepository = $changementRepository;
        $this->provinceRepository = $provinceRepository;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $nbCentrevote  = $this->centrevoteRepository->count();
        $nbInscription = $this->inscriptionRepository->count();
        $nbChangement = $this->changementRepository->count();
        $provinces = $this->provinceRepository->getAllOnLy();
        return view('home',compact("nbCentrevote","nbInscription",
        "nbChangement",'provinces'));
    }
    public function generatePDF()
    {
        
        $data = ['title' => 'domPDF in Laravel 10'];
        $pdf = Pdf::loadView('inscription', $data);
        return $pdf->download('document.pdf');
    }
}
