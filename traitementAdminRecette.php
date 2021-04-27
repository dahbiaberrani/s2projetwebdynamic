<?php 
    session_start();
    include_once("./libDataBase.php");
    if (isset($_GET["supprimer"])){
        echo "supression de la recette :".$_GET["supprimer"];
        $_idRecette = $_GET["supprimer"];
        supprimerRecette($_idRecette);
        header('Location: ./resultatRecherche.php?categorie='.$_SESSION["categorie"]."&cout=".$_SESSION["cout"]);                 
        exit();
    }

    if (isset($_GET["commenter"])){
        $_idRecette = $_GET["commenter"];
        $_date = date("Y-m-d");
        $_commentaire = $_SESSION["user"].":".$_GET["commentaire"];
        insererCommentaire($_idRecette, $_date, $_commentaire);
        header('Location: ./resultatRecherche.php?categorie='.$_SESSION["categorie"]."&cout=".$_SESSION["cout"]);                 
        exit();
    }
?>