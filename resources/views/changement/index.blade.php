@extends('welcome')
@section('title', '| changement')


@section('content')
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">changement</a></li>
        <li class="breadcrumb-item active" aria-current="page">MODIFICATION D'UN changement</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif

<div class="col-12">
    <div class="card ">
        <div class="card-header">LISTE D'ENREGISTREMENT DES changements</div>
            <div class="card-body">

                <table id="example1" class="table table-bordered table-responsive-md table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Prenom</th>
                            <th>Nom</th>
                            <th>NIP</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($changements as $changement)
                        <tr>
                            <td>{{ $changement->id }}</td>
                            <td>{{ $changement->prenom }}</td>
                            <td>{{ $changement->nom }}</td>
                            <td>{{ $changement->nip }}</td>
                            <td>
                                {{-- <a href="{{ route('changement.edit', $changement->id) }}" role="button" class="btn btn-primary"><i class="fa fa-edit"></i></a> --}}
                                <a href="{{ route('changement.show', $changement->changement) }}" role="button" class="btn btn-info"><i class="fa fa-print"></i></a>

{{--                                 {!! Form::open(['method' => 'DELETE', 'route'=>['changement.destroy', $changement->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                              <a class="btn btn-danger" href="{{ route('changement.destroy', $changement->id) }}" onclick="if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]><i class="fa fa-trash"><i class="far fa-trash-alt"></i></button>
                                {{-- {!! Form::close() !!} --}}



                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>
    </div>
</div>


@endsection
