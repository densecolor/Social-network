
<!DOCTYPE html>
<html>
	<head>
              <link href="style.css" rel="stylesheet" type="text/css" media="all" />
		<meta http-equiv="Content-Type"
			content="text/html;charset=UTF-8">

		<title>resultat de recherche</title>
		
	</head>
        <body>
<?php

	 require("fonction.php");  
         $connection=connectBD();
         session_start();
         $idm=$_SESSION["idm"];
//je récupère le code de ce membre par GET ‘codecomsupprim’ 
//à partir de la fonction *’afficher_chaque’          
	 $codesup=$_GET["codecomsupprim"];
         
//je fais appel aux deux fonctions

delete_souscommentaire($connection,$codesup); //pour trouver tous les commentaires qui n'ont pas de commentaires complémentaires et les supprimer
deleteinitial ($connection,$codesup); //pour supprimer le commentaire actuel

echo '<script language="javascript">history.go(-1);</script>';
?>
</body>
</html>