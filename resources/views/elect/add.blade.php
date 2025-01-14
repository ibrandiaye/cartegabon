{{-- \resources\views\permissions\create.blade.php --}}
@extends('welcome')

@section('title', '| Enregister Département')

@section('content')
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Centrevote</a></li>
        <li class="breadcrumb-item active" aria-current="page">AJOUT D'UN COMMUNE OU D'UNE DEPARTEMENT</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">

    <form action="{{ route('electeur.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header  text-center">FORMULAIRE D'ENREGISTREMENT D'UNE DEPARTEMENT</div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Prenom</label>
                            <input type="text" name="prenom"  value="{{ old('prenom') }}" class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="nom"  value="{{ old('nom') }}" class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>NIP / IPN</label>
                            <input type="text" name="nip_ipn"  value="{{ old('nip_ipn') }}" class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Date de Naissance</label>
                            <input type="date" name="date_naiss"  value="{{ old('date_naiss') }}" class="form-control"  required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Lieu de Naissance</label>
                            <input type="text" name="lieu_naiss"  value="{{ old('lieu_naiss') }}" class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>Province</label>
                        <select class="form-control" name="province" required="">
                            @foreach ($provinces as $province)
                            <option value="{{$province->province}}">{{$province->province}}</option>
                                @endforeach

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label>Commoudept</label>
                        <select class="form-control" name="commoudept" required="">
                            @foreach ($commoudepts as $commoudept)
                            <option value="{{$commoudept->commoudept}}">{{$commoudept->commoudept}}</option>
                                @endforeach

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label>Arrondissement</label>
                        <select class="form-control" name="arrondissement" required="">
                            @foreach ($arrondissements as $arrondissement)
                            <option value="{{$arrondissement->arrondissement}}">{{$arrondissement->arrondissement}}</option>
                                @endforeach

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label>Siege</label>
                        <select class="form-control" name="siege" required="">
                            @foreach ($sieges as $siege)
                            <option value="{{$siege->siege}}">{{$siege->siege}}</option>
                                @endforeach

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label>Centrevote</label>
                        <select class="form-control" name="centrevote_id" required="">
                            @foreach ($centrevotes as $centrevote)
                            <option value="{{$centrevote->id}}">{{$centrevote->centrevote}}</option>
                                @endforeach

                        </select>
                    </div>
                </div>


                <div>
                    <center>
                        <button type="submit" class="btn btn-success btn btn-lg "> ENREGISTRER</button>
                    </center>
                </div>
            </div>

        </div>

    </form>
</div>

@endsection


