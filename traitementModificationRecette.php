<?php
include_once('./libDataBase.php');

// Traitement de la Demande de changement de nom de recette
if (isset ($_GET['changeRecetteName'])) {
    updateName($_GET['idRecette'],$_GET['NomRecette']);
}

if (isset ($_GET['changeRecetteCategorie'])) {
    echo "changement catégorie recette pour: ".$_GET['categorie']."<br>";
    updateCategorie($_GET['idRecette'],$_GET['categorie']);
}

if (isset ($_GET['changeRecetteNombrePersonne'])) {
    echo "changement Nombre Personne recette pour: ".$_GET['NombrePersonne']."<br>";
    updateNombrePersonnes($_GET['idRecette'],$_GET['NombrePersonne']);
}

if (isset ($_GET['changeRecetteEtapes'])) {
    echo "changement Etapes recette pour: ".$_GET['etapes']."<br>";
    updateEtapes($_GET['idRecette'],$_GET['etapes']);
}

if (isset ($_GET['addRecetteIngredient'])) {

    //Vérification que l'ingrédient est bien renseigné

    // Vérification que le nouveau ingrédient n'existe pas
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