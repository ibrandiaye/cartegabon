<?php

namespace App\Http\Controllers;

use App\Repositories\CentrevoteRepository;
use App\Repositories\ChangementRepository;
use App\Repositories\InscriptionRepository;
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
    public function __construct(CentrevoteRepository $centrevoteRepository,InscriptionRepository $inscriptionRepository,
    ChangementRepository $changementRepository)
    {
        $this->middleware('auth');

        $this->centrevoteRepository = $centrevoteRepository;
        $this->inscriptionRepository = $inscriptionRepository;
        $this->changementRepository = $changementRepository;
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
        return view('home',compact("nbCentrevote","nbInscription","nbChangement"));
    }
    public function generatePDF()
    {
        
        $data = ['title' => 'domPDF in Laravel 10'];
        $pdf = Pdf::loadView('inscription', $data);
        return $pdf->download('document.pdf');
    }
}
