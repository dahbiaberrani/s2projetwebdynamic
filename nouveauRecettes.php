<?php  
  

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
        unset($_SESSION["mes_ingredients"]);
        $_SESSION=array();
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

    $connexion=mysqli_connect('mi-mariadb.univ-tlse2.fr','dahbia.berrani-eps-h','Akbou_2021');
    if (!$connexion) {
        echo("Desolé, connexion au serveur impossible\n");
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

       <label for="NomIngredient">Nom Ingredient</label>
        <select  id="NomIngredient" name="NomIngredient" type="text" > </br> 
        <option value=" " ></option></br>

<?php 
   
    $connexion=mysqli_connect('mi-mariadb.univ-tlse2.fr','dahbia.berrani-eps-h','Akbou_2021');
    if (!$connexion) {
        echo("Desolé, connexion au serveur impossible\n");
        exit;
      }
    if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
        echo("Désolé, accès à la base  impossible\n");
        exit;
    }
    mysqli_set_charset($connexion, "utf8");
    $requette2=("SELECT  Nomingredient From Ingredients");      
    $resultat =  mysqli_query($connexion,$requette2);
   
        if($resultat){
        
            while($ligne=mysqli_fetch_object($resultat)){
    
             echo ("<option value=\"".$ligne->Nomingredient."\">  ".$ligne->Nomingredient . "</option>\n");
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
            $nomIngredient = $_POST['NomIngredient'];
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
                // and print out the values
                echo $key.":".$quantite."".$unite;
                
                echo"</li>";
            }
            echo"</ul>";
        } 
?>

     <!-- ajouter etapes de prepartion recette  -->
   <label for="etapes">Etapes de preparation</label></br>
    <textarea  id="etapes" name="etapes" cols="50" rows="20" > <?php if (!isset($_POST['annuler'])){ echo $_POST['etapes'];} ?></textarea></br>  

	
    <input value="Envoyer" type="submit"/> 
    <input value="annuler" type="submit"/> 

    </form>



 </body>

</html>