<?php
    session_start();
 ?>
<html>
    <body>
        <?php 
            include_once("./entete.php");
            include_once("./libRecherche.php");
            
            $categorie = $_GET['categorie'];
            $res_cout = $_GET['cout'];
            $_SESSION["categorie"] = $categorie;
            $_SESSION["cout"] = $res_cout;

            // afichage des recettes par catégorie 
            if (empty($res_cout)) {

                if  ( $categorie === "*"){
                    echo"Ces recettes peuvent t'intéresser :";
                    affichertout() ;

                }elseif  ($categorie === "entree"){
                    echo"Ces recettes peuvent t'intéresser :";
                    afficherEntre();    
                }elseif  ($categorie === "dessert"){
                    echo"Ces recettes peuvent t'intéresser :";
                    affichedessert();
                }elseif  ($categorie === "plat"){
                    echo"Ces recettes peuvent t'intéresser :";
                    afficheplat();
                }
            } 
            else {
                $cout = floatval($res_cout);
                
                if  ( $categorie === "*"){
                    echo"Ces recettes peuvent t'intéresser :";
                    afficherTout_prix($cout) ;
            
                }elseif  ($categorie === "entree"){
                    echo"Ces recettes peuvent t'intéresser :";
                    afficherEntre_prix($cout);    
                }elseif  ($categorie === "dessert"){
                    echo"Ces recettes peuvent t'intéresser :";
                    afficherDessert_prix($cout);
                }elseif  ($categorie === "plat"){
                    echo"Ces recettes peuvent t'intéresser :";
                    afficherPlat_prix($cout);
                }
            }

            include_once("./pied_de_page.html");

        ?>
    </body>
</html>