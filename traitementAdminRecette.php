<?php 
    session_start();
    include_once("./libDataBase.php");

    // Supression de la recette par l'administrateur
    if (isset($_GET["supprimer"])){
        $_idRecette = $_GET["supprimer"];
        supprimerRecette($_idRecette);
        header('Location: ./resultatRecherche.php?categorie='.$_SESSION["categorie"]."&cout=".$_SESSION["cout"]);                 
        exit();
    }

    // Ajout d'un commentaire par un utilisateur ou l'administarteur
    if (isset($_GET["commenter"]) && !empty($_GET["commentaire"])){
        $_idRecette = $_GET["commenter"];
        $_date = date("Y-m-d");
        $_commentaire = $_SESSION["user"].":".$_GET["commentaire"];
        insererCommentaire($_idRecette, $_date, $_commentaire);
        header('Location: ./resultatRecherche.php?categorie='.$_SESSION["categorie"]."&cout=".$_SESSION["cout"]."#".$_idRecette);                 
        exit();
    }


    // Ajout d'une recette à ses favoris par un utilisateur ou l'administarteur
    if (isset($_GET["ajoutFavoris"])){
        $_idRecette = $_GET["ajoutFavoris"];
        ajouterAuxFavoris($_idRecette);
        header('Location: ./resultatRecherche.php?categorie='.$_SESSION["categorie"]."&cout=".$_SESSION["cout"]."#".$_idRecette);                 
        exit();
    }
?>