<?php
include_once 'config/dbconfig.php';
if(!INSTALLED){
	header('Location: install/index.php');
	exit();
}else{
}
include_once("includes/database.php");
include_once("includes/util.php");
include_once("includes/counter.php");
include_once("includes/intern.php");
include_once("includes/plugin.php");
include_once("includes/statistic.php");
include_once("includes/menu.php");
                     

#ini_set('session.use_trans_sid', '0');
ini_set("arg_separator.output","&amp;");

session_start();

$_SESSION["counter"] = "ok";
counter_up();


if(isset($_GET['download']) and isset($_GET['type'])){
    if(isset($_GET['intern'])){
        if($_SESSION['login'] == 'ok'){
            $types = array("pdf", "jpg", "zip");
            if(in_array($_GET['type'], $types)){
                $paths = array("pdf" => "intern/pdf/",
                               "jpg" => "intern/img/",
                               "zip" => "intern/zip/");
                $path = $paths[$_GET['type']] . $_GET['download'];
                if(is_file($path)){
                    $filesize = filesize($path);
                    header("Content-Type: application/force-download");
                    header("Content-Disposition: attachment; filename=" . $_GET['download']); 
                    header("Content-Length: $filesize");
                    readfile($path);
                    exit();
                    
                }
            }
        }else{
            echo 'erwischt!';
            exit();
        }
    }else{
        $types = array("pdf", "jpg", "zip");
        if(in_array($_GET['type'], $types)){
            $paths = array("pdf" => "pdfs/",
                           "jpg" => "downloads/",
                           "zip" => "downloads/");
            $path = $paths[$_GET['type']] . $_GET['download'];
            if(is_file($path)){
                $filesize = filesize($path);
                header("Content-Type: application/force-download");
                header("Content-Disposition: attachment; filename=" . $_GET['download']); 
                header("Content-Length: $filesize");
                readfile($path);
                exit();
                
            }
        }
        $site = "download";
    }
}
if(isset($_GET['site'])){
    $site = $_GET['site'];
}else{
    $site = "index";
}


if(startswith($site, "i_")){
    $path = "intern/" . $site;
    if(!is_file($path)){
        $menu_point = 0;
        $content = file_get_contents('templates/404');
    }else{
        $menu_point = get_pos($site);
        $content = intern_get_site($path);
        if(get_admin()){
            $point = get_menu_point_from_site($site);
            $point_id = $point['id'];
            $admin_mode = "
            <div style='border:2px solid #ffcc08;height:30px;line-height:30px;padding:0px 4px 0px 4px;position:relative;'>
              <span style='font-weight:bold;background-color:#B40404;color:#FFFF00;'>Admin-Modus</span>
              <a style='padding:0px 4px 0px 4px;border:0px;' href='admin.php?site=list_site&action=edit&id=$path'>Bearbeiten</a>
              <a style='padding:0px 4px 0px 4px;border:0px;' href='admin.php?site=list_site&action=html_edit&id=$path'>HTML bearbeiten</a>
              <a style='padding:0px 4px 0px 4px;border:0px;' href='admin.php?site=admin_menu&id=$point_id&action=edit'>Menüpunkt bearbeiten</a>
              <span style='position:absolute;right:4px;top:0px;'><a style='' href='admin.php'>Admin-Bereich</a></span>
            </div>";
            $content = $admin_mode . $content;
        }
    }
}else{
    $path = "content/" . $site;

    if(!is_file($path)){
        $menu_point = 0;
        $content = file_get_contents('templates/404');
    }else{
        $menu_point = get_pos($site);
        $content = file_get_contents($path);
        if(get_admin()){
            $point = get_menu_point_from_site($site);
            $point_id = $point['id'];
            $admin_mode = "
            <div style='border:2px solid #ffcc08;height:30px;line-height:30px;padding:0px 4px 0px 4px;position:relative;'>
              <span style='font-weight:bold;background-color:#B40404;color:#FFFF00;'>Admin-Modus</span>
              <a style='padding:0px 4px 0px 4px;border:0px;' href='admin.php?site=list_site&action=edit&id=$path'>Bearbeiten</a>
              <a style='padding:0px 4px 0px 4px;border:0px;' href='admin.php?site=list_site&action=html_edit&id=$path'>HTML Bearbeiten</a>
              <a style='padding:0px 4px 0px 4px;border:0px;' href='admin.php?site=admin_menu&id=$point_id&action=edit'>Menüpunkt bearbeiten</a>
              <span style='position:absolute;right:4px;top:0px;'><a style='' href='admin.php'>Admin-Bereich</a></span>
            </div>";
            $content = $admin_mode . $content;
        }
    }
}

if($site == "guestbook"){
    include_once("includes/guestbook.php");
    $content = guestbook_get_content();
}
if($site == "intern"){
    $content = intern_get_content_login($content);
}
$db = database_connect();
$result = mysql_query("SELECT * FROM loose_pages WHERE name='$site'");
$row = mysql_fetch_array($result);
if($row['display']){
    $id = $row['display'];
    $res = mysql_query("SELECT site FROM menu WHERE id=$id");
    $row = mysql_fetch_array($res);
    $site_r = $row['site'];
}else{
    $site_r = $site;
}
     
$_SESSION['site'] = $site;

statistic_do($site);

$css = 'style="background-color: #daa520 !important;"';##4c833b

if(isset($_GET['template'])){
    $template = file_get_contents("templates/" . $_GET['template']);
}else{
    $template = file_get_contents("templates/default");
}
$intern = intern_get_menu();
$template = str_replace("%intern%", $intern, $template);

#<a href="index.php?site=next_day">nächster Fahrtag</a>

#$intern = intern_get_menu();

$count = counter_get();

$menu = get_menu();

database_close($db);

$rand_img = "img/random_images/" . rand(0, 15) . ".jpg";
$template = str_replace("%menu_point%", $menu_point, $template);
$template = str_replace("%menu%", $menu, $template);
if(in_array($site, array("cam_today", "cam_day", "cam_archive"))){
    if($site == "cam_today"){
        $template = str_replace("<a href='index.php?template=webcam&site=cam_today'>heutiger Tag</a>", "<a " . $css . " href='index.php?template=webcam&site=cam_today'>heutiger Tag</a>", $template);
    }else if($site == "cam_day"){
        $template = str_replace("<a href='index.php?template=webcam&site=cam_archive'>Archiv</a>", "<a " . $css . " href='index.php?template=webcam&site=cam_archive'>Archiv</a>", $template);
    }else{
        $template = str_replace("<a href='index.php?template=webcam&site=cam_archive'>Archiv</a>", "<a " . $css . " href='index.php?template=webcam&site=cam_archive'>Archiv</a>", $template);
    }
}else{
    $template = str_replace("<a href='index.php?site=$site_r'>", "<a " . $css . " href='index.php?site=" . $site_r . "'>", $template);
}
$template = str_replace("%content%", $content, $template);
$template = str_replace("%rand_img%", $rand_img, $template);
$template = str_replace("%counter_all%", $count['gesamt'], $template);
$template = str_replace("%counter_day%", $count['heute'], $template);
$template = str_replace("%counter_1day%", $count['gestern'], $template);
$template = str_replace("%counter_month%", $count['monat'], $template);

$template = do_plugins($template);
echo $template; 
?>
