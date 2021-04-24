<?php session_start();?>
<meta charset="utf-8" />
<title>recettes étudiants </title>
<link rel="stylesheet" type="text/css"  href="./style/style.css" media="all">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="NoS1gnal"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <header>
        <h1>Rendez-vous dans l'assiette</h1>
  
        <nav id="menu">
        <ul>
           <li>
              <a href="./resultatRecherche.php?categorie=*&cout=*">tout</a>
           </li>
              <li>
                 <a href="./resultatRecherche.php?categorie=entre&cout=*">Entres</a>
              </li>
              <li>
                 <a href="./resultatRecherche.php?categorie=plat&cout=*">Plats</a>
              </li>
              <li>
                 <a href="./resultatRecherche.php?categorie=dessert&cout=*">Desserts</a>
              </li>
              <li>
                 <a href="./rechercheAvancee.php">recherche avancée</a>
  
              </li>
  
             
            
              <li>
                 <a href="./stat.php">statistiques</a>
              </li>
  
              <li>
                 
              <?php 
                
                 
                 if (!isset($_SESSION["user"])){
                     echo "<a href=\"./connexion.php\">connexion</a>";
                 }
                  else{
                     echo "<a href=\"./deconnexion.php\">deconnexion</a>";
                  }
                  
               ?>
              </li>
        
        </ul>
        </nav>
           
        </header>

