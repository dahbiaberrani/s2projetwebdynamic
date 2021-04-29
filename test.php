<?php

if (isset ($_GET['changeRecetteName'])) {
    echo "changement nom recette pour: ".$_GET['NomRecette']."<br>";
}

if (isset ($_GET['changeRecetteCategorie'])) {
    echo "changement catégorie recette pour: ".$_GET['categorie']."<br>";
}

if (isset ($_GET['changeRecetteNombrePersonne'])) {
    echo "changement Nombre Personne recette pour: ".$_GET['NombrePersonne']."<br>";
}

if (isset ($_GET['changeRecetteEtapes'])) {
    echo "changement Etapes recette pour: ".$_GET['etapes']."<br>";
}

if (isset ($_GET['addRecetteIngredient'])) {
    echo "Ajout ingrédients à la recette pour: <br>";
    echo "idIngrédient:".$_GET['Idingredient']."</br>";
    echo "qauntité:".$_GET['Quantite']."</br>";
    echo "unité:".$_GET['unite']."</br>";
}


if (isset ($_GET['deleteIngredient'])) {
    echo "Suppression ingrédient de la recette pour: <br>";
    echo "ingrédient:".$_GET['idIngredientToDelete']."</br>";
    echo "recette:".$_GET['idRecette']."</br>";
}

if (isset ($_GET['deleteComment'])) {
    echo "Suppression du commentaire:".$_GET['idCommentaireToDelete']."</br>";
}

?>