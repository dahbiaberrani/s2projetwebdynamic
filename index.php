<html>

   <head>

   <?php 
   include("./entete.php");?>  
   </head>


   <body>
      <h2>
      <?php
      if (isset($_SESSION["user"])){
         echo "Bienvenue: ".$_SESSION["user"];
      }
      ?>
      </h2> 
      <img id="cibleimgacceuil"src="./images/acceui.PNG">
   <?php include_once("./pied_de_page.html")?>
   </body>

</html>