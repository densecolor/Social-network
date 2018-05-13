<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Connexion à mySQL</title>
    </head>
    <body>
<!--   /*      define("dbhost","localhost");
       define("login","root");
        define("pwd",""); */	--!>

       <?php

define("dbhost","localhost");
define("login","21513405");
define("pwd","Q03UN9");
//connection bd
function connectBD(){      
        $connection=mysqli_connect(dbhost,login,pwd) or die ("non ok");
        $select_db=mysqli_select_db($connection,'db!21513405')or die ("non database");
 return $connection;
 
    }
    //judge email is null or not(unique or not)
    function emailunique($connection,$email){
	$sql="SELECT COUNT(*) FROM MEMBRES WHERE EMAILM=?";
	$ordreemail=mysqli_prepare($connection,$sql);
	mysqli_stmt_bind_param($ordreemail,"s",$email);
	mysqli_execute($ordreemail);
	mysqli_stmt_bind_result($ordreemail,$cpt);
	mysqli_stmt_fetch($ordreemail);
	if($cpt==0){
        return true;}
	else{
        return false;}
    }
        
     // amis or fans
    //la variable $judge est les gens que je veux judger ce qui est mon amis ou mon fans (following ou follower)
        function amisfans($connection,$idm,$judge)
                {
   $sql="select s.IDM_1,m2.NOMM,m2.PRENOMM
       from SUIVRE s,MEMBRES m1,MEMBRES m2
           where s.IDM=$idm and s.IDM_1=$judge
           and s.IDM=m1.IDM
           and s.IDM_1=m2.IDM";
     $res=mysqli_query($connection,$sql);
     $num= mysqli_num_rows($res);
 $ligne= mysqli_fetch_array($res);

 //il faut juger , si on ne peut pas trouver que je le suis dans la table suivre
 //je peut seulement consulter son demiprofil
    if (is_null($ligne)and $idm!=$judge){
       $sql="select NOMM,PRENOMM
               from MEMBRES
               where IDM=$judge";
                    $resultat=mysqli_query($connection,$sql);
                    $kong=mysqli_fetch_array($resultat);
        echo("<a href='demiprofil.php?monfan=".$judge."'>".utf8_encode($kong['NOMM']." ".$kong['PRENOMM']." </a>"));
         }
   //si $judge include  moi, il faut enlever le lien de moi($idm) 
    else {
      if(is_null($ligne) and $idm ==$judge){
           $sql="select M.NOMM, M.PRENOMM
          FROM MEMBRES M
             WHERE M.IDM=$idm";
        $res=mysqli_query($connection,$sql);
        $ligne= mysqli_fetch_array($res);
         echo utf8_encode($ligne["NOMM"]." ".$ligne["PRENOMM"]);
      }
//sinon je peux consulter son profil2      
      else{
           echo("<a href='profil2.php?idmamis=".$ligne["IDM_1"]."'>".utf8_encode($ligne["NOMM"]." ".$ligne["PRENOMM"]." </a>"));
      }
      }
                }
                
