<?php 
include_once 'defaults.php';

$_SESSION["database_server_error"] = "";
$_SESSION["database_name_error"] = "";
$_SESSION["database_user_error"] = "";
$_SESSION["database_name_error"] = "";

$_SESSION["database_server"] = get_safe_post("database_server", 30);
$_SESSION["database_name"] = get_safe_post("database_name", 30);
$_SESSION["database_user"] = get_safe_post("database_user", 30);
$_SESSION["database_passw"] = get_safe_post("database_passw", 30);

$link = mysql_connect($_SESSION["database_server"], $_SESSION["database_user"], $_SESSION["database_passw"]);
if (!$link) {
	$_SESSION["database_server_error"] = "Verbindung schlug fehl: " . mysql_error($link);
	header('Location: index.php');
	exit();
}
if(!mysql_select_db($_SESSION["database_name"])){
	$_SESSION["database_name_error"] = "Diese Datebank konnte nicht ausgewählt werden";
	header('Location: index.php');
	exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    
    <title>dk Club Beta 0.1</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
    
    <style type="text/css">
    html, body{
    	margin: 0px;
    	padding: 0px;
    }
    body{
    	background-image: url("/img/background9.jpg");
    	font-family: Helvetica, Arial, sans-serif;
    }
    .main{
    	width:1030px;
    	margin: 10px auto;
    	background-color: white;
    }
    .header{
    	padding-bottom: 10px;
    	text-align:center;
    }
    .content{
    	padding:20px;
    }
    .greenbox{
    	margin: 10px;
    	padding: 10px;
    	background-color: #04B404;
    }
    .redbox{
   		margin: 10px;
    	padding: 10px;
    	background-color: #FE2E2E;
    }
    </style>
    <script type="text/javascript">
    <!--

    // -->
    </script>
  </head>
  <body> 
    <div class="main">
    <div class="header"><img src="header.png" alt="header" /></div>
    
    <div class="content">
    	<h1>Install 2/3</h1>
    	<div class="greenbox">
    		es wurde erfolgreich mit der Datenbank verbunden
     	</div>
     	<?php
     	$errors = mkdb();
     	if(!$errors){
			echo "<div class='greenbox'>Die Datenbank wurde erfolgreich erstellt</div>";
		}else{
			echo "<div class='redbox'>Die Datenbank konnte nicht angelegt werden</div>";
		} 
     	?>
    	<h3>3: Benutzer "Admin" anlegen</h3>
    	<form action="step3.php" method="post">
    		<table>
    			<tr>
    				<td>Benutzername: </td><td><input type="text" name="admin_name" value="<?php get_session_value("admin_name")?>"/></td>
    				<td><?php get_session_value("admin_name_error")?></td>
    			</tr>
    			<tr>
    				<td>Passwort: </td><td><input type="text" name="admin_passw1" value=""/></td>
    				<td><?php get_session_value("admin_passw1_error")?></td>
    			</tr>
    			<tr>
    				<td>Passwort Wiederholen: </td><td><input type="text" name="admin_passw2" value=""/></td>
    				<td><?php get_session_value("admin_passw2_error")?></td>
    			</tr>
    		</table>
    		<p>
    			<input type="submit" value="Einstellung testen und weiter"/>
    		</p>
    	</form>
    </div>
    </div>
<?php

?>
</body>
</html>