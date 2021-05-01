<?php  
    session_start();
    include_once('./libDataBase.php') ;

    // Charegement de l'image sélectionnée sur le serveur dans le répertoire images.
    if (isset($_POST['uploadImage'])){
        // Tableaux de donnees
        $tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
        $infosImg = array();
        
        // Variables
        $extension = '';
        $nomImage = '';
       
        // On verifie si le fichier est bien sélectionné
        if( !empty($_FILES['fichier']['name']) )
        {
            // Recuperation de l'extension du fichier
            $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);

            // On verifie l'extension du fichier pour être sûr que c'est une image
            if(in_array(strtolower($extension),$tabExt))
            {
                // On recupere les infotrmations du du fichier
                $infosImg = getimagesize($_FILES['fichier']['tmp_name']);

                // On verifie le type ndu ficheir que c'est une l'image
                if($infosImg[2] >= 1 && $infosImg[2] <= 14)
                {
                    // On renomme le fichier pour lui donner un nom unique
                    // Pour ne pas ecraser une image qui aurait par hasard le même nom
                    $nomImage = "./images/".md5(uniqid()).'.'.$extension;  
                    if (move_uploaded_file($_FILES['fichier']['tmp_name'], $nomImage)) {
                        $_SESSION['imagePath'] = $nomImage;
                    }
                    else {
                        // Sinon il y a une erreur
                        $_erreur = "UploadImage";            
                    }
                    
                }
                else {
                    // Sinon erreur sur le type de l'image
                    $_erreur = "TypeImage";          
                }
            }
            else {
                // Sinon on affiche une erreur pour l'extension
                $_erreur = "ExtentionImage";         
            }
        }
        else {
            // Sinon on affiche une erreur pour le champ vide
            $_erreur = "NoFileImage";
        }
    }
    
    // Récupération des inforamtios saisies
    $Nomrecette = $_POST["NomRecette"];
    $categorie = $_POST["categorie"];
    $NombrePersonne = $_POST["NombrePersonne"];
    $Idingredient = $_POST["Idingredient"];
    $Quantite = $_POST["Quantite"];
    $unite = $_POST["unite"];
    $etapes = $_POST["etapes"];

    // Ajout de la recette à la base de données
    if (isset($_POST['Envoyer'])){
        if (!isset($_SESSION['imagePath'])) {
            $_erreur = "NoImage";
        }
        elseif (empty($_POST["NomRecette"])) {
            $_erreur = "NomRecette";
        }
        elseif(empty($_POST["categorie"])) {
            $_erreur = "categorie";
        }
        elseif (empty($_POST["NombrePersonne"])) {
            $_erreur = "NombrePersonne";
        }
        elseif(count($_SESSION["mes_ingredients"])==0) {
            $_erreur = "mes_ingredients";
        }
        elseif(!(isset($_POST['etapes']) && !empty($_POST['etapes']))) {
            $_erreur = "etapes";
        } 
        else {
            $_erreur = "FALSE";
                //connexion à la base de donnees 
                $connexion= my_connect();

            // Insertion de la nouvelle recette
            $cout_recette = calculCout($_SESSION["mes_ingredients"],$_SESSION["uniteMesure"]);
            $requette1=("INSERT INTO `Recettes` ( `Nomrecette`, `Etapes`, `Nomcategorie`, `Nombrepersonne`,`Cout`, `Imagepath`) 
                VALUES  (\"".$Nomrecette."\",\"".$etapes."\",\"".$categorie."\" ,\"".$NombrePersonne."\" ,\"".$cout_recette."\" ,\"".$_SESSION['imagePath']."\")");
            
            $resultat1 = mysqli_query($connexion,$requette1); 
                        
            if ($resultat1)  {
                // récuperation de l'id de la recette qui vient d'être crée
                $req_Id_recette=(" SELECT MAX(Idrecette) as Nbrecette From Recettes") ;     
                $resultat0 =  mysqli_query($connexion,$req_Id_recette);
                if ($resultat0){
                    $emp = mysqli_fetch_object($resultat0);
                    $Id_recette = $emp-> Nbrecette;
                }else{
                    echo "<p>Erreur dans l'exécution de la requette</p>";
                    echo"message de mysqli:".mysqli_error($connexion);
                }
    

                // Iinsertion des ingrédients de la recettes
                foreach($_SESSION["mes_ingredients"] as $key=>$quantite){
                    $requette2= "INSERT INTO `Compositions` (`Idingredient`, `Idrecette`, `Quantitee`, `Unite`) 
                            VALUES (\"". $key."\", \"". $Id_recette."\", \"".  $quantite."\", \"".  $_SESSION["uniteMesure"][$key]."\" )";
                    $resultat2 = mysqli_query($connexion,$requette2);
                    
                    if (!$resultat2) {
                        echo "<p>Erreur dans l'exécution de la requette d'ajout d'ingredient dans la composition'</p>";
                        echo"message de mysqli:".mysqli_error($connexion);
                        exit();
                    }
                }

                //Annulation de toutes les variable de session relatives a l'ajout de recette
                unsetRecetteVariables(); 
                header('Location: ./resultatRecherche.php?categorie='.strtolower($categorie).'#'.$Id_recette);   
                
                // Déconnexion de la base de données
                mysqli_close($connexion);
                exit();
            }else{
                echo "<p>Erreur dans l'exécution de la requette d'ajout de la recette</p>";
                echo"message de mysqli:".mysqli_error($connexion);
                // Déconnexion de la base de données
                mysqli_close($connexion);
                exit();
            }
        }
    } 

    
    
    //fonction d'annulation de toutes les variable de session relatives a l'ajout de recette
    function unsetRecetteVariables(){
        unset($_SESSION["mes_ingredients"]);
        unset($_SESSION["uniteMesure"]);
        unset($_SESSION['imagePath']);
    }
    if (isset($_POST['annuler'])){
        //Annulation de toutes les variable de session relatives a l'ajout de recette
        unsetRecetteVariables();
    }

    include_once("./entete.php");  
    
    //gestion des erreurs du formulaire
    if ($_erreur === "NoFileImage"){
        echo "<h1 id=\"headererror\" >Veuillez sélectionner une image !</h1>";
    }
    elseif($_erreur === "ExtentionImage"){
        echo "<h1 id=\"headererror\" >L'extension du fichier est incorrecte !</h1>"; 
    } 
    elseif($_erreur === "TypeImage"){
        echo "<h1 id=\"headererror\" >Le fichier sélectionné n'est pas une image !</h1>";
    } 
    elseif($_erreur === "UploadImage"){
        echo "<h1 id=\"headererror\" >Problème lors du chargement <br> Veuillez réessayer !</h1>"; 
    }
    elseif($_erreur === "NoImage"){
        echo"<h1 id=\"headererror\" >Veuillez charger une image de la recette</h1>";
    } 
    elseif ($_erreur === "NomRecette"){
        echo"<h1 id=\"headererror\" >Nom de la recette incomplet</h1>";
    }
    elseif($_erreur === "categorie"){
        echo"<h1 id=\"headererror\" >Catégorie de la recette incomplet</h1>";
    }
    elseif ($_erreur === "NombrePersonne"){
        echo"<h1 id=\"headererror\" >Nombre de personnes de la recette invalide</h1>";
    }
    elseif($_erreur === "mes_ingredients"){
        echo"<h1 id=\"headererror\" >ingrédients de la recette incomplet</h1>";
    }
    elseif($_erreur === "etapes"){
        echo"<h1 id=\"headererror\" >Les étapes de la recette incompletes</h1>";
    } 

    
?>

<html>
    <body>
        <h2>Ajout d'une nouvelle recette</h2></br>
        <div id="formulaire_recette">
            <form enctype="multipart/form-data" action="./nouvelleRecette.php" method="POST">
                <!-- Formulaire pour ajouter la photo de la recette -->
                <fieldset>
                    <legend>Ajout de la photo</legend>
                    <p>
                        <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Sélectionnez une image :</label>
                
                        <input name="fichier" type="file" id="fichier_a_uploader" />
                        <input type="submit" name="uploadImage" value="Charger" />
                    </p>
                </fieldset>

                <!-- Afficahge de l'image si elle à été rajoutée -->
                <?php 
                    if (isset($_SESSION['imagePath'])){
                        echo "<img class =\"center\" src=\"".$_SESSION['imagePath']."\">";  
                    }
                ?>
                <br>
                <!-- Nom recette -->
                <div id="nom_recette">
                    <label for="NomRecette">Nom Recette</label>
                    <input  id="NomRecette" name="NomRecette" type="text" value="<?php if (!isset($_POST['annuler'])){ echo $_POST['NomRecette'];} ?>" > 
                    
                </div>
                <!-- choix Catégorie recette -->
                <div id="categorie">
                    <label for="categorie">catégorie:</label> 
                    <select  id="categorie" name="categorie" type="text"> 
                        <option value="" ></option>
                        <!-- code php pour recuprer la liste des catégorie existantes dans la base de donnee  -->   
                        <?php        
                            $connexion= my_connect();
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

                            // Déconnexion de la base de données
                            mysqli_close($connexion);
                        ?>
                    </select></br>
                </div>

                <div id="nbpersonne">
                    <!-- ajouter nombre de personne  -->
                    <label for="NombrePersonne ">Nombre personne </label>
                    <input  id="NombrePersonne" name="NombrePersonne" type="number" value="<?php if (!isset($_POST['annuler'])){echo$_POST['NombrePersonne'];}?>"> 
                </div>
                

                <div id="ingredient">
                    <!-- selectionner les ingredient de recettes  -->
                    <label for="Idingredient">Nom Ingredient</label>
                    <select  id="Idingredient" name="Idingredient" type="numbre" > 
                    <option value="" ></option>

                    <!-- code php pour recuprée la liste des ingredient  de la base de donnee  -->   
                    <?php 
                        
                        //connexion à la base de donnees 
                        $connexion= my_connect();
                        $requette2=("SELECT  Nomingredient,Idingredient From Ingredients");      
                        $resultat =  mysqli_query($connexion,$requette2);
                        if($resultat){ 
                            while($ligne=mysqli_fetch_object($resultat)){
                            echo ("<option value=\"".$ligne->Idingredient."\">  ".$ligne->Nomingredient . "</option>\n");
                            }
                        }
                        else{
                            echo "<p>Erreur dans l'exécution de la requette</p>";
                            echo"message de mysqli:".mysqli_error($connexion);
                        }

                        // Déconnexion de la base de données
                        mysqli_close($connexion);
                    ?>
                    </select>
                    
                    <!-- ajouter la quantite   -->
                    <label for="Quantite">Quantite </label>
                    <input  id="Quantite" name="Quantite" type="number" >

                    <!-- selctionner unite -->
                    <label for="unite"> unite </label>
                    <select  id="unite" name="unite" type="text" > 
                    <option value="" name="ml" type="text"></option>
                    <option value="g" name="g" type="text">g</option>
                    <option value="ml" name="ml" type="text">ml</option>
                    <option value="unite" name="sans unite" type="text" >unité</option></select>
                    <input  type="submit"  value="ajouter l'ingredient" name="ajouter"/>
                </div>            
                <div>
                <!-- ajouter un nouveau ingredient   -->
                <p>Vous ne trouvez pas votre ingrédient?:<a href="./newIngredient.php" target="_blank">Ajouter un nouveau ingrédient</a></p>
                <!-- code php pour afficher les ingredients en forme d'un tableau   -->   
                <?php 
                
                    $unite = $_POST['unite'];
                    $quantite = $_POST['Quantite'];
                    if(!isset($_SESSION["mes_ingredients"])){
                        $_SESSION["mes_ingredients"] = array() ;
                        $_SESSION["uniteMesure"] = array();
                    }

                    if (isset($_POST['ajouter']) && !empty($_POST['unite']) && !empty($_POST['Quantite']) && !empty($_POST['Idingredient'])){

                        $idIngredient = $_POST['Idingredient'];
                        $_SESSION["mes_ingredients"]+= array($idIngredient=>$quantite);
                        $_SESSION["uniteMesure"] += array($idIngredient=>$unite);
                       
                    } 

                    echo "cout de la recette: <strong>"  .calculCout($_SESSION["mes_ingredients"],$_SESSION["uniteMesure"])."€</strong><br>";
                    echo"ingrédients de la recette: </br> ";
                    echo"<ul>";
                    foreach($_SESSION["mes_ingredients"] as $key=>$quantite){
                        echo"<li>";
                        // recupérer Nom ingredient et affichage sur la page des inforamtions
                        if ($_SESSION["uniteMesure"][$key] === "unite") {
                            echo "<strong>".getIngredientNameById($key)."</strong>: ".$quantite;
                        }
                        else {
                            echo "<strong>".getIngredientNameById($key)."</strong>: ".$quantite." <strong>".$_SESSION["uniteMesure"][$key]."</strong>";
                        }
                        echo"</li>";
                    }
                    echo"</ul>";
                ?>
                <div id="etape">
                    <!-- Ajouter les étapes de préparation de la recette  -->
                    <label for="etapes">Etape de la préparation:</label></br>
                    <textarea  id="etapes" name="etapes" cols="100" rows="10" ><?php if (!isset($_POST['annuler'])){ echo $_POST['etapes'];} ?></textarea> 
                </div>

                <div id="boton_envoie">
    
                    <input value="Ajouter la recette" name="Envoyer" type="submit"/> 
                    <input value="Effacer tous les champs" name="annuler" type="submit"/> 
                </div>
            </form>
        </div>
        <?php include_once("./pied_de_page.html");?>
    </body>
</html>