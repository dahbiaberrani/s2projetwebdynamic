  <!DOCTYPE html lang="fr">
  <html>

  <head>
      <meta charset="utf-8" />
      <title>Mon site </title>
  </head>
  <header>

      <!-- Le menu -->

      <?php include("entete.php"); ?>

      <!-- Le corps -->
  </header>

  <body>
      <p>Ces recettes peuvent t'intéresser :</p>


      <?php 
        // Connexion à la base de données
             
	                $connexion=mysqli_connect('mi-mariadb.univ-tlse2.fr','dahbia.berrani-eps-h','Akbou_2021');
        
                    if (!$connexion) {
                        echo("Desolé, connexion au serveur impossible\n");
                        exit;
                      }


                    //selection de la base donnees

                    if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
                        echo("Désolé, accès à la base  impossible\n");
                        exit;
                    }
                    mysqli_set_charset($connexion, "utf8");
             // Récupération des recettes 
              $requette_recette="SELECT Idrecette,Nomrecette,Imagepath,Etapes FROM Recettes  ";      
               
              //$requette2="SELECT Quantitee FROM Compositions Where Idrecette=1";
              
              $table_recette_resultat =  mysqli_query($connexion,$requette_recette);
            // affichage chaque recettes
            if($table_recette_resultat){
                echo ("Bienvenue sur mon site ");

                while($ligne_recette=mysqli_fetch_object($table_recette_resultat)){
                    echo ("<h1>".$ligne_recette->Nomrecette."</h1><img src=".$ligne_recette->Imagepath."><br>");


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
                

        ?>
      <?php include("pied_de_page.php");?>
  </body>

  </html>