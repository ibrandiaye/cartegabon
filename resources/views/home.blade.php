@extends('welcome')

@section('content')
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
       
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container">
    <div class="hk-row">
        <div class="col-md-4">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block font-12 font-weight-500 text-dark text-uppercase mb-5">Nombre de centre de vote</span>
                            <span class="d-block display-6 font-weight-400 text-dark">{{$nbCentrevote}}</span>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block font-12 font-weight-500 text-dark text-uppercase mb-5">Nombre D'inscription</span>
                            <span class="d-block display-6 font-weight-400 text-dark">{{$nbInscription}}</span>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="d-block font-12 font-weight-500 text-dark text-uppercase mb-5">Nombre de Modification</span>
                            <span class="d-block display-6 font-weight-400 text-dark">{{$nbChangement}}</span>
                        </div>
                        <div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
