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
			<li  id="current"><a href="modifier.php">Modifier mon profil</a></li>
			<li><a href="recherche.php">Découvrir des membres</a></li>
			<li><a href="deconnexion.php">Deconnecter</a></li>
		</ul>
	</div>	
			 <div id="three-column" class="container">  
            <?php
             
            session_start();
            require("fonction.php"); 
            $connection=connectBD(); 
            $idm=$_SESSION["idm"];
            $password= $_SESSION['password'];
              
            ?>
		<div id='tbox2'>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
<h1>Modification</h1>
<a href='modifierpseudo.php'><button class="button" type="button">changer mon pseudo</button></a>
 <a href='modifierpsd.php'><button class="button" type="button">changer mot de passe</button></a>
 <a href='modifiercompetence.php'><button class="button" type="button">modifier competence</button></a>
<!--<a href='profil.php'><button class="button" type="button">Retour au mon profil</button></a>-->
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