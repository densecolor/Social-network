<!DOCTYPE html>
<html>
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
			<li id="current"><a href="#">Consultation</a></li>
			<li><a href="deconnexion.php">Deconnecter</a></li>			
		</ul>
	</div>	
     <div id="three-column" class="container">   
  <?php
	require("fonction.php");  
        $connection=connectBD();
        session_start();
       $idm=$_SESSION["idm"];
       //je récupère le code de ce membre par GET ‘monfan’ à partir de fonction *’amisfans’. On le met dans la session ‘idmclick’.
       if(isset($_GET['monfan'])){
   }
        $idmclick=$_GET["monfan"];
        $_SESSION["idmclick"]=$idmclick;
	
	?>
      
			<div id='tbox1'> 
              <div id="three-column" class="container">
 <div id='tbox1'>		
<h1>Son profil</h1>
<?php
$sql="SELECT M.NOMM,M.PRENOMM,M.PSEUDOM
			FROM MEMBRES M
			WHERE M.IDM=".$idmclick;
				$ordre=mysqli_query($connection,$sql);
				
			while($ligne=mysqli_fetch_array($ordre)){
                            echo "<table style='text-align:left'><tr><td>Nom: ";
                            amisfans($connection,$idm,$idmclick);
                                         if($idmclick!=$idm){
                                    suivre($connection,$idm, $idmclick);
                                }
								echo"</td></tr></table>";
			}
?>

<?php
$sql="SELECT C.CODEC,C.NOMC,N.IDN,N.LIBELLEN,'nonidm'
			FROM COMPETENCE C,NIVEAU N,AVOIR A 
			WHERE C.CODEC=A.CODEC
			AND A.IDN=N.IDN
			AND A.IDM=".$idmclick."
			UNION
				SELECT C2.CODEC,C2.NOMC,'','',R.IDM
			FROM RECOMMANDER R, COMPETENCE C2
			WHERE R.CODEC=C2.CODEC
			AND R.IDM_1=".$idmclick;
			
				$ordre=mysqli_query($connection,$sql);
				$nb=mysqli_num_rows($ordre);
				if($nb!=0){
						echo("<h1>Compétences</h1>");
			while($ligne=mysqli_fetch_array($ordre)){
                            echo "<table style='text-align:left'><tr><td>";
					echo $ligne["NOMC"];
                                        echo" ";
					echo	$ligne["LIBELLEN"];
                                        if ($ligne["LIBELLEN"]==''){
                                             echo " recommandé par ";
                                            amisfans($connection, $idm, $ligne["nonidm"]);
                                        }
				echo "</td></tr>";
                                }
                                echo "</table>";
                                        }
                                       
				
				else{
					echo("il n'a pas de competences declares ou recommandes");
				}
				?>
				<br>
                  <i>lui recommandez une competence:</i>
		<form action="recommander.php" method="get">
				<?php
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
                  
          <div id="tbox2">
             <h2>Ses commentaires</h2>
              <p>Vous ne l'avez pas suivi</p>
              <p>Pour voir ses commentaires, il vous faut d'abord le suivre</p>
          </div>
                  
   <div id="tbox3">

   </div>
          
<!-- footer starts here -->		
		<div id="footer">
			<p>
			&copy; copyright 2017 <strong>Université Toulouse 1 Capitole</strong>&nbsp;&nbsp;  
			
			Design by: <a href="#">LI Yao& LIU Jin</a> | 
			
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
			</p>		
		</div>
	
<!-- footer ends here -->	
    </body>
	
</html>