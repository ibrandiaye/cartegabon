{{-- \resources\views\permissions\create.blade.php --}}
@extends('welcome')

@section('title', '| Enregister Siege')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Siege</a></li>
        <li class="breadcrumb-item active" aria-current="page">ENREGISTREMENT D'UN SIEGE</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">


    <form action="{{ route('siege.store') }}" method="POST">
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Siege</label>
                        <input type="text" name="siege"  value="{{ old('siege') }}" class="form-control"  required>
                    </div>
                </div>
                <div>

                        <button type="submit" class="btn btn-success btn btn-lg "> ENREGISTRER</button>

                </div>
            </div>

        </div>

    </form>
</div>
@endsection


