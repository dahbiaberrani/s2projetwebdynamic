

<?php 
     include_once("entete.html");
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

     // resultat recherche nombre des entre des plat et de dessert
     $requette_groupBy = "SELECT count(Idrecette) AS nombre_recette,Nomcategorie FROM `Recettes` group by Nomcategorie";
     $resultat =  mysqli_query($connexion,$requette_groupBy);
    // affichage chaque recettes
    if($resultat){
        echo " <h4>statistiques du site:</h4>";
        echo " <table border ><tr colspan=2><th>nombre recette</th> <th>categorie</th></tr>";

        while($ligne=mysqli_fetch_object($resultat)){
            echo "<tr ><td>".$ligne->nombre_recette."</td><td>".$ligne->Nomcategorie."</td></tr>";
        }
        echo "</table></th></br>";
    } else{
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo"message de mysqli:".mysqli_error($connexion);
    }


    // resultat  de recherche sur nombre de commentaire chaque recette 
    $requette_groupBy2 = "SELECT Nomrecette, count(Idcommentaire) AS nbCommentaire FROM Commentaires join Recettes USING(Idrecette) group by Idrecette";
    $resultat =  mysqli_query($connexion,$requette_groupBy2);
   // affichage chaque recettes
   if($resultat){
       
       echo " <table border ><tr><th>Nom recette</th> <th>nombre commentaire</th></tr>";

       while($ligne=mysqli_fetch_object($resultat)){
           echo "<tr ><td>".$ligne->Nomrecette."</td><td>".$ligne->nbCommentaire."</td></tr>";
       }
       echo "</table></th>";
    }else{
       echo "<p>Erreur dans l'exécution de la requette</p>";
       echo"message de mysqli:".mysqli_error($connexion);
    }


?>