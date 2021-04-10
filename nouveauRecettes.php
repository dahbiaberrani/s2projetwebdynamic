<html>

<head>
<title>Choix d'une opération sur 2 nombres</title>
</head>

 <body>
   <h2>Ajouter des nouveau Films</h2>
  <form action="insererFilms.php" method="POST">

	
	   <br/>

    <label for="real">Réalisateur</label>

   <select  id="real" name="real" > 
<?php 
    
    $connexion=mysqli_connect('mi-mariadb.univ-tlse2.fr','dahbia.berrani-eps-h','Akbou_2021');
    if (!$connexion) {
        echo("Desolé, connexion au serveur impossible\n");
        exit;
      }
    if (!mysqli_select_db($connexion,'19_L1M_dahbia_berrani_eps_haddad')) {
        echo("Désolé, accès à la base  impossible\n");
        exit;
    }
    mysqli_set_charset($connexion, "utf8");
    $requette1=("SELECT NumInd , Nom,Prenom From Individus");      
    $resultat =  mysqli_query($connexion,$requette1);
        if($resultat){
            
            while($ligne=mysqli_fetch_object($resultat)){
    
                echo ("<option value=\"".$ligne->NumInd."\"> ".$ligne->Prenom ." ".$ligne->Nom ."</option>\n");
            }
        }else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
?>
</select></br>

   <label for="titre">Titre du film</label>

   <input  id="titre" name="titre" type="text"> </br>
    <label for="genre ">Genre</label>

   <select  id="genre" name="genre" type="text">
   <?php 
    $connexion=mysqli_connect('mi-mariadb.univ-tlse2.fr','dahbia.berrani-eps-h','Akbou_2021');
    if (!$connexion) {
        echo("Desolé, connexion au serveur impossible\n");
        exit;
      }
    if (!mysqli_select_db($connexion,'19_L1M_dahbia_berrani_eps_haddad')) {
        echo("Désolé, accès à la base  impossible\n");
        exit;
    }
    mysqli_set_charset($connexion, "utf8");
    $requette2=("SELECT Genre From Films GROUP by Genre");      
    $resultat =  mysqli_query($connexion,$requette2);
        if($resultat){
            
            while($ligne=mysqli_fetch_object($resultat)){
    
                echo ("<option value=\"".$ligne->Genre."\">".$ligne->Genre."</option>\n");
            }
           
        }else{
            echo "<p>Erreur dans l'exécution de la requette</p>";
            echo"message de mysqli:".mysqli_error($connexion);
        }
    
?>
   </select> </br>
  
   
   <label for="annee">Année de Réalisation</label>

   <input  id="annee" name="annee" type="number"></br>

	 
	<input value="ajouter" type="submit"/> 
	<input type="reset" name="btAnnuler" value="Annuler" /></p>
   </form>
 </body>

</html>