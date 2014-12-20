<?php include_once 'defaults.php'; 
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
    .yellowbox{
   		margin: 10px;
    	padding: 10px;
    	background-color: #FFBF00;
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
    	<h1>Install 1/3</h1>
    	
    	<h3>1: PHP Check</h3>
    	<?php
    	if(version_compare(PHP_VERSION, "5.2.0") >= 0){
			echo "<div class='greenbox'>Deine PHP Version ist aktuell genug: " . PHP_VERSION . "</div>";
		}else{
			echo "<div class='redbox'>Deine PHP Version ist leider zu alt, du hast: " . PHP_VERSION . " <br/>es wird aber mindestens 5.2.0 benötig </div>";
		}
		if(is_writable(realpath(dirname(dirname(__FILE__))))){
			echo "<div class='greenbox'>PHP darf in diesem Verzeichnis Dateinen schreiben</div>";
		}else{
			echo "<div class='yellowbox'>PHP darf in diesem Verzeichnis nicht schreiben, sie können fortfahren, müssen dann aber am Ende der Installation eine Datei manuel anlegen.</div>";
		}
    	?>
    	<h3>2: mit MySql verbinden</h3>
    	<form action="step2.php" method="post">
    		<table>
    			<tr>
    				<td>Datebank-Server: </td><td><input type="text" name="database_server" value="<?php echo get_session_value("database_server")?>"/></td>
    				<td><?php echo get_session_value("database_server_error")?></td>
    			</tr>
    			<tr>
    				<td>Datenbank-Name: </td><td><input type="text" name="database_name" value="<?php echo  get_session_value("database_name")?>"/></td>
    				<td><?php echo get_session_value("database_name_error")?></td>
    			</tr>
    			<tr>
    				<td>Datenbank-Benutzer: </td><td><input type="text" name="database_user" value="<?php echo get_session_value("database_user")?>"/></td>
    				<td><?php echo get_session_value("database_user_error")?></td>
    			</tr>
    			<tr>
    				<td>Datenbank-Passwort: </td><td><input type="text" name="database_passw" value=""/></td> 
    				<td><?php echo get_session_value("database_passw_error")?></td>
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