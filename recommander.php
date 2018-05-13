<!DOCTYPE html>
<html>
	<head>
             <link href="style.css" rel="stylesheet" type="text/css" media="all" />
		<meta http-equiv="Content-Type"
			content="text/html;charset=UTF-8">

		<title>profil</title>
		
	</head>
<?php
require("fonction.php");  
$connection=connectBD();
session_start();
$idm=$_SESSION["idm"];
//je récupère le code de ce membre par SESSION ‘idmclick’
// à partir de la page 'demiprofil.php' 
//ou par SESSION ‘idmclick’ à partir de la page 'profil2.php'
$idmclick=$_SESSION["idmclick"];
?>
	
	<?php
//je récupère les codes de competences que j'ai choisi soit dans la page'profil2.php',
//soit dans la page'demiprofil.php' par GET ‘com’
//et les inserert dans la table recommander de la BD
    $comp=$_GET["com"];
    foreach ($comp as $com){
            $sql="INSERT INTO RECOMMANDER(IDM, CODEC, IDM_1) VALUES ($idm,'$com',$idmclick)";
            $ordre=mysqli_query($connection,$sql);
            if(!$ordre){
                    echo ("vous avez deja recommander cette competence a votre ami");
                    echo("<br>");
            }
            else{
                    echo("reussi");
            }

    }
    echo '<script language="javascript">history.go(-1);</script>';
		
	?>
