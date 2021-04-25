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
        return $_cout_recette;
    }
   
    //fonction qui affiche les ingredients  d'une recette qui a un idrecette $_idRecette
    function afficherIngredients($_idRecette){
        $connexion= my_connect();
        $requette_composant="SELECT Nomingredient,Quantitee,Unite FROM Compositions join Ingredients USING(Idingredient) JOIN Recettes USING(Idrecette) where Idrecette = $_idRecette ";
        $table_composant_resultat =  mysqli_query($connexion,$requette_composant);   
        if($table_composant_resultat){
            echo ("Ingredients: <ul> ");
            while($ligne_composant=mysqli_fetch_object($table_composant_resultat)){
                echo ("<li>".$ligne_composant->Quantitee."".$ligne_composant->Unite." ".$ligne_composant->Nomingredient."</li>");
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
        if ($_SESSION["user"] === "admin" ){

            //Ajout du bouton suppprimer
            echo "<form action=\"./traitementAdminRecette.php\" method=\"GET\">";
            echo "<button type=\"submit\">supprimer</button>";
            echo "<input type=\"hidden\"  name=\"supprimer\" value=\"".$_idRecette."\">";
            echo "</form>";

            //Ajout du boutton modifier
            echo "<form action=\"./traitementAdminRecette.php\" method=\"GET\">";
            echo "<button type=\"submit\">modifier</button>";
            echo "<input type=\"hidden\"  name=\"modifier\" value=\"".$_idRecette."\">";
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
            echo ("<div id=\"recette\">");
            afficherControlRecetteAdmin($_idRecette);
            echo("<h1>".$ligne_recette->Nomcategorie.":".$ligne_recette->Nomrecette."</h1><img src=".$ligne_recette->Imagepath."><br><h4> pour ".$ligne_recette->Nombrepersonne." Personne, Coût:".$ligne_recette->Cout."€</h4>");
            // affichage chaque Ingrediens 
            afficherIngredients($_idRecette);     
            // affichage des Etapes recettes    
            echo "<p>".$ligne_recette->Etapes."</p>";
            //affichage chaque Commentaires 
            afficherCommentaires($_idRecette);   
            echo "</div>"; 
        }
        else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }
?>