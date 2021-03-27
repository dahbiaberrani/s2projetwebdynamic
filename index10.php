  <!DOCTYPE html lang="fr">
  <html>

  <head>
      <meta charset="utf-8" />
      <title>Mon site </title>
  </head>
  <header>

      <!-- Le menu -->

      <?php include("entete.php");include("page1.php") ?>

      <!-- Le corps -->
  </header>

  <body>
      <p>Ces recettes peuvent t'intéresser :</p>

    <?php
    affichertout();
    ?>
     
        
      <?php include("pied_de_page.php");?>
  </body>

  </html>


  