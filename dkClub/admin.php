<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    
    <title>Admin-Bereich</title>
    
    <script src="files/jquery.js" type="text/javascript"></script>
    <script src="flowplayer/flowplayer-3.2.6.min.js" type="text/javascript"></script>
    
    <link rel="stylesheet" type="text/css" href="styles/html.css"/>
    <link rel="stylesheet" type="text/css" href="styles/default.css"/>
    <link rel="stylesheet" type="text/css" href="js/diashow.css" />
    
    <style type="text/css">
       body{
        background: #3B5378 url(/test/bg.png) repeat-x;
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
      #menu ul{
        list-style-type : none;
        margin : 0px;
        padding : 0px;
      }
      #menu_list li{
        margin-top : 1px;
        display : block;
      } 
      ul#menu_list li a {
        display : list-item;
        background : #ffcc08;
        color : #000;	
        padding : 9px 12px 9px 12px;
        font-size : 18px;
      }
      ul#menu_list li ul li a{
        display : list-item;
        background: #ffd94a;
        color : #000;	
        padding : 9px 7px 9px 7px;
        margin-left : 10px;
      }
      ul#menu_list a {
        display : block;
        width : 150px;
        text-decoration : none;	
      }
      .sub_menu{
        
      }
      .fake_link{
        cursor : pointer;
      }
      #menu {
        margin-right : 10px;
      }
      #base_layout td{
        vertical-align : top;
      }
      #footer {
        text-align : center;
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
      #impress_link{
        position : absolute;
        left : 0px;
        font-size : 12px;
      }
      #content_td{
        width : 100%;
      }
    </style>
    <script type="text/javascript">
      function send_login_sql(){
        var form = document.getElementById('form_sql');
        form.submit();
      }
    </script>
  </head>
  <body>
<?php
if($_SESSION['login'] == 'ok' and $_SESSION["spezi"] == 1){
  include_once("includes/database.php");
  include_once("includes/util.php");
}else{
  echo "<div style='margin : 10px auto;background-color:red;padding:50px;width:250px;text-align:center;'>
          <p>Keine Berechtigung</p>
          <a href='index.php?site=intern'>Einloggen</a>
        </div>";
  exit();
}
?>
    <form id="form_sql" action="http://ironcrust.rzone.de/myadmin/start.php" method="post" target="_blank" style="display:none;">
		<input type="hidden" name="action" value="ask_admin">
		<input type="hidden" name="dbname" value="DB1133193" >
		<input type="hidden" name="dbid" value="">
		<input type="hidden" name="dbtype" value="mysql">
		<input type="hidden" name="my" value="5">
		<input type="hidden" name="rid" value="51434621">
		<input type="hidden" name="keytag" value="0428f5e8c9644ae434861ceb4b1dfe3f" >
		<input TYPE="hidden" NAME="track" value="51434621.swh.strato-hosting.eu" >
		<input type="hidden" name="country_id" value="DE" >
		<input type="hidden" name="masterID" value="51434621.swh.strato-hosting.eu">
	</form>
	
    <div id="main_div">
      <div id="header">
        <a name="oben"><img src="img/logo.gif" alt="Logo des Schwäbischer Eisenbahnverein"/></a>
      </div>
      <div id="layout">
        <table id="base_layout">
        <tr>
        <td>
        <div id="menu">
          <ul id="menu_list">
            <li>
              <a href="admin.php?site=index">Übersicht</a>
            </li>
            <li>
              <a href="admin.php?site=settings">Einstellungen</a>
            </li>
            <li>
              <a class="fake_link">Menü</a>
              <ul class="sub_menu">
                <li>
                  <a href="admin.php?site=admin_menu">Menü verwalten</a>
                </li>
                <li>
                  <a href="admin.php?site=add_hmenu">neuer Hauptpunkt</a>
                </li>
                <li>
                  <a href="admin.php?site=add_umenu">neuer Unterpunkt</a>
                </li>
                <li>
                  <a href="admin.php?site=loose_pages">lose Seiten verknüpfen</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="fake_link">Seiten</a>
              <ul class="sub_menu">
                <li>
                  <a href="admin.php?site=list_site">Seiten Liste</a>
                </li>
                <li>
                  <a href="admin.php?site=new_site">Neue Seite</a>
                </li>
                <li>
                  <a href="admin.php?site=diff_site">Backup</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="admin.php?site=css">css</a>
            </li>
            <li>
              <a href="admin.php?site=dateim">Dateimanager</a>
            </li>
            <li>
              <a class="fake_link">Fahrtage</a>
              <ul class="sub_menu">
                <li>
                  <a href="admin.php?site=days">Fahrtage Liste</a>
                </li>
                <li>
                  <a href="admin.php?site=days&action=new&id=0">Neuer Fahrtag</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="admin.php?site=guestbook">Gästebuch</a>
            </li>
            <li>
              <a class="fake_link">Terminabfrage</a>
              <ul class="sub_menu">
                <li>
                  <a href="admin.php?site=termin_abf_conf">Termine einstellen</a>
                </li>
                <li>
                  <a href="admin.php?site=termin_abf">Datenbank abfragen</a>
                </li>
                <li>
                  <a href="index.php?site=i_terminabfrage_admin">Terminabfrage</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="admin.php?site=new_password">Passwort Link</a>
            </li>
            <li>
              <a href="index.php">SEV-Seite</a>
            </li>
          </ul>
        </div>
        </td>
        <td id="content_td">
        <div id="content">
<?php
if(isset($_GET['site'])){
    $site = $_GET['site'];
}else{
    $site = 'index';
}
$path = "admin/$site.php";
include_once($path);
?>
        </div>
        </td>
        </tr>
        </table>
        <div id="footer"> 
          <a id="goto_top_link" href="#oben"><img src="img/goto_top.png" alt="nach oben"/></a>
          <a id="validator_link" href="http://validator.w3.org/check?uri=referer"><img src="img/valid-xhtml10-blue.png" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
        </div>
      </div>
    </div>
  </body>
</html>
