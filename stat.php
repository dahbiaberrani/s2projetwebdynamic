<html>
    <head>
        <meta charset="utf-8" />
        <title>mise à jour de recette</title>
        <link rel="stylesheet" type="text/css"  href="./style/style.css" media="all">
        
    </head>
    <body>
        
        <?php
            include_once("./libDataBase.php");
            include_once("./entete.php");
            echo "<div id=\"formulaire_recette\">";
                
                // Connexion à la base de données              
                $connexion= my_connect();
                    
                // resultat recherche nombre des entreés, des plats et des desserts
                $requette_groupBy = "SELECT count(Idrecette) AS nombre_recette,Nomcategorie FROM `Recettes` group by Nomcategorie";
                $resultat =  mysqli_query($connexion,$requette_groupBy);
                // affichage chaque recette
                if($resultat){
                    echo " <h4>statistiques du site:</h4>";
                    echo " <table border ><tr colspan=2><th>nombre recette</th> <th>categorie</th></tr>";

                    while($ligne=mysqli_fetch_object($resultat)){
                        echo "<tr ><td>".$ligne->nombre_recette."</td><td>".$ligne->Nomcategorie."</td></tr>";
                    }
                    echo "</table></th></br>";
                } 
                else{
                    echo "<p>Erreur dans l'exécution de la requette</p>";
                    echo"message de mysqli:".mysqli_error($connexion);
                }


                // resultat  de recherche sur nombre de commentaires de chaque recette 
                $requette_groupBy2 = "SELECT Nomrecette, count(Idcommentaire) AS nbCommentaire FROM Commentaires join Recettes USING(Idrecette) group by Idrecette";
                $resultat =  mysqli_query($connexion,$requette_groupBy2);
                // affichage de chaque recettes
                if($resultat){
                    
                    echo " <table border ><tr><th>Nom recette</th> <th>nombre commentaire</th></tr>";

                    while($ligne=mysqli_fetch_object($resultat)){
                        echo "<tr ><td>".$ligne->Nomrecette."</td><td>".$ligne->nbCommentaire."</td></tr>";
                    }
                    echo "</table></th>";
                }
                else{
                    echo "<p>Erreur dans l'exécution de la requette</p>";
                    echo"message de mysqli:".mysqli_error($connexion);
                }
                mysqli_close($connexion);
            echo "</div>";
            include_once("./pied_de_page.html");
        ?>
    </body>
</html>