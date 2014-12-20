<?php
include_once('run_admin.php');
include_once('dateimanager/dir.php');

function delTree($dir) {
   $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
  } 
  
function new_folder($dir){
    $new_name = $_POST['folder_name'];
    $real_dir = $_POST['real_dir'];
    $new_path = path_join(array($real_dir, $new_name));
    if(file_exists($new_path)){
        return "<h1>Der Ordnername ist bereits vergeben</h1>";
    }
    mkdir($new_path);
    $db = database_connect();
    database_set_event("Ordner '$new_path' erstellt");
    database_close($db);
    return "Ordner erstellt";
}
function upload($dir){
    $new_name = $_FILES['datei']['name'];
    $real_dir = $_POST['real_dir'];
    $new_path = path_join(array($real_dir, $new_name));
    if(file_exists($new_path)){
        return "<h1>Dieser Name ist bereits vergeben</h1>";
    }
    move_uploaded_file($_FILES['datei']['tmp_name'], $new_path);
    $db = database_connect();
    database_set_event("Datei '$new_path' hochgeladen");
    database_close($db);
    return "Datei hochgeladen";
}
function remove($dir){
    $real_dir = $_POST['path'];
    if(is_file($real_dir)){
        unlink($real_dir);
    }elseif(is_dir($real_dir)){
        delTree($real_dir);
    }
    $db = database_connect();
    database_set_event("Datei '$real_dir' gelöscht");
    database_close($db);
    return "Datei gelöscht";
}
function rename_file($dir){
    $real_dir = $_POST['real_dir'];
    $old_dir = $_POST['old_path'];
    $new_name = $_POST['new_name'];
    $new_path = path_join(array($real_dir, $new_name));
    if(file_exists($new_path)){
        return "<h1>Der Ordnername ist bereits vergeben</h1>";
    }
    rename($old_dir, $new_path);
    $db = database_connect();
    database_set_event("Datei '$old_dir' in '$new_path' umbenannt");
    database_close($db);
    return "Datei umbenannt";
}
if(isset($_GET['dir'])){
    $dir = $_GET['dir'];
}else{
    $dir = '/';
}
if(isset($_GET['action'])){
    $act = $_GET['action'];
    if($act == 'new_folder'){
        echo new_folder($dir);
    }elseif($act == 'upload'){
        echo upload($dir);
    }elseif($act == 'remove'){
        echo remove($dir);
    }elseif($act == 'rename'){
        echo rename_file($dir);
    }
}
echo read_dir($dir);

?>
