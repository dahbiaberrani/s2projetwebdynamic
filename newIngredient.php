<html>
    <head>
    </head>
    <body>
            <div id="nouv_ingredient">
                <form action="newIngredient.php" method="POST">
                <div>
                    <label for="nouv_ingredient">nom ingredient:</label>
                    <input  id="nouvIngredient" name="nouvIngredient" type="text" value="<?php if (!isset($_POST['annuler'])){ echo $_POST['nouvIngredient'];} ?>" > 
                    <p> veuillier saisir le prix par kilogramme, par litre ou par unité </p>
                    <label for="prix"> prix ingredient:</label>
                    <input  id="prix" name="prix" type="number" step="0.01" value="<?php if (!isset($_POST['annuler'])){ echo $_POST['prix'];} ?>" > 
                </div> 
                <div>
                    <input value="ajouter" name="ajouter" type="submit"/> 
                    <input value="annuler" name="annuler" type="submit"/> 
                <div>
                </form>
            </div>
    </body>     
</html>

<?php
        include_once('./libDataBase.php') ;
        //connexion à la base de donnees 
        $connexion= my_connect();
        if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
            echo("Désolé, accès à la base  impossible\n");
            exit();
        }
        mysqli_set_charset($connexion, "utf8");


        $Prix = $_POST["prix"];
        $NomIngredient=$_POST["nouvIngredient"];

        $req_Id_ingredient=(" SELECT MAX(Idingredient) as NbING From Ingredients");     
        $resultat =  mysqli_query($connexion,$req_Id_ingredient);
        if ($resultat){
            $emp = mysqli_fetch_object($resultat);
            $Id_ingredient = $emp-> NbING +1;
        }else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
        $requette3=("INSERT INTO `Ingredients` (`Idingredient`, `Nomingredient`, `Prix`)
                    VALUES  (\"".$Id_ingredient."\",\"".$NomIngredient."\",\"".$Prix."\")");


    if (isset($_POST['ajouter'])){
        if   (empty($_POST["prix"]) or empty($_POST["nouvIngredient"])){
      
            echo"<h1 >Formulaire incomplet</h1>";
            
        }else{
    

            $resultat3 = mysqli_query($connexion,$requette3);
                                
            if ($resultat3)  {
                echo" ingredient ajouter ";
            }else{
                echo "<p>Erreur dans l'exécution de la requette d'ajout de la ingredient</p>";
                echo"message de mysqli:".mysqli_error($connexion);

            }

        }
    }
?>