<html>
	<head>
		<title>Choix d'une opération sur 2 nombres</title>
	</head>
	<body>
		<?php include("./entete.php");?>
		<form action="./resultatRecherche.php" method="GET">
		<label  for = 'categorie'>Sélectionner une catégorie: </label>
			<select  id="categorie" name ="categorie">
				<option value="*">Tous catégorie </option>
				<option value="plat"> Plat principal</option>
				<option value="entree">Entrée</option>
				<option value="dessert">Dessert</option>
			</select> 
			<label  for = 'categorie'>Coûtant moins de: </label>
			<input  id = "cout" name ="cout" type="number" step ="0.01" >
			<label  for = 'categorie'>€</label>
			<br/> 
			<input value="Selectionner" type="submit"/> 
		</form>
		<?php include_once("./pied_de_page.html")?>
 	</body>
</html>