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
                    mysqli_query("SET NAMES 'utf8'");
             // Récupération des recettes 
              $requette="SELECT Nomrecette,Imagepath,Etapes FROM Recettes  ";      
              $requette1="SELECT Nomingredient FROM Ingredients  "; 
              $requette="SELECT Quantitee FROM Compostions Where Idrecette=1"; 
              $requette2="SELECT commentaire FROM Commentaires ";
              $table_resultat =  mysqli_query($connexion,$requette);
            // affichage chaque recettes
            if($table_resultat){
                echo ("Bienvenue sur mon site ");

                while($ligne=mysqli_fetch_object($table_resultat))
           
                {
                echo ("<h1>".$ligne->Nomrecette."</h1><img src=".$ligne->Imagepath."><br>");
                }

            }else{
                echo "<p>Erreur dans l'exécution de la requette</p>";
                echo"message de mysqli:".mysqli_error($connexion);
            }

                // affichage chaque Ingrediens 
            $table_resultat =  mysqli_query($connexion,$requette1);

                      
            if($table_resultat){
                echo ("Ingredients :<br>");

                while($ligne=mysqli_fetch_object($table_resultat))
           
                {
                echo ("<h1>".$ligne->Nomringredient."</h1><img src=".$ligne->Imagepath."><br>");
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