//ajouter ou anuuler l'appreciation  
//il faut judger, $idm est $idm dans le page profil.php, $idm est $idmamis dans le page profil.php, $wo est toujours $idm dans le page profil2.php 
//pour une meme commentaire, je peux l'apprecier soit dans profil.php,soit dans profil2.php
//dans la page profil.php, si je la deja apprecie, $idm et $wo la deja apprecient
//$idm et $wo est la meme personne, donc selon ma requete, il va selectionner une resultat
//mais quand je suis dans la page profil2.php, $idm=$idmamis, $wo=$idm, ce sont deux personne different
//donc dans la page profil2.php, si je la apprecie, et $idmamis la apprecie aussi, ma requete va selectionner deux resutat 
//si je la apprecie, et $idmamis ne la apprecie pas, ou inverse, ma requete va selectionner une seule resutat
//donc dans la page profil2.php, c'est important de savoir c'est qui la apprecier!
      function Islike($codecom,$idm,$wo,$connection,$nblike,$flag){
          $sql="SELECT C.NBAPP,A.IDM,A.CODECOM
                  FROM COMMENTAIRE C,APPRECIER A
                  WHERE C.CODECOM=$codecom 
                      AND (A.IDM=$idm  OR A.IDM=$wo)
                      AND C.CODECOM=A.CODECOM
";
            $res=mysqli_query($connection,$sql);
            $nb=mysqli_num_rows($res);
        $ligne= mysqli_fetch_array($res);

//si $idm est dans le table apprecier, 
//c'est a dire que j'ai deja apprecier, je ne peux plus apprecier sur cet commentaire
// je peux seulent annuler
           if($nb==2){        
                       echo (" <span><a href='apprecierrr.php?codecomapprecier=".$codecom."&like=annuler' >"
                               . "<img width='25px' src='images/likegrey.png'></img></a>".$nblike);                        
             }
                else
                  {
       if (($nb==1 and $flag==1 and $ligne["IDM"]=$idm)or ($nb==1 and $flag==2 and $ligne["IDM"]!=$idm)){
            echo (" <span><a href='apprecierrr.php?codecomapprecier=".$codecom."&like=annuler' >"
                    . "<img width='25px' src='images/likegrey.png'></img></a>".$nblike);                        
       }else{
            echo (" <span><a href='apprecierrr.php?codecomapprecier=".$codecom."&like=ajouter' >"
                    . "<img width='25px' src='images/like.png'></img></a>".$nblike);         
       }                   
      }
    }
      
      
        //suivre et ne suivre plus
        function suivre($connection,$idm, $idmsuis){
            $sql="SELECT * FROM SUIVRE WHERE IDM=$idm AND IDM_1=".$idmsuis;
	$ordre=mysqli_query($connection,$sql);
	$nb=mysqli_num_rows($ordre);
      //il faut juger si la personne je veux suivre est moi meme ou non
	if ($idm!=$idmsuis and $nb==0){
            echo "<a href='suivre.php?idmrecherche=".$idmsuis."&sui=suivre'>"
                    . "<img width='30px' src='images/suivre.png'></img></a>";       
        }
        else{
            if($idm!=$idmsuis and $nb!=0){
            echo "<a href='suivre.php?idmrecherche=".$idmsuis."&sui=nesuivreplus'>"
                    . "<img width='30px' src='images/nesuivre.png'></img></a>";
        }
        }
        }
        
//AFFICHER TOUS LES COMMENTAIRES
//si je suis dans ma page profil,$flag=1 
//il faut afficher Trouver touts les codes commentaires initial pour moi 
//ainsi que les codes commentaires initiaux de mes amis
//si je suis dans ma page profil,$flag=1 
//il faut afficher Trouver touts les codes commentaires initial pour ce membre
     function afficher_commentaire($connection,$idm,$wo,$flag){
            if($flag==1){
                $codecom= trouver_commentaire_ini_moi($connection, $idm,$wo,$flag);
                
            }else{
                $codecom= trouver_commentaire_ini_membre($connection, $idm,$wo,$flag);
            }
   for($i=0;$i<count($codecom);$i++){   
     echo" <div id='commentaire'>";
      afficher_chaque($connection,$codecom[$i],$idm,$wo,$flag);
       echo" <ul>";
      afficher_souscommentaire($connection,$codecom[$i],$idm,$wo,$flag);    
      echo "</ul>";
      echo" </div>";
       }
       }
        
