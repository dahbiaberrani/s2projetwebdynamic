<?php 
    //connexion à la base de donnees 
    function my_connect(){
        $connexion=mysqli_connect('mi-mariadb.univ-tlse2.fr','dahbia.berrani-eps-h','Akbou_2021');
        if (!$connexion){
            echo ("désolé,connexion au serveur impossible\n");
            exit;
        }
        else {
            return $connexion;
        }
    }
    
    // recupère le nom Idingredient 
    function getIngredientNameById($_idIngredient){
        $connexion= my_connect();
        if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
            echo("Désolé, accès à la base  impossible\n");
            exit;
        }
        mysqli_set_charset($connexion, "utf8");
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
        if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
            echo("Désolé, accès à la base  impossible\n");
            exit;
        }
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
            }else{
                $_prix = $_prix_unitaire * $quantite / 1000;
            }
            
            $_cout_recette += $_prix;
        } 
        return $_cout_recette;

    }

    // fonction qui chercher des recettes par cour définit:
 
    function afficherParCout(){
        $res_cout = $_GET['cout'];
        if ($res_cout == "moins_cher"){
            $cout = 5;
    
        }elseif ($res_cout == "moins_3"){
            $cout = 3;
        }elseif ($res_cout == "moyen_cher"){
            $cout = 10;
        }elseif ($res_cout == "*"){
            $cout = 100;
        }
      
        $connexion= my_connect();
        //selection de la base donnees
        if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
            echo("Désolé, accès à la base  impossible\n");
            exit;
        }
        mysqli_set_charset($connexion, "utf8");
        // Récupération des recettes 
        
        $requette_recette="SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout FROM Recettes  where Cout <= $cout ";      
            
        $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
        // affichage chaque recettes
        if($table_recette_resultat){
            

            while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                echo ("<h1>".$ligne_recette->Nomrecette."</h1><img src=".$ligne_recette->Imagepath."><br><h4> pour ".$ligne_recette->Nombrepersonne." Personne</h4><em>".$ligne->Cout."</em>");

                // __________________________affichage chaque Ingrediens 
                $requette_composant="SELECT Nomingredient,Quantitee,Unite FROM Compositions join Ingredients USING(Idingredient) JOIN Recettes USING(Idrecette) where Idrecette = $ligne_recette->Idrecette ";
                $table_composant_resultat =  mysqli_query($connexion,$requette_composant);   
                if($table_composant_resultat){
                    echo ("Ingredients: <ul> ");
                    
                    while($ligne_composant=mysqli_fetch_object($table_composant_resultat)){
                        echo ("<li>".$ligne_composant->Quantitee."".$ligne_composant->Unite." ".$ligne_composant->Nomingredient."</li>");
                    }
                    echo "</ul>";
                }else{
                    echo "<p>Erreur dans l'exécution de la requette </p>";
                    echo"message de mysqli:".mysqli_error($connexion);
                }
                // affichage des Etapes recettes    
                echo"<p>".$ligne_recette->Etapes."</p>";

                // __________________________affichage chaque Commentaires 
                $requette_commentaire="SELECT Commentaire,Idrecette,Datecommentaire FROM Commentaires where Idrecette = $ligne_recette->Idrecette";
                $table_commentaire_resultat =  mysqli_query($connexion,$requette_commentaire);   
                if($table_commentaire_resultat){
                    echo ("Commentaires:<ul> ");
                    
                    while($ligne_commentaire=mysqli_fetch_object($table_commentaire_resultat)){
                        echo ("<li>".htmlspecialchars($ligne_commentaire->Datecommentaire).": ".htmlspecialchars($ligne_commentaire->Commentaire)."</li>");
                    }
                    echo "</ul>";
                }else{
                    echo "<p>Erreur dans l'exécution de la requette</p>";
                    echo"message de mysqli:".mysqli_error($connexion);
                }
            }
        }else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }

        mysqli_close($connexion);
    }


   
?>