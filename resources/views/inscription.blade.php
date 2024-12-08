<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        /* Style général */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .header, .sub-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .gray {
            background-color: green;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Titre principal -->
        <div class="header">
            <h4>
                REPUBLIQUE GABONAISE<br>
                UNION - TRAVAIL - JUSTICE<br>
                MINISTÈRE DE L’INTÉRIEUR ET DE LA SECURITE
            </h4>
        </div>
        <hr>
        <div class="sub-header">
            <h4>FORMULAIRE D'INSCRIPTION SUR LES LISTES ELECTORALES</h4>
            <h4>Numéro de la demande :  {{$inscription->id}} </h4>
        </div>

        <!-- Identification de la commission -->
        <div class="gray" style="display:flex; align-items: center;justify-content: center;height: 30px;">
            <center> <h4>IDENTIFICATION DE LA COMMISSION ADMINISTRATIVE</h4></center> 
        </div>
        <table>
            <tr>
                <td style="text-align: left;">Province : <strong>{{$identification->province}}</strong></td>
                <td style="text-align: left;">Commune ou département : <strong>{{$identification->commoudept}}</strong></td>
                <td style="text-align: left;">Arrondissement : <strong>  {{$identification->arrondissement ?? null}} </strong></td>
            </tr>
        </table>

        <!-- Identification du demandeur -->
        <div class="gray"  style="display:flex; align-items: center;justify-content: center;height: 30px;">
          <center>  <h4>IDENTIFICATION DU DEMANDEUR</h4></center>
        </div>
        <table>
            <tr>
                <td style="text-align: left;">NIP : <strong>{{$identification->nip}}</strong></td>
            </tr>
            <tr>
                <td style="text-align: left;">PRENOM : <strong>{{$identification->prenom}}</strong></td>
            </tr>
            <tr>
                <td style="text-align: left;">NOM : <strong>{{$identification->nom}}</strong></td>
            </tr>
            <tr>
                <td style="text-align: left;">DATE ET LIEU DE NAISSANCE : <strong>{{$identification->datenaiss}} {{$identification->lieunaiss}}</strong></td>
            </tr>
        </table>

        <div class="gray" style="display:flex; align-items: center;justify-content: center;height: 30px;">
            <center> <h4>INFORMATIONS ELECTORALES</h4></center> 
        </div>
        <table>
            <tr>
                <td style="text-align: left;">Province : <strong>{{$inscription->province}}</strong></td>
                <td style="text-align: left;">Commune ou département : {{$inscription->commoudept}}</td>
                <td style="text-align: left;">Arrondissement : {{$inscription->arrondissement ?? null}} </td>
            </tr>
            <tr>
                <td style="text-align: left;" colspan="3">Centre de vote : {{$inscription->centrevote}}</td>
               
            </tr>
            
        </table>
    

        <!-- Authentification du formulaire -->
        <div class="gray" style="display:flex; align-items: center;justify-content: center;height: 30px;">
           <center> <h4>AUTHENTIFICATION DU FORMULAIRE</h4></center>
        </div>
        <br>
        <table>
            <tr>

               
                <td style="text-align: left; height: 80px;padding-top: 0px;border: none;"> Signature du demandeur :</td>
                <td style="text-align: right;border: none;">Visa du représentant de la CENA (Signature et cachet)</td> 
            </tr>
            <tr>
                <td style="text-align: left; height: 80px;padding-top: 0px;border: none;"></td>
                <td style="text-align: right;height: 80px;border: none;"></td> 
            </tr>
        </table>
       
       
        <p>
            <br> Prénoms et nom du Président de la commission administrative : ..................................................
        </p>
    </div>

    
    
    <br>
    <div  style="display:flex; align-items: center;justify-content: center;height: 30px;">
        <center> <h4>  Numéro de la demande : {{$inscription->id}}</h4></center> 
            
    </div>
    <div  style="display:flex; align-items: center;justify-content: center;height: 30px;">
    <center> <h4>  RECEPISSE DESTINE A L’ELECTEUR</h4></center> 
    </div>

    <p>Prénoms <strong>{{$identification->prenom}}</strong>  Nom <strong>{{$identification->nom}}</strong>
        né(e) le<strong>{{$identification->datenaiss}}</strong>  à  <strong>{{$identification->lieunaiss}}</strong>
        a sollicité auprès de la commission administrative l’opération suivante :
        une demande d’inscription sur la liste électorale de <strong> {{$inscription->centrevote}} </strong></p>
        <table style="border: none;">
            <tr>
               
                <td style="text-align: left;border: none;"> Le Président de la commission</td>
               
                <td style="text-align: right;border: none;"> Visa de la CENA</td>
            </tr>
            <tr >
                <td style="text-align: left;border: none;"  ></td>
                <td style="text-align: left; border: none;" ></td>
               
            </tr>
      		      				

</body>

</html>
