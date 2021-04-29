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

            //Ajout du boutton modifier (mise à jour)
            echo "<form action=\"./loadRecette.php\" method=\"GET\">";
            echo "<button type=\"submit\">modifier</button>";
            echo "<input type=\"hidden\"  name=\"modifier\" value=\"".$_idRecette."\">";
            echo "</form>";         
        }
    }

    //fonctions qui affiche le formulaire pour ajouter un commentaire si un utilisateur est connecté
    function afficherAjoutCommentaire($_idRecette){
        if (isset($_SESSION["user"])){
            //Ajout du bouton commenter
            echo "<form action=\"./traitementAdminRecette.php\" method=\"GET\">";
            //Ajout de la zone de saisie du commentaire
            echo "<textarea  name=\"commentaire\" cols=\"150\" rows=\"5\" > </textarea>";
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
            echo ("<div id=\"recette\">");
            afficherControlRecetteAdmin($_idRecette);
            echo("<h1>".$ligne_recette->Nomcategorie.":".$ligne_recette->Nomrecette."</h1><img src=".$ligne_recette->Imagepath."><br><h4> pour ".$ligne_recette->Nombrepersonne." Personne, Coût:".$ligne_recette->Cout."€</h4>");
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

    // fonction pour charger une recette afin de la modifier dans un tableau à partir de la base de données
    function loadRecette($_idRecette){
        $tableauRecette['idRecette'] = $_idRecette;
        $tableauRecette['nomRecette'] = "Clafoutis";
        $tableauRecette['categorieRecette'] = "Entree";
        $tableauRecette['imageRecette'] = "./images/crepesalee.PNG";
        $tableauRecette['nombrePersonnesRecette'] =4;
        $tableauRecette['coutRecette'] = 3.1;
        $tableauRecette['etapesRecette'] = "etape1,Etape2";
        $ingedients['1']= array('quantite'=> 200,
                                'unite'=> 'g',
                                'nom' => 'fromage frais'
                            );
        $ingedients['2']= array('quantite'=> 150,
                            'unite'=> 'unite',
                            'nom' => 'oaufs'
                        );
        $ingedients['3']= array('quantite'=> 4,
                        'unite'=> 'ml',
                        'nom' => 'beurre fondu'
                    );

        $commentaires['1'] = array('textCommentaire' => "Commentaire 1",
                                    'dateCommentaire' => "2021-03-16");
        $commentaires['2'] = array('textCommentaire' => "Commentaire 2",
                                    'dateCommentaire' => "2021-04-01");
        $commentaires['3'] = array('textCommentaire' => "Commentaire 3",
                                    'dateCommentaire' => "2021-05-19");

        $tableauRecette['ingredientsRecette'] =  $commentaires;
        $tableauRecette['commentairesRecette'] = "tableau de commentaires";

        return $tableauRecette;
    }
?>