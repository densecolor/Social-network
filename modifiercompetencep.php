<html>
    <head>
         <link href="style.css" rel="stylesheet" type="text/css" media="all" />

        <meta charset="UTF-8">
        <title>Modification</title>
            
    </head>
    <body>
      
        <div id="home"> 
<?php
session_start();
require("fonction.php"); 
$connection=connectBD(); 
$idm=$_SESSION["idm"];
//je recupere le code de competence qu'il veut supprimer
$codesup=$_GET["codecomsupprim"];
?>
        <?php     
        $sql="DELETE FROM AVOIR WHERE CODEC=$codesup AND IDM=$idm";
        $res=mysqli_query($connection,$sql);
	   if($res){
            header("Location:modifiercompetence.php");     
       }
        ?>
        </div>
    </body>
</html>
