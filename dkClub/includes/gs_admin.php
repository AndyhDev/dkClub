<?php
include('database.php');
database_connect();
$id = $_GET['id'];
$action = $_GET['action'];

$id = mysql_real_escape_string($id);
$action = mysql_real_escape_string($action);

if($action == "delete"){
    mysql_query("DELETE FROM guestbook WHERE id='$id'");
    echo "Eintrag gelöscht";
}else{
    mysql_query("UPDATE guestbook SET ok=1 WHERE id='$id'");
    echo "Eintrag freigeschaltet";
}
?>
