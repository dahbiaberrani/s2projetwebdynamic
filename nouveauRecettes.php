<?php  

include_once('./libDataBase.php') ;
   /**
   * @return bool
   */
    function is_session_started(){
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
           } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
    
        return FALSE;
    }



    // Ouverture d'une session
    if ( is_session_started() === FALSE ){
        session_start();
    } 

    if (isset($_POST['annuler'])){
        //Annulation de toutes les variable de session
        session_destroy(); 
    }

     
?>

<html>

<head>

</head>

 <body>

    <h2>Ajouter des nouveau recettes</h2></br>

  <form action="nouveauRecettes.php" method="POST">
    <!-- Nom recette -->
        <label for="NomRecette">Nom Recette</label>
        <input  id="NomRecette" name="NomRecette" type="text" value="<?php if (!isset($_POST['annuler'])){ echo $_POST['NomRecette'];} ?>" > </br>

    <!-- choix Catégorie recette -->
         <label for="categorie">catégorie:</label> 
   <select  id="categorie" name="categorie" type="text"> 
     <option value="" ></option></br>
<?php 

        //connexion à la base de donnees 
        // include 'libDataBase.php';;
        //connexion à la base de donnees 
        //$connexion= my_connect();
        $connexion=mysqli_connect('mi-mariadb.univ-tlse2.fr','dahbia.berrani-eps-h','Akbou_2021');
        if (!connexion){
            echo ("désolé,connexion au serveur impossible\n");
            exit;
        }
    if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
        echo("Désolé, accès à la base  impossible\n");
        exit;
    }
    mysqli_set_charset($connexion, "utf8");
    $requette1=("SELECT  Nomcategorie From Categories");      
    $resultat =  mysqli_query($connexion,$requette1);
    if($resultat){
        
        while($ligne=mysqli_fetch_object($resultat)){
            if(  $_POST['categorie']==$ligne->Nomcategorie){
                echo ("<option value=\"".$ligne->Nomcategorie."\"selected=\"selected\">".$ligne->Nomcategorie ."</option>\n");
                
            }
            else{
                echo ("<option value=\"".$ligne->Nomcategorie."\"> ".$ligne->Nomcategorie ."</option>\n");
            }
            
        }

    }else{
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo"message de mysqli:".mysqli_error($connexion);
    }
?>
</select></br>
     <!-- ajouter nombre de personne  -->
    <label for="NombrePersonne ">Nombre personne </label>
    <input  id="NombrePersonne" name="NombrePersonne" type="number" value="<?php if (!isset($_POST['annuler'])){ echo $_POST['NombrePersonne'];} ?>"> </br>

       <!-- selectionner les ingredient de recettes  -->
    
       <label for="Idingredient">Nom Ingredient</label>
        <select  id="Idingredient" name="Idingredient" type="numbre" > </br> 
        <option value=" " ></option></br>

<?php 
   
        //connexion à la base de donnees 
     
        //connexion à la base de donnees 
        $connexion= my_connect();

    if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
        echo("Désolé, accès à la base  impossible\n");
        exit;
    }
    mysqli_set_charset($connexion, "utf8");
    $requette2=("SELECT  Nomingredient,Idingredient From Ingredients");      
    $resultat =  mysqli_query($connexion,$requette2);
   
        if($resultat){
        
            while($ligne=mysqli_fetch_object($resultat)){
    
             echo ("<option value=\"".$ligne->Idingredient."\">  ".$ligne->Nomingredient . "</option>\n");
            }
        }else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
?>
   </select>
            <!-- ajouter la quantite   -->
    <label for="Quantite">Quantite </label>
    <input  id="Quantite" name="Quantite" type="numbre" >

    <!-- selctionner unite -->
    <label for="unite"> unité </label>
    <select  id="unite" name="unite" type="text" > 
        <option value="g" name="g" type="text">g</option>
        <option value="ml" name="ml" type="text">ml</option>
        <option value=" " name="sans unite" type="text" >unité</option>
    </select></br>
        <input  type="submit"  value="ajouter" name="ajouter"/> 


     
