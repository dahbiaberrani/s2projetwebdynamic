<?php 
//connexion à la base de donnees 
    function my_connect(){
        $connexion=mysqli_connect('mi-mariadb.univ-tlse2.fr','dahbia.berrani-eps-h','Akbou_2021');
        if (!connexion){
            echo ("désolé,connexion au serveur impossible\n");
            exit;
        }
        else {
            return $connexion;
        }
    }
 
// recupère le nom Idingredient 
function getIngredientNameById($_idIngredient){
    $connexion= my_connect();
    if (!mysqli_select_db($connexion,'20_L2M_dahbia_berrani_eps_haddad')) {
        echo("Désolé, accès à la base  impossible\n");
        exit;
    }
    mysqli_set_charset($connexion, "utf8");
    $requette=("SELECT  Idingredient, Nomingredient From Ingredients where Idingredient = $_idIngredient");      
    $resultat =  mysqli_query($connexion,$requette);
    if($resultat){
        
        while($ligne=mysqli_fetch_object($resultat)){

            return ($ligne->Nomingredient);
        }
    }


}          
//echo getIngredientNameById(15);


?>