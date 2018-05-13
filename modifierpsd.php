<html>
    <head>
         <link href="style.css" rel="stylesheet" type="text/css" media="all" />

        <meta charset="UTF-8">
        <title>Modification</title>
    
            <script>   
  function check_psd() {
        //Pour vérifier les deux mot de passe sont égales ou pas
        var psd2=document.getElementById('password2').value;
        var psd3=document.getElementById('password3').value;
        var etat_psd=document.getElementById('etat_psd');
        //Il faut suffrir que tout deux mots de passe à la fois sont remplis et s'égalent
            if (psd2===psd3 &&psd2!==""){
                etat_psd.innerHTML="OK️";
            }else{
               
                etat_psd.innerHTML="Les deux fois de saisir sont differents";
            
            }
        }
    </script>
    
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
         
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <p>Votre mot de passe initial: <input type="password" name="password1" id="password1" onblur="check_psd()" required><span></span></p>
    <p>Votre mot de passe nouveau: <input type="password" name="password2" id="password2" onblur="check_psd()" required></p>
    <p>Confirmez votre mot de passe: <input type="password" name="password3" id="password3" onblur="check_psd()"required >
        <span style="color:red"class="error" id="etat_psd"></span></p>

    <?php
    if(isset($_POST['password1'])){
			$motdepass1=$_POST['password1'];
                    
		}else{
			$motdepass1=false;
		}
  if(isset($_POST['password2'])){
			$motdepass2=$_POST['password2'];
                    
		}else{
			$motdepass2=false;
		}
   if(isset($_POST['password3'])){
			$motdepass3=$_POST['password3'];
                    
		}else{
			$motdepass3=false;
		}
// vérification si le mot de passe initial est correct ou pas             
                $sql="select PASSWORD from MEMBRES WHERE IDM=$idm";
                $res=mysqli_query($connection,$sql);
               $ligne=mysqli_fetch_array($res);
               $password=$ligne["PASSWORD"];
                           
if($motdepass1!=$password and $motdepass1!="" ){
   echo "<span style='color:red'>mot de passe initial incorrect!</span>";
} else{
//vérification si le mot de passe initial et nouveau sont pareils
    if ($motdepass2==$motdepass1 and $motdepass2!=""){
        echo "<span style='color:red'>mot de passe nouveau et initial sont pareils!</span>";
    }else{
//vérification si les deux fois de saisir de nouveau mot de passe sont differents
        if($motdepass2!=$motdepass3 and $motdepass3!=""){
            echo "<span style='color:red'>les deux fois de saisir sont differents!</span>";
        }else {
//mis a jour le mot de passes dans la BD            
             if ($motdepass1==$password and $motdepass2==$motdepass3)  {
                   $sql="UPDATE MEMBRES SET PASSWORD=$motdepass2 where IDM=$idm";      
                    if($ordre=mysqli_query($connection,$sql)){
                        echo("<span style='color:green'>reussi</span>");
				} else{                                
                                    mysqli_error($connection);
              }
           }  
        }
    }
       
}
    
    ?>
     <table style='text-align:left'>
         		
     <tr><td><input class="button" type="submit" name="submit" value="Confirmer" onClick="return confirm('envoyer ?')"></td>
         <td><input class="button" name="reset" type="reset" onClick="return confirm('effacer ?')" value="Effacer" ></td> </tr>
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
			
			Design by: <a href="#">LI Yao& LIU Jin</a> 
			
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
			</p>		
		</div>
	
<!-- footer ends here -->	
    </body>
	
</html>