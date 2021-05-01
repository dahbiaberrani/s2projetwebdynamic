<?php 
    include_once ("./libDataBase.php");
   // fonction pour afficher les entrées seulement
    function afficherEntre(){
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="SELECT Idrecette FROM Recettes where Nomcategorie = 'Entree' ";                
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
        
    // fonction pour afficher les plats seulement
    function afficheplat(){
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="SELECT Idrecette FROM Recettes where Nomcategorie = 'Plat'  ";          
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

    // fonction pour afficher les desserts seulement
    function affichedessert(){
        $connexion= my_connect();  
        // Récupération des recettes 
        $requette_recette="SELECT Idrecette FROM Recettes where Nomcategorie = 'Dessert' ";      
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

    // fonction pour afficher toutes les recettes
    function affichertout(){
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="SELECT Idrecette FROM Recettes  ";      
                
        $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
        // affichage chaque recettes
        if($table_recette_resultat){
            echo ("Bienvenue sur mon site ");
            while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                afficherRecette($ligne_recette->Idrecette);
            }
        }else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        mysqli_close($connexion);
    }      
    
    // fonction pour afficher les entrées qui couttent moins de $cout
    function afficherEntre_prix($cout){
        // Connexion à la base de données   
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="  SELECT Idrecette FROM Recettes where Nomcategorie = 'Entree'and Cout <= $cout ";       
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
             
    // afficher les Plat  qui couttent moins de $cout        
    function afficherPlat_prix($cout){
        // Connexion à la base de données
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="  SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout FROM Recettes where Nomcategorie = 'Plat'and Cout <= $cout ";             
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
                        
    // afficher les dessert qui couttent moins de $cout
    function afficherDessert_prix($cout){
        // Connexion à la base de données  
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="  SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout FROM Recettes where Nomcategorie = 'Dessert'and Cout <= $cout ";    
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

    // afficher les recettes  qui couttent moins que $cout
    function afficherTout_prix($cout){
        // Connexion à la base de données
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette = " SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout FROM Recettes where  Cout <= $cout";      
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
?>