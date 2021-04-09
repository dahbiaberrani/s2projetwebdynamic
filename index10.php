  <!DOCTYPE html lang="fr">
  <html>

  <head>
      <meta charset="utf-8" />
      <title>Mon site </title>
      
      
  </head>
 

      <!-- Le menu -->

      <?php include("entete.html");include("toutrecette.php");include("entre.php");include("dessert.php") ?>

      <!-- Le corps -->


  <body>
      <p>Ces recettes peuvent t'intéresser :</p>

    <?php
    affichedessert();
    //afficherEntre();
    //affichertout();
    ?>
     
        
      <?php include("pied_de_page.html");?>
  </body>

  </html>


  