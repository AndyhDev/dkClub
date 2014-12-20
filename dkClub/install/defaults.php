<?php
session_start();
function get_session_value($name){
	if(isset($_SESSION[$name])){
		return $_SESSION[$name];
	}else{
		return "";
	}
}

function get_safe_post($key, $maxlen){
	if(isset($_POST[$key])){
		if(strlen($_POST[$key]) <= $maxlen){
			return htmlspecialchars($_POST[$key]);
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function mkadmin(){
	$name = mysql_real_escape_string($_SESSION["admin_name"]);
	$passw1 = $_SESSION["admin_passw1"];
	$passw2 = $_SESSION["admin_passw2"];
	
	$errors = false;
	if(strlen($name) < 4){
		$errors = true;
		echo "-Benutzername zu kurz, min. 4 Zeichen<br/>";
	}
	if(strlen($passw1) < 6){
		$errors = true;
		echo "-Passwort zu kurz, min. 6 Zeichen<br/>";
	}
	if($passw1 != $passw2){
		$errors = true;
		echo "-Die Passwörter stimmen nicht überein<br/>";
	}
	if(!$errors){
		$passw = sha1($passw1);
		$sql = "INSERT INTO mitglieder (name, special, passwort, active)
				VALUES ('$name', 1, '$passw', 1)";
		
		if(!mysql_query($sql)){
			$errors = true;
			echo "-Benutzer konnte nicht angelegt werden: " + mysql_errno() + "<br/>";
		}
	}
	return $errors;
}
function mkdb(){
	mysql_query("SET NAMES 'utf8'");
	
	$sql1 = "CREATE TABLE IF NOT EXISTS `backup` (
`id` int(5) NOT NULL AUTO_INCREMENT,
  `site` varchar(250) COLLATE latin1_german1_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `old` text COLLATE latin1_german1_ci NOT NULL,
  `diff` text COLLATE latin1_german1_ci NOT NULL,
   primary key (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;";
	
	$sql2 = "CREATE TABLE IF NOT EXISTS `counter` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
  `count` int(10) NOT NULL,
   primary key (ID)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;";
	
	$sql3 = "CREATE TABLE IF NOT EXISTS `days` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
  `motto` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `datum` date NOT NULL,
  `start_zeit` varchar(30) COLLATE latin1_german1_ci NOT NULL,
  `end_zeit` varchar(30) COLLATE latin1_german1_ci NOT NULL,
  `eintritt` varchar(30) COLLATE latin1_german1_ci NOT NULL,
  `zusatz` varchar(250) COLLATE latin1_german1_ci NOT NULL,
   primary key (ID)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;";
	
	$sql4 = "CREATE TABLE IF NOT EXISTS `guestbook` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE latin1_german1_ci NOT NULL,
  `e_mail` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `nachricht` text CHARACTER SET latin1 NOT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ok` int(1) NOT NULL DEFAULT '0',
   primary key (ID)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;";
	
	$sql5 = "CREATE TABLE IF NOT EXISTS `loose_pages` (
`id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE latin1_german1_ci NOT NULL,
  `display` int(5) NOT NULL,
   primary key (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;";
	
	$sql6 = "CREATE TABLE IF NOT EXISTS `menu` (
`id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE latin1_german1_ci NOT NULL,
  `typ` int(1) NOT NULL,
  `display` int(10) NOT NULL,
  `site` varchar(150) COLLATE latin1_german1_ci NOT NULL,
  `pos` int(5) NOT NULL,
   primary key (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;";
	
	$sql7 = "CREATE TABLE IF NOT EXISTS `mitglieder` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `vorname` varchar(30) COLLATE latin1_german1_ci NOT NULL,
  `nachname` varchar(30) COLLATE latin1_german1_ci NOT NULL,
  `e_mail` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `e_mail_club` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `special` int(1) NOT NULL DEFAULT '0',
  `passwort` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
   primary key (ID)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;";
	
	$sql8 = "CREATE TABLE IF NOT EXISTS `new_password` (
`id` int(10) NOT NULL AUTO_INCREMENT,
  `user` int(10) NOT NULL,
  `code` varchar(250) COLLATE latin1_german1_ci NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
   primary key (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;";
	
	$sql9 = "CREATE TABLE IF NOT EXISTS `settings` (
`id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE latin1_german1_ci NOT NULL,
  `value` text COLLATE latin1_german1_ci NOT NULL,
  `info` varchar(250) COLLATE latin1_german1_ci NOT NULL,
   primary key (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;";
	
	$sql10 = "CREATE TABLE IF NOT EXISTS `sites` (
`id` int(10) NOT NULL AUTO_INCREMENT,
  `day` date NOT NULL,
  `site` varchar(40) COLLATE latin1_german1_ci NOT NULL,
  `clicks` int(5) NOT NULL,
   primary key (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;";
	
	$sql11 = "CREATE TABLE IF NOT EXISTS `statistic` (
`id` int(10) NOT NULL AUTO_INCREMENT,
  `day` date NOT NULL,
  `clicks` int(5) NOT NULL,
   primary key (id)
) ENGINE=MyISAM AUTO_INCREMENT=856 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;";
	
	$sql12 = "CREATE TABLE IF NOT EXISTS `termin_abf` (
`id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE latin1_german1_ci NOT NULL,
  `hinweis` text COLLATE latin1_german1_ci NOT NULL,
  `1` int(1) NOT NULL,
  `2` int(1) NOT NULL,
  `3` int(1) NOT NULL,
  `4` int(1) NOT NULL,
  `5` int(1) NOT NULL,
  `6` int(1) NOT NULL,
  `7` int(1) NOT NULL,
  `8` int(1) NOT NULL,
  `9` int(1) NOT NULL,
  `10` int(1) NOT NULL,
  `11` int(1) NOT NULL,
  `12` int(1) NOT NULL,
  `13` int(1) NOT NULL,
  `14` int(1) NOT NULL,
  `15` int(1) NOT NULL,
  `16` int(1) NOT NULL,
  `17` int(1) NOT NULL,
  `18` int(1) NOT NULL,
  `19` int(1) NOT NULL,
  `20` int(1) NOT NULL,
  `21` int(1) NOT NULL,
  `22` int(1) NOT NULL,
  `23` int(1) NOT NULL,
  `24` int(1) NOT NULL,
  `25` int(1) NOT NULL,
  `26` int(1) NOT NULL,
  `27` int(1) NOT NULL,
  `28` int(1) NOT NULL,
  `29` int(1) NOT NULL,
  `30` int(1) NOT NULL,
  `31` int(1) NOT NULL,
  `32` int(1) NOT NULL,
  `33` int(1) NOT NULL,
  `34` int(1) NOT NULL,
  `35` int(1) NOT NULL,
  `36` int(1) NOT NULL,
  `37` int(1) NOT NULL,
  `38` int(1) NOT NULL,
  `39` int(1) NOT NULL,
  `40` int(1) NOT NULL,
  `41` int(1) NOT NULL,
  `42` int(1) NOT NULL,
  `43` int(1) NOT NULL,
  `44` int(1) NOT NULL,
  `45` int(1) NOT NULL,
  `46` int(1) NOT NULL,
  `47` int(1) NOT NULL,
  `48` int(1) NOT NULL,
  `49` int(1) NOT NULL,
  `50` int(1) NOT NULL,
   primary key (id)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;";
	
	
	$sql13 = "CREATE TABLE IF NOT EXISTS `termin_abf_config` (
`id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE latin1_german1_ci NOT NULL,
  `date` date NOT NULL,
  `type` int(1) NOT NULL,
  `link` int(4) NOT NULL,
   primary key (id)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;";
	
	
	$sql14 = "INSERT INTO menu (name, typ, display, site, pos) VALUES
			('Startseite', 1, 0, 'index', 1),
			('ein Hauptpunkt', 2, 0, '', 2),
			('ein Unterpunkt', 3, 2, 'seite2', 1),
			('Intern', 4, 0, '', 3),
			('Intern', 5, 4, 'i_index', 1);";
	
	$errors = false;
	if(!mysql_query($sql1)){
		echo "-Fehler beim anlegen der Tablelle 'backup'</br>";
		$errors = true;
	}
	if(!mysql_query($sql2)){
		echo "-Fehler beim anlegen der Tablelle 'counter'</br>";
		$errors = true;
	}
	if(!mysql_query($sql3)){
		echo "-Fehler beim anlegen der Tablelle 'days'</br>";
		$errors = true;
	}
	if(!mysql_query($sql4)){
		echo "-Fehler beim anlegen der Tablelle 'guestbook'</br>";
		$errors = true;
	}
	if(!mysql_query($sql5)){
		echo "-Fehler beim anlegen der Tablelle 'loose_pages'</br>";
		$errors = true;
	}
	if(!mysql_query($sql6)){
		echo "-Fehler beim anlegen der Tablelle 'menu'</br>";
		$errors = true;
	}
	if(!mysql_query($sql7)){
		echo "-Fehler beim anlegen der Tablelle 'mitglieder'</br>";
		$errors = true;
	}
	if(!mysql_query($sql8)){
		echo "-Fehler beim anlegen der Tablelle 'new_password'</br>";
		$errors = true;
	}
	if(!mysql_query($sql9)){
		echo "-Fehler beim anlegen der Tablelle 'settings'</br>";
		$errors = true;
	}
	if(!mysql_query($sql10)){
		echo "-Fehler beim anlegen der Tablelle 'sites'</br>";
		$errors = true;
	}
	if(!mysql_query($sql11)){
		echo "-Fehler beim anlegen der Tablelle 'statistic'</br>";
		$errors = true;
	}
	if(!mysql_query($sql12)){
		echo "-Fehler beim anlegen der Tablelle 'termin_abf'</br>";
		$errors = true;
	}
	if(!mysql_query($sql13)){
		echo "-Fehler beim anlegen der Tablelle 'termin_abf_config'</br>";
		$errors = true;
	}
	if(!mysql_query($sql14)){
		echo "-Fehler beim befüllen der Tablelle 'menu'</br>";
		$errors = true;
	}
	return $errors;
}
?>