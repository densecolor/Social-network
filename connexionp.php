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


	</div>
	   <!-- menu-->  
<div id="menu">
		<ul>
				<li> <a href="home.php">Home</a></li>
                                <li > <a href="inscrire.php">Inscription</a></li>
				<li> <a href="home.php">Connection</a></li>
		</ul>
	</div>	
			 <div id="three-column" class="container">  
        <?php
require("fonction.php");
 SESSION_start();
 $connection=connectBD();
 $email=$_GET['email'];
 $password=$_GET['password'];
 $_SESSION['password']=$password;
 
 //verifier si email existe
 $emailunique=emailunique($connection,$email); 
   if ($emailunique){
          echo "<p style='color:red'>email inconnu!<a href='home.php'>"
       . "</p><button type='button' class='button' style='width:100px'>retour</button></a>";
      }else{       
 $sql="SELECT IDM,NOMM,PRENOMM,PASSWORD
	FROM MEMBRES
	WHERE EMAILM='$email'";
   $res=mysqli_query($connection,$sql);
    while($ligne=mysqli_fetch_array($res)){
//verification du mot de passe
                if ($ligne["PASSWORD"]<>$password){
                    echo '<p style="color:red">Le mot de passe est faux </p><a href="home.php">'
                    . '<button type="button" class="button" style="width:100px">retour</button></a>';
                }else{
//si le mot de passe est correct, on s'adresse directement dans sa page personnelle
                  
                    header("Location: profil.php");
                }
                $idm=$ligne["IDM"];
    } 
//je garde le code d'utilisateur actuel pour toute la session
$_SESSION['idm']=$idm; 
      }
?>
      
    </body>
</html>
