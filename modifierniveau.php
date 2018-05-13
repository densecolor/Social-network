<html>
    <head>
         <link href="style.css" rel="stylesheet" type="text/css" media="all" />

        <meta charset="UTF-8">
        <title>Modification</title>
            
    </head>
    <body>
      
        <div id="home"> 
            <?php
            session_start();
            require("fonction.php"); 
            $connection=connectBD(); 
            $idm=$_SESSION["idm"];
            $codecc=$_SESSION["codecc"];
          
if(isset($_POST['niv'])){
                 $codenn=$_POST['niv'];      
        }else{
                 $codenn=false;
        }
//je combine les deux tableaux $codecc et $codenn quand leur array key sont identiques        
           $arr = array();
        foreach ($codecc as $key => $val) 
            {
                $arr[$val] =$codenn[$key];
//je mis a jour la BD
                $ins = "update AVOIR set IDN=$arr[$val] where IDM=$idm AND CODEC=$val";
                $res=mysqli_query($connection,$ins);
                if($res==1){
                     header("Location:modifiercompetence.php");
                }
                }  
        ?>
        </div>
    </body>
</html>