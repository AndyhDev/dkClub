<?php
include_once("includes/database.php");
include_once("includes/util.php");
include_once("includes/counter.php");
include_once("includes/intern.php");
include_once("includes/plugin.php");

$background_data = array("background1.jpg", "background2.jpg", "background3.jpg", "background4.jpg", "background5.jpg", "background6.jpg", "background7.jpg","background8.jpg", "background9.jpg", "background10.jpg",
                         "#FFF", "#A4A4A4", "#1C1C1C", "#F6E3CE", "#FE642E", "#8A2908", "#CEF6CE", "#D0FA58", "#86B404", "#CEE3F6", "#81F7F3", "#0489B1");
$background_methode = array("img", "color", "none");

session_start();
if(!isset($_SESSION["counter"])){
    $_SESSION["counter"] = "ok";
    counter_up();
}
if(isset($_COOKIE["background-data"]) and isset($_COOKIE["background-methode"])){
    if(in_array($_COOKIE["background-data"], $background_data) and in_array($_COOKIE["background-methode"], $background_methode)){
        if($_COOKIE["background-methode"] == "img"){
            $background = "background : url(img/" . $_COOKIE["background-data"] . ") no-repeat fixed;";
            
        }elseif($_COOKIE["background-methode"] == "color"){
            $background = "background : " . $_COOKIE["background-data"];
            
        }else{
            $background = "";
        }
    }else{
        $background = "background : url(img/background10.jpg) no-repeat fixed;";
    }
}else{
    $background = "background : url(img/background10.jpg) no-repeat fixed;";
}
$tmpl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    
    <title>Schwäbischer Eisenbahnverein Dampfbahn Kürnbach e.V.</title>
    
    <link rel="stylesheet" type="text/css" href="styles/html.css"/>
    <link rel="stylesheet" type="text/css" href="styles/default.css"/>
    <style type="text/css">
    <!--
      body{
        %background%;
      }
      #main_div{
        background : #ffffff;
        position : relative;
        width : 1030px;
        margin : 15px auto;
      }
      #header{
        text-align : center;
      }
      #layout{
        margin : 30px 15px 15px 15px;
        padding-bottom : 5px;
      }
      #footer {
        position : relative;
        margin-top : 10px;
        height : 31px;
      }
      #validator_link img{
        border : 0px;
      }
      #validator_link{
        position : absolute;
        right : 0px;
      }
    -->
    </style>
  </head>
  <body>
    <div id="main_div">
      <div id="header">
        <img src="img/logo.gif" alt="Logo des Schwäbischer Eisenbahnverein"/>
      </div>
      <div id="layout">
        <h1 class="text_center">Kontaktformular</h1><br/>';
        
echo str_replace("%background%", $background, $tmpl);  
   
$ok = True;
if(!isset($_POST['Vorname'])){
    $ok = False;
    echo "Keinen Vornamen angegeben<br/>";
}elseif(empty($_POST['Vorname'])){
    $ok = False;
    echo "Keinen Vornamen angegeben<br/>";
}
$vorname = $_POST['Vorname'];


$ok = True;
if(!isset($_POST['Nachname'])){
    $ok = False;
    echo "Keinen Nachnamen angegeben<br/>";
}elseif(empty($_POST['Nachname'])){
    $ok = False;
    echo "Keinen Nachnamen angegeben<br/>";
}
$nachname = $_POST['Nachname'];

if(!isset($_POST['email'])){
    $ok = False;
    echo "Keine E-Mail angegeben<br/>";
}elseif(empty($_POST['email'])){
    $ok = False;
    echo "Keine E-Mail angegeben<br/>";
}elseif(!check_email($_POST['email'])){
    $ok = False;
    echo "Keine gültige E-Mail angegeben<br/>";
}
$email = $_POST['email'];


if(!isset($_POST['frage'])){
    $ok = False;
    echo "Keine Frage angegeben<br/>";
}elseif(empty($_POST['email'])){
    $ok = False;
    echo "Keine Frage angegeben<br/>";
}
$frage = $_POST['frage'];

if($ok){
    $info = $_POST['info'];
    $plz = $_POST['PLZ'];
    $ort = $_POST['Ort'];
    $strasse = $_POST['Strasse'];
    
    $text = "Es wurde eine Frage bezüglich ''$info'' gestellt.

Adresse:
    Vorname : $vorname
    Nachname : $nachname
    Starße : $strasse
    PLZ : $plz
    Ort : $ort
    E-Mail : $email

Die Frage lautet:
$frage";
    
    $text2 = "Dies ist die Bestätigungsmail das ihre Frage an den SEV übermittelt wurde, desweiteren bekommen sie eine eine Kopie der Mail:
--------------------------------------------------------
Es wurde eine Frage bezüglich ''$info'' gestellt.

Adresse:
    Vorname : $vorname
    Nachname : $nachname
    Starße : $strasse
    PLZ : $plz
    Ort : $ort
    E-Mail : $email

Die Frage lautet:
$frage";

    $betreff = "Es wurden eine Frage gestellt";
    $absendermail = $email;
    $absendername = $vorname . " " . $nachname;
    $empfaenger = "info@sev-kuernbach.de";
    $header = "From: $absendername <$absendermail>" . "\r\n";
    $header = $header . 'MIME-Version: 1.0' . "\r\n";
    $header = $header . 'Content-type: text/plain; charset=utf-8' . "\r\n";
    mail($empfaenger, $betreff, $text, $header);
    
    $absendermail = "webmaster@sev-kuernbach.de";
    $absendername = "Webmaster";
    $header = "From: $absendername <$absendermail>" . "\r\n";
    mail($email, $betreff, $text2, $header);
    
    echo "<h1>Vielen Dank für ihre Frage</h1>";
}
echo '</div>
    </div>
  </body>
</html>'
?>