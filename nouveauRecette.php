<?php  

    include_once('./libDataBase.php') ;
            //connexion à la base de donnees 
            $connexion= my_connect();
            if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
                echo("Désolé, accès à la base  impossible\n");
                exit();
            }
            mysqli_set_charset($connexion, "utf8");


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
    <meta charset="utf-8" />
    <title>formuliare nouveau recette</title>
    <link rel="stylesheet" type="text/css"  href="./style/style.css" media="all">
    
</head>
    <body>
        <h2>Ajouter des nouveau recettes</h2></br>
        <div id="formilaire_ajout">
            <form action="nouveauRecette.php" method="POST">
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


                <!-- code php pour recuprée la liste des catégorie exicte de la base de donnee  -->   
                <?php        
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
                    <option value=" " ></option>

                <!-- code php pour recuprée la liste des ingredient  de la base de donnee  -->   
                <?php 
                    
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
                    <label for="unite"> unite </label>
                    <select  id="unite" name="unite" type="text" > 
                    <option value="g" name="g" type="text">g</option>
                    <option value="ml" name="ml" type="text">ml</option>
                    <option value="unite" name="sans unite" type="text" >unité</option></select>
                </div>  

                
                
                <div>
                    <input  type="submit"  value="ajouter" name="ajouter"/> 
                </div>
                             <!-- ajouter un nouvelle ingredient   -->
                <p><a href="./newIngredient.php" target="_blank">nouveau Ingredient</a></p>


                <!-- code php pour afficher les ingredient en forme d'un tableau   -->   
                <?php 
                
                    $unite = $_POST['unite'];
                    $quantite = $_POST['Quantite'];
                    if(!isset($_SESSION["mes_ingredients"])){
                        $_SESSION["mes_ingredients"] = array() ;
                        $_SESSION["uniteMesure"] = array();
                    }
                    if (isset($_POST['ajouter'])){

                        $idIngredient = $_POST['Idingredient'];
                        $_SESSION["mes_ingredients"]+= array($idIngredient=>$quantite);
                        $_SESSION["uniteMesure"] += array($idIngredient=>$unite);
                       
                        echo "cout de la recette:" .calculCout($_SESSION["mes_ingredients"],$_SESSION["uniteMesure"])."<br>";
                        echo"ingredient ajouter à la recette: </br> ";
                        echo"<ul>";
                        foreach($_SESSION["mes_ingredients"] as $key=>$quantite){
                            echo"<li>";
                            // recupérer Nom ingredient 
                            echo getIngredientNameById($key).":".$quantite."".$_SESSION["uniteMesure"][$key];
                            echo $_POST['$nouvIngredient'];
                            echo"</li>";
                        }
                        echo"</ul>";
                    } 
                ?>
                <div id="etape">
                    <!-- ajouter etapes de prepartion recette  -->
                    <label for="etapes">Etapes de preparation</label></br>
                    <textarea  id="etapes" name="etapes" cols="50" rows="20" > <?php if (!isset($_POST['annuler'])){ echo $_POST['etapes'];} ?></textarea> 
                </div>

                <div id="boton_envoie">
    
                    <input value="Envoyer" name="Envoyer" type="submit"/> 
                    <input value="annuler" name="annuler" type="submit"/> 
                </div>
            </form>
        </div>
    </body>

</html>

<!-- code php pour envoyée des nouvelle recette sur la base de donnes  -->   
<?php 

    $Nomrecette = $_POST["NomRecette"];
    $categorie = $_POST["categorie"];
    $NombrePersonne = $_POST["NombrePersonne"];
    $Idingredient = $_POST["Idingredient"];
    $Quantite = $_POST["Quantite"];
    $unite = $_POST["unite"];
    $etapes= $_POST["etapes"];



    if (isset($_POST['Envoyer'])){
        if (empty( $_POST["NomRecette"]) or empty($_POST["categorie"]) or empty($_POST["NombrePersonne"]) or count($_SESSION["mes_ingredients"])==0 or empty($_POST["etapes"])){
      
            echo"<h1 >Formulaire incomplet</h1>";
            
        }else{
            $cout_recette = calculCout($_SESSION["mes_ingredients"],$_SESSION["uniteMesure"]);
            $requette1=("INSERT INTO `Recettes` ( `Nomrecette`, `Etapes`, `Nomcategorie`, `Nombrepersonne`,`Cout`) 
    
                VALUES  (\"".$Nomrecette."\",\"".$etapes."\",\"".$categorie."\" ,\"".$NombrePersonne."\" ,\"".$cout_recette."\")");

            $req_Id_recette=(" SELECT MAX(Idrecette) as Nbrecette From Recettes");     
            $resultat0 =  mysqli_query($connexion,$req_Id_recette);
            if ($resultat0){
                $emp = mysqli_fetch_object($resultat0);
                $Id_recette = $emp-> Nbrecette;
            }else{
                echo "<p>Erreur dans l'exécution de la requette</p>";
                echo"message de mysqli:".mysqli_error($connexion);
            }

            $resultat1 = mysqli_query($connexion,$requette1);
                       
            if ($resultat1)  {
                echo" recette Ajouter";

                //insertion des ingrédients de la recettes

                foreach($_SESSION["mes_ingredients"] as $key=>$quantite){
                    $requette2= "INSERT INTO `Compositions` (`Idingredient`, `Idrecette`, `Quantitee`, `Unite`) 
                            VALUES (\"". $key."\", \"". $Id_recette."\", \"".  $quantite."\", \"".  $_SESSION["uniteMesure"][$key]."\" )";
                    $resultat2 = mysqli_query($connexion,$requette2);
                    
                    if (!$resultat2)  {
                        echo "<p>Erreur dans l'exécution de la requette d'ajout d'ingredient dans la composition'</p>";
                        echo"message de mysqli:".mysqli_error($connexion);
                        exit();
                    }
             }
          
            }else{
                echo "<p>Erreur dans l'exécution de la requette d'ajout de la recette</p>";
                echo"message de mysqli:".mysqli_error($connexion);
                exit();
            }

        }
        

   
    }
?>