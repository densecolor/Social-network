<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
         <link href="styleprofil.css" rel="stylesheet" type="text/css" media="all" />
        <meta charset="UTF-8">
        <title>Mon profil</title>
    </head>
<body>

<div id="wrap">

<div id="header">	
			
		<h1 id="logo">SI<span class="blue">GE</span></h1>
		<h2 id="slogan">Systèmes d’Information et Gestion des Entreprises</h2>	
		<form class="searchform "action="recherche_resultat.php" method="get">
			<input type="text" name="recherche"size="25" required>   <input type="submit" class="button" value="rechercher"></br>
			<input type="radio" name="limit" value="nom" checked>	recherche par nom   
			<input type="radio" name="limit" value="competence">	recherche par compétence
		</form>

	</div>
	   <!-- menu-->  
<div id="menu">
		<ul>
			<li id="current"> <a href="profil.php">Mon profil</a></li>
			<li><a href="modifier.php">Modifier mon profil</a></li>
			<li><a href="recherche.php">Découvrir des membres</a></li>
			<li><a href="deconnexion.php">Deconnecter</a></li>			
		</ul>
	</div>	
<div id="three-column" class="container">   
<?php

        require("fonction.php");  
	$connection=connectBD();
        session_start();
        $idm=$_SESSION["idm"];
     
    echo " <div id='tbox1'> ";
//Afficher le nom le prenom,l'adresse email et le pseudo d'utilisateur  
$sql="SELECT NOMM,PRENOMM,PSEUDOM,PASSWORD,EMAILM
	FROM MEMBRES
	WHERE IDM='$idm'";
   $res=mysqli_query($connection,$sql);
   while($ligne=mysqli_fetch_array($res)){
   echo("<h1>Mon profil</h1><table style='text-align:left'><tr><td>Nom:".utf8_encode($ligne["NOMM"]." ".$ligne["PRENOMM"]." </td></tr>"));
     echo "<tr><td>Email:".$ligne["EMAILM"]."</td></tr>";
       echo("<tr><td>Pseudo:".$ligne["PSEUDOM"]."</td></tr></table>");
   }  
//affcher ses compétences et niveauux ainsi que les compétences recommandés par les autres      
$sql="SELECT C.CODEC,C.NOMC,N.IDN,N.LIBELLEN,'nonidm'
			FROM COMPETENCE C,NIVEAU N,AVOIR A 
			WHERE C.CODEC=A.CODEC
			AND A.IDN=N.IDN
			AND A.IDM=$idm
			UNION
			SELECT C2.CODEC,C2.NOMC,'','',R.IDM
			FROM RECOMMANDER R, COMPETENCE C2
			WHERE R.CODEC=C2.CODEC
			AND R.IDM_1=$idm";
			
				$ordre=mysqli_query($connection,$sql);
				$nb=mysqli_num_rows($ordre);
				if($nb!=0){
					echo"<h1>Compétences</h1>";
                                    echo("<table style='text-align:left'>");
                                    while($ligne=mysqli_fetch_array($ordre)){
                                        echo "<tr><td>";
					echo $ligne["NOMC"];
                                        echo " ";
					echo	$ligne["LIBELLEN"];
                                        if ($ligne["LIBELLEN"]==''){
                                             echo " recommandé  par ";
//vérification si les gens qui recommandent sont ses followings ou ses followers en utilisant la fonction  amisfans
                                            amisfans($connection, $idm, $ligne["nonidm"]);
                                        }
					echo "</td></tr>";
				}}
                                    echo "</table>";
   echo "</div>";
 ?>
     </div>     
<?php 
//Afficher ses commentaires
 echo" <div id='tbox2'> ";
       $idm=$_SESSION["idm"];
     
       echo" <div class='title'>";
            echo "<h1>Les commentaires:</h1>";
            afficher_commentaire($connection,$idm,$idm,1);        
       	echo"</div>";		       

?>
        </br>
        </br>
<!--/* boîte de commentaire */-->
    <div class="sous">
        <form action ="dejalaisser.php" method="GET" >
		<textarea cols=60 rows=10 name="commentaire" placeholder="140 caractere au maximum" maxlength="140" required></textarea></br>
		<input class="button" type="submit" value="enregistrer">		
        </form>	
          
    </div>  

            <?php
      echo"</div>";	   
//fans or amis
   echo " <div id='tbox3'> ";
   echo ("<h1>Decouvert</h1>");
//les gens que je suis
   echo "<h2>Followings:</h2>";
   $sql="select m2.NOMM, m2.PRENOMM,m2.PSEUDOM,m2.IDM
        from MEMBRES m1,MEMBRES m2, SUIVRE s
        where m2.IDM=s.IDM_1
        and  m1.IDM=s.IDM
        and m1.IDM=$idm";
     $res=mysqli_query($connection,$sql);
    
   while($ligne=mysqli_fetch_array($res)){
       $amis[]=$ligne["IDM"];
//adresse d'un ami, je transmet son IDM en tant que idmamis
   echo("<p><a href='profil2.php?idmamis=".$ligne["IDM"]."'>".utf8_encode($ligne["NOMM"]." ".$ligne["PRENOMM"])." </a>");
//je met l'image de suivre adéquat
    suivre($connection,$idm, $ligne["IDM"]);
     echo "</p>";
   }
   
   
//les gens qui me suivent  
echo "<h2>Followers:</h2>";
      $sql="select m2.IDM ,m2.NOMM, m2.PRENOMM,m2.PSEUDOM
            from MEMBRES m1,MEMBRES m2, SUIVRE s
            where m2.IDM=s.IDM
            and  m1.IDM=s.IDM_1
            and m1.IDM=$idm";
     $res=mysqli_query($connection,$sql);
     mysqli_error($connection);
     $nb=mysqli_num_rows($res);
   if($nb!=0){
      while($ligne=mysqli_fetch_array($res)){
          $fans[]=$ligne["IDM"];   
   }
      }   
    if(!empty($fans) and !empty($amis)){
//si j'ai des following et des followers	
//following et follower en même temps
       $inter=array_intersect($fans,$amis);
//les gens qui ne sont que mon fans, pas mon amis	
       $diff=array_diff($fans,$amis);
       $nbdiff=count($diff);
       $nbinter=count($inter);
       
     if($diff){
         
       foreach($diff as $diff){
           $sql="select m.IDM,m.NOMM,m.PRENOMM
            from MEMBRES m
            where m.IDM=$diff";
              $res=mysqli_query($connection,$sql);
         $diffligne=mysqli_fetch_array($res);       
//adresse d'un fans, je transmet son IDM en tant que monfan         
             echo('<p><a href="demiprofil.php?monfan='.$diff.'">'.utf8_encode($diffligne["NOMM"].''.$diffligne["PRENOMM"]).'</a>');
//je met l'image de suivre             
             suivre($connection,$idm, $diff);
             echo "</p>";
       }
       }
        if($inter){
       foreach($inter as $inter){
          
           $sql="select m.IDM,m.NOMM,m.PRENOMM
            from MEMBRES m
            where m.IDM=$inter";
         $res=mysqli_query($connection,$sql);
         $interligne=mysqli_fetch_array($res);       
 // pour ceux qui sont mes fans et mes amis en même temps, je ne veux que son adresse en tant que ami où je peux voir les commentaires        
       echo ('<p><a href="profil2.php?idmamis='.$inter.'">'.utf8_encode($interligne["NOMM"].''.$interligne["PRENOMM"]).'</a>');
         suivre($connection,$idm, $inter);
          echo "</p>";
       }
        }
        
        }
    echo "</div>";
  
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
