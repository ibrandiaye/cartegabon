{{-- \resources\views\permissions\create.blade.php --}}
@extends('welcome')

@section('title', '| Modifier Département')

@section('content')
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Province</a></li>
        <li class="breadcrumb-item active" aria-current="page">MODIFICATION D'UN COMMUNE OU D'UNE DEPARTMENT</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">

    {!! Form::model($commoudept, ['method'=>'PATCH','route'=>['commoudept.update', $commoudept->id]]) !!}
        @csrf
        <div class="card ">
            <div class="card-header text-center">FORMULAIRE DE MODIFICATION Département</div>
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
                            <input type="text" name="nom"  value="{{$electeur->nom}}" class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="nom"  value="{{$electeur->nom}}" class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>NIP / IPN</label>
                            <input type="text" name="nip_ipn"  value="{{$electeur->nip_ipn}}" class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Date de Naissance</label>
                            <input type="date" name="nom"  value="{{$electeur->date_naiss}}" class="form-control"  required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Lieu de Naissance</label>
                            <input type="text" name="lieu_naiss"  value="{{$electeur->lieu_naiss}}" class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>Province</label>
                        <select class="form-control" name="province" required="">
                            @foreach ($provinces as $province)
                            <option value="{{$province->province}}" {{ $province->province==$electeur->province ? 'selected' : '' }} >{{$province->province}}</option>
                                @endforeach

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label>Commoudept</label>
                        <select class="form-control" name="commoudept" required="">
                            @foreach ($commoudepts as $commoudept)
                            <option value="{{$commoudept->commoudept}}" {{ $commoudept->commoudept==$electeur->commoudept ? 'selected' : '' }} >{{$commoudept->commoudept}}</option>
                                @endforeach

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label>Arrondissement</label>
                        <select class="form-control" name="arrondissement" required="">
                            @foreach ($arrondissements as $arrondissement)
                            <option value="{{$arrondissement->arrondissement}}" {{ $arrondissement->arrondissement==$electeur->arrondissement ? 'selected' : '' }} >{{$arrondissement->arrondissement}}</option>
                                @endforeach

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label>Siege</label>
                        <select class="form-control" name="siege" required="">
                            @foreach ($sieges as $siege)
                            <option value="{{$siege->siege}}"  {{ $siege->siege==$electeur->siege ? 'selected' : '' }} >{{$siege->siege}}</option>
                                @endforeach

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label>Centrevote</label>
                        <select class="form-control" name="centrevote_id" required="">
                            <option value="">Selectioner</option>
                            @foreach ($centrevotes as $centrevote)
                            <option value="{{$centrevote->id}}"  {{ $electeur->centrevote_id==$centrevote->id  ? 'selected' : '' }} >{{$centrevote->centrevote}}</option>
                                @endforeach

                        </select>
                    </div>
                </div>
                <div>
                    <center>
                        <button type="submit" class="btn btn-success btn btn-lg "> MODIFIER</button>
                    </center>
                </div>


             </div>
        </div>
    {!! Form::close() !!}
</div>

@endsection
