<?php
session_start();
if($_SESSION['login'] == 'ok'){
    $path = 'intern/img/' . $_GET['img'];
    $info = getimagesize($path);
    header("Content-length: " . filesize($path));
    switch($info[2]) {
        case 1: //gif
            header("Content-type: image/gif");
            break;
        case 2: // jpeg
            header("Content-type: image/jpeg");
            break;
        case 3: // png
            header("Content-type: image/png");
            break;
    }
    readfile($path);
}
?>