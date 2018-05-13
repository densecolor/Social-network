<html>
    <head>
         <link href="style.css" rel="stylesheet" type="text/css" media="all" />

        <meta charset="UTF-8">
        <title>Modification</title>
            
    </head>
    <body>
          <div class="dropdown">
  <button class="dropbtn">MENU</button>
  <div class="dropdown-content">
      <a href="profil.php">Mon profil</a>
  <a href="modifier.php">Modifier mon profil</a>
   <a href="recherche.php">Recherche</a>
    <a href="deconnexion.php">Deconnecter</a>
  </div>
        </div>
      
        <div id="home"> 
           
            <?php
            session_start();
            require("fonction.php"); 
            $connection=connectBD(); 
            $idm=$_SESSION["idm"];
          
           
            ?>
       <?php
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
if(isset($_POST['niveau2'])){
			 $codeniveau2=$_POST['niveau2'];
		}else{
			 $codeniveau2=false;
		}

?>
  

<?PHP
//ajouter les competences;
if($codecompetence){
for($i=0;$i<count($codecompetence);$i++){
     $order=  $list_com_niv[$codecompetence[$i]];
    $sqlc ="insert into AVOIR  (IDM,CODEC,IDN) values('$idm','$codecompetence[$i]','$codeniveau[$order]')";
    $resultc=mysqli_query($connection,$sqlc);   
     if($resultc==1){
           header("Location:modifiercompetence.php");
         }else{
               echo mysqli_error($connection);				
		}
}
}

//insert un nouveau competence
$nouveau=$_POST["competence"];
$sql="SELECT NOMC FROM COMPETENCE WHERE NOMC LIKE '%".$nouveau."%'";
$ordre=mysqli_query($connection,$sql);
$nb=mysqli_num_rows($ordre);
if ($nb!=0){
    header("Location:modifiercompetence.php");
     echo "<span style='color:red'>vous avez deja ce competence!</span></br>";
}else
{
    if (!empty($nouveau)){
     $requete1="INSERT INTO COMPETENCE VALUE(null,'$nouveau')";
      $result=mysqli_query($connection,$requete1);   
     if($result==1){
              echo"reussi!!</br>";
			  header("Location:modifiercompetence.php");
         }else{
               echo mysqli_error($connection);				
		}
     $requete2="SELECT CODEC FROM COMPETENCE WHERE NOMC='".$nouveau."'";
     $res2=mysqli_query($connection,$requete2); 
     $ligne2=mysqli_fetch_array($res2);
     $codenouveau=$ligne2["CODEC"];
     
     $requete3="INSERT INTO AVOIR VALUES('$idm','$codenouveau','$codeniveau2')";
     $res3=mysqli_query($connection,$requete3); 
      if($res3==1){
           header("Location:modifiercompetence.php");
         }else{
               echo mysqli_error($connection);				
		}
}
}
?>
        </div>
    </body>
</html>
