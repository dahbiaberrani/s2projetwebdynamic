<?php 
    
   
      include("entete.html"); include("toutrecette.php");include("entre.php");include("dessert.php");include("plat.php");

    $res = $_GET['categorie'];
  // afichage des recettes par catégorie 

    if  ( $res == "*"){
        echo"Ces recettes peuvent t'intéresser :";
        affichertout() ;

    }elseif  ($res == "entre"){
        echo"Ces recettes peuvent t'intéresser :";
        afficherEntre();    
    }elseif  ($res == "dessert"){
        echo"Ces recettes peuvent t'intéresser :";
        affichedessert();
    }elseif  ($res == "plat"){
        echo"Ces recettes peuvent t'intéresser :";
        afficheplat();
    }
?>