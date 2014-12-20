<?php
include_once("../includes/util.php");

$path = getcwd();
$files = scandir($path);
$allow = array(".jpg", ".jpeg", "jpe", ".png", ".tiff");
foreach($files as $name){
    $t_path =  $path . "/" . $name;
    $ext = strtolower(strrchr($name, "."));
    if(in_array($ext, $allow) and !startswith($name, 'thumbnail')){
        $date = filemtime($t_path);
        #02_09_12#12_00.jpg
        $new_name = date('d_m_Y-H_i', $date) . ".jpg";
        echo "$name $new_name<br/>";
        copy($t_path, "../webcam/" . $new_name);
    }
}
?>
