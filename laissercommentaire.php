<!DOCTYPE html>
<html>
    <head>
         <link href="style.css" rel="stylesheet" type="text/css" media="all" />
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
			<li id="current"><a href="#">laisser un commentaire</a></li>
			<li><a href="deconnexion.php">Deconnecter</a></li>
		</ul>
	</div>	
			 <div id="three-column" class="container">  
	<?php
require("fonction.php");  
$connection=connectBD();
session_start(); 
$idm=$_SESSION["idm"];
//je récupère le code de ce membre par GET ‘codecom’ 
//à partir de la fonction *’afficher_chaque’
//je le met dans la SESSION["codecom"]
$codecom=$_GET["codecom"];
$_SESSION['codecom']=$codecom;
$codecom= $_SESSION['codecom'];
	?>
                             
<!-- laisser votre commentaire -->
<div id='tbox2'>
<!--j'utilise l'attribut maxlength="140" pour specifier le maximum nombre de caractere pour textarea-->
<h1>Vous pouvez laisser votre commentaire ici <h1>	
<form action ="dejalaisser.php" method="GET" id="myform">  
    <textarea cols=60 rows=10 name="souscommentaire" placeholder="140 caractere au maximum"  maxlength="140" required></textarea></br>
    <input type="submit" class="button" value="enregistrer" id="sbmt">
    <a href="javascript:" onclick="history.back(); "><button class="button" type="button">retour</button></a>
		  
</form>	
   
	  
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