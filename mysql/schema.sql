
CREATE TABLE `Einheit` (
 `ID` int(11) NOT NULL,
 `Name` varchar(255) NOT NULL,
 `Standard` tinyint(1) NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE `Einkauf` (
  `ID` int(11) NOT NULL,
  `Anzahl` double NOT NULL DEFAULT '1',
  `Einheit` int(11) NOT NULL DEFAULT '5',
  `Name` varchar(255) NOT NULL,
  `Erledigt` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `uid` INT NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(128),
  `theme` varchar(128) NULL,
  `password` char(128) NOT NULL,
  `salt` char(64) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `session_id` varchar(255),
  `user` INT NOT NULL,
  `expires` datetime NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE `Rezept` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Dauer` int(11) NOT NULL,
  `Beschreibung` longtext NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE `RezeptZutat` (
  `ID` int(11) NOT NULL,
  `Rezept` int(11) NOT NULL,
  `Menge` float NOT NULL,
  `Einheit` int(11) NOT NULL,
  `Zutat` int(11) NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE `Zutat` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE VIEW `ViewEinkauf` AS  select `Einkauf`.`ID` AS `ID`,`Einkauf`.`Anzahl` AS `Anzahl`,`Einheit`.`Name` AS `Einheit`,`Einkauf`.`Name` AS `Name`,`Einkauf`.`Erledigt` AS `Erledigt` from (`Einkauf` join `Einheit` on((`Einkauf`.`Einheit` = `Einheit`.`ID`))) ;

ALTER TABLE `Einheit`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `Einkauf`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_Einheit` (`Einheit`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

ALTER TABLE `Rezept`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `RezeptZutat`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_rezeptzutat_rezept` (`Rezept`),
  ADD KEY `fk_rezeptzutat_einheit` (`Einheit`),
  ADD KEY `fk_rezeptzutat_zutat` (`Zutat`);

ALTER TABLE `Zutat`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `Einheit`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Einkauf`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Rezept`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `RezeptZutat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Zutat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `uid` INT NOT NULL AUTO_INCREMENT,
  MODIFY `username` varchar(32) NOT NULL UNIQUE;

ALTER TABLE `sessions`
  ADD CONSTRAINT `fk_session_uid` FOREIGN KEY (`user`) REFERENCES `users` (`uid`);

ALTER TABLE `Einkauf`
  ADD CONSTRAINT `fk_einkauf_einheit` FOREIGN KEY (`Einheit`) REFERENCES `Einheit` (`ID`);

ALTER TABLE `RezeptZutat`
  ADD CONSTRAINT `fk_rezeptzutat_einheit` FOREIGN KEY (`Einheit`) REFERENCES `Einheit` (`ID`),
  ADD CONSTRAINT `fk_rezeptzutat_rezept` FOREIGN KEY (`Rezept`) REFERENCES `Rezept` (`ID`),
  ADD CONSTRAINT `fk_rezeptzutat_zutat` FOREIGN KEY (`Zutat`) REFERENCES `Zutat` (`ID`);

INSERT INTO `Einheit` (`ID`, `Name`, `Standard`) VALUES
  (1, 'g', 0),
  (2, 'kg', 0),
  (3, 'ml', 0),
  (4, 'l', 0),
  (5, 'x', 1),
  (6, 'EL', 0),
  (7, 'TL', 0),
  (8, 'Prise', 0),
  (9, 'Dose', 0),
  (10, 'Packung', 0),
  (11, 'Glas', 0);