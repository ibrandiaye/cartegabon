{{-- \resources\views\permissions\create.blade.php --}}
@extends('welcome')

@section('title', '| Modifier Région')

@section('content')

<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">commoudept</a></li>
        <li class="breadcrumb-item active" aria-current="page">MODIFICATION D'UN commoudept</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">

    {!! Form::model($commoudept, ['method'=>'PATCH','route'=>['commoudept.update', $commoudept->id]]) !!}
        @csrf
        <div class="card">
            <div class="card-header text-center">FORMULAIRE DE MODIFICATION commoudept</div>
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
                        <label>commoudept</label>
                    <input type="text" name="commoudept" class="form-control" value="{{$commoudept->commoudept}}"  min="1" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <label>Province</label>
                    <select class="form-control" name="province_id" required="">
                        @foreach ($provinces as $province)
                        <option value="{{$province->id}}" {{$province->id==$commoudept->province_id ? 'selected' : ''}}>{{$province->province}}</option>
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
