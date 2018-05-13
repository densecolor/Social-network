<!DOCTYPE html>
<html>
    <head>
         <link href="styleprofil.css" rel="stylesheet" type="text/css" media="all" />
        <meta charset="UTF-8">
        <title>Le profil d'un membre</title>
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
			<li> <a href="profil.php">Mon profil</a></li>
			<li><a href="modifier.php">Modifier mon profil</a></li>
			<li><a href="recherche.php">Découvrir des membres</a></li>
			<li><a href="deconnexion.php">Deconnecter</a></li>
		</ul>
	</div>	
			 <div id="three-column" class="container">  
			 <div id='tbox2'>
	<?php
         
	 require("fonction.php");  
      $connection=connectBD();
        session_start();
       $idm=$_SESSION["idm"];
	?>
                             
	<?php
	$limit=$_GET["limit"];//recherche par nom ou par compétence
	$recherche=$_GET["recherche"];//le contenu de ma recherche
	?>
	<h1>votre recherche par <?php echo $limit; ?>: <?php  echo $recherche;?></h1>
        
	<?php
	//recherche par competencec declaree
	if (!empty ($recherche) and $limit=="competence"){
	
		$sql="SELECT distinct M.IDM,M.NOMM,M.PRENOMM
					FROM MEMBRES M, AVOIR A,COMPETENCE C
					WHERE M.IDM=A.IDM
					AND C.CODEC=A.CODEC
					AND M.IDM IN ( SELECT M1.IDM
					FROM MEMBRES M1, AVOIR A1,COMPETENCE C1
					WHERE M1.IDM=A1.IDM
					AND C1.CODEC=A1.CODEC
					AND C1.NOMC LIKE '%".$recherche."%') ";
		$ordre=mysqli_query($connection,$sql);
		$nb1=mysqli_num_rows($ordre);
                
		if($nb1!=0){
				echo("<h2>Ceux qui ont la competence declaree que vous cherchez: </h2><table>");
			while($ligne=mysqli_fetch_array($ordre)){
                          $declare[]=$ligne["IDM"];
                        }
                        foreach($declare as $declare){
                            echo "<tr><td>";
			//lien hypertexte adéquat
                             amisfans($connection,$idm,$declare);
                              echo "</td><td>";
				 suivre($connection,$idm,$declare);
				echo"</td></tr>";
                        }	
			}
	}	
	echo"</table>";
	
	//recherche par competence recommandee
	if (!empty ($recherche) and $limit=="competence"){
		
		$sql=" select M.IDM AS CODE,M.NOMM AS NAME, M.PRENOMM AS ABC,M1.IDM,M1.NOMM, M1.PRENOMM
                        from MEMBRES M, MEMBRES M1, RECOMMANDER R, COMPETENCE C
                        WHERE M.IDM=R.IDM
                        AND M1.IDM=R.IDM_1
                        AND R.CODEC=C.CODEC
                        AND C.NOMC LIKE '%".$recherche."%';";
		$ordre=mysqli_query($connection,$sql);
			$nb2=mysqli_num_rows($ordre);
			if($nb2!=0){
			echo("<h2>ceux qui ont la competence recommandee que vous cherchez: </h2><table>");
			while($ligne=mysqli_fetch_array($ordre)){
                          $recommande[]=$ligne["IDM"];  //ceux qui sont recommandés
                          $recom[]=$ligne["CODE"];//ceux qui recommanent
                        }
                       
                        if($recom and $recommande){
                        foreach(array_keys($recom) as $i){                         
                             echo "<tr><td>";
 //ce sont ceux qui sont recommandés par les autres
 //lien hypertexte adéquat
                          amisfans($connection,$idm,$recommande[$i]);
						  echo"</td><td>";
						  suivre($connection,$idm,$recommande[$i]);
						  echo"</td>";
                          echo ("<td>recommande par </td> ");
//ce sont ceux qui recommandent les compétences
//lien hypertexte adéquat
						  echo"<td>";
                            amisfans($connection,$idm,$recom[$i]);
                            echo "</td><td>";
							suivre($connection,$idm,$recom[$i]);
							echo"</td></tr>";
                        }
                                      
			}
			echo"</table>";
	}
        
//il n'y a pas de compétences déclarées ni de compétences recommandées
if ($nb1==0 and $nb2==0)	{
	echo("aucun resultat");
}

        }



//rechercher par nom
	if (!empty ($recherche) and $limit=="nom"){
		echo"<table>";
		//je peux chercher par nom par prénom et par pseudo
		$sql="SELECT M.IDM,M.NOMM,M.PRENOMM,M.PSEUDOM
					FROM MEMBRES M
					WHERE (M.NOMM LIKE '%".$recherche."%'
					OR M.PRENOMM	LIKE '%".$recherche."%'
					OR M.PSEUDOM LIKE '%".$recherche."%')";
					$ordre=mysqli_query($connection,$sql);
			$nb2=mysqli_num_rows($ordre);
			if($nb2!=0){
			while($ligne=mysqli_fetch_array($ordre)){
                            echo '<tr><td>';
							//lien hypertexte adéquat
				amisfans($connection,$idm,$ligne["IDM"]);
                                     echo '</td><td>';  
				suivre($connection,$idm,$ligne["IDM"]);	
						echo"</td></tr>";
			}
	}
	else{
		echo("aucun resultat");
	}
echo"</table>";
}
         
	?>
	
</div>    
</div>  

 
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