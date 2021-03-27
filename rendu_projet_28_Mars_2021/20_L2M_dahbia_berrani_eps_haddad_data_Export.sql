-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2021 at 12:04 PM
-- Server version: 10.3.23-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `20_L2M_dahbia_berrani_eps_haddad`
--

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`Nomcategorie`) VALUES
('Dessert'),
('Entree'),
('Plat');


--
-- Dumping data for table `Recettes`
--

INSERT INTO `Recettes` (`Idrecette`, `Nomrecette`, `Etapes`, `Nomcategorie`, `Imagepath`, `Nombrepersonne`, `Cout`) VALUES
(1, 'Crêpe salé', '1. Dans un grand saladier, battre ensemble les œufs et le sel. Incorporer progressivement la farine en fouettant pour former une pâte, puis petit à petit le lait. Enfin ajouter le beurre fondu. Bien mélanger.\nLaisser la pâte à crêpes reposer 1 heure.\n\n2. Chauffer une poêle antiadhésive à feu moyen élevé. Badigeonner d''un filet d''huile neutre puis verser une petite louche de pâte dans la poêle. Faire tourner la poêle pour bien enrober le fond. Cuire jusqu’à ce que le premier côté soit doré puis retourner et faire cuire 30 secondes supplémentaires. Retirer et reproduire jusqu’à ce qu’il n’y ait plus de pâte. Réaliser 8 crêpes.\n\n3. Mélanger le fromage frais à l’aide d’une fourchette pour lui donner une texture onctueuse. Y ajouter quelques brins d’aneth, et de persil, le zeste d''un demi-citron, et l’ail haché. Mélanger et assaisonner à votre goût.\n\n4. Étaler une fine couche de fromage aux herbes sur l’intégralité de la crêpe. Déposer une feuille de batavia et une tranche de saumon fumé. Rouler en serrant bien dans du film alimentaire. Placer les rouleaux au réfrigérateur pendant 30 minutes.\n\n5. Sortir les rouleaux et le découper en deux en biseau juste avant deservir.', 'Entree', './images/crepesalee.PNG', 4, 3.5),
(2, 'Ratatouille', 'Lavez et détaillez les courgettes, l''aubergine, le poivron vert et le rouge, en cubes de taille moyenne. Coupez les tomates en quartiers et émincez l''oignon.\r\nDans une poêle, versez un peu d''huile d''olive et faites-y revenir les uns après les autres les différents légumes pendant 5 minutes pour qu''ils colorent. Commencez par les poivrons, puis les aubergines, les courgettes et enfin les oignons et les tomates que vous cuirez ensemble.\r\nAprès avoir fait cuire les légumes, ajoutez-les tous aux tomates et aux oignons, baissez le feu puis mélangez. Ajoutez un beau bouquet garni de thym, de romarin et de laurier, salez, poivrez, puis couvrez pour laisser mijoter 40 minutes en remuant régulièrement.\r\nÀ environ 10 minutes du terme de la cuisson, ajoutez les deux belles gousses d''ail écrasées puis couvrez de nouveau. N''hésitez pas à goûter et à assaisonner de nouveau selon vos goûts.', 'Plat', './images/ratatouille.PNG', 6, 6),
(3, 'Riz au lait', 'Dans une casserole, versez un litre d''eau avec une pincée de sel et portez à ébullition. Ajoutez le riz et laissez-le cuire pendant 3 minutes avant de l''égoutter. Le but consiste à nettoyer le riz pour le débarrasser de sa poussière.\nVersez le lait et la crème liquide dans une casserole. Grattez l''intérieur d''une gousse de vanille et ajoutez-la avec les grains dans la casserole. Incisez un bâton de cannelle dans la longueur et plongez-le avec le reste. Portez le tout à ébullition.\n\nVersez le riz et le sucre dans la casserole. Laissez cuire à feu doux pendant 30 à 40 minutes en surveillant et en remuant de temps en temps. Arrêtez la cuisson lorsque le riz est bien cuit et qu''il reste un peu de lait dans la casserole.', 'Dessert', './images/rizaulait.PNG', 4, 4),
(4, 'Veloute de potiron et carottes', 'Éplucher et couper en dés le potiron, les pommes de terre, les carottes en rondelles.\r\nEmincer l''ail et l''oignon.\r\nFaire suer l''oignon dans l''huile d''olive.\r\nAjouter tous les légumes et l''ail puis verser le bouillon et le lait.\r\nSaler, poivrer,  et laisser cuire environ une trentaine de minutes.\r\nMixer le tout (ajouter éventuellement la crème) et rectifier l''assaisonnement si nécessaire.\r\nBon appétit !', 'Entree', './images/potiron.PNG', 5, 0),
(5, 'Linguine à la toscane', 'Dans une casserole, faire infuser 5 mn le piment - que vous aurez préalablement écrasé - dans de l''huile chaude (4 cuillerées à soupe). Ajouter l''ail. Puis les herbes hachées (ceci juste avant d''y jeter les linguines).\r\nParallèlement, faire cuire les linguines ''al dente''. Goûter l''eau lors de la cuisson pour vous assurer qu''elle est convenablement salée. Essorer les linguines (point trop), puis les jeter dans la casserole qui contient l''huile, le piment, l''ail et les herbes.\r\nMélanger délicatement. Servir avec du parmesan, un filet d''huile d''olive sur chaque assiette et un tour de moulin à poivre.E viva la Toscana!', 'Plat', './images/linguine.PNG', 4, 4),
(6, 'yaourt et chocolat', 'Préchauffer le four à 180°C (thermostat 6). Mettre le chocolat à fondre au bain-marie (sans beurre ni rien d''autre).\r\nPendant ce temps, mélanger tous les autres ingrédients (en mélangeant d''abord la levure et la farine, sinon elles se mélangent mal).\r\nAjouter le chocolat fondu.\r\nBeurrer un moule à manqué et verser la pâte.\r\nMettre au four 15 min à 180°C (thermostat 6), puis 15 min à 150°C (thermostat\r\nVérifier la cuisson: il doit être cuit sur le dessus et humide à l''intérieur.', 'Dessert', './images/yaourtchocolat.PNG', 6, 3.5),
(7, 'Tomates courgettes œufs ', '-Laver les légumes\r\n- Éplucher la courgette partiellement (faire des "rayures")\r\n- Couper la courgette en rondelles puis chaque rondelles en quarts\r\n- Couper les tomates en tranches puis chaque tranches en deux\r\n\r\n- Mettre un peu d''huile dans la poêle\r\n- Faire revenir la courgette dans la poêle jusqu''à ce qu''elle soit dorée\r\n- Mettre les tomates dans la poêle avec les courgettes\r\n\r\n- Une fois que les tomates se détachent de leur peaux ajouter les œufs sur les courgettes et les tomates (comme pour des œufs au plat)\r\n- Saler et poivrer selon les préférences\r\n- Mettre le couvercle sur la poêle\r\n\r\n- Servir une fois les œufs cuits', 'Entree', './images/courg.PNG', 3, 2),
(8, 'Alambres', 'Ce plat est à combinaisons multiples! On peut utiliser tous les légumes et viandes qui vous restent dans votre réfrigérateur.\r\n\r\nLa combinaison la plus simple est la suivante:\r\n1- Couper un oignon, tomates et poivrons\r\n2- Faire revenir les oignons dans un poêle avec de l''huile d''olive\r\n3- Ajouter les légumes (et de la viande de boeuf haché pour les non végétariens)\r\n4- Faire revenir jusqu''à ce que les légumes et la viande soient cuits\r\n5- Servir\r\n\r\nLes possibilités sont infinies, en fonction de vos envies.\r\nPeut se manger avec des tortillas, seul, avec un féculent (riz, pâtes), faire fondre du fromage, le gratiner, etc. etc.', 'Plat', './images/alambres.PNG', 2, 2),
(9, 'Carottes et courgettes sauce curry', 'Couper le demi oignon en petits morceaux. Le faire cuire dans une poêle à feu moyen dans de l''huile d''olive.\r\n\r\nPendant que l''oignon cuit, éplucher les carottes et les couper en petits morceaux, les ajouter à l''oignon.\r\n\r\nAjouter également la courgette coupée en petits morceaux.\r\n\r\nSaler et poivrer la préparation.\r\n\r\nPoser un couvercle sur la poêle et laisser à feu moyen pendant une quinzaine de minutes. En fin de cuisson, vous pouvez augmenter la cuisson quelques secondes afin de faire griller les légumes.\r\n\r\nUne fois les légumes cuits, ajouter la crème fraîche (selon l''envie) puis le curry, et le fromage râpé.\r\nBien mélanger.\r\n\r\nReposer le couvercle pendant 1 à 2 minutes, juste le temps que le fromage fonde sur les légumes.\r\n\r\nC''est prêt!', 'Entree', './images/carotte.PNG', 4, 4.5),
(10, 'Dessert fruité', '1) Découper les fruits en morceaux\r\n2) Disposez les dans une assiettes\r\n3) Mettez de la chantilly comme vous le souhaitez\r\n\r\nDéguster !', 'Dessert', './images/dessertfuite.PNG', 1, 2);


