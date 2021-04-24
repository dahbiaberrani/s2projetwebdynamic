<?php 
    
      
      include_once("entete.html"); include_once("toutrecette.php");include_once("entre.php");include_once("dessert.php");include_once("plat.php");

    $res = $_GET['categorie'];
    $res_cout = $_GET['cout'];
    // afichage des recettes par catégorie 

    if  ( $res === "*"){
        echo"Ces recettes peuvent t'intéresser :";
        affichertout() ;

    }elseif  ($res === "entre"){
        echo"Ces recettes peuvent t'intéresser :";
        afficherEntre();    
    }elseif  ($res === "dessert"){
        echo"Ces recettes peuvent t'intéresser :";
        affichedessert();
    }elseif  ($res === "plat"){
        echo"Ces recettes peuvent t'intéresser :";
        afficheplat();
    }
    
    //recherche par cout définie :
    include_once("libDataBase.php");
    
    if (empty($res_cout)){
        echo "veuillier selectionnée un crètère de recherche";
       
    }else{
        echo"Ces recettes peuvent t'intéresser :";
        echo afficherParCout();
    }
    
?>