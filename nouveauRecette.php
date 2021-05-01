<?php  
    session_start();
    include_once('./libDataBase.php') ;
    //connexion à la base de donnees 
    $connexion= my_connect();
    
    $Nomrecette = $_POST["NomRecette"];
    $categorie = $_POST["categorie"];
    $NombrePersonne = $_POST["NombrePersonne"];
    $Idingredient = $_POST["Idingredient"];
    $Quantite = $_POST["Quantite"];
    $unite = $_POST["unite"];
    $etapes= $_POST["etapes"];

    if (isset($_POST['Envoyer'])){
        if (empty( $_POST["NomRecette"])){
            $_erreur = "NomRecette";
        }
        elseif(empty($_POST["categorie"])){
            $_erreur = "categorie";
        }
        elseif (empty($_POST["NombrePersonne"])){
            $_erreur = "NombrePersonne";
        }
        elseif(count($_SESSION["mes_ingredients"])==0){
            $_erreur = "mes_ingredients";
        }
        elseif(!(isset($_POST['etapes']) && !empty($_POST['etapes']))){
            $_erreur = "etapes";
        } 
        else{
            $_erreur = "FALSE";
            $cout_recette = calculCout($_SESSION["mes_ingredients"],$_SESSION["uniteMesure"]);
            $requette1=("INSERT INTO `Recettes` ( `Nomrecette`, `Etapes`, `Nomcategorie`, `Nombrepersonne`,`Cout`) 
    
                VALUES  (\"".$Nomrecette."\",\"".$etapes."\",\"".$categorie."\" ,\"".$NombrePersonne."\" ,\"".$cout_recette."\")");

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
    

                //insertion des ingrédients de la recettes

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
                header('Location: ./resultatRecherche.php?categorie='.strtolower($categorie).'&cout=*');                 
                exit();
            }else{
                echo "<p>Erreur dans l'exécution de la requette d'ajout de la recette</p>";
                echo"message de mysqli:".mysqli_error($connexion);
                exit();
            }
        }
    } 

    if (isset($_POST['uploadImage'])){
        echo"<h1 id=\"headererror\" >Telechargement de la photo</h1>";
        var_dump($_FILES);
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
                    
                    // changer les droits du répértoire cible car à chaque fois ils reviennent comme avant.
                    $destination = "/opt/CRIE/dahbia.berrani-eps-h/public_html/s2projetwebdynamic/images";
                    $chmod = "0774";
                    if(!chmod($destination,octdec($chmod))){
                        echo "<h1 id=\"headererror\" >Impossible de changer les droit du répértoire!</h1>";
                        echo get_current_user ( );
                    }
                    
                    if (move_uploaded_file($_FILES['fichier']['tmp_name'], $nomImage)) {
                        $_SESSION['imagePath'] = $nomImage;
                    }
                    else {
                        // Sinon il y a une erreur
                        echo "<h1 id=\"headererror\" >Problème lors du chargement <br> Veuillez réessayer !</h1>";
                        
                    }
                    
                }
                else {
                    // Sinon erreur sur le type de l'image
                    echo "<h1 id=\"headererror\" >Le fichier sélectionné n\'est pas une image !</h1>";
                }
            }
            else {
                // Sinon on affiche une erreur pour l'extension
                echo "<h1 id=\"headererror\" >L\'extension du fichier est incorrecte !</h1>";          
            }
        }
        else {
            // Sinon on affiche une erreur pour le champ vide
            echo "<h1 id=\"headererror\" >Veuillez sélectionner une image !</h1>";
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
    if ($_erreur === "NomRecette"){
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
            <form enctype="multipart/form-data" action="./nouveauRecette.php" method="POST">
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
                <img src="<?php echo $_SESSION['imagePath'];?>"><br>
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
                             <!-- ajouter un nouvelle ingredient   -->
                <p>Vous ne trouvez pas votre ingrédient?:<a href="./newIngredient.php" target="_blank">Ajouter un nouveau ingrédient</a></p>


                <!-- code php pour afficher les ingredients en forme d'un tableau   -->   
                <?php 
                
                    $unite = $_POST['unite'];
                    $quantite = $_POST['Quantite'];
                    if(!isset($_SESSION["mes_ingredients"])){
                        $_SESSION["mes_ingredients"] = array() ;
                        $_SESSION["uniteMesure"] = array();
                    }

                    if (isset($_POST['ajouter']) && !empty($_POST['unite']) && !empty($_POST['Quantite']) && intval($_GET['Quantite']) > 0 && !empty($_POST['Idingredient'])){

                        $idIngredient = $_POST['Idingredient'];
                        $_SESSION["mes_ingredients"]+= array($idIngredient=>$quantite);
                        $_SESSION["uniteMesure"] += array($idIngredient=>$unite);
                       
                    } 

                    echo "cout de la recette:" .calculCout($_SESSION["mes_ingredients"],$_SESSION["uniteMesure"])."€<br>";
                    echo"ingrédients de la recette: </br> ";
                    echo"<ul>";
                    foreach($_SESSION["mes_ingredients"] as $key=>$quantite){
                        echo"<li>";
                        // recupérer Nom ingredient 
                        echo getIngredientNameById($key).":".$quantite."".$_SESSION["uniteMesure"][$key];
                        echo $_POST['$nouvIngredient'];
                        echo"</li>";
                    }
                    echo"</ul>";
                ?>
                <div id="etape">
                    <!-- ajouter etapes de prepartion recette  -->
                    <label for="etapes">Etapes de preparation</label></br>
                    <textarea  id="etapes" name="etapes" cols="50" rows="20" ><?php if (!isset($_POST['annuler'])){ echo $_POST['etapes'];} ?></textarea> 
                </div>

                <div id="boton_envoie">
    
                    <input value="Envoyer" name="Envoyer" type="submit"/> 
                    <input value="annuler" name="annuler" type="submit"/> 
                </div>
            </form>
        </div>
        <?php include_once("./pied_de_page.html");?>
    </body>
</html>