--
-- Dumping data for table `Commentaires`
--

INSERT INTO `Commentaires` (`Idcommentaire`, `Commentaire`, `Idrecette`, `Datecommentaire`) VALUES
(1, 'recette facile et rapide à préparée c''est un vrai délice je me suis réglée avec ma famillle, c''est une recette à refaire sans doute .je vous recommande vivement cette recette à la tester ainsi que le site   merci infiniment ', 1, '2021-03-16'),
(2, 'recette facile et rapide à préparée c''est un vrai délice je me suis réglée avec ma famillle, c''est une recette à refaire sans doute .je vous recommande vivement cette recette à la tester ainsi que le site merci infiniment ', 1, '2021-03-16'),
(3, 'C''est une ratatouille savoureuse.Les temps de cuisson sont corrects.Cette recette apporte une meilleure cuisson des légumes, par rapport à ma recette habituelle, qui était d''ajouter, au fur et à mesure, les légumes dans le même faitout.Je l''ai préparée plusieurs fois cet été, je la recommande!', 2, '2021-03-21'),
(4, 'Une excellente recette!!!!! C''est la première ratatouille que je réalise et c''était un véritable délice!!! Ni mon mari ni moi sommes fans de ce plat mais là nous l''avons tout simplement dégusté!!! Il n''a rien laissé!! vraiment merci pour cette succulente recette! une vraie révélation et une réussite pour nous !!!! Un plat onctueux, plein de saveurs.... à refaire très très vite pour la famille!!', 2, '2021-04-01'),
(5, 'J''ai essayé beaucoup de recette de riz au lait... J''ai jamais vraiment réussi à avoir un bon rendu à art avec cette recette... C''est trop bon ! J''ai un peu réduit le sucre (70gr au lieu de 100gr) et j''ai utilisé un riz long car je n''avais pas de riz rond. Et bien le résultat est succulent !', 3, '2021-05-01'),
(6, 'Très facile à faire. Et pour ceux, qui aiment la noix de coco, on peut rajouter du lait de coco en fin de cuisson. __Merci pour cette délicieuse recette !', 3, '2021-06-01'),
(7, 'Délicieux !', 5, '2021-02-12'),
(8, 'Vraiment très très bon et qui permet de manger un peu de légume.', 5, '2021-02-23'),
(9, 'Essai aujourd''hui un peu trop sec dommage', 6, '2021-04-23'),
(10, 'Très facile à faire. ', 4, '2021-03-02'),
(11, 'recettes facile et rapide.', 7, '2021-03-23'),
(12, 'cette délicieuse recette !', 8, '2021-02-23'),
(13, 'Rien à dire au terme de goût et e budget.\r\n', 9, '2021-02-28'),
(14, 'Délicieux ! je vous recommande. ', 10, '2021-03-29');




