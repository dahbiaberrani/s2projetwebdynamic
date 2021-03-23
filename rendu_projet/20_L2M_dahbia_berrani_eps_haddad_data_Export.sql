-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 22, 2021 at 07:35 PM
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
-- Dumping data for table `Ingredients`
--

INSERT INTO `Ingredients` (`Idingredient`, `Nomingredient`, `Prix`) VALUES
(1, 'fromage frais', 1.56),
(2, 'œufs', 0.9),
(3, 'beurre fondu', 1.5),
(4, 'lait entier', 0.3),
(5, 'pincée de sel', 0),
(6, 'farine', 0.5),
(7, 'huile', 0.5),
(8, 'persil', 0.3),
(9, 'ail', 5),
(10, ' zeste citron', 0),
(11, ' de saumon fumé', 5),
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
(24, 'crème liquide', 0.52);

--
-- Dumping data for table `Recettes`
--

INSERT INTO `Recettes` (`Idrecette`, `Nomrecette`, `Etapes`, `Nomcategorie`, `Imagepath`, `Nombrepersonne`, `Cout`) VALUES
(1, 'Crêpe salé', '1. Dans un grand saladier, battre ensemble les œufs et le sel. Incorporer progressivement la farine en fouettant pour former une pâte, puis petit à petit le lait. Enfin ajouter le beurre fondu. Bien mélanger.\nLaisser la pâte à crêpes reposer 1 heure.\n\n2. Chauffer une poêle antiadhésive à feu moyen élevé. Badigeonner d''un filet d''huile neutre puis verser une petite louche de pâte dans la poêle. Faire tourner la poêle pour bien enrober le fond. Cuire jusqu’à ce que le premier côté soit doré puis retourner et faire cuire 30 secondes supplémentaires. Retirer et reproduire jusqu’à ce qu’il n’y ait plus de pâte. Réaliser 8 crêpes.\n\n3. Mélanger le fromage frais à l’aide d’une fourchette pour lui donner une texture onctueuse. Y ajouter quelques brins d’aneth, et de persil, le zeste d''un demi-citron, et l’ail haché. Mélanger et assaisonner à votre goût.\n\n4. Étaler une fine couche de fromage aux herbes sur l’intégralité de la crêpe. Déposer une feuille de batavia et une tranche de saumon fumé. Rouler en serrant bien dans du film alimentaire. Placer les rouleaux au réfrigérateur pendant 30 minutes.\n\n5. Sortir les rouleaux et le découper en deux en biseau juste avant deservir.', 'Entree', './images/crepesalee.PNG', 4, 0),
(2, 'Ratatouille', 'Lavez et détaillez les courgettes, l''aubergine, le poivron vert et le rouge, en cubes de taille moyenne. Coupez les tomates en quartiers et émincez l''oignon.\r\nDans une poêle, versez un peu d''huile d''olive et faites-y revenir les uns après les autres les différents légumes pendant 5 minutes pour qu''ils colorent. Commencez par les poivrons, puis les aubergines, les courgettes et enfin les oignons et les tomates que vous cuirez ensemble.\r\nAprès avoir fait cuire les légumes, ajoutez-les tous aux tomates et aux oignons, baissez le feu puis mélangez. Ajoutez un beau bouquet garni de thym, de romarin et de laurier, salez, poivrez, puis couvrez pour laisser mijoter 40 minutes en remuant régulièrement.\r\nÀ environ 10 minutes du terme de la cuisson, ajoutez les deux belles gousses d''ail écrasées puis couvrez de nouveau. N''hésitez pas à goûter et à assaisonner de nouveau selon vos goûts.', 'Plat', './images/ratatouille.PNG', 6, 0),
(3, 'Riz au lait', 'Dans une casserole, versez un litre d''eau avec une pincée de sel et portez à ébullition. Ajoutez le riz et laissez-le cuire pendant 3 minutes avant de l''égoutter. Le but consiste à nettoyer le riz pour le débarrasser de sa poussière.\nVersez le lait et la crème liquide dans une casserole. Grattez l''intérieur d''une gousse de vanille et ajoutez-la avec les grains dans la casserole. Incisez un bâton de cannelle dans la longueur et plongez-le avec le reste. Portez le tout à ébullition.\n\nVersez le riz et le sucre dans la casserole. Laissez cuire à feu doux pendant 30 à 40 minutes en surveillant et en remuant de temps en temps. Arrêtez la cuisson lorsque le riz est bien cuit et qu''il reste un peu de lait dans la casserole.', 'Dessert', './images/rizaulait.PNG', 4, 0);


