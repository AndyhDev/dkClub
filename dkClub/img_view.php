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


if(isset($_GET['img'])){
    if(!is_file($_GET['img'])){
        $img = "img/404.png";
    }else{
        $img = $_GET['img'];
    }
}else{
    $img = "img/404.png";
}

@$size = getimagesize($img);
if(!$size){
    $img = "img/404.png";
    $width = 900;
}else{
    $width = $size[0];
    if($width < 900){
        $width = 900;
    }else{
        $width = $width + 30;
    }
}
if(startswith($img, 'intern')){
    $img = "img.php?img=" . str_replace('intern/img/', '', $img);
}
if(!isset($_SESSION['site'])){
    $back_link = "index.php";
}else{
    $back_link = "index.php?site=" . $_SESSION['site'];
}
$background = "background: #3B5378 url(/test/bg.png) repeat-x;";

$template = file_get_contents("templates/img_view");
$template = str_replace("%background%", $background, $template);
$template = str_replace("%img%", $img, $template);
$template = str_replace("%width%", $width, $template);
$template = str_replace("%back_link%", $back_link, $template);
echo $template;

?>
