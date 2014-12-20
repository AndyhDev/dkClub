<?php
function plugin_get_album($name){
    $album = array();
    $album['name'] = $name;
    $path = "fotos/album/" . $name;
    $album['path'] = $path;
    
    $files = scandir($path);
    $images = array();
    $thumbs = array();
    $allow = array(".jpg", ".jpeg", "jpe", ".png", ".tiff");
    foreach($files as $name){
        $t_path = $path . "/" . $name;
        $thumb = $path . "/thumb_" . $name;
        $ext = strtolower(strrchr($name, "."));
        if(in_array($ext, $allow) and !startswith($name, 'thumb_') and is_file($thumb)){
            $images[] = $t_path;
            $thumbs[] = $thumb;
        }
    }
    $album['images'] = $images;
    $album['thumbs'] = $thumbs;
    return $album;
    
}
function plugin_overview($name, $display_name){
    $album = plugin_get_album($name);
    $html = "<h1 class='text_center'>$display_name</h1>
    <span class='text_center'>
    Diese Bilder wurden dem SEV von Mitgliedern und Freunden für die Veröffentlichung zur Verfügung gestellt.</span>
    <table style='width:100%;'><tr>";
    
    $site = 0;
    if(isset($_GET['page'])){
        if(check_int($_GET['page'])){
            $site= $_GET['page'];
        }
    }
    
    $content = $GLOBALS['site'];
    $count = 0;
    $page = $site * 25;
    $images = array_slice($album['thumbs'], $page, 25);
    foreach($images as $img){
        if($count == 5){
            $count = 0;
            $html = $html . "</tr><tr>";
        }
        $pic_name = str_replace("fotos/album/" . $name . "/thumb_", "", $img);
        $html = $html . "<td style='padding-top:15px;'><a href='index.php?site=$content&amp;page=$site&amp;img=$pic_name'><img src='$img' alt='bildvorschau'/></a></td>";
        $count++;
    }
    $html = $html . "</tr></table>";
    
    $anz = count($album['thumbs']);
    $pages = ceil($anz/25);
    $html = $html . '<br/><div style="margin-bottom:8px;">Seiten:</div><table><tr>';
    for($i=1;$i <= $pages;$i++) {  
        $page = $i - 1;
        if($page == $site){
            $html = $html . "<td><a style='background-color:gray;' class='page_link' href='index.php?site=$content&amp;page=$page'>$i</a></td>";
        }else{
            $html = $html . "<td><a class='page_link' href='index.php?site=$content&amp;page=$page'>$i</a></td>";
        }
    }
    $html = $html . '</tr></table>';
    
    return $html;
}
function plugin_show_image($name, $display_name){
    $html = "<h1 class='text_center'>$display_name</h1>";
    $path = "fotos/album/" . $name . "/" . $_GET['img'];
    if(is_file($path)){
        $content = $GLOBALS['site'];
        $site = 0;
        if(isset($_GET['page'])){
            if(check_int($_GET['page'])){
                $site= $_GET['page'];
            }
        }
        $album = plugin_get_album($name);
        $anz = count($album['thumbs']) -1;
        $pos = array_search($path, $album['images']);
        
        if($pos == $anz){
            $back_img = str_replace("fotos/album/" . $name . "/",  "", $album['images'][$pos-1]);
            $back_link = "<a href='index.php?site=$content&amp;page=$site&amp;img=$back_img'><img src='img/back_s.png' alt='back'/></a>";
            $next_link = "";
        }
        elseif($pos == 0){
            $next_img = str_replace("fotos/album/" . $name . "/",  "", $album['images'][$pos+1]);
            $back_link = "";
            $next_link = "<a href='index.php?site=$content&amp;page=$site&amp;img=$next_img'><img src='img/next_s.png' alt='next'/></a>";
        }else{
            $next_img = str_replace("fotos/album/" . $name . "/",  "", $album['images'][$pos+1]);
            $back_img = str_replace("fotos/album/" . $name . "/",  "", $album['images'][$pos-1]);
            $next_link = "<a href='index.php?site=$content&amp;page=$site&amp;img=$next_img'><img src='img/next_s.png' alt='next'/></a>";
            $back_link = "<a href='index.php?site=$content&amp;page=$site&amp;img=$back_img'><img src='img/back_s.png' alt='back'/></a>";
        }
        $html = $html . "<div class='text_center'>
                           <table style='margin:0 auto;'><tr>
                           <td>$back_link</td>
                           <td><a href='index.php?site=$content&amp;page=$site'>zur Übersicht</a></td>
                           <td>$next_link</td></tr></table>
                           <img src='$path' alt='Bild'/>
                         </div>";
    }else{
        $html = $html . "<h1>Fehler 404</h1>Bild nicht gefunden";
    }
    return $html;
}
function plugin_album($name, $display_name){
    if(isset($_GET['img'])){
        return plugin_show_image($name, $display_name);
    }else{
        return plugin_overview($name, $display_name);
    }
    
}
?>