//AFFICHER LES SOUS COMMENTAIRES DE $codecom
//je trouve les sous commentaire par requte
       function afficher_souscommentaire($connection,$codecom,$idm,$wo,$flag){
           $sql="SELECT CT.CODECOM,CT.IDM,CT.CODECOM_APPARTENIR,CT.CONTENU,CT.DATECOM,CT.NBAPP,M.NOMM,M.PRENOMM
				FROM COMMENTAIRE CT,MEMBRES M
				WHERE CT.IDM=M.IDM
                                AND CT.CODECOM_APPARTENIR=$codecom";     
        $res=mysqli_query($connection,$sql);
     
   $nb2=mysqli_num_rows($res);
   while($ligne= mysqli_fetch_array($res)){   
       echo mysqli_error($connection);
       $codecomsous[]=$ligne['CODECOM'];
   }
//je fais le boucle de souscommentaire
 for($j=0;$j<$nb2;$j++){
     echo "<li>";
       afficher_chaque($connection,$codecomsous[$j],$idm,$wo,$flag);
       echo "<ul>";
         afficher_souscommentaire($connection,$codecomsous[$j],$idm,$wo,$flag);
       echo "</ul>";
         echo "</li>";
 }
       }
       
     
       
     
// affichage des commentaires
// afficher le nom le prenom, la date, le contenu, le nombre d'appreciation de chaque commentaire
function afficher_chaque($connection,$codecom,$idm,$wo,$flag){
             $sql=" SELECT A.CODECOM,A.IDM,A.CODECOM_APPARTENIR,A.CONTENU,A.DATECOM,A.NBAPP,M.NOMM,M.PRENOMM
            FROM COMMENTAIRE A,MEMBRES M
            WHERE M.IDM=A.IDM
            AND A.CODECOM=$codecom
               ";
   $res=mysqli_query($connection,$sql);

  while($ligne= mysqli_fetch_array($res)){
    if(!empty($ligne)){
         
         echo "<table style='text-align:left';>";
      echo "<tr><td>";
               amisfans($connection,$wo,$ligne['IDM']);
              echo "".$ligne["DATECOM"]."</td></tr>";
             
      echo "<tr><td id='contenu'>".utf8_encode($ligne["CONTENU"])."</td></tr>";
      echo "<tr><td id='icon'>";
      // le bouton d'appreciation d'un commentaire
         Islike($ligne["CODECOM"], $idm, $wo,$connection, $ligne["NBAPP"],$flag);
                 echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp";       

      //le bouton supprimer un commentaire  
      // il faut judger, dans le page profil, $idm egale $idm et $wo egale $idm
      //  dans le page profil2,  $idm egale $idmamis mais $wo egale $idm toujours
      // je peut seulement supprimer les commentaires que $wo ecrit
        if($flag=1 and $wo==$ligne['IDM']){
        echo "<a href='del.php?codecomsupprim=".$ligne["CODECOM"] ."' onclick='return confirm(\"supprimer?\")'>"
                . "<img width='25px' src='images/supprimer.png'></img></a>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp";
        }
        else{
        if ($flag!=1 and $wo==$ligne['IDM']){
            echo "<a href='del.php?codecomsupprim=".$ligne["CODECOM"] ."' onclick='return confirm(\"supprimer?\")'>"
                    . "<img width='25px' src='images/supprimer.png'></img></a>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp";
        }
        }
        //le bouton d'ajouter un commentaire
        echo "<a href='laissercommentaire.php?codecom=".$ligne["CODECOM"] ."'><img width='25px' src='images/ajouter.png'>"
                . "</img></a>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp";
        echo " </td></tr>";
   echo "</table>";
 } 
                       }  
       }
       
       
 //Trouver toues les commentaires initial par un code membre
       function trouver_commentaire_ini_membre($connection,$idm,$wo,$flag){
           $sql="SELECT A.CODECOM,A.IDM,A.CODECOM_APPARTENIR,A.CONTENU,A.DATECOM,A.NBAPP,M.NOMM,M.PRENOMM
            FROM COMMENTAIRE A,MEMBRES M           
            where M.IDM=A.IDM
                AND A.IDM=$idm
                ";
            $res=mysqli_query($connection,$sql);
            echo mysqli_error($connection);
            $num=mysqli_num_rows($res);
            if($num!=0){
               
                   while($ligne= mysqli_fetch_array($res)){
                   $codecom[]=$ligne['CODECOM'];
                   echo mysqli_error($connection);       
            }              
             return $codecom;    
            }
            else{
                echo ("il n'a pas laisse de commentaire.");            
       }      
       }
       
 //Trouver touts les commentaires initial pour moi 
 //ainsi que les codes commentaires initiaux de mes amis
       function trouver_commentaire_ini_moi($connection,$mycodeM,$wo,$flag){
          $sql="SELECT CODECOM
FROM(
SELECT COMMENTAIRE.CODECOM CODECOM,DATECOM,CONTENU,COMMENTAIRE.IDM,COMMENTAIRE.CODECOM_APPARTENIR
FROM MEMBRES M1,SUIVRE,COMMENTAIRE,MEMBRES M2
WHERE SUIVRE.IDM_1=M1.IDM
AND SUIVRE.IDM=M2.IDM
AND SUIVRE.IDM_1=COMMENTAIRE.IDM
AND SUIVRE.IDM=$mycodeM
AND CODECOM_APPARTENIR is NULL
UNION
SELECT COMMENTAIRE.CODECOM CODECOM,DATECOM,CONTENU,COMMENTAIRE.IDM,COMMENTAIRE.CODECOM_APPARTENIR
FROM MEMBRES,COMMENTAIRE
WHERE MEMBRES.IDM=COMMENTAIRE.IDM
AND MEMBRES.IDM=$mycodeM
AND CODECOM_APPARTENIR is NULL) A
ORDER BY DATECOM DESC ";
             $res=mysqli_query($connection,$sql);
             $nb= mysqli_num_rows($res);
             if(!empty($nb)){
            while($ligne= mysqli_fetch_array($res)){    
                   $codecom[]=$ligne['CODECOM'];
                }
        return $codecom;
             }
	   }
       
       
   


