{{-- \resources\views\permissions\create.blade.php --}}
@extends('welcome')

@section('title', '| Enregister Commetarrondissement')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Commetarrondissement</a></li>
        <li class="breadcrumb-item active" aria-current="page">ENREGISTREMENT D'UN CENTRE de VOTE</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">


    <form action="{{ route('commetarrondissement.store') }}" method="POST">
        @csrf
        <div class="card">
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
                            <label>Commoudept</label>
                            <select class="form-control" name="commoudept_id" required="">
                                @foreach ($commoudepts as $commoudept)
                                <option value="{{$commoudept->id}}">{{$commoudept->commoudept}}</option>
                                    @endforeach

                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label>Arrondissement</label>
                            <select class="form-control" name="arrondissement_id" required="">
                                @foreach ($arrondissements as $arrondissement)
                                <option value="{{$arrondissement->id}}">{{$arrondissement->arrondissement}}</option>
                                    @endforeach

                            </select>
                        </div>
                        <div>

                            <button type="submit" class="btn btn-success btn btn-lg "> ENREGISTRER</button>

                    </div>
                </div>


            </div>

        </div>

    </form>
</div>
@endsection


