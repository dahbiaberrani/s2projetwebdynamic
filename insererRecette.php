<?php 

    include 'libDataBase.php';     
    $connexion= my_connect();
   

    if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
        echo("Désolé, accès à la base  impossible\n");
        exit();
    }
    
    
  
  //  if (empty($_POST["real"]) or empty($_POST["titre"]) or empty($_POST["genre"]) or empty($_POST["annee"])){
       
      //  echo"Formulaire incomplet";
      //  exit();
   // }
    $newrecette = $_POST["categorie"];
    $nom = $_POST["Nom"];
    $nbpersonne = $_POST["Nombrepersonne"];
    $etapes = $_POST["etapes"];

    $nomingredient = $_POST["NomIngredient"];
    $prix = $_POST["Prix"];
    $quantite = $_POST["Quantite"];
    $unite = $_POST["unite"];
    

    mysqli_set_charset($connexion, "utf8");
   
   

    $requette2=(" INSERT INTO `Ingredients` (`Idingredient`, `Nomingredient`, `Prix`) 
                 VALUES (\"".$nomingredient."\",\"".$prix."\")");
    $resultat2 = mysqli_query($connexion,$requette2);
    if ($resultat2){
        echo"ingredient ajouter";

    }else{
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo"message de mysqli:".mysqli_error($connexion);
    }
    
?>