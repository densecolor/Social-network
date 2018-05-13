<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
         <link href="style.css" rel="stylesheet" type="text/css" media="all" />
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
       <?php
// je ferme toute la session et supprime toutes les donnees dans la session, cela me renvoie a la page d'accueil      
session_start();
session_destroy();
echo 'Vous etes deconnecte. <a href="home.php"><button type="button" style="width:100px">retour</button></a>';
  header("Location: home.php");
?>
    </body>
</html>