<?php

 
    $unite = $_POST['unite'];
    $quantite = $_POST['Quantite'];
        if(!isset($_SESSION["mes_ingredients"])){
            $_SESSION["mes_ingredients"] = array() ;
        }
 
        if (isset($_POST['ajouter'])){
            $nomIngredient = $_POST['Idingredient'];
            //$nomRecette = $_POST['NomRecette'];
            //sauvegarde de la saisie de l'utilsateur 
            $_SESSION["mes_ingredients"]+=array($nomIngredient=>$quantite);
           // $_SESSION["nom_recette"]= $nomRecette;
           


            echo"ingredient ajouter à la recette: </br> ";
         
           //echo $_SESSION["mes_ingredients"];
           // loop through the session array with foreach
           echo"<ul>";
            foreach($_SESSION["mes_ingredients"] as $key=>$quantite){
                echo"<li>";
               
                // recupérer Nom ingredient 

                echo getIngredientNameById($key).":".$quantite."".$unite;
                
                echo"</li>";
            }
            echo"</ul>";
        } 
?>

     <!-- ajouter etapes de prepartion recette  -->
   <label for="etapes">Etapes de preparation</label></br>
    <textarea  id="etapes" name="etapes" cols="50" rows="20" > <?php if (!isset($_POST['annuler'])){ echo $_POST['etapes'];} ?></textarea></br>  
    
   
    <input value="Envoyer" name="Envoyer" type="submit"/> 
    <input value="annuler" name="annuler" type="submit"/> 

    </form>

 <!-- ajouter des recette sur la base  -->
 <?php 
    

    //connexion à la base de donnees 
    $connexion= my_connect();
    if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
        echo("Désolé, accès à la base  impossible\n");
        exit();
    }
  

    $Nomrecette = $_POST["NomRecette"];
    $categorie = $_POST["categorie"];
    $NombrePersonne = $_POST["NombrePersonne"];
    $Idingredient = $_POST["Idingredient"];
    $Quantite = $_POST["Quantite"];
    $unite = $_POST["unite"];
    $etapes= $_POST["etapes"];
    mysqli_set_charset($connexion, "utf8");


   /* $req_Id_ingredient=(" SELECT MAX(Idingredient) as NbING From Ingredients");     
    $resultat =  mysqli_query($connexion,$req_Id_ingredient);
    if ($resultat){
        $emp = mysqli_fetch_object($resultat);
        $Id_ingredient = $emp-> NbING +1;
    }else{
        echo "<p>Erreur dans l'exécution de la requette</p>";
        echo"message de mysqli:".mysqli_error($connexion);
    }*/


    if (isset($_POST['Envoyer'])){
        if (empty( $_POST["NomRecette"]) or empty($_POST["categorie"]) or empty($_POST["NombrePersonne"]) or empty($_POST["Idingredient"]) or empty($_POST["Quantite"]) or empty( $_POST["unite"]) or empty($_POST["etapes"])){
      
            echo"<h1 >Formulaire incomplet</h1>";
            
        }else{
            $requette1=("INSERT INTO `Recettes` ( `Nomrecette`, `Etapes`, `Nomcategorie`, `Nombrepersonne`) 
                VALUES  (\"".$Nomrecette."\",\"".$etapes."\",\"".$categorie."\" ,\"".$NombrePersonne."\")");

            $req_Id_recette=(" SELECT MAX(Idrecette) as Nbrecette From Recettes");     
            $resultat0 =  mysqli_query($connexion,$req_Id_recette);
            if ($resultat0){
                $emp = mysqli_fetch_object($resultat0);
                $Id_recette = $emp-> Nbrecette;
            }else{
                echo "<p>Erreur dans l'exécution de la requette</p>";
                echo"message de mysqli:".mysqli_error($connexion);
            }
    
            $requette2= "INSERT INTO `Compositions` (`Idingredient`, `Idrecette`, `Quantitee`, `Unite`) 
                    VALUES (\"". $Idingredient."\", \"". $Id_recette."\", \"".  $Quantite."\", \"".  $unite."\" )";

            $resultat1 = mysqli_query($connexion,$requette1);
            $resultat2 = mysqli_query($connexion,$requette2);
            if ($resultat1)  {
                echo" recette Ajouter";
                if ($resultat2)  {
                    echo" compostion Ajouter";
                }
            }else{
                echo "<p>Erreur dans l'exécution de la requette</p>";
                echo"message de mysqli:".mysqli_error($connexion);
            }

        }
        

   
    }
?>


 </body>

</html>