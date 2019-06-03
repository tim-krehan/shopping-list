<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
if (!(is_writable($_SESSION["docroot"].'/config/config.php')))
{
  if(file_exists($_SESSION["docroot"].'/config/config.php'))
  {
    header("Location: /error/ConfigReadOnly");
    exit;
  }
  elseif (!(is_writable($_SESSION["docroot"].'/config')))
  {
    header("Location: /error/ConfigFolderReadOnly");
    exit;
  }
}


include $_SESSION["docroot"].'/config/config.php';
if($CONFIG['installed']=='true'){
  header("Location: /");
}




$connection = new mysqli(
  $host = $_POST['dbhost'],
  $username = $_POST['username'],
  $passwd = $_POST['passwd'],
  $database = $_POST['database']
);

if (!is_null($connection->connect_error))
{
    header("Location: /error/DBConnFailed");
    exit;
}

$CONFIG["installed"] = true;
$CONFIG["host"] = $_POST['dbhost'];
$CONFIG["database"] = $_POST['database'];
$CONFIG["username"] = $_POST['username'];
$CONFIG["passwd"] = $_POST['passwd'];

file_put_contents($_SESSION["docroot"].'/config/config.php', '<?php '."\r\n".'$CONFIG = '.var_export($CONFIG, true).";\n\r?>");

$SQLStatements = Array ();
array_push($SQLStatements, "
CREATE TABLE `Einheit` (
 `ID` int(11) NOT NULL,
 `Name` varchar(255) NOT NULL,
 `Standard` tinyint(1) NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;");

array_push($SQLStatements, "
CREATE TABLE `Einheit` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Standard` tinyint(1) NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;");

array_push($SQLStatements, "
CREATE TABLE `Einkauf` (
  `ID` int(11) NOT NULL,
  `Anzahl` double NOT NULL DEFAULT '1',
  `Einheit` int(11) NOT NULL DEFAULT '5',
  `Name` varchar(255) NOT NULL,
  `Erledigt` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;");

array_push($SQLStatements, "
CREATE TABLE `users` (
  `uid` INT NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(128),
  `theme` varchar(128) NULL,
  `password` char(128) NOT NULL,
  `salt` char(64) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;");

array_push($SQLStatements, "
CREATE TABLE `sessions` (
  `session_id` varchar(255),
  `user` INT NOT NULL,
  `expires` datetime NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;");

array_push($SQLStatements, "
CREATE TABLE `Rezept` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Dauer` int(11) NOT NULL,
  `Beschreibung` text NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;");

array_push($SQLStatements, "
CREATE TABLE `RezeptZutat` (
  `ID` int(11) NOT NULL,
  `Rezept` int(11) NOT NULL,
  `Menge` float NOT NULL,
  `Einheit` int(11) NOT NULL,
  `Zutat` int(11) NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;");

array_push($SQLStatements, "
CREATE TABLE `Zutat` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;");

array_push($SQLStatements, "
CREATE VIEW `ViewEinkauf` AS  select `Einkauf`.`ID` AS `ID`,`Einkauf`.`Anzahl` AS `Anzahl`,`Einheit`.`Name` AS `Einheit`,`Einkauf`.`Name` AS `Name`,`Einkauf`.`Erledigt` AS `Erledigt` from (`Einkauf` join `Einheit` on((`Einkauf`.`Einheit` = `Einheit`.`ID`))) ;");


array_push($SQLStatements, "
ALTER TABLE `Einheit`
  ADD PRIMARY KEY (`ID`);");

array_push($SQLStatements, "
ALTER TABLE `Einkauf`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_Einheit` (`Einheit`);");

array_push($SQLStatements, "
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);");

array_push($SQLStatements, "
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);");

array_push($SQLStatements, "
ALTER TABLE `Rezept`
  ADD PRIMARY KEY (`ID`);");

array_push($SQLStatements, "
ALTER TABLE `RezeptZutat`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_rezeptzutat_rezept` (`Rezept`),
  ADD KEY `fk_rezeptzutat_einheit` (`Einheit`),
  ADD KEY `fk_rezeptzutat_zutat` (`Zutat`);");

array_push($SQLStatements, "
ALTER TABLE `Zutat`
  ADD PRIMARY KEY (`ID`);");


array_push($SQLStatements, "
ALTER TABLE `Einheit`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;");

array_push($SQLStatements, "
ALTER TABLE `Einkauf`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;");

array_push($SQLStatements, "
ALTER TABLE `Rezept`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;");

array_push($SQLStatements, "
ALTER TABLE `RezeptZutat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;");

array_push($SQLStatements, "
ALTER TABLE `Zutat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;");

array_push($SQLStatements, "
ALTER TABLE `users`
  MODIFY `uid` INT NOT NULL AUTO_INCREMENT,
  MODIFY `username` varchar(32) NOT NULL UNIQUE;
  ");

array_push($SQLStatements, "
ALTER TABLE `sessions`
  ADD CONSTRAINT `fk_session_uid` FOREIGN KEY (`user`) REFERENCES `users` (`uid`);");

array_push($SQLStatements, "
ALTER TABLE `Einkauf`
  ADD CONSTRAINT `fk_einkauf_einheit` FOREIGN KEY (`Einheit`) REFERENCES `Einheit` (`ID`);");

array_push($SQLStatements, "
ALTER TABLE `RezeptZutat`
  ADD CONSTRAINT `fk_rezeptzutat_einheit` FOREIGN KEY (`Einheit`) REFERENCES `Einheit` (`ID`),
  ADD CONSTRAINT `fk_rezeptzutat_rezept` FOREIGN KEY (`Rezept`) REFERENCES `Rezept` (`ID`),
  ADD CONSTRAINT `fk_rezeptzutat_zutat` FOREIGN KEY (`Zutat`) REFERENCES `Zutat` (`ID`);");

array_push($SQLStatements, "
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
  (11, 'Glas', 0);");


foreach($SQLStatements as $statement){
  $result = $connection->query($statement);
}
$connection->close();
header ("Location: install_adduser.php");
?>
