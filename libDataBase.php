<?php 
    session_start();
    //connexion à la base de donnees 
    function my_connect(){
        $connexion=mysqli_connect('mi-mariadb.univ-tlse2.fr','dahbia.berrani-eps-h','Akbou_2021');
        if (!$connexion){
            echo ("désolé,connexion au serveur impossible\n");
            exit;
        }
        else {
            
            //selection de la base donnees

            if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
                echo("Désolé, accès à la base  impossible\n");
                exit;
            }
            mysqli_set_charset($connexion, "utf8");
            return $connexion;
        }
    }
    
    // recupère le nom Idingredient 
    function getIngredientNameById($_idIngredient){
        $connexion= my_connect();
        $requette=("SELECT  Idingredient, Nomingredient From Ingredients where Idingredient = $_idIngredient");      
        $resultat =  mysqli_query($connexion,$requette);
        if($resultat){    
            while($ligne=mysqli_fetch_object($resultat)){
                return ($ligne->Nomingredient);
            }
        }
    }      

    // calcule cout des ingredient :  
    function calculCout($_ingredientArray,$_unitArray){
        $connexion= my_connect();
        $_cout_recette = 0;
        foreach( $_ingredientArray  as $id_ingredient=>$quantite ) {      
            $requette=("SELECT  Prix  From   Ingredients where Idingredient = $id_ingredient");
            $resultat=  mysqli_query($connexion,$requette);
            if($resultat){  
                $ligne=mysqli_fetch_object($resultat);
                $_prix_unitaire = $ligne->Prix;
            }
            if($_unitArray[ $id_ingredient] === "unite"){
                $_prix =  $_prix_unitaire * $quantite;
            }
            else{
                $_prix = $_prix_unitaire * $quantite / 1000;
            }        
            $_cout_recette += $_prix;
        } 
        mysqli_close($connexion);
        return round ( $_cout_recette, 2 );
    }
   
    //fonction qui affiche les ingredients  d'une recette qui a un idrecette $_idRecette
    function afficherIngredients($_idRecette){
        $connexion= my_connect();
        $requette_composant="SELECT Nomingredient,Quantitee,Unite FROM Compositions join Ingredients USING(Idingredient) JOIN Recettes USING(Idrecette) where Idrecette = $_idRecette ";
        $table_composant_resultat =  mysqli_query($connexion,$requette_composant);   
        if($table_composant_resultat){
            echo ("Ingredients: <ul> ");
            while($ligne_composant=mysqli_fetch_object($table_composant_resultat)){
                if ($ligne_composant->Unite === "unite") {
                    echo ("<li>".$ligne_composant->Quantitee." ".$ligne_composant->Nomingredient.".</li>");
                }
                else {        
                    echo ("<li>".$ligne_composant->Quantitee." ".$ligne_composant->Unite." de ".$ligne_composant->Nomingredient.".</li>");
                }             
            }
            echo "</ul>";
        }else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }

    // fonction qui affiche les commentaires d'une recette qui a un idrecette $_idRecette 
    function afficherCommentaires($_idRecette){
        $connexion= my_connect();
        $requette_commentaire="SELECT Commentaire,Idrecette,Datecommentaire FROM Commentaires where Idrecette = $_idRecette";
        $table_commentaire_resultat =  mysqli_query($connexion,$requette_commentaire);   
        if($table_commentaire_resultat){
            echo ("Commentaires:<ul> ");
            
            while($ligne_commentaire=mysqli_fetch_object($table_commentaire_resultat)){
                echo ("<li>".$ligne_commentaire->Datecommentaire.": ".$ligne_commentaire->Commentaire."</li>");
            }
            echo "</ul>";
        }else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }

    //fonction qui affiche les boutons de contrôl de la recette selon le type de connexion (administrateur ou simple utilisateur)
    function afficherControlRecetteAdmin($_idRecette){
        if (isset($_SESSION["user"])) {
            if ($_SESSION["user"] === "admin" ){
                //Ajout du bouton suppprimer
                echo "<div class=\"controlAdmin\">";
                    echo "<form action=\"./traitementAdminRecette.php\" method=\"GET\">";
                        echo "<button type=\"submit\">supprimer</button>";
                        echo "<input type=\"hidden\"  name=\"supprimer\" value=\"".$_idRecette."\">";
                    echo "</form>";
                echo "</div>";

                //Ajout du boutton modifier (mise à jour)
                echo "<div class=\"controlAdmin\">";
                    echo "<form action=\"./loadRecette.php\" method=\"GET\">";
                        echo "<button type=\"submit\">modifier</button>";
                        echo "<input type=\"hidden\"  name=\"modifier\" value=\"".$_idRecette."\">";
                    echo "</form>";    
                echo "</div>";     
            }
   
            //Ajout du boutton Ajouter aux Favoris
            echo "<div class=\"controlAdmin\">";
                echo "<form action=\"./traitementAdminRecette.php\" method=\"GET\">";
                    echo "<button type=\"submit\">ajouter aux favoris</button>";
                    echo "<input type=\"hidden\"  name=\"ajoutFavoris\" value=\"".$_idRecette."\">";
                echo "</form>";    
            echo "</div>";   

        }
    }

    //fonctions qui affiche le formulaire pour ajouter un commentaire si un utilisateur est connecté
    function afficherAjoutCommentaire($_idRecette){
        if (isset($_SESSION["user"])){
            //Ajout du bouton commenter
            echo "<form action=\"./traitementAdminRecette.php\" method=\"GET\">";
            //Ajout de la zone de saisie du commentaire
            echo "<textarea  name=\"commentaire\" cols=\"100\" rows=\"5\" > </textarea>";
            echo "<button type=\"submit\">commenter</button>";
            echo "<input type=\"hidden\"  name=\"commenter\" value=\"".$_idRecette."\">";
            echo "</form>";            
        }
    }

    //fonction qui affiche une recette qui a un idrecette $_idRecette
    function afficherRecette($_idRecette){
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout,Nomcategorie FROM Recettes where Idrecette = $_idRecette";                  
        $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
        // affichage chaque recettes
        if($table_recette_resultat){
            $ligne_recette=mysqli_fetch_object($table_recette_resultat);
            echo ("<div class=\"recette\" id=\"".$_idRecette."\">");
            afficherControlRecetteAdmin($_idRecette);
            echo("<h1>".$ligne_recette->Nomcategorie.":".$ligne_recette->Nomrecette."</h1><img class =\"center\" src=".$ligne_recette->Imagepath."><br><h4> pour ".$ligne_recette->Nombrepersonne." Personne, Coût:".$ligne_recette->Cout."€</h4>");
            // affichage chaque Ingrediens 
            afficherIngredients($_idRecette);     
            // affichage des Etapes recettes    
            echo "<p>".$ligne_recette->Etapes."</p>";
            //affichage chaque Commentaires 
            afficherCommentaires($_idRecette);  
            afficherAjoutCommentaire($_idRecette);
            echo "</div>"; 
        }
        else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }

    // fonction qui supprime un commentaire 
    function supprimerCommentaire($_idCommentaire){
        $connexion= my_connect();
        $requette_commentaire="DELETE FROM Commentaires where Idcommentaire = $_idCommentaire";
        $table_commentaire_resultat =  mysqli_query($connexion,$requette_commentaire);   
        if(!$table_commentaire_resultat){      
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion); 
        }
        mysqli_close($connexion);
    }

    // fonction qui supprime tout les commentaires d'une recette
    function supprimerToutCommentaires($_idRecette){
        // recherche de tout les commentaires de la recette
        $connexion= my_connect();
        $requette_commentaire="SELECT Idcommentaire FROM Commentaires where Idrecette = $_idRecette";
        $table_commentaire_resultat =  mysqli_query($connexion,$requette_commentaire);   
        if($table_commentaire_resultat){      
            while($ligne_commentaire=mysqli_fetch_object($table_commentaire_resultat)){
                supprimerCommentaire($ligne_commentaire->Idcommentaire);
            }
        }
        else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }

    // fonction qui supprime un ingrédient d'une recette 
    function supprimerIngredient($_idIngredient,$_idRecette){
        $connexion= my_connect();
        $requette_compositions="DELETE FROM Compositions where Idingredient = $_idIngredient and Idrecette = $_idRecette";
        $table_compositions_resultat =  mysqli_query($connexion,$requette_compositions);   
        if(!$table_compositions_resultat){      
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion); 
        }
        mysqli_close($connexion);
    }

    // fonction qui supprime tout les ingrédients d'une recette
    function supprimerToutIngredients($_idRecette){
        // recherche de tout les commentaires de la recette
        $connexion= my_connect();
        $requette_compositions="SELECT Idingredient FROM Compositions where Idrecette = $_idRecette";
        $table_compositions_resultat =  mysqli_query($connexion,$requette_compositions);   
        if($table_compositions_resultat){      
            while($ligne_compositions=mysqli_fetch_object($table_compositions_resultat)){
                supprimerIngredient($ligne_compositions->Idingredient,$_idRecette);
            }
        }
        else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }

    // fonction qui supprime une recette de la base de donnees 
    function supprimerRecette($_idRecette){
        // suppression de tout les commentaires de la recette
        supprimerToutCommentaires($_idRecette);
        // suppression des ingrédients de la recette
        supprimerToutIngredients($_idRecette);
        // suppression de la recette
        $connexion= my_connect();
        $requette_recettes="DELETE FROM Recettes where Idrecette = $_idRecette";
        $table_recettes_resultat =  mysqli_query($connexion,$requette_recettes);   
        if(!$table_recettes_resultat){      
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion); 
        }
        mysqli_close($connexion);
    }

    // fonction qui insère un commentaire
    function insererCommentaire($_idRecette, $_date, $_commentaire){
        $connexion= my_connect();
        $requette_commentaire="INSERT INTO `Commentaires` (`Idrecette`, `Datecommentaire`, `Commentaire`) 
        VALUES (\"".$_idRecette."\", \"".$_date."\", \"".$_commentaire."\")";
        $table_commentaire_resultat =  mysqli_query($connexion,$requette_commentaire);   
        if(!$table_commentaire_resultat){
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }

// fonction pour charger les ingrédients d'une recette dans un tableau
function loadIngredients($_idRecette){
    $connexion= my_connect();
    $requette_composant="SELECT Idingredient, Nomingredient, Quantitee, Unite FROM Compositions join Ingredients USING(Idingredient) JOIN Recettes USING(Idrecette) where Idrecette = $_idRecette ";
    $table_composant_resultat =  mysqli_query($connexion,$requette_composant);   
    $ingredients = array();
    if($table_composant_resultat){
        while($ligne_composant=mysqli_fetch_object($table_composant_resultat)){
            $ingredients += array($ligne_composant->Idingredient =>array('quantite' =>$ligne_composant->Quantitee, 'unite' =>$ligne_composant->Unite,'nom' =>$ligne_composant->Nomingredient ));
        }
    }else{
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo"message de mysqli:".mysqli_error($connexion);
    }
    mysqli_close($connexion);
    return $ingredients;
}

// Fonction pour charger les commentaires d'une recette dans un tableau
function loadComments($_idRecette){
    $connexion= my_connect();
    $requette_commentaire="SELECT Idcommentaire, Commentaire, Idrecette, Datecommentaire FROM Commentaires where Idrecette = $_idRecette";
    $table_commentaire_resultat =  mysqli_query($connexion,$requette_commentaire);   
    $commentaires = array();
    if($table_commentaire_resultat){ 
        while($ligne_commentaire=mysqli_fetch_object($table_commentaire_resultat)){
            $commentaires += array($ligne_commentaire->Idcommentaire => array('textCommentaire' => $ligne_commentaire->Commentaire,'dateCommentaire' => $ligne_commentaire->Datecommentaire));          
        } 
    }else{
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo"message de mysqli:".mysqli_error($connexion);
    }
    mysqli_close($connexion); 
    return $commentaires;
}

// fonction pour charger une recette afin de la modifier dans un tableau à partir de la base de données
function loadRecette($_idRecette){
    $connexion= my_connect();
    // Récupération des informations de la recettes 
    $requette_recette="SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout,Nomcategorie FROM Recettes where Idrecette = $_idRecette";                  
    $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
    if($table_recette_resultat){
        $ligne_recette=mysqli_fetch_object($table_recette_resultat);

        // Sauvegarde des inforamtions de la recette dans un tableau
        $tableauRecette['nomRecette'] = $ligne_recette->Nomrecette;
        $tableauRecette['categorieRecette'] = $ligne_recette->Nomcategorie;
        $tableauRecette['imageRecette'] = $ligne_recette->Imagepath;
        $tableauRecette['nombrePersonnesRecette'] = $ligne_recette->Nombrepersonne;
        $tableauRecette['etapesRecette'] = $ligne_recette->Etapes;
        $tableauRecette['cout'] = $ligne_recette->Cout;
      
        // Chargement des Ingrediens de la recette
        $ingedients = loadIngredients($_idRecette); 
        $tableauRecette['ingredientsRecette'] =  $ingedients; 

        // Chargement des Commentaires de la recette
        $commentaires = loadComments($_idRecette);
        $tableauRecette['commentairesRecette'] = $commentaires; 
    }
    else{
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo"message de mysqli:".mysqli_error($connexion);
    }
    mysqli_close($connexion);

    return $tableauRecette;
}

// Fonction pour rajouter un ingrédient à la composition d'une recette
function addComposition($_Idingredient, $_Idrecette, $_quantitee, $_uniteMesure){
    $connexion = my_connect();
    $requette2 = "INSERT INTO `Compositions` (`Idingredient`, `Idrecette`, `Quantitee`, `Unite`) 
                            VALUES (\"". $_Idingredient."\", \"". $_Idrecette."\", \"".$_quantitee."\", \"".$_uniteMesure."\" )";
    $resultat2 = mysqli_query($connexion,$requette2);
    
    if (!$resultat2) {
        echo "<p>Erreur dans l'exécution de la requette d'ajout d'ingredient dans la composition'</p>";
        echo"message de mysqli:".mysqli_error($connexion);
        exit();
    }
    mysqli_close($connexion);
}

// Fonction pour mettre à jour le coût d'un recette
function updateCout($_idRecette,$_nouveauCout){

    $connexion = my_connect();
    $requette2 = " UPDATE Recettes SET Cout =\"".$_nouveauCout."\" WHERE Idrecette = \"".$_idRecette."\"";
    $resultat2 = mysqli_query($connexion,$requette2);
    
    if (!$resultat2) {
        echo "<p>Erreur dans l'exécution de la requette d'ajout d'ingredient dans la composition'</p>";
        echo"message de mysqli:".mysqli_error($connexion);
        exit();
    }
    mysqli_close($connexion);
}

// Fonction pour mettre à jour le nom d'une recette
function updateName($_idRecette,$_nouveauNom){

    $connexion = my_connect();
    $requette2 = " UPDATE Recettes SET Nomrecette =\"".$_nouveauNom."\" WHERE Idrecette = \"".$_idRecette."\"";
    $resultat2 = mysqli_query($connexion,$requette2);
    
    if (!$resultat2) {
        echo "<p>Erreur dans l'exécution de la requette d'ajout d'ingredient dans la composition'</p>";
        echo"message de mysqli:".mysqli_error($connexion);
        exit();
    }
    mysqli_close($connexion);
}

// Fonction pour mettre à jour la catégorie d'une recette
function updateCategorie($_idRecette,$_nouvelleCategorie){

    $connexion = my_connect();
    $requette2 = " UPDATE Recettes SET Nomcategorie =\"".$_nouvelleCategorie."\" WHERE Idrecette = \"".$_idRecette."\"";
    $resultat2 = mysqli_query($connexion,$requette2);
    
    if (!$resultat2) {
        echo "<p>Erreur dans l'exécution de la requette d'ajout d'ingredient dans la composition'</p>";
        echo"message de mysqli:".mysqli_error($connexion);
        exit();
    }
    mysqli_close($connexion);
}

// Fonction pour mettre à jour le nombre de personnes d'une recette
function updateNombrePersonnes($_idRecette,$_nouveauNombre){

    $connexion = my_connect();
    $requette2 = " UPDATE Recettes SET Nombrepersonne =\"".$_nouveauNombre."\" WHERE Idrecette = \"".$_idRecette."\"";
    $resultat2 = mysqli_query($connexion,$requette2);
    
    if (!$resultat2) {
        echo "<p>Erreur dans l'exécution de la requette d'ajout d'ingredient dans la composition'</p>";
        echo"message de mysqli:".mysqli_error($connexion);
        exit();
    }
    mysqli_close($connexion);
}

// Fonction pour mettre à jour le nombre de personnes d'une recette
function updateEtapes($_idRecette,$_nouvellesEtapes){
    $connexion = my_connect();
    $requette2 = " UPDATE Recettes SET Etapes =\"".$_nouvellesEtapes."\" WHERE Idrecette = \"".$_idRecette."\"";
    $resultat2 = mysqli_query($connexion,$requette2);
    
    if (!$resultat2) {
        echo "<p>Erreur dans l'exécution de la requette d'ajout d'ingredient dans la composition'</p>";
        echo"message de mysqli:".mysqli_error($connexion);
        exit();
    }
    mysqli_close($connexion);
}

// Fonction pour vérifier si un ingrédient apaprtient à la composition d'une recette
function inComposition($_idIngredient, $_idRecette){
    $connexion= my_connect();
    $requette_composant="SELECT Idingredient FROM Compositions join Ingredients USING(Idingredient) JOIN Recettes USING(Idrecette) where Idrecette = $_idRecette and Idingredient = $_idIngredient";
    $table_composant_resultat =  mysqli_query($connexion,$requette_composant);   
    if($table_composant_resultat){    
        if (mysqli_num_rows($table_composant_resultat) == 0) {
            $resultat = FALSE;
        }  
        else {
            $resultat = TRUE;
        }
    }else{
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo"message de mysqli:".mysqli_error($connexion);
    }
    mysqli_close($connexion);
    return $resultat;
}

// Fonction pour ajouté une recette à la liste des recettes à modérer par l'administarteur
function ajouterModeration($Id_recette){
    $connexion= my_connect();
    $requette_moderation="INSERT INTO `Moderations` (`Idmoderation`) VALUES (\"".$Id_recette."\")";
   
    $table_moderations_resultat =  mysqli_query($connexion,$requette_moderation);   
    if(!$table_moderations_resultat) {      
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo"message de mysqli:".mysqli_error($connexion);
        echo $requette_moderation;
    }
    mysqli_close($connexion);
}

//fonction qui affiche les boutons de contrôl pour la modération d'une recette par l'administrateur (acceptation ou Refuser)
function afficherControlRecetteAdminModeration($_idRecette){
    if ($_SESSION["user"] === "admin" ){
        //Ajout du boutton Accepter 
        echo "<div class=\"controlAdmin\">";
            echo "<form  action=\"./modererRecette.php\" method=\"GET\">";
                echo "<button type=\"submit\">accepter</button>";
                echo "<input type=\"hidden\"  name=\"accepter\" value=\"".$_idRecette."\">";
            echo "</form>"; 
        echo "</div>";

        //Ajout du bouton Refuser
        echo "<div class=\"controlAdmin\">";
            echo "<form  action=\"./modererRecette.php\" method=\"GET\">";
                echo "<button type=\"submit\">refuser</button>";
                echo "<input type=\"hidden\"  name=\"refuser\" value=\"".$_idRecette."\">";
            echo "</form>";
        echo "</div>";        
    }
}

// Fonction qui affiche les recette en attente de modération
function afficherRecettePourModeration($_idRecette){
    $connexion= my_connect();
    // Récupération des recettes 
    $requette_recette="SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout,Nomcategorie FROM Recettes where Idrecette = $_idRecette";                  
    $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
    // affichage chaque recettes
    if($table_recette_resultat){
        $ligne_recette=mysqli_fetch_object($table_recette_resultat);
        echo ("<div class=\"recette\" id=\"".$_idRecette."\">");
        afficherControlRecetteAdminModeration($_idRecette);
        echo("<h1>".$ligne_recette->Nomcategorie.":".$ligne_recette->Nomrecette."</h1><img class =\"center\" src=".$ligne_recette->Imagepath."><br><h4> pour ".$ligne_recette->Nombrepersonne." Personne, Coût:".$ligne_recette->Cout."€</h4>");
        // affichage de chaque Ingrediens 
        afficherIngredients($_idRecette);     
        // affichage des Etapes recettes    
        echo "<p>".$ligne_recette->Etapes."</p>";
        echo "</div>"; 
    }
    else{
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo"message de mysqli:".mysqli_error($connexion);
    }
    mysqli_close($connexion);
}

// Fonction pour refuser une recette par l'administrateur
function  refuserRecette($_idRecette){
    // Supprimer la recette de la table Moderations
    $connexion = my_connect();
    $requette_recettes = "DELETE FROM Moderations where Idmoderation = $_idRecette";
    $table_recettes_resultat =  mysqli_query($connexion,$requette_recettes);   
    if(!$table_recettes_resultat){      
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo "message de mysqli:".mysqli_error($connexion); 
        echo $requette_recettes;
    }
    // Supression de la recette de la table recette
    supprimerRecette($_idRecette);
    mysqli_close($connexion);
}


// Fonction pour refuser une recette par l'administrateur
function  accepterRecette($_idRecette){
    // Supprimer la recette de la table Moderations
    $connexion = my_connect();
    $requette_recettes = "DELETE FROM Moderations where Idmoderation = $_idRecette";
    $table_recettes_resultat =  mysqli_query($connexion,$requette_recettes);   
    if(!$table_recettes_resultat){      
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo "message de mysqli:".mysqli_error($connexion); 
        echo $requette_recettes;
    }
    mysqli_close($connexion);
}

// Fonction pour rajouter une recette à ses favoris
function ajouterAuxFavoris($_idRecette){
    $connexion= my_connect();
    $requette_favoris="INSERT INTO `Favoris` (`Idrecette`, `Idutilisateur`) VALUES (\"".$_idRecette."\",\"".$_SESSION["userid"]."\")";
   
    $table_favoris_resultat =  mysqli_query($connexion,$requette_favoris);   
    if(!$table_favoris_resultat) {      
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo"message de mysqli:".mysqli_error($connexion);
        echo $requette_moderation;
    }
    mysqli_close($connexion);
}

// Fonction qui permet de savoir si une recette fait partis des favoris de l'utlisateur connecté
function isFavoris($_idRecette){
    $connexion= my_connect();
    $requette_favoris="INSERT INTO `Favoris` (`Idrecette`, `Idutilisateur`) VALUES (\"".$_idRecette."\",\"".$_SESSION["userid"]."\")";
   
    $table_favoris_resultat =  mysqli_query($connexion,$requette_favoris);   
    if(!$table_favoris_resultat) {      
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo"message de mysqli:".mysqli_error($connexion);
        echo $requette_moderation;
    }
    mysqli_close($connexion);

    return FALSE;
}

?>