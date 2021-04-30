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
    
    //fonction d'annulation de toutes les variable de session relatives a l'ajout de recette
    function unsetRecetteVariables(){
        unset($_SESSION["mes_ingredients"]);
        unset($_SESSION["uniteMesure"]);
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
        echo"<h1 id=\"headererror\" >Nombre de personnes de la recette incomplet</h1>";
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
            <form action="./nouveauRecette.php" method="POST">
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
                    <input  id="NombrePersonne" name="NombrePersonne" type="number" value="<?php if (!isset($_POST['annuler'])){ echo $_POST['NombrePersonne'];} ?>"> 
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


                <!-- code php pour afficher les ingredient en forme d'un tableau   -->   
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