<!DOCTYPE html>
<html>
	<head>  <link href="style.css" rel="stylesheet" type="text/css" media="all" />
		<meta http-equiv="Content-Type"
			content="text/html;charset=UTF-8">
		<title>profil</title>
		
	</head>
											

<?php
require("fonction.php");  
$connection=connectBD();
session_start();
$idm=$_SESSION["idm"];//si je laisse un commentaire initial, c'est mon idm
//SESSION["codecom"] vient de la page'laissercommentaire.php'
if(isset($_SESSION["codecom"])){
$codecom=$_SESSION["codecom"];
}
//si  je laisse un commentaire complémentaire, j'ai besoin aussi du code du commentaire initial
$today=date("d/m/y H:i:s");  // je récupère le temps et la date

// insérer le commentaire dans la table commentaire
//je récupère le contenu ‘commentaire ’par GET de la page 'profil.php'
if(isset($_GET["commentaire"])){
    $commentaire=$_GET["commentaire"];
    //je récupère le contenu du commentaire
$sqlsql="INSERT INTO COMMENTAIRE (CODECOM_APPARTENIR,IDM,CONTENU,DATECOM)
	VALUES(null,'$idm','$commentaire','$today')";
$ordre=mysqli_query($connection,$sqlsql);
		if ($ordre=1){
			echo ("insert reussi");
                        
			echo '<script language="javascript">history.go(-1);</script>';
		}
		else{
			echo mysqli_error($connection);	
	}
}

//je récupère le contenu ‘commentaire ’par GET de la page 'profil.php'
// s'il s'agit d'un commentaire complémentaire, 
// je dois connaître le code du commentaire initial (CODECOM_APPARTENIR)
//cela vient de la SESSION["codecom"] qui vient de la page'laissercommentaire.php'
if(isset($_GET["souscommentaire"])){
    $souscommentaire=$_GET["souscommentaire"];
	$sql="INSERT INTO COMMENTAIRE (CODECOM_APPARTENIR,IDM,CONTENU,DATECOM)
	VALUES('$codecom','$idm','$souscommentaire','$today')";
	$ordre=mysqli_query($connection,$sql);
		if ($ordre=1){
			echo ("insert reussi");
			echo '<script language="javascript">history.go(-2);</script>';
		}
		else{
			echo mysqli_error($connection);
			
	}
}
?>
