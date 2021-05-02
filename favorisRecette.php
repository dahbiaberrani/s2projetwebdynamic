<html>
    <body>
        <?php 
            include_once("./entete.php");
            include_once("./libRecherche.php");

            // Protection si jamais on s'amuse à appeler direcetement cette page dans l'url sans s'authentifier
            if(!isset($_SESSION["userid"])){
                header('Location: ./index.php');
                exit();
            }
            // afichage des recettes à modérer
            afficherRecetteFavorites();
            include_once("./pied_de_page.html");

        ?>
    </body>
</html>