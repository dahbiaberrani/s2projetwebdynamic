<?php session_start();?>
<!DOCTYPE html>
    <html lang="en">
        <?php include_once("./entete.php");?>
        <h1 id="headererror"><?php 
                $_error = $_GET["error"] ;
                if ($_error==="pass_word"){
                    echo "mot de pass incorrecte ";
                }
                if ($_error==="account_not_found"){
                    echo "compte inexistant, veuillez vous inscrire ";
                }
                
        ?></h1>
        <body>

        <div class="login-form">
             
            
            <form action="./traitement_connexion.php" method="post">
                <h2 class="text-center">Connexion</h2>       
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                </div>   
            </form>
            <p class="text-center"><a href="./inscription.php">Inscription</a></p>
        </div>
        
        <?php include_once("./pied_de_page.html")?>
        </body>
</html>