//supprimer sousommentaires
//A partir du code du commentaire que je veux supprimer, 
//je chercher ses commentaires complémentaires, si ces derniers sont les commentaires les plus petits, 
//je les supprime, si ils ont encore des commentaires complémentaires de leur part, 
//je repartis de ces codes là et jusqu’à ce que je trouve les commentaires les plus petit et les supprime.
    function delete_souscommentaire($connection,$codecom){
$sql="SELECT CT.CODECOM,CT.IDM,CT.CODECOM_APPARTENIR,
       CT.CONTENU,CT.DATECOM,CT.NBAPP,M.NOMM,M.PRENOMM
        FROM COMMENTAIRE CT,MEMBRES M
        WHERE CT.IDM=M.IDM
        AND CT.CODECOM_APPARTENIR=$codecom";   
        $res=mysqli_query($connection,$sql);
		 $nb2=mysqli_num_rows($res);		
   while($ligne= mysqli_fetch_array($res)){  
       echo mysqli_error($connection);
       echo $ligne["CODECOM"];
	      	  echo"</br>";
	   $codecomsous[]=$ligne['CODECOM'];
   }
 //si il n'y a pas de sous commentaire,je supprime le commentaire initial  
	if($nb2==0){		
	   deleteinitial($connection,$codecom);
		}
 else{
//si il y a sous commentaire, je fais boucle de ma fonction 
	 if($nb2>0){
for($j=0;$j<$nb2;$j++){
	delete_souscommentaire($connection,$codecomsous[$j]);
	 }}
delete_souscommentaire($connection,$codecom);
	}
	}

//supprimer commentaires initials
function deleteinitial($connection,$codecom){
//supprimer apprecier
//Avant de supprimer l’enregistrement dans la table commentaire, 
//on doit d’abord supprimer celui dans la table apprécié pour la raison de la contrainte d’intégrité.
	$sql="delete from APPRECIER WHERE CODECOM=$codecom";
	  $res=mysqli_query($connection,$sql);
	   if($res){
           echo "reussi app";      
       }	   
//supprimer commentaire
	 $sql=" delete FROM COMMENTAIRE
            WHERE CODECOM=$codecom";      
          $res=mysqli_query($connection,$sql);      
       if($res){
           echo "reussi";
       }
} 
    
   ?>   

    </body>
</html>

		

