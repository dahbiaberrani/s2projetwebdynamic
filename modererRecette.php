<?php 
    session_start();
    include_once("./libDataBase.php");
    if (isset($_GET["refuser"])){
        $_idRecette = $_GET["refuser"];
        refuserRecette($_idRecette);
    }

    if (isset($_GET["accepter"])){
        $_idRecette = $_GET["accepter"];
        accepterRecette($_idRecette);
    }
?>
<html>
    <body>
        <?php 
            include_once("./entete.php");
            include_once("./libRecherche.php");

            // afichage des recettes à modérer
            afficherRecetteAModerer();
            include_once("./pied_de_page.html");

        ?>
    </body>
</html>