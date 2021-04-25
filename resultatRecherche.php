<?php
    session_start();
    include_once("./entete.php");
 ?>
<html>
<body>
<?php 
    
      
    
    include_once("./libRecherche.php");
     

    $res = $_GET['categorie'];
    $res_cout = $_GET['cout'];
    $_SESSION["categorie"] = $res;
    $_SESSION["cout"] = $res_cout;

    // afichage des recettes par catégorie 
    if ($res_cout === "*"){

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
    } else{
        $res_cout = $_GET['cout'];
        if ($res_cout == "moins_3"){
            $cout = 3;
    
        }elseif ($res_cout == "moins_5"){
            $cout = 5;
        }elseif ($res_cout == "moyen_10"){
            $cout = 10;
        }
        if  ( $res === "*"){
            echo"Ces recettes peuvent t'intéresser :";
            afficherTout_prix($cout ) ;
    
        }elseif  ($res === "entre"){
            echo"Ces recettes peuvent t'intéresser :";
            afficherEntre_prix($cout);    
        }elseif  ($res === "dessert"){
            echo"Ces recettes peuvent t'intéresser :";
            afficherDessert_prix($cout );
        }elseif  ($res === "plat"){
            echo"Ces recettes peuvent t'intéresser :";
            afficherPlat_prix($cout);
        }
    }

 include_once("./pied_de_page.html");

    
?>
</body>
</html>