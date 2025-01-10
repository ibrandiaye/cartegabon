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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                 Nombre de Centre de vote : <span id="nbCentre"></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <label>Province</label>
                            <select class="form-control" name="province_id" id="province_id_ct" required="">
                                <option value="">Selectionnez</option>
                                @foreach ($provinces as $province)
                                <option value="{{$province->id}}">{{$province->province}}</option>
                                    @endforeach

                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label>Commune ou departement</label>
                            <select class="form-control" name="commoudept_id" id="commoudept_id_ct" required="">

                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label>Arrondissement</label>
                            <select class="form-control" name="arrondissement_id" id="arrondissement_id_ct" >

                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label>Centre de vote</label>
                            <select class="form-control" name="centrevote_id" id="centrevote_id_ct" >

                            </select>
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
@section('script')
    <script>
        url_app = '{{ config('app.url') }}';
        //alert("ibra");
        $("#province_id").change(function () {
         alert("ibra");
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
                    console.log(data);
                    $.each(data.commoudepts,function(index,row){
                        alert(row.nomd);
                        commoudept +="<option value="+row.id+">"+row.commoudept+"</option>";

                    });

                    $("#commoudept_id").empty();
                 //   $("#commoudept_id").append(commoudept);
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
                    $("#nbCentre").empty();
                    $("#nbCentre").append(data.nbCentre); 
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
                    $("#nbCentre").empty();
                    $("#nbCentre").append(data.nbCentre); 
                    $.each(data.commoudepts,function(index,row){
                        //alert(row.nomd);
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
                    $("#nbCentre").empty();
                    $("#nbCentre").append(data.nbCentre); 
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
            var commoudept_id_ct =  $("#commoudept_id_ct").children("option:selected").val();

            var centrevote = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/centrevote/by/arrondissement/'+arrondissement_id_ct+'/'+commoudept_id_ct,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    $("#nbCentre").empty();
                    $("#nbCentre").append(data.nbCentre); 
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
        $("#centrevote_id_ct").change(function () {
            $("#nbCentre").empty();
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
                       /* contenu = "Province : <strong>"+data.province+"</strong><br>"+
                            "Commune ou Departement : <strong> "+data.commoudept+"</strong><br>"+
                            "Arrondissement : <strong>"+data.arrondissement +"</strong><br>"+
                           "Siege : <strong>"+data.siege+"</strong><br>"+
                            "Centre de vote : <strong>"+data.centrevote +"</strong><br>";
                            $("#electeur_id").val(data.id);*/
                            $("#nom").val(data.nom);
                            $("#prenom").val(data.prenom);
                            $("#datenaiss").val(data.date_naiss);
                            $("#lieunaiss").val(data.lieu_naiss);
                     }
                     else
                     {
                        contenu = "<div class='alert alert-danger'> Donnees non trouvé</div>"
                     }


                    console.log(contenu);
            $("#ancienne").html(contenu);
                }
            });

        });

    </script>
@endsection