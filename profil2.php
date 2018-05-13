<!DOCTYPE html>
<html>
    <head>
         <link href="styleprofil.css" rel="stylesheet" type="text/css" media="all" />
        <meta charset="UTF-8">
        <title>Le profil d'un membre</title>
    </head>
<body>

<div id="wrap">
    
<!--head-->
<div id="header">	
			
		<h1 id="logo">SI<span class="blue">GE</span></h1>
		<h2 id="slogan">Systèmes d’Information et Gestion des Entreprises</h2>
		
<form class="searchform "action="recherche_resultat.php" method="get">
                <input type="text" name="recherche"size="25" required>   
                <input type="submit" class="button" value="rechercher"></br>
                <input type="radio" name="limit" value="nom" checked>	recherche par nom   
                <input type="radio" name="limit" value="competence">	recherche par compétence
</form>	
</div>
    
<!-- menu-->  
<div id="menu">
		<ul>
			<li> <a href="profil.php">Mon profil</a></li>
			<li><a href="modifier.php">Modifier mon profil</a></li>
			<li><a href="recherche.php">Découvrir des membres</a></li>
			<li id="current"><a href="#">Consultation</a></li>
			<li><a href="deconnexion.php">Deconnecter</a></li>
		</ul>
</div>	
	
	
<?php

     session_start();
	 require("fonction.php");  
         $connection=connectBD();
//je récupère le code de ce membre par GET ‘idmamis’ de la fonction*'amisfans', je le met dans la session ‘idmclick’.
         $idmamis=$_GET["idmamis"];
         $idm=$_SESSION["idm"];
        $_SESSION["idmclick"]=$idmamis;
	?>
              

     <div id="three-column" class="container">  
	

<?php
	echo " <div id='tbox1'> ";
         echo "<h1>Son profil</h1>";
//information personnelle
//j'utilise les deux fonctions pour afficher le nom de ce membre que je viste
//pour juger si on est amis ou non et si je peux le suivre ou non         
            echo "<table style='text-align:left'><tr><td>Nom: ";
                    amisfans($connection,$idm,$idmamis);
		    suivre($connection,$idm, $idmamis);
			echo "</td></tr></table>";
?>

<?php
$sql="SELECT C.CODEC,C.NOMC,N.IDN,N.LIBELLEN,'nonidm'
			FROM COMPETENCE C,NIVEAU N,AVOIR A 
			WHERE C.CODEC=A.CODEC
			AND A.IDN=N.IDN
			AND A.IDM=$idmamis
			UNION
			SELECT C2.CODEC,C2.NOMC,'','',R.IDM
			FROM RECOMMANDER R, COMPETENCE C2
			WHERE R.CODEC=C2.CODEC
			AND R.IDM_1=$idmamis";
			
				$ordre=mysqli_query($connection,$sql);
				$nb=mysqli_num_rows($ordre);
				if($nb!=0){
					echo"<h1>Compétences</h1>";
						echo("<table style='text-align:left'>");
			while($ligne=mysqli_fetch_array($ordre)){
                            echo "<tr><td>";
					echo $ligne["NOMC"];
                                        echo" ";
					echo	$ligne["LIBELLEN"];
                                        if ($ligne["LIBELLEN"]==''){
                                              echo " recommandé par ";
                                            amisfans($connection, $idm, $ligne["nonidm"]);
                                        }
				echo "</td></tr>";
				}echo "</table>";
                                
                                        }
                                
				else{
					echo("il n'a pas de competences declares ou recommandes");
				}
?>
<br>
  <i>lui recommandez une competence:</i>
	<form action="recommander.php" method="get">
<?php
//Il peut aussi lui recommande une ou plusieurs compétences, les informations saisies sont transmises dans la page ‘recommander.php’.
            $sql="SELECT C.CODEC, C.NOMC
                    FROM COMPETENCE C";
                            $ordre=mysqli_query($connection,$sql);
                               echo "<table style='text-align:left'>";
                            while($ligne=mysqli_fetch_array($ordre)){
                                echo"<tr><td>";
                                    echo ("<input type=checkbox name='com[]' value=".$ligne["CODEC"]."></td><td>");
                                    echo $ligne["NOMC"];
                                    echo("</td></tr>");

                            } echo "</table>";
?>							
	    <input type="submit" class="button" value="recommander">
	</form>

  </div>																	
<!-- commentaires de ce membre -->

<?php
      echo" <div id='tbox2'>";
       echo "<h1>Ses commentaires</h1>";
    
	afficher_commentaire($connection,$idmamis,$idm,2);

     echo"</div>";		
?>
<?php
   echo " <div id='tbox3'> ";
   echo ("<h1>Decouvert</h1>");
   //les gens qu'il suit
 echo "<h2>Following:</h2>";
   $sql="select m2.NOMM, m2.PRENOMM,m2.PSEUDOM,m2.IDM
			from MEMBRES m1,MEMBRES m2, SUIVRE s
			where m2.IDM=s.IDM_1
			and  m1.IDM=s.IDM
			and m1.IDM=$idmamis";
     $res=mysqli_query($connection,$sql);
 
   while($ligne=mysqli_fetch_array($res)){
       $amis[]=$ligne["IDM"];
	  echo '<p>';
                amisfans($connection, $idm, $ligne["IDM"]);
                suivre($connection,$idm, $ligne["IDM"]);
	   }
	   
	   
			echo "</p>";
   
//les gens qui lui suivent
   echo "<h2>Followers:</h2>";
      $sql="select m2.IDM ,m2.NOMM, m2.PRENOMM,m2.PSEUDOM
				from MEMBRES m1,MEMBRES m2, SUIVRE s
				where m2.IDM=s.IDM
				and  m1.IDM=s.IDM_1
				and m1.IDM=$idmamis";
     $res=mysqli_query($connection,$sql);
     mysqli_error($connection);
     $nb=mysqli_num_rows($res);
   if($nb!=0){
      while($ligne=mysqli_fetch_array($res)){
          $fans[]=$ligne["IDM"];   
   }
   } 
    if(!empty($fans) and !empty($amis)){   
       $inter=array_intersect($fans,$amis);
       $diff=array_diff($fans,$amis);
       $nbdiff=count($diff);
       $nbinter=count($inter);
       
     if(!empty($diff)){
       foreach($diff as $diff){
           echo '<p>';
            amisfans($connection, $idm, $diff);
	    suivre($connection,$idm, $diff);
              echo "</p>";
         }
       }
       }
        if(!empty($inter)){
       foreach($inter as $inter){
        echo '<p>';
           amisfans($connection, $idm, $inter);
	   suivre($connection,$idm, $inter);
	  echo "</p>";
       }
        }
echo"</div>";
  
?>



</div>
    
<!-- footer starts here -->		
		<div id="footer">
			<p>
			&copy; copyright 2017 <strong>Université Toulouse 1 Capitole</strong>&nbsp;&nbsp;  			
			Design by: <a href="#">LI Yao& LIU Jin</a> 			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
			</p>		
		</div>	
<!-- footer ends here -->

    </body>
	
</html>