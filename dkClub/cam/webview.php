<?php
if (! ($name1 = $_POST["name1"]))

{

$name1 = false;

}

if (! ($name2 = $_POST["name2"]))

{

$name2 = false;

}

if (! ($image = $_FILES['image']['tmp_name']))

{
    
$image = false;

}

if (! ($passw = $_POST["passw"]))

{
    
$passw = false;

}
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!Einstellungen!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$image_path = "/cam/";
$password = "ZjMwZDA1ZWFkMTFiZWE3NDNkNTgzZTQyODJlMzA0ZjY=";
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!

$root_dir = getenv("DOCUMENT_ROOT");

function glue2path()
{
    $i     = 0;
    $stack     = array();
    $args     = func_get_args();
    $tmp     = join('/', $args);
    $tmp = preg_replace ('#//+#','/', $tmp);
    return $tmp;
}

function load($name1, $name2, $image, $image_path, $root_dir)
{
    if ($image and $name1){
        $image1_path = glue2path($root_dir, $image_path, $name1);
        copy($image, $image1_path);
        $im = imagecreatefromjpeg($image1_path);
        $old_x = imagesx($im);
        $old_y = imagesy($im);
        $new_x = 320;
        $new_y = 240;
        $new_im = imagecreatetruecolor($new_x, $new_y); 
        $name3 = "thumbnail" . $name1;
        imagecopyresampled($new_im ,$im, 0, 0, 0, 0, $new_x, $new_y, $old_x, $old_y); 
        imagejpeg($new_im, glue2path($root_dir, $image_path, $name3), 80);

    }

    if ($image and $name2){
        $image2_path = glue2path($root_dir, $image_path, $name2);
        copy($image, $image2_path);
    }
    
    echo "done";
}

if ($passw == $password) {
    load($name1, $name2, $image, $image_path, $root_dir);

} else {
    echo "login incorrect";
}
?>
