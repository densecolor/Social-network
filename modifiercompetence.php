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
            <?php


            ?>
   	<div id='tbox2'>     

<form action="modifierniveau.php" method="post">
                <?php
//modifier le niveau d’une compétence
//d'abord, je recupere et affiche les competences et niveaux de ce utilisateur dans la BD            
$sql="SELECT C.CODEC,C.NOMC,N.IDN,N.LIBELLEN
			FROM COMPETENCE C,NIVEAU N,AVOIR A 
			WHERE C.CODEC=A.CODEC
			AND A.IDN=N.IDN
			AND A.IDM=$idm
			";
        $ordre=mysqli_query($connection,$sql);
        $nb=mysqli_num_rows($ordre);
        if($nb!=0){
echo("<h2>Changer les compétences et niveaux</h2><table style='text-align:left'> ");                 
while($ligne=mysqli_fetch_array($ordre)){                          
                echo "<tr><td>";
		echo $ligne["NOMC"]; 
//je transmet les compétences qu’il veut changer dans la session ‘codecc'
                 $codecc[]=$ligne["CODEC"]; 
                  $_SESSION["codecc"]=$codecc;
                echo "<td>";
                echo  $ligne["LIBELLEN"];
                echo "</td></td><td>";      
                echo '<select name="niv[]" >';
                for($i=0;$i<count($ligne["IDN"]);$i++){
                    $sqln="select IDN, LIBELLEN from NIVEAU";
                    $res=mysqli_query($connection,$sqln);
                    while($ligneniveau=mysqli_fetch_array($res)){
 //pour chaque competence, j'affiche le niveau qu'il correspond dans la liste deroulant en utilisant selected                       
                    if ($ligneniveau['IDN']==$ligne["IDN"]){
                    echo("<option  value=".$ligne["IDN"]." selected='selected'>".$ligneniveau["LIBELLEN"]." </option>");
                    }else{
                        echo("<option  value=".$ligneniveau['IDN'].">".$ligneniveau["LIBELLEN"]." </option>");
                    }
                    }                       
                }               
                echo '</select></td><td>';                   
                echo "</td><td>";
//j'envoie les codes de competences que je veux supprimer a la page 'modifiercompetencep'
                echo "<a href='modifiercompetencep.php?codecomsupprim=".$ligne["CODEC"] ."' onclick='return confirm(\"supprimer?\")'><img width='25px' src='images/supprimer.png'></img></a>";
                echo"</td></tr>";
                        }                              
                        }
       echo "</table>";
            ?>
<!--//j'envoie les codes de competences et les codes niveaux a la page ‘modierniveau.php’-->
              <input class="button" type="submit" name="submit" value="Changer" onClick="return confirm('envoyer ?')">
</form>
			  
		
<form action="modifiercompetenceajouter.php" method="POST">
            <?php
//ajouter une compétence 
$i=0;
  $sql="SELECT IDN,LIBELLEN
                FROM NIVEAU";  
            $res=mysqli_query($connection,$sql);
            while($ligne=mysqli_fetch_array($res)){
		$list_niveau[$i]['idn']=$ligne['IDN'];
                $list_niveau[$i]['libellen']=$ligne['LIBELLEN'];
                $i++;
            }
//je selecte les competences qu’il n’a pas déclarée(ne pas dans la table AVOIR)     
         $sql="SELECT CODEC,NOMC
                FROM COMPETENCE
                WHERE CODEC NOT IN (SELECT C.CODEC
                                    FROM COMPETENCE C,AVOIR A 
                                    WHERE C.CODEC=A.CODEC
                                    AND A.IDM=$idm)
				";  
         $res=mysqli_query($connection,$sql);
         
echo "<h2>Ajouter vos compétences et le niveau: </h2> ";		 
echo "<table style='text-align:left'>";
//cette partie est pareil que la page 'inscrire.php' 
         $j=0;
    while($ligne=mysqli_fetch_array($res)){
                 echo "<tr>";
                 echo "<td>";
		echo("<input type='checkbox' name='CODEC[]'  value=".$ligne['CODEC'].">".$ligne['NOMC']);
                $list_com_niv[$ligne['CODEC']]=  $j;
                $j++;
                echo '</td><td>';
                echo '<select name="niveau[]">';
                for($i=0;$i<count($list_niveau);$i++){
                    echo("<option  value=".$list_niveau[$i]['idn'].">".$list_niveau[$i]['libellen']." </option>");
                }
                echo '</select>';
                echo "</td></tr>";               
    }
	
    if (isset($list_com_niv)){
    $_SESSION['list_com_niv']=$list_com_niv;
    }
	
?>
<?php
//ajouter nouveau competence(cette partie est pareil que la page 'inscrire.php')
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
 ?>
     <input class="button" type="submit" name="submit" value="Ajouter" onClick="return confirm('envoyer ?')"><br>
</form>
<a href="modifier.php ">retour</a>
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