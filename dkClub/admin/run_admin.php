<?php
session_start();
if($_SESSION['login'] == 'ok' and $_SESSION["spezi"] == 1){
}else{
    echo "so nicht!";
    exit();
}
?>