--
-- Dumping data for table `Ingredients`
--

INSERT INTO `Ingredients` (`Idingredient`, `Nomingredient`, `Prix`) VALUES
(1, 'fromage frais', 1.56),
(2, 'oaufs', 0.9),
(3, 'beurre fondu', 1.5),
(4, 'lait entier', 0.3),
(5, 'pincée de sel', 0),
(6, 'farine', 0.5),
(7, 'huile', 0.5),
(8, 'persil', 0.3),
(9, 'ail', 5),
(10, ' zeste citron', 0),
(11, ' de saumon fumée', 5),
(12, 'Aubergine', 2),
(13, 'Poivron rouge', 2.5),
(14, 'Oignon', 0.8),
(15, 'Tomate', 1.5),
(16, 'Courgette', 1.75),
(17, 'Huile d''olive', 2),
(18, 'Garni', 0.6),
(19, 'poivre', 1.5),
(20, 'Poivron vert', 1.5),
(21, 'Sucre', 0.6),
(22, 'Cannelle', 1.5),
(23, 'Riz rond', 0.8),
(24, 'crème liquide', 0.52),
(25, 'Parmesan rapé', 2.5),
(26, 'Poivre noir', 1.5),
(27, 'Linguine', 1.57),
(28, 'Sel', 1),
(29, 'Piment d''Espelette', 1.6),
(30, 'Yaourt nature', 0.3),
(31, 'chocolat poudre ', 2.5),
(32, 'Potiran', 2.5),
(33, 'Carotte', 1),
(34, 'Pomme de terre', 2.5),
(36, 'Potiran', 2.5),
(38, 'Pomme de terre', 2.5),
(40, 'Lait', 0.7),
(41, 'cuillère à soupe Huile d''olive', 0),
(42, 'Fromage rapé', 2.5),
(43, 'Crème fraîche liquide', 0.5),
(44, 'curry', 0.5),
(45, 'Banane', 0.5),
(46, 'Fraises', 0.5),
(47, 'chanty', 1.5);

