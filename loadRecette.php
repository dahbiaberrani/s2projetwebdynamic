<?php 
    session_start();
    include_once("./libDataBase.php");
    $_idRecette = $_GET["modifier"];
    echo "modification de la recette :".$_idRecette."</br>";
    $_session['recette'] = loadRecette($_idRecette);
    var_dump($_session['recette']);
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>mise à jour de recette</title>
    <link rel="stylesheet" type="text/css"  href="./style/style.css" media="all">
    
</head>
    <body>
        <h2>mise à jour de la recette</h2></br>
        <div id="formilaire_modification">
            <form action="./loadRecette.php" method="POST">
                <!-- Nom recette -->
                <div id="nom_recette">
                    <label for="NomRecette">Nom Recette</label>
                    <input  id="NomRecette" name="NomRecette" type="text" value="<?php echo $_session['recette']['nomRecette'];?>" > 
                    
                </div>
                <!-- choix Catégorie recette -->
                <div id="categorie">
                    <label for="categorie">catégorie:</label> 
                    <select  id="categorie" name="categorie" type="text"> 
                        
                        <!-- code php pour recuprer la liste des catégorie existantes dans la base de donnee  -->   
                        <?php        
                            $connexion= my_connect();
                            $requette1=("SELECT  Nomcategorie From Categories");      
                            $resultat =  mysqli_query($connexion,$requette1);
                            if($resultat){                               
                                while($ligne=mysqli_fetch_object($resultat)){
                                    if( $_session['recette']['categorieRecette']==$ligne->Nomcategorie){
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
                    </select></br>
                </div>

                <div id="nbpersonne">
                    <!-- ajouter nombre de personne  -->
                    <label for="NombrePersonne ">Nombre personne </label>
                    <input  id="NombrePersonne" name="NombrePersonne" type="number" value="<?php echo $_session['recette']['nombrePersonnesRecette'];?>"> 
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
                    <!-- ajouter un nouvelle ingredient  qui n'existe pas encore dans la base de données -->
                    <p>Vous ne trouvez pas votre ingrédient?:<a href="./newIngredient.php" target="_blank">Ajouter un nouveau ingrédient</a></p>
                </div>
             
                <?php
                
                    // Calcul et affichage du cût de la recette
                    $_ingerdients = array();
                    $_unites = array();
                    foreach($_session['recette']['ingredientsRecette'] as $key=>$value){
                        $_ingerdients+= array($key=>$_session['recette']['ingredientsRecette'][$key]['quantite']);
                        $_unites += array($key=>$_session['recette']['ingredientsRecette'][$key]['unite']);         
                    }
                    echo "cout de la recette: ".calculCout($_ingerdients,$_unites)."€<br>";

                    //  Affichage de la liste des ingrédients
                    echo "ingrdéients de la recette: </br> ";
                    echo "<ul>";
                    foreach($_session['recette']['ingredientsRecette'] as $key=>$value){
                        echo "<li>";
                            //selectionner les ingredient de recettes "
                            var_dump($key);
                            echo "<label for=\"Idingredient\">Nom Ingredient: ".$_session['recette']['ingredientsRecette'][$key]['nom']."</label>";
                            //ajouter la quantite 
                            echo "<label for=\"Quantite\">Quantite ".$_session['recette']['ingredientsRecette'][$key]['quantite']."</label>";
                            // unite
                            echo "<label for=\"unite\"> unite ".$_session['recette']['ingredientsRecette'][$key]['unite']."</label>";
                            //Ajout du bouton suppprimer
                            echo "<form action=\"./test.php\" method=\"GET\">";
                                echo "<input type=\"hidden\"  name=\"idIngredient\" value=\"".$key."\">";
                                echo "<input type=\"hidden\"  name=\"idRecette\" value=\"".$_idRecette."\">";
                                echo "<button type=\"submit\">supprimer</button>";
                            echo "</form>";
                        echo "</li>";
                    }
                    echo "</ul>";
                ?>
                
                <div id="etape">
                    <!-- ajouter etapes de prepartion recette  -->
                    <label for="etapes">Etapes de preparation</label></br>
                    <textarea  id="etapes" name="etapes" cols="50" rows="20" ><?php echo $_session['recette']['etapesRecette']; ?></textarea> 
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
?>