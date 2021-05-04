

-- --------------------------------------------------------
--
-- Structure de la table 'Categories'
--


CREATE TABLE IF NOT EXISTS Categories (
 
  Nomcategorie varchar(15) NOT NULL,
  PRIMARY KEY (Nomcategorie)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------
--
-- Structure de la table 'Ingredients'
--


CREATE TABLE IF NOT EXISTS Ingredients(
  Idingredient int NOT NULL AUTO_INCREMENT ,
  Nomingredient varchar(30) NOT NULL DEFAULT '',
  Prix float(10) DEFAULT NULL,
  PRIMARY KEY (Idingredient)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Structure de la table 'Recettes'
--


CREATE TABLE IF NOT EXISTS Recettes (
  Idrecette int(11) NOT NULL AUTO_INCREMENT,
  Nomrecette varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '',
  Etapes text CHARACTER SET utf8 NOT NULL,
  Nomcategorie varchar(15) NOT NULL,
  Imagepath varchar(255) DEFAULT NULL,
  Nombrepersonne int(11) NOT NULL,
  Cout float NOT NULL,

  PRIMARY KEY (Idrecette),
  FOREIGN KEY (Nomcategorie) REFERENCES  Categories(Nomcategorie)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Structure de la table 'Commentaires'
--


CREATE TABLE IF NOT EXISTS Commentaires (
  Idcommentaire int NOT NULL AUTO_INCREMENT,
  Commentaire text NOT NULL,
  Idrecette int NOT NULL,
  Datecommentaire date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (Idcommentaire),
  FOREIGN KEY (Idrecette) REFERENCES Recettes(Idrecette)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Structure de la table 'Compositions' 
--


CREATE TABLE IF NOT EXISTS Compositions (
  Idingredient int NOT NULL,
  Idrecette int NOT NULL,
  Quantitee int NOT NULL,
  Unite varchar(10) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (Idingredient,Idrecette),
  FOREIGN KEY (Idrecette) REFERENCES Recettes(Idrecette),
  FOREIGN KEY (Idingredient) REFERENCES Ingredients(Idingredient) 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;





--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE IF NOT EXISTS `Utilisateurs` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(80) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Structure de la table 'Moderations' 
--


CREATE TABLE IF NOT EXISTS Moderations (
  Idmoderation int NOT NULL,
  PRIMARY KEY (Idmoderations),
  FOREIGN KEY (Idmoderations) REFERENCES Recettes(Idrecette)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Structure de la table 'Favoris' 
--


CREATE TABLE IF NOT EXISTS Favoris (
  Idutilisateur int NOT NULL,
  Idrecette int NOT NULL,
  PRIMARY KEY (Idutilisateur,Idrecette),
  FOREIGN KEY (Idutilisateur) REFERENCES Utilisateurs(id),
  FOREIGN KEY (Idrecette) REFERENCES Recettes(Idrecette)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

