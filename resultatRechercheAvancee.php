<?php 
      
      include_once("./entete.html"); 
      include_once("./libRecherche.php");


    $res = $_GET['categorie'];
    $res_cout = $_GET['cout'];
    // afichage des recettes par catégorie 

    if  ( $res === "*"){
        echo"Ces recettes peuvent t'intéresser :";
        affichertout_prix($res_cout) ;

    }elseif  ($res === "entre"){
        echo"Ces recettes peuvent t'intéresser :";
        afficherEntre_prix($res_cout);    
    }elseif  ($res === "dessert"){
        echo"Ces recettes peuvent t'intéresser :";
        affichedessert_prix($res_cout);
    }elseif  ($res === "plat"){
        echo"Ces recettes peuvent t'intéresser :";
        afficheplat_prix($res_cout);
    }
    
?>