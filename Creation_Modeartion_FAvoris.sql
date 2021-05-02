CREATE TABLE Moderations (
    Idmoderation int NOT NULL,
    PRIMARY KEY (Idmoderations),
    FOREIGN KEY (Idmoderations) REFERENCES Recettes(Idrecette)
);

CREATE TABLE Favoris (
	Idutilisateur int NOT NULL,
    Idrecette int NOT NULL,
    PRIMARY KEY (Idutilisateur,Idrecette),
    FOREIGN KEY (Idutilisateur) REFERENCES Utilisateurs(id),
    FOREIGN KEY (Idrecette) REFERENCES Recettes(Idrecette)
);