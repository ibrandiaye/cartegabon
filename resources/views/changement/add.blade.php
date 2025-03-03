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


    <form action="{{ route('changement.store') }}" method="POST">
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
                                    <label>NIP</label>
                                    <input type="text" name="nip" id="nip" value="{{ old('nip') }}" class="form-control"  required>
                                    <span class="input-group-append">
                                        <button type="button" id="btnnumelec" class="btn  btn-primary"><i class="fa fa-search"></i> Rechercher</button>
                                        </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Prenom</label>
                                    <input type="text" name="prenom" id="prenom"   value="{{ old('prenom') }}" class="form-control"  required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>nom</label>
                                    <input type="text" name="nom" id="nom" value="{{ old('prenom') }}" class="form-control"  required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date de Naissance</label>
                                    <input type="date" name="datenaiss" id="datenaiss"  value="{{ old('datenaiss') }}" class="form-control"  required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Lieu de Naissance</label>
                                    <input type="text" name="lieunaiss" id="lieunaiss"  value="{{ old('lieunaiss') }}" class="form-control"  required>
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
                                    <label>Nature de la piece</label>
                                    <select class="form-control" name="type_piece" id="type_piece" required="">
                                        <option value="">Selectionnez</option>
                                        <option value="carte d'identité">carte d'identité</option>
                                        <option value="passeport">passeport</option>

                                    </select>
                                    {{-- <input type="text" name="type_piece"  value="{{ old('type_piece') }}" class="form-control"  required> --}}
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
                            <div class="col-md-12">
                                <div class="row">
                                    <label>Le demandeur est-il un électeur ayant un handicap réduisant sa mobilité ?   </label>
                                    <div class="col-md-4 mt-15">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" value="1" name="handicap" class="custom-control-input" required>
                                            <label class="custom-control-label" for="customRadio1">Oui</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-15">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio2" value="0" name="handicap" checked class="custom-control-input" required>
                                            <label class="custom-control-label" for="customRadio2">Non</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           {{--  <div class="col-lg-6">
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


                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Arrondissement</label>
                                <select class="form-control" name="arrondissement_id" id="arrondissement_id" >

                                </select>
                            </div> --}}
                        </div>


                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Ancienne Situation
                    </div>
                    <div class="card-body" id="ancienne">

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Nouvelle Situation
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Province</label>
                                <select class="form-control" name="province_id_nv" id="province_id_nv" required="">
                                    <option value="">Selectionnez</option>
                                    @foreach ($provinces as $province)
                                    <option value="{{$province->id}}">{{$province->province}}</option>
                                        @endforeach

                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Commune ou departement</label>
                                <select class="form-control" name="commoudept_id_nv" id="commoudept_id_nv" required="">

                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Arrondissement</label>
                                <select class="form-control" name="arrondissement_id_nv" id="arrondissement_id_nv" >

                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Centre de vote</label>
                                <select class="form-control" name="centrevote_id" id="centrevote_id_nv" >

                                </select>
                            </div>
                        </div>
                        <div>
                            <input type="hidden" name="electeur_id" value="" id="electeur_id" required>
                            <input type="hidden" name="commoudept_id" value="" id="commoudept_id" required>

                            <input type="hidden" name="arrondissement_id" value="" id="arrondissement_id" >

                            <input type="hidden" name="province_id" value="" id="province_id" required>

                            <br>
                                <button type="submit" class="btn btn-success btn btn-lg "> ENREGISTRER</button>

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

                    $.each(data.commoudepts,function(index,row){
                       
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

                    $.each(data.commoudepts,function(index,row){
                       
                       commoudept +="<option value="+row.id+">"+row.commoudept+"</option>";

                   });

                    $("#commoudept_id_ct").empty();
                    $("#commoudept_id_ct").append(commoudept);
                }
            });
        });
        $("#commoudept_id_ct").change(function () {

            var commoudept_id_ct =  $("#commoudept_id_ct").children("option:selected").val();

            var arrondissement = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/arrondissement/by/commoudept/'+commoudept_id_ct,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)
                    $.each(data.arrondissements,function(index,row){
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
                url:url_app+'/centrevote/by/commoudept/'+commoudept_id_ct,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)
                    $.each(data.centrevotes,function(index,row){
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
            var commoudept_id_ct =  $("#commoudept_id_ct").children("option:selected").val();

            var centrevote = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/centrevote/by/arrondissement/'+arrondissement_id_ct+'/'+commoudept_id_ct,
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


        //nouvelle situation

        $("#province_id_nv").change(function () {
        // alert("ibra");
        var province_id =  $("#province_id_nv").children("option:selected").val();

            var commoudept = "<option value=''>Veuillez selectionner</option>";
            $("#centrevote_id_nv").empty();

            $.ajax({
                type:'GET',
                url:url_app+'/commoudept/by/province/'+province_id,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {

                    $.each(data.commoudepts,function(index,row){
                       
                       commoudept +="<option value="+row.id+">"+row.commoudept+"</option>";

                   });

                    $("#commoudept_id_nv").empty();
                    $("#commoudept_id_nv").append(commoudept);
                    $("#centrevote_id_nv").empty();

                    
                }
            });
        });
        $("#commoudept_id_nv").change(function () {

            var commoudept_id_nv =  $("#commoudept_id_nv").children("option:selected").val();
            $("#centrevote_id_nv").empty();

            var arrondissement = "<option value=''>Veuillez selectionner</option>";
            var centrevote = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/centrevote/by/commoudept/'+commoudept_id_nv,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)
                    $.each(data.centrevotes,function(index,row){
                        //alert(row.nomd);
                        centrevote +="<option value="+row.id+">"+row.centrevote+"</option>";

                    });

                    $("#centrevote_id_nv").empty();


                    $("#centrevote_id_nv").append(centrevote);
                }
            });
            $.ajax({
                type:'GET',
                url:url_app+'/arrondissement/by/commoudept/'+commoudept_id_nv,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)
                    $.each(data.arrondissements,function(index,row){
                        //alert(row.nomd);
                        arrondissement +="<option value="+row.id+">"+row.arrondissement+"</option>";

                    });

                    $("#arrondissement_id_nv").empty();


                    $("#arrondissement_id_nv").append(arrondissement);
                }
            });

        });


        $("#arrondissement_id_nv").change(function () {

            var arrondissement_id_nv =  $("#arrondissement_id_nv").children("option:selected").val();
            var commoudept_id_nv =  $("#commoudept_id_nv").children("option:selected").val();
            $("#centrevote_id_nv").empty();

            var centrevote = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/centrevote/by/arrondissement/'+arrondissement_id_nv+'/'+commoudept_id_nv,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)
                    $.each(data.centrevotes,function(index,row){
                        //alert(row.nomd);
                        centrevote +="<option value="+row.id+">"+row.centrevote+"</option>";

                    });

                    $("#centrevote_id_nv").empty();


                    $("#centrevote_id_nv").append(centrevote);
                }
            });
        });


        $("#btnnumelec").click(function () {
            nip =  $("#nip").val();
           // alert(nip);
           $("#electeur_id").val('');
            contenu = '';
            $.ajax({
                type:'GET',
                url:url_app+'/electeur/by/nip_ipn/'+nip,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)
                    if(data.province)
                     {
                        contenu = "Province : <strong>"+data.province+"</strong><br>"+
                            "Commune ou Departement : <strong> "+data.commoudept+"</strong><br>"+
                            "Arrondissement : <strong>"+data.arrondissement +"</strong><br>"+
                           "Siege : <strong>"+data.siege+"</strong><br>"+
                            "Centre de vote : <strong>"+data.centrevote +"</strong><br>";
                            $("#electeur_id").val(data.id);
                            $("#nom").val(data.nom);
                            $("#prenom").val(data.prenom);
                            $("#datenaiss").val(data.date_naiss);
                            $("#lieunaiss").val(data.lieu_naiss);

                            $("#commoudept_id").val(data.commoudept_id);
                            $("#arrondissement_id").val(data.arrondissement_id);
                            $("#province_id").val(data.province_id);
                     }
                     else
                     {
                        contenu = "<div class='alert alert-danger'> Electeur non trouvé</div>"
                     }


                    console.log(contenu);
            $("#ancienne").html(contenu);
                }
            });

        });
    </script>
@endsection