--
-- Dumping data for table `Commentaires`
--

INSERT INTO `Commentaires` (`Idcommentaire`, `Commentaire`, `Idrecette`, `Datecommentaire`) VALUES
(1, 'recette facile et rapide à préparée c''est un vrai délice je me suis réglée avec ma famillle, c''est une recette à refaire sans doute .je vous recommande vivement cette recette à la tester ainsi que le site   merci infiniment ', 1, '2021-03-16'),
(2, 'recette facile et rapide à préparée c''est un vrai délice je me suis réglée avec ma famillle, c''est une recette à refaire sans doute .je vous recommande vivement cette recette à la tester ainsi que le site merci infiniment ', 1, '2021-03-16'),
(3, 'C''est une ratatouille savoureuse.Les temps de cuisson sont corrects.Cette recette apporte une meilleure cuisson des légumes, par rapport à ma recette habituelle, qui était d''ajouter, au fur et à mesure, les légumes dans le même faitout.Je l''ai préparée plusieurs fois cet été, je la recommande!', 2, '2021-03-21'),
(4, 'Une excellente recette!!!!! C''est la première ratatouille que je réalise et c''était un véritable délice!!! Ni mon mari ni moi sommes fans de ce plat mais là nous l''avons tout simplement dégusté!!! Il n''a rien laissé!! vraiment merci pour cette succulente recette! une vraie révélation et une réussite pour nous !!!! Un plat onctueux, plein de saveurs.... à refaire très très vite pour la famille!!', 2, '2021-04-01'),
(5, 'J''ai essayé beaucoup de recette de riz au lait... J''ai jamais vraiment réussi à avoir un bon rendu à art avec cette recette... C''est trop bon ! J''ai un peu réduit le sucre (70gr au lieu de 100gr) et j''ai utilisé un riz long car je n''avais pas de riz rond. Et bien le résultat est succulent !', 3, '2021-05-01'),
(6, 'Très facile à faire. Et pour ceux, qui aiment la noix de coco, on peut rajouter du lait de coco en fin de cuisson. __Merci pour cette délicieuse recette !', 3, '2021-06-01');

--
-- Dumping data for table `Compositions`
--

INSERT INTO `Compositions` (`Idingredient`, `Idrecette`, `Quantitee`, `Unite`) VALUES
(1, 1, 200, 'g'),
(2, 1, 2, ''),
(3, 1, 60, 'g'),
(4, 1, 500, 'ml'),
(4, 3, 750, 'ml'),
(5, 1, 1, ''),
(5, 3, 1, ''),
(6, 1, 250, 'g'),
(7, 1, 300, 'ml'),
(8, 1, 250, 'g'),
(9, 1, 2, ''),
(10, 1, 1, ''),
(11, 1, 100, 'g'),
(12, 2, 300, 'g'),
(13, 2, 300, 'g'),
(14, 2, 400, 'g'),
(15, 2, 100, 'g'),
(16, 2, 200, 'g'),
(17, 2, 100, 'ml'),
(18, 2, 100, 'g'),
(19, 2, 150, 'g'),
(20, 2, 100, 'g'),
(21, 3, 100, 'g'),
(22, 3, 1, ''),
(23, 3, 120, 'g'),
(24, 3, 200, 'ml');




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
