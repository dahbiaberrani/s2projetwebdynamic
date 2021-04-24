<?php 
    include_once ("./libDataBase.php");
   
    function afficherEntre(){
        $connexion= my_connect();
             // Récupération des recettes 
              $requette_recette="SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne FROM Recettes where Nomcategorie = 'Entree' ";      
               
              //$requette2="SELECT Quantitee FROM Compositions Where Idrecette=1";
              
              $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
            // affichage chaque recettes
            if($table_recette_resultat){
               

                while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                    echo ("<h1>".$ligne_recette->Nomrecette."</h1><img src=".$ligne_recette->Imagepath."><br><h4> pour ".$ligne_recette->Nombrepersonne." Personne</h4>");


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
                        echo "<p>Erreur dans l'exécution de la requette</p>";
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
                            echo ("<li>".$ligne_commentaire->Datecommentaire.": ".$ligne_commentaire->Commentaire."</li>");
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
        
      // fonction pour afficher les plat seulement:
    function afficheplat(){
        $connexion= my_connect();
        // Récupération des recettes 
        $requette_recette="SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne FROM Recettes where Nomcategorie = 'Plat'  ";      
            
        //$requette2="SELECT Quantitee FROM Compositions Where Idrecette=1";
            
        $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
        // affichage chaque recettes
        if($table_recette_resultat){
               

            while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                echo ("<h1>".$ligne_recette->Nomrecette."</h1><img src=".$ligne_recette->Imagepath."><br><h4> pour ".$ligne_recette->Nombrepersonne." Personne</h4>");


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
                    echo "<p>Erreur dans l'exécution de la requette</p>";
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
                        echo ("<li>".$ligne_commentaire->Datecommentaire.": ".$ligne_commentaire->Commentaire."</li>");
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
  
    function affichedessert(){
        $connexion= my_connect();
        
             // Récupération des recettes 
              $requette_recette="SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne FROM Recettes where Nomcategorie = 'Dessert' ";      
              $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
            // affichage chaque recettes
            if($table_recette_resultat){
               

                while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                    echo ("<h1>".$ligne_recette->Nomrecette."</h1><img src=".$ligne_recette->Imagepath."><br><h4> pour ".$ligne_recette->Nombrepersonne." Personne</h4>");
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
                        echo "<p>Erreur dans l'exécution de la requette</p>";
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
                            echo ("<li>".$ligne_commentaire->Datecommentaire.": ".$ligne_commentaire->Commentaire."</li>");
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

    function affichertout(){
            $connexion= my_connect();
            // Récupération des recettes 
            $requette_recette="SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne FROM Recettes  ";      
                   
            $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
            // affichage chaque recettes
            if($table_recette_resultat){
                echo ("Bienvenue sur mon site ");
    
                while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                    echo ("<h1>".$ligne_recette->Nomrecette."</h1><img src=".$ligne_recette->Imagepath."><br><h4> pour ".$ligne_recette->Nombrepersonne." Personne</h4>");
    
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
                        echo "<p>Erreur dans l'exécution de la requette</p>";
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
        

    function afficherEntre_prix($cout){
        // Connexion à la base de données
     
        $connexion= my_connect();
             // Récupération des recettes 
              $requette_recette="  SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout FROM Recettes where Nomcategorie = 'Entree'and Cout <= $cout ";      
               
              //$requette2="SELECT Quantitee FROM Compositions Where Idrecette=1";
              
              $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
            // affichage chaque recettes
            if($table_recette_resultat){
               

                while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                    echo ("<h1>".$ligne_recette->Nomrecette."</h1><img src=".$ligne_recette->Imagepath."><br><h4> pour ".$ligne_recette->Nombrepersonne." Personne</h4>");


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
                        echo "<p>Erreur dans l'exécution de la requette</p>";
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
                            echo ("<li>".$ligne_commentaire->Datecommentaire.": ".$ligne_commentaire->Commentaire."</li>");
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
        
      
           
    // afficher les Plat par prix inférieur à une valeur         
    function afficherPlat_prix($cout){
            // Connexion à la base de données
            $connexion= my_connect();

                 // Récupération des recettes 
                  $requette_recette="  SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout FROM Recettes where Nomcategorie = 'Plat'and Cout <= $cout ";      
                   
                  //$requette2="SELECT Quantitee FROM Compositions Where Idrecette=1";
                  
                  $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
                // affichage chaque recettes
                if($table_recette_resultat){
                   
    
                    while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                        echo ("<h1>".$ligne_recette->Nomrecette."</h1><img src=".$ligne_recette->Imagepath."><br><h4> pour ".$ligne_recette->Nombrepersonne." Personne</h4>");
    
    
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
                            echo "<p>Erreur dans l'exécution de la requette</p>";
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
                                echo ("<li>".$ligne_commentaire->Datecommentaire.": ".$ligne_commentaire->Commentaire."</li>");
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
            
          
               
    // afficher les dessert par prix  inférieur à une valeur 
    function afficherDessert_prix($cout){
                // Connexion à la base de données
             
                $connexion= my_connect();
                     // Récupération des recettes 
                      $requette_recette="  SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout FROM Recettes where Nomcategorie = 'Dessert'and Cout <= $cout ";      
                       
                      //$requette2="SELECT Quantitee FROM Compositions Where Idrecette=1";
                      
                      $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
                    // affichage chaque recettes
                    if($table_recette_resultat){
                       
        
                        while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                            echo ("<h1>".$ligne_recette->Nomrecette."</h1><img src=".$ligne_recette->Imagepath."><br><h4> pour ".$ligne_recette->Nombrepersonne." Personne</h4>");
        
        
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
                                echo "<p>Erreur dans l'exécution de la requette</p>";
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
                                    echo ("<li>".$ligne_commentaire->Datecommentaire.": ".$ligne_commentaire->Commentaire."</li>");
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

     // afficher les recettes par prix  inférieur à une valeur 
     function afficherTout_prix($cout){
        // Connexion à la base de données
     
        $connexion= my_connect();
             // Récupération des recettes 
              $requette_recette="  SELECT Idrecette,Nomrecette,Imagepath,Etapes,Nombrepersonne,Cout FROM Recettes where  Cout <= $cout ";      
               
              //$requette2="SELECT Quantitee FROM Compositions Where Idrecette=1";
              
              $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
            // affichage chaque recettes
            if($table_recette_resultat){
               

                while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                    echo ("<h1>".$ligne_recette->Nomrecette."</h1><img src=".$ligne_recette->Imagepath."><br><h4> pour ".$ligne_recette->Nombrepersonne." Personne</h4>");


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
                        echo "<p>Erreur dans l'exécution de la requette</p>";
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
                            echo ("<li>".$ligne_commentaire->Datecommentaire.": ".$ligne_commentaire->Commentaire."</li>");
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