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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Identification
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Prenom</label>
                                    <input type="text" name="Prenom"  value="{{ old('Prenom') }}" class="form-control"  required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>nom</label>
                                    <input type="text" name="Prenom"  value="{{ old('Prenom') }}" class="form-control"  required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date de Naissance</label>
                                    <input type="date" name="datenaiss"  value="{{ old('datenaiss') }}" class="form-control"  required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Lieu de Naissance</label>
                                    <input type="text" name="lieunaiss"  value="{{ old('lieunaiss') }}" class="form-control"  required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Profession</label>
                                    <input type="text" name="profession"  value="{{ old('profession') }}" class="form-control"  required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tel</label>
                                    <input type="text" name="tel"  value="{{ old('tel') }}" class="form-control"  required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="text" name="nip"  value="{{ old('nip') }}" class="form-control"  required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nature de la piece</label>
                                    <input type="text" name="type_piece"  value="{{ old('type_piece') }}" class="form-control"  required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>N° de la piece d'identité</label>
                                    <input type="text" name="num_piece"  value="{{ old('num_piece') }}" class="form-control"  required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Domicile</label>
                                    <input type="text" name="domicile"  value="{{ old('domicile') }}" class="form-control"  required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Province</label>
                                <select class="form-control" name="province_id" id="province_id" required="">
                                    <option value="">Selectionnez</option>
                                    @foreach ($provinces as $province)
                                    <option value="{{$province->id}}">{{$province->province}}</option>
                                        @endforeach

                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Commune ou departement</label>
                                <select class="form-control" name="commoudept_id" id="commoudept_id" required="">
                                   {{--  @foreach ($commoudepts as $commoudept)
                                    <option value="{{$commoudept->id}}">{{$commoudept->commoudept}}</option>
                                        @endforeach --}}

                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Arrondissement</label>
                                <select class="form-control" name="arrondissement_id" id="arrondissement_id" >
                                   {{--  @foreach ($arrondissements as $arrondissement)
                                    <option value="{{$arrondissement->id}}">{{$arrondissement->arrondissement}}</option>
                                        @endforeach
         --}}
                                </select>
                            </div>
                        </div>

                        <div>
                            <br>
                                <button type="submit" class="btn btn-success btn btn-lg "> ENREGISTRER</button>

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Carte ELectorale
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Province</label>
                                <select class="form-control" name="province_id_ct" id="province_id_ct" required="">
                                    <option value="">Selectionnez</option>
                                    @foreach ($provinces as $province)
                                    <option value="{{$province->id}}">{{$province->province}}</option>
                                        @endforeach

                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Commune ou departement</label>
                                <select class="form-control" name="commoudept_id_ct" id="commoudept_id_ct" required="">

                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Arrondissement</label>
                                <select class="form-control" name="arrondissement_id_ct" id="arrondissement_id_ct" >

                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Centre de vote</label>
                                <select class="form-control" name="centrevote_id_ct" id="centrevote_id_ct" >

                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </form>
</div>
@endsection
@section('script')
    <script>
        url_app = '{{ config('app.url') }}';
        $("#province_id").change(function () {
        // alert("ibra");
        var province_id =  $("#province_id").children("option:selected").val();
        $(".province").val(province_id);
        $(".commoudept").val("");
        $(".arrondissement").val("");
            var commoudept = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/commoudept/by/province/'+province_id,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {

                    $.each(data,function(index,row){
                        //alert(row.nomd);
                        commoudept +="<option value="+row.id+">"+row.commoudept+"</option>";

                    });

                    $("#commoudept_id").empty();
                    $("#commoudept_id").append(commoudept);
                }
            });
        });
        $("#commoudept_id").change(function () {
            $("#rts").empty();
            $("#centrevote_id").empty();
            $("#lieuvote_id").empty();
            var commoudept_id =  $("#commoudept_id").children("option:selected").val();
            $(".commoudept").val(commoudept_id);
            $(".arrondissement").val("");
            var arrondissement = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/arrondissement/by/commoudept/'+commoudept_id,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)
                    $.each(data,function(index,row){
                        //alert(row.nomd);
                        arrondissement +="<option value="+row.id+">"+row.arrondissement+"</option>";

                    });

                    $("#arrondissement_id").empty();


                    $("#arrondissement_id").append(arrondissement);
                }
            });
        });

        $("#province_id_ct").change(function () {
        // alert("ibra");
        var province_id =  $("#province_id_ct").children("option:selected").val();

            var commoudept = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/commoudept/by/province/'+province_id,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {

                    $.each(data,function(index,row){
                        //alert(row.nomd);
                        commoudept +="<option value="+row.id+">"+row.commoudept+"</option>";

                    });

                    $("#commoudept_id_ct").empty();
                    $("#commoudept_id_ct").append(commoudept);
                }
            });
        });
        $("#commoudept_id_ct").change(function () {

            var commoudept_id =  $("#commoudept_id_ct").children("option:selected").val();
            $(".commoudept").val(commoudept_id);
            $(".arrondissement").val("");
            var arrondissement = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/arrondissement/by/commoudept/'+commoudept_id,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)
                    $.each(data,function(index,row){
                        //alert(row.nomd);
                        arrondissement +="<option value="+row.id+">"+row.arrondissement+"</option>";

                    });

                    $("#arrondissement_id_ct").empty();


                    $("#arrondissement_id_ct").append(arrondissement);
                }
            });
            var centrevote = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/centrevote/by/commoudept/'+commoudept_id,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)
                    $.each(data,function(index,row){
                        //alert(row.nomd);
                        centrevote +="<option value="+row.id+">"+row.centrevote+"</option>";

                    });

                    $("#centrevote_id_ct").empty();


                    $("#centrevote_id_ct").append(centrevote);
                }
            });
        });


        $("#arrondissement_id_ct").change(function () {

            var arrondissement_id_ct =  $("#arrondissement_id_ct").children("option:selected").val();
            $(".commoudept").val(arrondissement_id_ct);
            $(".arrondissement").val("");
            var centrevote = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/centrevote/by/arrondissement/'+arrondissement_id_ct,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)
                    $.each(data,function(index,row){
                        //alert(row.nomd);
                        centrevote +="<option value="+row.id+">"+row.centrevote+"</option>";

                    });

                    $("#arrondissement_id_ct").empty();


                    $("#arrondissement_id_ct").append(centrevote);
                }
            });
        });



    </script>
@endsection
