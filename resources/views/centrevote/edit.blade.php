{{-- \resources\views\permissions\create.blade.php --}}
@extends('welcome')

@section('title', '| Modifier Région')

@section('content')

<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Centrevote</a></li>
        <li class="breadcrumb-item active" aria-current="page">MODIFICATION D'UN CENTRE DE VOTE</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">

    {!! Form::model($centrevote, ['method'=>'PATCH','route'=>['centrevote.update', $centrevote->id]]) !!}
        @csrf
        <div class="card">
            <div class="card-header text-center">FORMULAIRE DE MODIFICATION CENTRE DE VOTE</div>
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

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Centrevote</label>
                    <input type="text" name="centrevote" class="form-control" value="{{$centrevote->centrevote}}"  min="1" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <label>Province</label>
                    <select class="form-control" name="province_id" required="">
                        @foreach ($provinces as $province)
                        <option value="{{$province->id}}" {{ $province->id==$centrevote->province_id ? 'selected' : '' }} >{{$province->province}}</option>
                            @endforeach

                    </select>
                </div>
                <div class="col-lg-6">
                    <label>Commoudept</label>
                    <select class="form-control" name="commoudept_id" required="">
                        @foreach ($commoudepts as $commoudept)
                        <option value="{{$commoudept->id}}" {{ $commoudept->id==$centrevote->commoudept_id ? 'selected' : '' }} >{{$commoudept->commoudept}}</option>
                            @endforeach

                    </select>
                </div>
                <div class="col-lg-6">
                    <label>Arrondissement</label>
                    <select class="form-control" name="arrondissement_id" required="">
                        @foreach ($arrondissements as $arrondissement)
                        <option value="{{$arrondissement->id}}" {{ $arrondissement->id==$centrevote->arrondissement_id ? 'selected' : '' }} >{{$arrondissement->arrondissement}}</option>
                            @endforeach

                    </select>
                </div>
                <div class="col-lg-6">
                    <label>Siege</label>
                    <select class="form-control" name="siege_id" required="">
                        @foreach ($sieges as $siege)
                        <option value="{{$siege->id}}"  {{ $siege->id==$centrevote->siege_id ? 'selected' : '' }} >{{$siege->siege}}</option>
                            @endforeach

                    </select>
                </div>
                <div>

                        <button type="submit" class="btn btn-success btn btn-lg "> MODIFIER</button>

                </div>


            </div>
        </div>
    {!! Form::close() !!}
</div>

@endsection
