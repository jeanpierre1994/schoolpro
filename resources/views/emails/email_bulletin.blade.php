<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
</head>

<body>

<div style=" display:block; max-width:800px; margin:5px auto;  padding:0; color:#fff; background: #d3d3de; border-radius:5px;border:1px solid #c0ddf6;font-size:15px; font-family: Montserrat, sans serif;">
    <div style=" display:block;  text-align:center;padding:10px;margin: 0;">
        <img src="{{ asset('nice/assets/img/british.png') }}" alt="logo" class="img-responsive" width="auto" height="30px" style="width: auto; height:100px;">
          </div>
<div style=" display:block;  text-align:center;padding:20px;margin: 0; color:#000;">
    <b style="font-size: 120%">NOTIFICATION : {{$contenu['titre']}} {{$contenu['annee']}}</b>
      </div>

    <div style="background:#fff; color: #000; display:block;padding:30px; text-align: justify; ">
    <p>Bonjour <b>{{$contenu['nom_prenoms']}}</b>,</p>  
    <p>Nous vous informons que votre “ <b>{{$contenu['titre']}}</b> ” de l'année <b>{{$contenu['annee']}}</b> est déja disponible. </p> 
    <p>Merci de bien vouloir cliquer sur le lien <strong>“ Télécharger mon bulletin ”</strong> ci-dessous pour l'imprimer. </p> 
    <p style="text-align: center"> 
        <a href="{{route('bulletins.telecharger',['codeBulletin' => $contenu['code_bulletin'], 'etudiant_id' => $contenu['code_etudiant'] ])}}" class="btn btn-dark" style="background:#6d4c41; color:#fff; padding:5px; text-decoration:none; border-radius:4px;">
            Télécharger mon bulletin
            </a>
    </p>  
    <p class="small">
        BRITISH & FRENCH ACADEMY Int'l
    </p>
      </div>
      <div style=" background:#d3d3de;color:#fff; text-align:center;padding:30px 10px; display:block;  ">
          <a style="color:#000; text-decoration: none;" href="#" target="_blank" > &copy; 2024 - Conception & Réalisation : Schoolpro </a>
      </div>
</div>

</body>
</html>
