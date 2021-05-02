<?php 
    include_once ("./libDataBase.php");
   // fonction pour afficher les entrées seulement sauf celles en attente de modération par l'administrateur
    function afficherEntre(){
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="SELECT Idrecette FROM Recettes where Nomcategorie = 'Entree' and  Idrecette not in (SELECT Idmoderation FROM Moderations) ";                
        $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
        // affichage chaque recettes
        if($table_recette_resultat){
            while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                afficherRecette($ligne_recette->Idrecette);
            }
        }else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }
        
    // fonction pour afficher les plats seulement sauf celles en attente de modération par l'administrateur
    function afficheplat(){
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="SELECT Idrecette FROM Recettes where Nomcategorie = 'Plat'  and  Idrecette not in (SELECT Idmoderation FROM Moderations)  ";          
        $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
        // affichage chaque recettes
        if($table_recette_resultat){
            while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                afficherRecette($ligne_recette->Idrecette);
            }
        }else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }

    // fonction pour afficher les desserts seulement sauf celles en attente de modération par l'administrateur
    function affichedessert(){
        $connexion= my_connect();  
        // Récupération des recettes 
        $requette_recette="SELECT Idrecette FROM Recettes where Nomcategorie = 'Dessert'  and  Idrecette not in (SELECT Idmoderation FROM Moderations) ";      
        $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
        // affichage chaque recettes
        if($table_recette_resultat){
            while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                afficherRecette($ligne_recette->Idrecette);
            }
        }
        else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }   
        mysqli_close($connexion); 
    }

    // fonction pour afficher toutes les recettes sauf celles en attente de modération par l'administrateur
    function affichertout(){
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="SELECT Idrecette FROM Recettes WHERE Idrecette not in (SELECT Idmoderation FROM Moderations)";      
                
        $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
        // affichage chaque recettes
        if($table_recette_resultat){

            while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                afficherRecette($ligne_recette->Idrecette);
            }
        }else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }      
    
    // fonction pour afficher les entrées qui couttent moins de $cout sauf celles en attente de modération par l'administrateur
    function afficherEntre_prix($cout){
        // Connexion à la base de données   
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="  SELECT Idrecette FROM Recettes where Nomcategorie = 'Entree'and Cout <= $cout  and  Idrecette not in (SELECT Idmoderation FROM Moderations) ";       
        $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
        // affichage chaque recettes
        if($table_recette_resultat){
            while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                afficherRecette($ligne_recette->Idrecette);
            }
        }
        else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }
             
    // afficher les Plat  qui couttent moins de $cout sauf celles en attente de modération par l'administrateur
    function afficherPlat_prix($cout){
        // Connexion à la base de données
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="  SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout FROM Recettes where Nomcategorie = 'Plat'and Cout <= $cout and  Idrecette not in (SELECT Idmoderation FROM Moderations) ";             
        $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
        // affichage chaque recettes
        if($table_recette_resultat){
            while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                afficherRecette($ligne_recette->Idrecette);
            }
        }
        else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }
                        
    // afficher les dessert qui couttent moins de $cout sauf celles en attente de modération par l'administrateur
    function afficherDessert_prix($cout){
        // Connexion à la base de données  
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="  SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout FROM Recettes where Nomcategorie = 'Dessert'and Cout <= $cout and  Idrecette not in (SELECT Idmoderation FROM Moderations) ";    
        $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
        // affichage chaque recettes
        if($table_recette_resultat){
            while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                afficherRecette($ligne_recette->Idrecette);
            }
        }
        else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);  
    }

    // afficher les recettes  qui couttent moins que $cout sauf celles en attente de modération par l'administrateur
    function afficherTout_prix($cout){
        // Connexion à la base de données
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette = " SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout FROM Recettes where  Cout <= $cout and  Idrecette not in (SELECT Idmoderation FROM Moderations) ";      
        $table_recette_resultat =  mysqli_query($connexion, $requette_recette);
        // affichage chaque recettes
        if ($table_recette_resultat) {
            while ($ligne_recette=mysqli_fetch_object($table_recette_resultat)) {
                afficherRecette($ligne_recette->Idrecette);
            }
        }
        else {
            echo "<p>Erreur dans l'exécution de la requette afficherTout_prix</p>";
            echo"message de mysqli:".mysqli_error($connexion);

            echo  "<br>".$requette_recette;
        }
        mysqli_close($connexion);
    }   
    
    // Afficahge des recettes en attente de modération
    function afficherRecetteAModerer(){
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="SELECT Idrecette FROM Recettes WHERE Idrecette in (SELECT Idmoderation FROM Moderations)";      
                
        $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
        // affichage chaque recettes
        if($table_recette_resultat){
            while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                afficherRecettePourModeration($ligne_recette->Idrecette);
            }
        }else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }
?>