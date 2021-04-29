<?php 
    session_start();
    include_once("./libDataBase.php");
    $_idRecette = $_GET["modifier"];
    echo "modification de la recette :".$_idRecette."</br>";
    $_recette = loadRecette($_idRecette);
    var_dump($_recette);
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>mise à jour de recette</title>
    <link rel="stylesheet" type="text/css"  href="./style/style.css" media="all">
    
</head>
    <body>
        <h2>mise à jour de la recette : <?php echo $_recette['nomRecette'];?></h2></br>
        <div id="formulaire_modification">
            <!-- Image de la recette -->
            <?php echo "<img src=\"".$_recette['imageRecette']."\">"; ?>
            <!-- Nom recette -->
            <div id="nom_recette">
                <form action="./traitementModificationRecette.php" method="GET">
                    <label for="NomRecette">Nom Recette</label>
                    <input  id="NomRecette" name="NomRecette" type="text" value="<?php echo $_recette['nomRecette'];?>" > 
                    <input type="hidden"  name="idRecette" value="<?php echo $_idRecette;?>">
                    <button type="submit" name="changeRecetteName">Confirmez la modification</button>
                </form>     
            </div>
            <!-- choix Catégorie recette -->
            <div id="categorie">
                <form action="./traitementModificationRecette.php" method="GET">
                    <label for="categorie">catégorie:</label> 
                    <select  id="categorie" name="categorie" type="text"> 
                        
                        <!-- code php pour recuprer la liste des catégorie existantes dans la base de donnee  -->   
                        <?php        
                            $connexion= my_connect();
                            $requette1=("SELECT  Nomcategorie From Categories");      
                            $resultat =  mysqli_query($connexion,$requette1);
                            if($resultat){                               
                                while($ligne=mysqli_fetch_object($resultat)){
                                    if( $_recette['categorieRecette']==$ligne->Nomcategorie){
                                        echo ("<option value=\"".$ligne->Nomcategorie."\"selected=\"selected\">".$ligne->Nomcategorie ."</option>\n");                                     
                                    }
                                    else{
                                        echo ("<option value=\"".$ligne->Nomcategorie."\"> ".$ligne->Nomcategorie ."</option>\n");
                                    }                                    
                                }
                            }
                            else{
                                echo "<p>Erreur dans l'exécution de la requette</p>";
                                echo"message de mysqli:".mysqli_error($connexion);
                            }
                        ?>
                    </select>
                    <input type="hidden"  name="idRecette" value="<?php echo $_idRecette;?>">
                    <button type="submit" name="changeRecetteCategorie">Confirmez la modification</button>
                </form>
            </div>
            <!-- ajouter nombre de personne  -->
            <div id="nbpersonne">
                <form action="./traitementModificationRecette.php" method="GET">    
                    <label for="NombrePersonne ">Nombre personne </label>
                    <input  id="NombrePersonne" name="NombrePersonne" type="number" value="<?php echo $_recette['nombrePersonnesRecette'];?>"> 
                    <input type="hidden"  name="idRecette" value="<?php echo $_idRecette;?>">
                    <button type="submit" name="changeRecetteNombrePersonne">Confirmez la modification</button>
                </form>
            </div>
            <!-- Ajouter des ingredients à la recettes  -->
            <div id="ingredient">
                <form action="./traitementModificationRecette.php" method="GET">
                    <label for="Idingredient">Nom Ingredient</label>
                    <select  id="Idingredient" name="Idingredient" type="numbre" > 
                        <option value="" ></option>

                        <!-- code php pour recuprée la liste des ingredients présent dans la base de données  -->   
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
                        <option value="" name="" type="text"></option>
                        <option value="g" name="g" type="text">g</option>
                        <option value="ml" name="ml" type="text">ml</option>
                        <option value="unite" name="sans unite" type="text" >unité</option>
                    </select>
                    <input type="hidden"  name="idRecette" value="<?php echo $_idRecette;?>">
                    <button type="submit" name="addRecetteIngredient">Ajouter l'ingrédient</button>
                </form>
            </div>  


            <div>
                <!-- ajouter un nouvelle ingredient  qui n'existe pas encore dans la base de données -->
                <p>Vous ne trouvez pas votre ingrédient?:<a href="./newIngredient.php" target="_blank">Ajouter un nouveau ingrédient</a></p>
            </div>
            
            <?php
                // Calcul et affichage du coût de la recette
                $_ingerdients = array();
                $_unites = array();
                foreach($_recette['ingredientsRecette'] as $key=>$value){
                    $_ingerdients+= array($key=>$_recette['ingredientsRecette'][$key]['quantite']);
                    $_unites += array($key=>$_recette['ingredientsRecette'][$key]['unite']);         
                }
                echo "cout de la recette: ".calculCout($_ingerdients,$_unites)."€<br>";

                //  Affichage de la liste des ingrédients
                echo "ingrdéients de la recette: <br> ";
            
                foreach($_recette['ingredientsRecette'] as $key=>$value){
                    
                    echo "<form action=\"./traitementModificationRecette.php\" method=\"GET\">";
                        // Affichage de la quantite 
                        echo $value['quantite'];
                        //Affichage unité si différente de "unite"
                        $_Unite = $value['unite'];
                        if ($_Unite != "unite") {
                            echo " ".$_Unite;
                        }
                        // Affichage du nom de l'ingrédient
                        echo " ".$value['nom'];              
                        //Ajout du bouton suppprimer afin de permettre la supression d'un ingrédient dans la recette.
                        
                            echo "<input type=\"hidden\"  name=\"idIngredientToDelete\" value=\"".$key."\">";
                            echo "<input type=\"hidden\"  name=\"idRecette\" value=\"".$_idRecette."\">";
                            echo "<button type=\"submit\" name=\"deleteIngredient\">supprimer</button>";
                            
                        echo "</form>";                 
                }               
            ?>
            <!-- ajouter etapes de prepartion recette  -->
            <div id="etape">
                <form action="./traitementModificationRecette.php" method="GET"> 
                    <label for="etapes">Etapes de preparation</label></br>
                    <textarea  id="etapes" name="etapes" cols="50" rows="20" ><?php echo $_recette['etapesRecette']; ?></textarea>
                    <input type="hidden"  name="idRecette" value="<?php echo $_idRecette;?>">
                    <button type="submit" name="changeRecetteEtapes">Confirmez la modification</button>
                </form>
            </div>
            <!-- Permettre l'ajout d'un nouveau commentaire à la recette -->
            <!-- Affichage des commentaires de la recette pour proposer la suppression -->
            <?php 
                //  Affichage de la liste des ingrédients
                echo "Commentaires de la recette: <br> ";
                echo "<ul>";
                    foreach($_recette['commentairesRecette'] as $key=>$value){
                        echo "<li>";
                            echo "<form action=\"./traitementModificationRecette.php\" method=\"GET\">";
                                // Affichage de la date du commentaire
                                echo $value['dateCommentaire'].":";
                                // Affichage du text du commentaire
                                echo " ".$value['textCommentaire']." ";              
                                //Ajout du bouton suppprimer afin de permettre la supression d'un commentaire.             
                                echo "<input type=\"hidden\"  name=\"idRecette\" value=\"".$_idRecette."\">";
                                echo "<input type=\"hidden\"  name=\"idCommentaireToDelete\" value=\"".$key."\">";
                                echo "<button type=\"submit\" name=\"deleteComment\">supprimer</button>";                
                            echo "</form>";   
                        echo "</li>";        
                    }   
                echo "</ul>";           
            ?>
                
        </div>
        <?php include_once("./pied_de_page.html");?>
    </body>
</html>