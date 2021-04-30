<?php
include_once('./libDataBase.php');

// Traitement de la Demande de changement de nom de recette
if (isset($_GET['changeRecetteName'])) {
    // Vérification si le nom est bien renseigné
    if (empty( $_GET['NomRecette'])) {
        // Retour à la page de modification de la recette pour afficher la même recette et l'erreur
        header("Location: ./loadRecette.php?erreur=nameError&modifier=".$_GET['idRecette']);                 
        exit();
    }
    updateName($_GET['idRecette'],$_GET['NomRecette']);
}

if (isset ($_GET['changeRecetteCategorie'])) {
    updateCategorie($_GET['idRecette'],$_GET['categorie']);
}

if (isset($_GET['changeRecetteNombrePersonne'])) { 
    // Vérification si le nombre de personnes est bien renseigné
    if (empty($_GET['NombrePersonne']) or intval($_GET['NombrePersonne']) <= 0) {
        // Retour à la page de modification de la recette pour afficher la même recette et l'erreur
        header("Location: ./loadRecette.php?erreur=nombrePersonnesError&modifier=".$_GET['idRecette']);                 
        exit();
    }
    updateNombrePersonnes($_GET['idRecette'],$_GET['NombrePersonne']);
}

if (isset($_GET['changeRecetteEtapes'])) {   
    // Vérification si les étapes sont bien renseignées
    if (empty( $_GET['etapes'])) {
        // Retour à la page de modification de la recette pour afficher la même recette et l'erreur
        header("Location: ./loadRecette.php?erreur=etapesError&modifier=".$_GET['idRecette']);                 
        exit();
    }
    updateEtapes($_GET['idRecette'],$_GET['etapes']);
}

if (isset($_GET['addRecetteIngredient'])) {

    //Vérification que l'ingrédient est bien renseigné
    if (empty( $_GET['Idingredient'])) {
        // Retour à la page de modification de la recette pour afficher la même recette et l'erreur
        header("Location: ./loadRecette.php?erreur=ingredientError&modifier=".$_GET['idRecette']);                 
        exit();
    }
    if (empty( $_GET['Quantite']) or intval($_GET['Quantite']) <= 0) {
        // Retour à la page de modification de la recette pour afficher la même recette et l'erreur
        header("Location: ./loadRecette.php?erreur=quantiteError&modifier=".$_GET['idRecette']);                 
        exit();
    }
    if (empty( $_GET['unite'])) {
        // Retour à la page de modification de la recette pour afficher la même recette et l'erreur
        header("Location: ./loadRecette.php?erreur=uniteError&modifier=".$_GET['idRecette']);                 
        exit();
    }

    // Vérification que le nouveau ingrédient n'existe pas déjà dans la composition de la recette
    if (inComposition($_GET['Idingredient'], $_GET['idRecette']) == TRUE) {
        // Retour à la page de modification de la recette pour afficher la même recette et l'erreur
        header("Location: ./loadRecette.php?erreur=ingredientAlreadyExist&modifier=".$_GET['idRecette']);                 
        exit();
    }

    addComposition($_GET['Idingredient'], $_GET['idRecette'], $_GET['Quantite'], $_GET['unite']);

    // mise à jour du cout de la recette 
    // calcul du cout de l'ingrégient ajouté
    $_ingredientArray = array($_GET['Idingredient']=>$_GET['Quantite']);
    $_unitArray = array($_GET['Idingredient']=>$_GET['unite']);
    $coutAAjouter = calculCout($_ingredientArray,$_unitArray);
    $_nouveauCout = $_GET['cout'] + $coutAAjouter;

    // Mise à jout de la base de données
    updateCout($_GET['idRecette'],$_nouveauCout);
}


if (isset ($_GET['deleteIngredient'])) {
    supprimerIngredient($_GET['idIngredientToDelete'],$_GET['idRecette']);

    // mise à jour du cout de la recette 
    // calcul du cout de l'ingrégient supprimé

    $_ingredientArray = array($_GET['idIngredientToDelete']=>$_GET['quantiteToDelete']);
    $_unitArray = array($_GET['idIngredientToDelete']=>$_GET['unitToDelete']);
    $coutAEnlever = calculCout($_ingredientArray,$_unitArray);
    $_nouveauCout = $_GET['cout'] - $coutAEnlever;

    // Mise à jout de la base de données
    updateCout($_GET['idRecette'],$_nouveauCout);
}

if (isset ($_GET['deleteComment'])) {
    supprimerCommentaire($_GET['idCommentaireToDelete']);
    echo "Suppression du commentaire:".$_GET['idCommentaireToDelete']."</br>";
}

// Retour à la page de modificaztion de la recette pour afficher la même recette mais une fois modifiée
header("Location: ./loadRecette.php?modifier=".$_GET['idRecette']);                 
exit();

?>