{{-- \resources\views\permissions\create.blade.php --}}
@extends('welcome')

@section('title', '| Modifier Région')

@section('content')

<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Siege</a></li>
        <li class="breadcrumb-item active" aria-current="page">MODIFICATION D'UN SIEGE</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">

    {!! Form::model($siege, ['method'=>'PATCH','route'=>['siege.update', $siege->id]]) !!}
        @csrf
        <div class="card">
            <div class="card-header text-center">FORMULAIRE DE MODIFICATION SIEGE</div>
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
                    <input type="text" name="siege" class="form-control" value="{{$siege->siege}}"  min="1" required>
                    </div>
                </div>
                <div>

                        <button type="submit" class="btn btn-success btn btn-lg "> MODIFIER</button>

                </div>


            </div>
        </div>
    {!! Form::close() !!}
</div>

@endsection
