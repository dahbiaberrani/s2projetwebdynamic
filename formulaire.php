<html>

<head>
<title>Choix d'une opération sur 2 nombres</title>
</head>
 <body>
    <?php include("entete.html");?>
  <form action="listeDesrecettes.php" method="GET">
  <label  for = 'categorie'>Sélectionner un catégorie: </label>
	<select  id="categorie" name ="categorie">
		<option value=" ">  </option>
		<option value="*">Tous catégorie </option>
		<option value="plat"> Plat principal</option>
		<option value="entre">Entrée</option>
		<option value="dessert">Dessert</option>
        <option value="cout">cout</option>
 
	</select>

	<br/> 
	<input value="Selectionner" type="submit"/> 
	
   </form>
 </body>

</html>