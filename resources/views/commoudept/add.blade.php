{{-- \resources\views\permissions\create.blade.php --}}
@extends('welcome')

@section('title', '| Enregister Arrondissement')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Arrondissement</a></li>
        <li class="breadcrumb-item active" aria-current="page">ENREGISTREMENT D'UN ARRONDISSEMENT</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">


    <form action="{{ route('arrondissement.store') }}" method="POST">
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

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>commoudept</label>
                        <input type="text" name="commoudept"  value="{{ old('commoudept') }}" class="form-control"  required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <label>Province</label>
                    <select class="form-control" name="province_id" required="">
                        @foreach ($provinces as $province)
                        <option value="{{$province->id}}">{{$province->province}}</option>
                            @endforeach

                    </select>
                </div>
                <div>

                        <button type="submit" class="btn btn-success btn btn-lg "> ENREGISTRER</button>

                </div>
            </div>

        </div>

    </form>
</div>
@endsection


