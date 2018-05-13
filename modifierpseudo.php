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
          
            ?>
   	<div id='tbox2'>     
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">              
            <table style='text-align:left'>                
            <tr><td><p><input type="text" name="pseudo" id="pseudo"required></p></td></tr>
       <?php
if(isset($_POST['pseudo'])){
        $pseudo=$_POST['pseudo'];

}else{
        $pseudo=false;
} 
//mis a jour le pseudo dans la BD
            if (!empty($pseudo)){
            $sql="UPDATE MEMBRES SET PSEUDOM='".$pseudo."' where IDM=$idm";            
                    if($ordre=mysqli_query($connection,$sql)){
                        echo("<span style='color:green'>reussi</span>");
                  } else{   
                         mysqli_error($connection);
                             }   
                         }
            else{
                echo "<h2>saisir votre nouveau pseudo </h2>";
            }
            ?>
             <tr><td><input class="button" type="submit" name="submit" value="Confirmer" required onClick="return confirm('envoyer ?')"></td>
             <td><input class="button" name="reset" type="reset"  value="Effacer" ></td></tr>
             <tr><td><a href="modifier.php">retour</a></td></tr>
        </table>
    </form>
  </div>    
</div>  
</div>
<!-- footer starts here -->		
		<div id="footer">
			<p>
			&copy; copyright 2017 <strong>Université Toulouse 1 Capitole</strong>&nbsp;&nbsp;  			
			Design by: <a href="http://www.styleshout.com/">LI Yao& LIU Jin</a> 			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
			</p>		
		</div>	
<!-- footer ends here -->	
    </body>
	
</html>