--
-- Dumping data for table `Compositions`
--

INSERT INTO `Compositions` (`Idingredient`, `Idrecette`, `Quantitee`, `Unite`) VALUES
(1, 1, 200, 'g'),
(2, 1, 2, ''),
(2, 6, 3, ''),
(2, 7, 2, ''),
(3, 1, 60, 'g'),
(4, 1, 500, 'ml'),
(4, 3, 750, 'ml'),
(5, 1, 1, ''),
(5, 3, 1, ''),
(6, 1, 250, 'g'),
(6, 6, 120, 'g'),
(7, 1, 300, 'ml'),
(7, 7, 75, 'ml'),
(8, 1, 250, 'g'),
(9, 1, 2, ''),
(9, 4, 1, ''),
(9, 5, 2, ''),
(9, 8, 2, ''),
(10, 1, 1, ''),
(11, 1, 100, 'g'),
(12, 2, 300, 'g'),
(13, 2, 300, 'g'),
(13, 8, 200, 'g'),
(14, 2, 400, 'g'),
(14, 4, 60, 'g'),
(14, 8, 60, 'g'),
(15, 2, 100, 'g'),
(15, 7, 300, 'g'),
(15, 8, 300, 'g'),
(16, 2, 200, 'g'),
(16, 7, 200, 'g'),
(16, 8, 200, 'g'),
(16, 9, 100, 'g'),
(17, 2, 100, 'ml'),
(17, 5, 150, 'ml'),
(17, 6, 50, 'ml'),
(17, 8, 50, 'ml'),
(17, 9, 75, 'ml'),
(18, 2, 100, 'g'),
(19, 2, 150, 'g'),
(20, 2, 100, 'g'),
(21, 3, 100, 'g'),
(21, 6, 75, 'g'),
(22, 3, 1, ''),
(23, 3, 120, 'g'),
(24, 3, 200, 'ml'),
(25, 5, 150, 'g'),
(25, 8, 300, 'g'),
(26, 4, 10, 'g'),
(26, 5, 15, 'g'),
(26, 7, 75, 'g'),
(26, 9, 75, 'g'),
(27, 5, 500, 'g'),
(28, 7, 75, 'g'),
(28, 9, 75, 'g'),
(29, 5, 150, 'g'),
(30, 6, 1, ''),
(31, 6, 200, 'g'),
(32, 4, 1000, 'g'),
(33, 4, 500, 'g'),
(33, 9, 200, 'g'),
(38, 4, 50, 'g'),
(40, 4, 500, 'ml'),
(41, 4, 1, ''),
(42, 9, 100, 'g'),
(43, 9, 75, 'ml'),
(44, 9, 75, 'g'),
(45, 10, 100, 'g'),
(46, 10, 100, 'g'),
(47, 10, 100, 'g');





/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
