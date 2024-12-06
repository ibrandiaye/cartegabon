@extends('welcome')
@section('title', '| centrevote')


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
        <div class="card-header">LISTE D'ENREGISTREMENT DES CENTRES DE VOTES</div>
            <div class="card-body">
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalform2">
                    importer
                </button>
                <table id="datable_3" class="table table-hover w-100 display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Centrevote</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($centrevotes as $centrevote)
                        <tr>
                            <td>{{ $centrevote->id }}</td>
                            <td>{{ $centrevote->centrevote }}</td>
                            <td>
                                <a href="{{ route('centrevote.edit', $centrevote->id) }}" role="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>
{{--                                 {!! Form::open(['method' => 'DELETE', 'route'=>['centrevote.destroy', $centrevote->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
 --}}                                <a class="btn btn-danger" href="{{ route('centrevote.destroy', $centrevote->id) }}" onclick="if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]><i class="fa fa-trash"><i class="far fa-trash-alt"></i></button>
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

<div class="modal fade" id="exampleModalform2" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('importer.centrevote') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-header">
                <h5 class="modal-title">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group no-margin">
                            <label for="field-7" class="control-label">Document</label>
                            <input type="file" name="file" class="form-control" required>
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
