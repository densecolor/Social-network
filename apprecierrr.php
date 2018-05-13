<html>
    <head>
        <link href="style.css" rel="stylesheet" type="text/css" media="all" />
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
	<?php
	require("fonction.php");  
        $connection=connectBD();
        session_start();
        $idm=$_SESSION["idm"];
//je récupère le code de commentaire qu’il veut apprécier
//l’indice transmis par la fonction ‘Islike’
// pour indiquer s’il veut apprécier ou annuler d’apprécier.        
        $codeapp=$_GET["codecomapprecier"];
//je récupère le flag qui est transmit par la fonction 'Islike'      
	$flag=$_GET['like'];
//Si flag est ajouter, je fais deux requêtes, une pour insérer dans la table apprécier mon IDM et le CODECOM, 
//l’autre est pour actualiser le nombre d’appréciation(NBAPP) dans la table commentaire.       
	   if($flag=='ajouter'){
   //j'ajoute mon appréciation dans la table apprécier
                         $sql="INSERT INTO APPRECIER (IDM,CODECOM)
                                                VALUES ('$idm','$codeapp')";
                if($ordre=mysqli_query($connection,$sql)){
                //j'actualise le nombre des appréciations pour le commentaire actuel
                  $sql="UPDATE COMMENTAIRE SET NBAPP=NBAPP+1 WHERE CODECOM=".$codeapp;
                if($ordre=mysqli_query($connection,$sql)){

                        //echo("reussi");
                }
                else{
                        mysqli_error($connection);
                }
                }
                else{
                        mysqli_error($connection);
                }				
	   }
 //Si le flag est annuler, je fais aussi deux requêtes, une pour supprimer l’enregistrement dans la table apprécier, 
 //l’autre pour actualiser NBAPP en faisant moins un.          
	   else{
		   //je supprime l'enregistrement dans la table apprécier
		   $sql="delete from APPRECIER where IDM='$idm' and CODECOM='$codeapp'";
                        if($ordre=mysqli_query($connection,$sql)){
                   //je fais moins un pour le nombre des appréciation du commentaire actuel
                        $sql="UPDATE COMMENTAIRE SET NBAPP=NBAPP-1 WHERE CODECOM=".$codeapp;
                        if($ordre=mysqli_query($connection,$sql)){
                                //echo("reussi");
                        }
                        else{
                                echo mysqli_error($connection);
                        }
                        }
                        else{
                                echo mysqli_error($connection);					
                        }		  
	   }
	   
echo '<script language="javascript">history.go(-1);</script>';	   
	   ?>
    </body>
</html>
