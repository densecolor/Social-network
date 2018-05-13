<!DOCTYPE html>
<html>
	<html>
    <head>
         <link href="styleprofil.css" rel="stylesheet" type="text/css" media="all" />
        <meta charset="UTF-8">
        <title>découvrir des membres</title>
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
			<li > <a href="profil.php">Mon profil</a></li>
			<li><a href="modifier.php">Modifier mon profil</a></li>
			<li id="current"> <a href="recherche.php">Découvrir des membres</a></li>
			<li><a href="deconnexion.php">Deconnecter</a></li>			
		</ul>
	</div>	
     <div id="three-column" class="container">   
<?php
require("fonction.php");  
$connection=connectBD();
session_start();
$idm=$_SESSION["idm"];
?>
		<!-- ceux qui ont plus de membres suivis -->
		<?php
                echo " <div id='tbox1'> ";
                echo"<h1>Ceux qui ont plus de followers</h1><br><table>";
//je cherche dans la table suivre, je compte le nombre d'apparition de chaque  IDM_1 
		$sql="SELECT M.IDM,M.NOMM,M.PRENOMM,M.PSEUDOM,COUNT(IDM_1)AS       NBFOLLOWS
					FROM SUIVRE S,MEMBRES M
					WHERE M.IDM=S.IDM_1
					GROUP BY M.IDM,M.IDM,M.PRENOMM,M.PSEUDOM
					ORDER BY COUNT(IDM_1)DESC
					LIMIT 3";
		$ordre=mysqli_query($connection,$sql);
                
		while($ligne=mysqli_fetch_array($ordre)){
                          $declare[]=$ligne["IDM"];
                        }
                       
                                 if(!empty($declare)){
                        foreach($declare as $declare){
                            echo "<tr><td>";
                             amisfans($connection,$idm,$declare);
                              echo "</td>";
                                    
			if($declare!=$idm){
				//je ne peux pas suivre moi-même
				echo"<td>";
			 suivre($connection,$idm, $declare);
			 echo"</td></tr>";
                        }
                        }
						echo"</table>";
                                 }
					
                                 echo"</div>";
		?>
		
		
<!-- ceux qui ont le ou les mêmes compétences que moi -->		
	<?php
         echo " <div id='tbox2'> ";
        echo" <h1> Mêmes compétences que moi</h1><br><table>";
//je cherche les membres qui ont les mêmes compétences(déclarées ou recommandées) que moi
		$sql="SELECT M.IDM,M.NOMM,M.PRENOMM,M.PSEUDOM
					FROM MEMBRES M, AVOIR A
					WHERE M.IDM=A.IDM
					AND A.CODEC IN( SELECT A2.CODEC
                                                        FROM AVOIR A2
                                                        WHERE A2.IDM=$idm 
                                                        UNION 
                                                        SELECT R.CODEC
                                                        FROM RECOMMANDER R
                                                        WHERE R.IDM_1=$idm) 
					UNION
					SELECT M2.IDM,M2.NOMM,M2.PRENOMM,M2.PSEUDOM
					FROM  MEMBRES M2, RECOMMANDER R2
					WHERE M2.IDM=R2.IDM_1
					AND R2.CODEC IN( SELECT A2.CODEC
                                                        FROM AVOIR A2
                                                        WHERE A2.IDM=$idm
                                                UNION 
                                                        SELECT R.CODEC
                                                        FROM RECOMMANDER R
                                                        WHERE R.IDM_1=$idm) 
					AND M2.IDM NOT IN( SELECT M.IDM
                                                        FROM MEMBRES M, AVOIR A
                                                        WHERE M.IDM=A.IDM
                                                        AND A.CODEC IN( SELECT A2.CODEC
                                                        FROM AVOIR A2
                                                        WHERE A2.IDM=$idm
                                                        UNION 
                                                        SELECT R.CODEC
                                                        FROM RECOMMANDER R
                                                        WHERE R.IDM_1=$idm) )
                    limit 3";
		
			$ordre=mysqli_query($connection,$sql);
                      
                        $nb= mysqli_num_rows($ordre);
                        
                      if($nb!=0){
			while($ligne=mysqli_fetch_array($ordre)){
                          $meme[]=$ligne["IDM"];
                        }
                      }
                        if(!empty($meme)){
                        foreach($meme as $meme){
                            echo "<tr><td>";
                             amisfans($connection,$idm,$meme);
                              echo "</td>";
					if($meme!=$idm){
                              echo"<td>";         
                         suivre($connection,$idm, $meme);
						 echo"</td></tr>";
                                        }      
					
									}
                        }
						echo"</table>";
		
		echo "</div>"
		?>
<!-- ceux qui ont plus de commentaires appréciés -->
		
		<?php
                echo"<div id='tbox3'>";
                  echo"<h1>Ceux qui ont plus de 'like'</h1><br><table>";
//je cherche le nombre d'appréciation les plus importants dans la table commentaire
		$sql="select M.IDM,M.NOMM,M.PRENOMM,SUM(C.NBAPP)
                    from MEMBRES M,COMMENTAIRE C
                    WHERE M.IDM=C.IDM
                    GROUP BY  M.IDM,M.NOMM,M.PRENOMM
					LIMIT 3";
			$ordre=mysqli_query($connection,$sql);
			while($ligne=mysqli_fetch_array($ordre)){
                          $star[]=$ligne["IDM"];
                        }
                        // print_r($star);
                          if(!empty($star)){
                        foreach($star as $star){
                            echo "<tr><td>";
                             amisfans($connection,$idm,$star);
                              echo "</td>";
                       
					if($star!=$idm){
						echo"<td>";
					  suivre($connection,$idm, $star);
					  echo"</td></tr>";
                                                  }
			}
                          }
         
						  echo"</table>";
		
		echo "</div>"
          
          
		?>
		
        
</div>    
</div>  

 
</div>


    </body>
	
</html>