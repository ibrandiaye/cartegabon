@extends('welcome')
@section('title', '| electeur')


@section('content')
<style>
#pag p {
    padding: 10px;
}

</style>
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Province</a></li>
        <li class="breadcrumb-item active" aria-current="page">MODIFICATION D'UN COMMUNE OU D'UNE DEPARTMENT</li>
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
            <div class="card-header">LISTE D'ENREGISTREMENT DES ELECTEURS</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalform2">
                                <i class="fa fa-file"></i> Importer Electeurs
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalform3">
                                <i class="fa fa-file"></i> Modifications Electeurs
                            </button> 
                        </div>    
                        <div class="col-md-2">
                           {{--  --}}

                            <a class="btn btn-danger" href="{{ route('vider.electeur') }}" onclick="if(!confirm('Êtes-vous sûr de vouloir vider la table ?')) { return false; }"><i class="fa fa-trash"></i> Vider </button></a>

                        </div>
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('electeur.index') }}">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher Par nin...">
                                <button type="submit" class="btn btn-info">Rechercher</button>
                            </form>
                        </div>
                    </div>


                    <table id="" class="table table-bordered table-responsive-md table-striped text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Prenom</th>
                                <th>Nom</th>
                                <th>NIP / IPN</th>
                                <th>Date de Naissance</th>
                                <th>Lieu de Naissance</th>
                                <th>CentreVote</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($electeurs as $electeur)
                            <tr>
                                <td>{{ $electeur->id }}</td>
                                <td>{{ $electeur->prenom }}</td>
                                <td>{{ $electeur->nom }}</td>
                                <td>{{ $electeur->nip_ipn }}</td>
                                <td>{{ $electeur->date_naiss }}</td>
                                <td>{{ $electeur->lieu_naiss }}</td>

                                <td>{{ $electeur->centrevote }}</td>
                                <td>
                                  {{--   <a href="{{ route('electeur.edit', $electeur->id) }}" role="button" class="btn btn-primary"><i class="fa fa-edit"></i></a>

                                    <a  href="{{ route('electeur.destroy', $electeur->id) }}" class="btn btn-danger"  onclick="if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]><i class="fa fa-trash"></i></a>

 --}}


                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
                <div id="pag">
                    {{ $electeurs->links() }}
                </div>
        </div>
    </div>
</div>




                <div class="modal fade" id="exampleModalform2" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="{{ route('importer.electeur') }}" method="POST" enctype="multipart/form-data" id="form">
                                @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Importer Nouveaux Electeurs</h5>
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
                                <button type="submit" id="btn" class="btn btn-primary">Valider</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="exampleModalform3" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="{{ route('update.import.electeur') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Importer Modification Electeurs</h5>
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
@section("script")

<script type="text/javascript">
   

        document.getElementById('btn').addEventListener('click', function(event) {

            var form = document.getElementById('form'); // Remplacez 'votreFormulaire' par l'ID de votre formulaire
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                this.setAttribute('disabled', 'disabled');
                this.innerText = 'Enregistrement en cours...';
                form.submit();
            }
            form.classList.add('was-validated');
        });
    </script>

@endsection