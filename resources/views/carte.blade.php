<!doctype html>
                        <html>
                            <head>
                                <meta charset='utf-8'>
                                <meta name='viewport' content='width=device-width, initial-scale=1'>
                                <title>Republique Gabonaise</title>
                                    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
                                    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
                                
                                <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
                                <link href='' rel='stylesheet'>
                                <style>
.register {
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
    margin-top: 3%;
    padding: 3%;
}

.register-left {
    text-align: center;
    color: #fff;
    margin-top: 4%;
}

.register-left input {
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 60%;
    background: #f8f9fa;
    font-weight: bold;
    color: #383d41;
    margin-top: 30%;
    margin-bottom: 3%;
    cursor: pointer;
}

.register-right {
    background: #f8f9fa;
    border-top-left-radius: 10% 50%;
    border-bottom-left-radius: 10% 50%;
}

.register-left img {
    margin-top: 15%;
    margin-bottom: 5%;
    width: 25%;
    -webkit-animation: mover 2s infinite alternate;
    animation: mover 1s infinite alternate;
}

@-webkit-keyframes mover {
    0% {
        transform: translateY(0);
    }

    100% {
        transform: translateY(-20px);
    }
}

@keyframes mover {
    0% {
        transform: translateY(0);
    }

    100% {
        transform: translateY(-20px);
    }
}

.register-left p {
    font-weight: lighter;
    padding: 12%;
    margin-top: -9%;
}

.register .register-form {
    padding: 10%;
    margin-top: 10%;
}

.btnRegister {
    float: right;
    margin-top: 10%;
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    background: #0062cc;
    color: #fff;
    font-weight: 600;
    width: 50%;
    cursor: pointer;
}

.register .nav-tabs {
    margin-top: 3%;
    border: none;
    background: #0062cc;
    border-radius: 1.5rem;
    width: 28%;
    float: right;
}

.register .nav-tabs .nav-link {
    padding: 2%;
    height: 34px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
}

.register .nav-tabs .nav-link:hover {
    border: none;
}

.register .nav-tabs .nav-link.active {
    width: 100px;
    color: #0062cc;
    border: 2px solid #0062cc;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
}

.register-heading {
    text-align: center;
    margin-top: 8%;
    margin-bottom: -15%;
    color: #495057;
}</style>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
    <script type='text/javascript' src='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script>
</head>
<body oncontextmenu='return false' class='snippet-body'>
<div class=" register">
    <div class="row">
        <div class="col-md-3 register-left">
            <img src="{{ asset('img/2.webp') }}" alt="" />
            <h3>Republique Gabonaise</h3>
            <p>MINISTÈRE DE L’INTÉRIEUR ET DE LA SECURITE</p>
        </div>
        <div class="col-md-9 register-right">

            <h3 class="register-heading">Consultation du fichier électoral</h3>
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <form method="POST" action="{{ route('carte.search') }}">
                @csrf
                <div class="row register-form">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="nip_ipn"  value="{{ old('nip_ipn') ?? $nip }}" class="form-control" placeholder="NIP / IPN * "  required>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="nom" class="form-control" placeholder="Votre Nom " value="{{ old('nom') ?? $nom }}" />
                        </div>


                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control"  name="prenom" placeholder="Votre prenom " value="{{ old('prenom') ?? $prenom }}" />
                        </div>
                        <input type="submit" class="btnRegister" value="Rechercher" />
                    </div>

                    <div class="col-md-12">
                        <br>
                        @if(!empty($electeur))
                        <div class="alert alert-success">
                            Fichier électoral : résultat de votre recherche
                        </div>
                        @endif
                         @if(!empty($erreur))
                        <div class="alert alert-danger">
                           <center> {!! $erreur !!}</center>
                        </div>
                        @endif
 
                    </div>
                    @if(!empty($electeur))
                        @if($electeur->localisation=='nt')
                        <div class="col-md-6">
                        <h6> [ Etat Civil ]</h6>
                            NIP / IPN : <strong>{{ $electeur->nip_ipn }}</strong><br>
                            Prenom : <strong>{{ $electeur->prenom  }}</strong><br>
                            Nom : <strong>{{ $electeur->nom  }}</strong><br>
                            Date de Naissance : <strong>{{ $electeur->date_naiss }}</strong><br>
                            Lieu de Naissance : <strong>{{ $electeur->lieu_naiss }}</strong><br>
                        </div>
                        <div class="col-md-6">
                            <h6> [ Données Electorales ]</h6>
                            Province : <strong>{{ $electeur->province }}</strong><br>
                            Commune ou Departement : <strong>{{ $electeur->commoudept  }}</strong><br>
                            Arrondissement ou Canton : <strong>{{ $electeur->arrondissement  }}</strong><br>
                            Centre de vote : <strong>{{ $electeur->centrevote }}</strong><br>
                            Bureau de vote : <strong>{{ $electeur->siege }}</strong><br>
                        </div>
                        @else
                        <div class="col-md-6">
                            <h6> [ Etat Civil ]</h6>
                                NIP / IPN : <strong>{{ $electeur->nip_ipn }}</strong><br>
                                Prenom : <strong>{{ $electeur->prenom  }}</strong><br>
                                Nom : <strong>{{ $electeur->nom  }}</strong><br>
                                Date de Naissance : <strong>{{ $electeur->date_naiss }}</strong><br>
                                Lieu de Naissance : <strong>{{ $electeur->lieu_naiss }}</strong><br>
                            </div>
                            <div class="col-md-6">
                                <h6> [ Données Electorales ]</h6>
                                Continent : <strong>{{ $electeur->province }}</strong><br>
                                Pays : <strong>{{ $electeur->commoudept  }}</strong><br>
                                Ville : <strong>{{ $electeur->arrondissement  }}</strong><br>
                                Centre de vote : <strong>{{ $electeur->centrevote }}</strong><br>
                                Bureau de vote : <strong>{{ $electeur->siege }}</strong><br>
                            </div>
                        @endif
                    @endif
                </div>
            </form>



        </div>
    </div>

</div>
<script type='text/javascript'></script>
</body>
</html>
