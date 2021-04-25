<?php 
session_start();
if (isset($_GET["supprimer"])){
     echo "supression de la recette :".$_GET["supprimer"];
     header('Location: ./resultatRecherche.php?categorie='.$_SESSION["categorie"]."&cout=".$_SESSION["cout"]);                 
     exit();
}
if (isset($_GET["modifier"])){
    echo "modification de la recette :".$_GET["modifier"];
}

?>