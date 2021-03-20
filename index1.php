  
<!DOCTYPE html lang="fr">
<html>
    <head>
        <meta charset="utf-8" >
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
             
	                $connexion=mysqli_connect('mi-mariadb.univ-tlse2.fr','dahbia.berrani-eps-h', 'Akbou_2021');
        
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
              $requette="SELECT Recettes.Nomrecette,Recettes.Imagepath,Ingredients.Nomingredient,Compositions.Quantitee,Recettes.Etapes FROM `Ingredients` join Compositions USING(Idingredient) JOIN Recettes USING(Idrecette) ";      
              $requette2="SELECT commentaire FROM Commentaires ";
              $table_resultat =  mysqli_query($connexion,$requette2);
            // affichage chaque recettes
            if($table_resultat){
                echo ("Bienvenue sur mon site ");

                while($ligne=mysqli_fetch_object($table_resultat))
           
                {
                
                
           
                //echo ("<h1>".$ligne->Nomrecette."</h1><img src=".$ligne->Imagepath."><br>".$ligne->Nomingredient."". $ligne->Quantitee."g<br>");
                //echo ("<p>".$ligne->Etapes."</p>");
                echo ("<p>".$ligne->commentaire."</p>");
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