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
	?>
	
	
<?php
   session_start();
//je récupère le code de ce membre par GET ‘idmrecherche’ à partir de fonction *’suivre’   
if(isset($_GET["idmrecherche"])){
      $idmclick=$_GET["idmrecherche"];
}
//ou je récupère le code de ce membre par SESSION ‘idmclick’ à partir de la page 'demiprofil.php' 
//ou par SESSION ‘idmclick’ à partir de la page 'profil2.php'
     else{
      $idmclick=$_SESSION["idmclick"];
     }  
$idm=$_SESSION["idm"];
//je récupère l'etat de la variable flag par GET ‘sui’ à partir de fonction *’suivre’ 
$flag=$_GET['sui'];

//Si l’indice est ‘suivre’, on insère l’enregistrement dans la table ‘suivre’.
if($flag=='suivre'){

		$sql="INSERT INTO SUIVRE 
				VALUES('$idm','$idmclick')";
		$ordre=mysqli_query($connection,$sql);
		if(!$ordre){
			echo mysqli_error($connection);
		}
		else{
			echo("reussi de suivre");
                        echo "<p>Les gens que je suis:</p>";
   $sql="select m2.NOMM, m2.PRENOMM,m2.PSEUDOM,m2.IDM
from MEMBRES m1,MEMBRES m2, SUIVRE s
where m2.IDM=s.IDM_1
 and  m1.IDM=s.IDM
  and s.IDM_1=$idmclick
and m1.IDM=$idm";
     $res=mysqli_query($connection,$sql);
   while($ligne=mysqli_fetch_array($res)){
   echo("<p><a href='profil2.php?idmamis=".$ligne["IDM"]."'>".$ligne["NOMM"]." ".$ligne["PRENOMM"]." </a></p>");
   }
                }	
   }
   
 //Si l’indice est ‘nesuivreplus’, on supprime l’enregistrement en cause.
	else{	
            	$sql="delete from SUIVRE where IDM=$idm and IDM_1=$idmclick";
			
		$ordre=mysqli_query($connection,$sql);
		if(!$ordre){
			echo mysqli_error($connection);
		}
          
   }
echo '<script language="javascript">history.go(-1);</script>';

?>
       
    </body>
</html>
