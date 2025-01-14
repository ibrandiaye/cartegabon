<?php

namespace App\Http\Controllers;

use App\Repositories\CentrevoteRepository;
use App\Repositories\ChangementRepository;
use App\Repositories\ElectRepository;
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
     protected $elecRepository;

    public function __construct(CentrevoteRepository $centrevoteRepository,InscriptionRepository $inscriptionRepository,
    ChangementRepository $changementRepository,ProvinceRepository $provinceRepository,
    ElectRepository $electRepository)
    {
        $this->middleware('auth');

        $this->centrevoteRepository = $centrevoteRepository;
        $this->inscriptionRepository = $inscriptionRepository;
        $this->changementRepository = $changementRepository;
        $this->provinceRepository = $provinceRepository;
        $this->elecRepository = $electRepository;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $nbCentrevote  = $this->centrevoteRepository->count();
        $nbelec = $this->elecRepository->count();
       // $nbChangement = $this->changementRepository->count();
        $provinces = $this->provinceRepository->getAllOnLy();
        return view('home',compact("nbCentrevote","nbelec",
        'provinces'));
    }
    public function generatePDF()
    {
        
        $data = ['title' => 'domPDF in Laravel 10'];
        $pdf = Pdf::loadView('inscription', $data);
        return $pdf->download('document.pdf');
    }
}
