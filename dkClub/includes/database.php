<?php
@include_once '../config/dbconfig.php';
@include_once 'config/dbconfig.php';

function database_connect(){
    $res = @mysql_query('SELECT * FROM menu WHERE id=1');
    if(!$res){
        $link = mysql_connect(dbServer, dbUser, dbPassword);
        if (!$link) {
            die('Verbindung schlug fehl: ' . mysql_error());
        }
        mysql_select_db(dbName);
        mysql_query("SET NAMES 'utf8'");
        return $link;
    }
}

function database_get_password($user){
    $user = mysql_real_escape_string($user);
    $sql = "SELECT passwort FROM mitglieder WHERE name ='$user'";
    $result = mysql_query($sql);
    if(!empty($result)){
        $data = mysql_fetch_assoc($result);
        return $data['passwort'];
    }else{
        return false;
    }
}
function database_add_guestbook($name, $e_mail, $na){
    $db = database_connect();
    $name = mysql_real_escape_string($name);
    $e_mail = mysql_real_escape_string($e_mail);
    $na = str_replace("\n", "<br/>", $na);
    $na = mysql_real_escape_string($na);
    
    $sql = "INSERT INTO guestbook (name, e_mail, nachricht)
            VALUES ('$name', '$e_mail', '$na')";
    mysql_query($sql);
    return mysql_insert_id();
}

function database_get_name($user){
    $user = mysql_real_escape_string($user);
    $sql = "SELECT vorname, nachname FROM mitglieder WHERE name ='$user'";
    $result = mysql_query($sql);
    if(!empty($result)){
        $data = mysql_fetch_assoc($result);
        return $data;
    }else{
        return false;
    }
}
function database_is_active($user){
    $user = mysql_real_escape_string($user);
    $sql = "SELECT active FROM mitglieder WHERE name ='$user'";
    $result = mysql_query($sql);
    if(!empty($result)){
        $data = mysql_fetch_assoc($result);
        if($data['active'] == 1){
            return True;
        }
    }
    return False;
}
function database_get_special($user){
    $user = mysql_real_escape_string($user);
    $sql = "SELECT special FROM mitglieder WHERE name ='$user'";
    $result = mysql_query($sql);
    if(!empty($result)){
        $data = mysql_fetch_assoc($result);
        return $data['special'];
    }else{
        return 0;
    }
}
function database_add_menu($name, $typ, $display, $site, $pos){
    $name = mysql_real_escape_string($name);
    $type = mysql_real_escape_string($typ);
    $display = mysql_real_escape_string($display);
    $site = mysql_real_escape_string($site);
    $pos = mysql_real_escape_string($pos);
    
    $sql = "INSERT INTO menu (name, typ, display, site, pos)
            VALUES ('$name', $typ, $display, '$site', $pos)";
    mysql_query($sql);
    return mysql_insert_id();
}
function database_update_menu($id, $name, $typ, $display, $site, $pos){
    $id = mysql_real_escape_string($id);
    $name = mysql_real_escape_string($name);
    $type = mysql_real_escape_string($typ);
    $display = mysql_real_escape_string($display);
    $site = mysql_real_escape_string($site);
    $pos = mysql_real_escape_string($pos);
    
    $sql = "UPDATE menu
            SET name='$name', typ='$typ', display='$display', site='$site', pos='$pos'
            WHERE id=$id";
    mysql_query($sql);
}
function database_get($name){
    $name = mysql_real_escape_string($name);
    $sql = "SELECT value FROM settings WHERE name='$name'";
    $result = mysql_query($sql);
    if(!empty($result)){
        $data = mysql_fetch_assoc($result);
        return $data['value'];
    }else{
        return 0;
    }
    
}
function database_set_event($info){
    $info = mysql_real_escape_string($info);
    $sql = "INSERT INTO events (info)
            VALUES ('$info')";
    mysql_query($sql);
}
function database_set($name, $value){
    $name = mysql_real_escape_string($name);
    $value = mysql_real_escape_string($value);
    $sql = "INSTER INTO settings (name, value)
            VALUES ('$name', '$value')";
    mysql_query($sql);        
}
function database_close($link){
    #mysql_close($link);
}
?>
