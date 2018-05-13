<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
         <link href="styleprofil.css" rel="stylesheet" type="text/css" media="all" />
     <style>
    .error {color: #000000;}
    </style>
        <meta charset="UTF-8">
        <title>Inscription</title>
        
 <script>   
  function check_psd() {
//Pour vérifier les deux mot de passe sont égales ou pas
        var psd1=document.getElementById('password1').value;
        var psd2=document.getElementById('password2').value;
        var etat_psd=document.getElementById('etat_psd');
//Il faut suffrir que tout deux mots de passe à la fois sont remplis et s'égalent
            if (psd1===psd2 &&psd1!==""){
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
	</div>
	   <!-- menu-->  
<div id="menu">
		<ul>
			<li> <a href="home.php">Home</a></li>
			<li  id="current"> <a href="#">Inscription</a></li>
			<li> <a href="home.php">Connection</a></li>
			
		</ul>
	</div>	
			 <div id="three-column" class="container">  
			 <div id='tbox2'>
 <?php
   require("fonction.php"); 
      session_start();
  $connection=connectBD();

?>
                             
<!--une fois on clique sur le bouton s'inscrire, j'envoie la formulaire a la meme page, la meme page s'acualise avec l'information de confirmation-->
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
         <table style='text-align:left'>  
            <tr><td><h1>Inscripiton</h1></td></tr>
            <tr><td><span class="error">* Champs obligatoire</span></td></tr>
            <tr><td>Adresse e-mail : <input type="email" name="email" required><span class="error">*</span></td></tr>             
            <tr><td>Votre mot de passe : <input type="password" name="password1" id="password1" onblur="check_psd()" required>
                    <span class="error">*</span></td></tr>
            <tr><td>Confirmez votre mot de passe: <input type="password" name="password2" id="password2" onblur="check_psd()" required>
                    <span class="error" id="etat_psd">*</span></td></tr>
            <tr><td>Nom : <input type="text" name="nom" required ><span class="error">*</span></td></tr>
            <tr><td>Prenom :<input type="text" name="prenom" required><span class="error">*</span></td></tr>
            <tr><td>Pseudo : <input type="text" name="pseudo" required><span class="error">*</span></td></tr>
           </table>                   
          </br>
 
<?php
//choisir les competences et les niveaux     
//je recupere les niveaux et les mettre dans un nouveau tableau $list_niveau[$i][]
//$i=0;
  $sql="SELECT IDN,LIBELLEN
                FROM NIVEAU";  
            $res=mysqli_query($connection,$sql);
           // $ligne=mysqli_fetch_array($res);
            
           while($ligne=mysqli_fetch_array($res)){
               $ligneligne[]=$ligne["IDN"];
               $ligneligneligne[]=$ligne["LIBELLEN"];
//                $list_niveau[$i]['idn']=$ligne['IDN'];
//                $list_niveau[$i]['libellen']=$ligne['LIBELLEN'];
//                $i++;
            }
           
echo "<div id='competence'>";       
         $sql="SELECT CODEC,NOMC
                FROM COMPETENCE";  
         $res=mysqli_query($connection,$sql);
         echo "<table style='text-align:left'>";
          echo "<tr>";
                 echo "<td>";
         echo "Selectionner vos compétences et le niveau:  ";
          echo '</td><tr>';
         $j=0;
    while($ligne=mysqli_fetch_array($res)){
     echo "<tr>";
     echo "<td>";
    echo("<input type='checkbox' name='CODEC[]'  value=".$ligne['CODEC'].">".$ligne['NOMC']);
//je recupere les codes de competences et les mettre dans un nouveau tableau $list_com_niv[]              
        $list_com_niv[$ligne['CODEC']]=$j;
        $j++;
        echo '</td><td>';
        //$codecompetence=$ligne['CODEC'];
        echo '<select name="niveau[]">';
        for($i=0;$i<count($ligneligne);$i++){
        echo("<option  value=".$ligneligne[$i].">". $ligneligneligne[$i]." </option>");
        }
        echo '</select>';
        echo "</td></tr>";               
                                            }
//je garde l'ordre de codec                                            
 $_SESSION['list_com_niv']=$list_com_niv;    
 
//ajouter nouveau competence

echo '<tr><td>';
echo '<input type="text" name="competence" value=""></td><td>';
echo '<select name="niveau2">';
        
         $sql="SELECT IDN,LIBELLEN
                FROM NIVEAU";  
         $res=mysqli_query($connection,$sql);
    while($ligne=mysqli_fetch_array($res)){
		echo("<option  value=".$ligne['IDN'].">".$ligne['LIBELLEN']." </option>");
    } 
echo '</select></br>';
 echo'</td></tr></table>';   
echo "</div>";
?>	

<?php
// je recuperes les vaiables de la formulaire
if(isset($_SESSION['list_com_niv'])){
    $list_com_niv=$_SESSION['list_com_niv'];
}
if(isset($_POST['CODEC'])){
			$codecompetence=$_POST['CODEC'];
                    
		}else{
			$codecompetence=false;
		}
		
if(isset($_POST['niveau'])){
			 $codeniveau=$_POST['niveau'];
		}else{
			 $codeniveau=false;
		}
                               		
if(isset($_POST['nom'])){
			 $nom=$_POST['nom'];
		}else{
			 $nom=false;
		}
if(isset($_POST['prenom'])){
			 $prenom=$_POST['prenom'];
		}else{
			 $prenom=false;
		}
 if(isset($_POST['email'])){
			 $email=$_POST['email'];
		}else{
			 $email=false;
		}
if(isset($_POST['password1'])){
			 $password=$_POST['password1'];
		}else{
			 $password=false;
		}    
      
  if(isset($_POST['password2'])){
			$motdepass=$_POST['password2'];
                    
		}else{
			$motdepass=false;
		}
  if(isset($_POST['pseudo'])){
			 $pseudo=$_POST['pseudo'];
		}else{
			 $pseudo=false;
		} 

$emailunique=emailunique($connection,$email);

$_SESSION['codecompetence']=$codecompetence;
$_SESSION['codeniveau']=$codeniveau;
$codecompetence=$_SESSION['codecompetence'];
$codeniveau=$_SESSION['codeniveau'];

//je recuperes le niveau que je remplis pour la nouvelle competence
if(isset($_POST['niveau2'])){
			 $codeniveau2=$_POST['niveau2'];
		}else{
			 $codeniveau2=false;
		}



//insertion les infos personnelles dans la table membres de la base de donnee
//verification si l'adresse email saisi exite deja: 
 if($emailunique){
//verification si les deux fois de saisir de mot de pass sont differents
     if($password==$motdepass){
  $sql="insert into MEMBRES values(null,'$nom','$prenom','$pseudo','$email','$password')";
 $resultinscrire=mysqli_query($connection,$sql);
           if($resultinscrire==1){
               session_destroy();
                echo"<span style='color:green'>Vos informations sont bien enregesitrées!</span></br>";
            }
			else{echo mysqli_error($connection);
				echo "<span style='color:red'>Inscription échoué</span></br>";
			}  
// je selecte le code du membre qui vient de reussir a inscrire
                    if ($email){
                        $sql="select IDM from MEMBRES where EMAILM='".$email."'";
                        $result=mysqli_query($connection,$sql);
                                            $ligne=mysqli_fetch_array($result);
                        $IDMM=$ligne["IDM"];
                        $_SESSION["IDMM"]=$IDMM;
                        $IDMM= $_SESSION["IDMM"];
                    }
//insertion les infos competences et niveaux dans la table avoir de la base de donnee
                        if($codecompetence and $codeniveau){
                                for($i=0;$i<count($codecompetence);$i++){
//pour l'ordre des codec et l'ordre des codeniveaux soit correspondants
//ici je recuperes l'ordre de codec que je viens de garder dans la session quand je selecte les competences au debut
//les codeniveaux sont inserent selon ce ordre  
                               $order= $list_com_niv[$codecompetence[$i]];                                    
                               $sqlc ="insert into AVOIR  (IDM,CODEC,IDN) values('$IDMM','$codecompetence[$i]','$codeniveau[$order]')";
				$resultc=mysqli_query($connection,$sqlc);
                                if($resultc==1){
                                    //echo "reussi";
                                }
                                else{
                                    echo mysqli_error($connection);				
		}
         }	                                			
 }                          
                 } else{
                     echo "<span style='color:red'>Les deux fois de saisir de mot de pass sont differents!</span></br>";
                 }                     
 }else {if(empty($email)==false){
 echo "<span style='color:red'>Vous avez deja inscrit!</span></br>"; 
 }
 }
 ?>	
<?php
//insertion du nouveau competence
if(isset($_POST["competence"])){
		$nouveau=$_POST["competence"];
//verification si le nouveau competence saisi existe deja
$sql="SELECT NOMC FROM COMPETENCE WHERE NOMC LIKE '%".$nouveau."%'";
$ordre=mysqli_query($connection,$sql);
$nb=mysqli_num_rows($ordre);
if ($nb!=0 and !empty($nouveau)){
echo "<span style='color:red'>Le competence vous avez saisit est dans la liste, vous pouvez choisir apres dans votre profil</span></br>";
}else
{
//insertion le nouveau competence dans la table competence
    if (!empty($nouveau)){
     $requete1="INSERT INTO COMPETENCE VALUE(null,'$nouveau')";
      $result=mysqli_query($connection,$requete1);   
     if($result!=1){
               echo mysqli_error($connection);				
		}
     $requete2="SELECT CODEC FROM COMPETENCE WHERE NOMC='".$nouveau."'";
     $res2=mysqli_query($connection,$requete2); 
     $ligne2=mysqli_fetch_array($res2);
     $codenouveau=$ligne2["CODEC"];
//insertion le nouveau competence dans la table avoir     
     $requete3="INSERT INTO AVOIR VALUES('$IDMM','$codenouveau','$codeniveau2')";
     $res3=mysqli_query($connection,$requete3); 
      if($res3!=1){
           echo mysqli_error($connection);	
         }
}
}
}
?>

<table style='text-align:left'>        		
    <tr><td><input class="button" type="submit" name="submit" value="S'inscrire" onClick="return confirm('envoyer ?')"></td>
    <td><input class="button" name="reset" type="reset" onClick="return confirm('effacer ?')" value="Effacer" ></td>
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