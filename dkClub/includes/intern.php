<?php
function intern_get_menu(){
    if(isset($_SESSION["login"])){
        if($_SESSION["login"] == "ok"){
            $content = file_get_contents("templates/intern_login");
            if($_SESSION["spezi"] == 1){
                $link = '<li><a href="index.php?site=i_spezi">SpeziFunk</a></li>';
                return str_replace('%spezi_link%', $link, $content);
            }else{
                return str_replace('%spezi_link%', '', $content);
            }
        }else{
            return file_get_contents("templates/intern_logout");
        }
    }else{
        return file_get_contents("templates/intern_logout");
    }
}

function intern_get_site($site){
    if(isset($_SESSION["login"])){
        if($_SESSION["login"] == "ok"){
            if($site == "intern/i_logout"){
                $_SESSION["login"] = "logout";
                $_SESSION["spezi"] = 0;
                $_SESSION["name"] = 0;
                return "<h1>Sie wurden ausgeloggt</h1>";
            }else{
                if($_SESSION["spezi"] == 1){
                    return file_get_contents($site);
                }else{
                    $spezi_sites = array('intern/i_spezi');
                    if(in_array($site, $spezi_sites)){
                        return file_get_contents('templates/401');
                    }else{
                        return file_get_contents($site);
                    }
                }
            }
        }else{
            return file_get_contents('templates/401');
        }
    }else{
        return file_get_contents('templates/401');
    }
}

function get_admin(){
    if(isset($_SESSION["login"])){
        if($_SESSION["login"] == "ok"){
            if($_SESSION["spezi"] == 1){
                return true;
            }
        }
    }
    return false;
}
function intern_get_content_login($content){
    if(isset($_GET["action"])){
        if(!isset($_POST["user"])){
            $content = str_replace("%error1%", "<td><img src='img/error_s.png' alt='Error'/></td>", $content);
            $content = str_replace("%error2%", "", $content);
            return $content;
        }elseif(empty($_POST["user"])){
            $content = str_replace("%error1%", "<td><img src='img/error_s.png' alt='Error'/></td>", $content);
            $content = str_replace("%error2%", "", $content);
            return $content;
        }else{
            $user = $_POST["user"];
        }
        //if(!isset($_POST["password_sha1"])){
        if(!isset($_POST["passw"])){
            $content = str_replace("%error2%", "<td><img src='img/error_s.png' alt='Error'/></td>", $content);
            $content = str_replace("%error1%", "", $content);
            return $content;
        //}elseif(empty($_POST["password_sha1"])){
        }elseif(empty($_POST["passw"])){
            $content = str_replace("%error2%", "<td><img src='img/error_s.png' alt='Error'/></td>", $content);
            $content = str_replace("%error1%", "", $content);
            return $content;
        }else{
            //$password = $_POST["password_sha1"];
            $password = sha1($_POST["passw"]);
        }
        $db = database_connect();
        $special = database_get_special($user);
        $password2 = database_get_password($user);
        $name = database_get_name($user);
        
        database_close($db);
        if($password2){
            if(!database_is_active($user) && $special != 1){
                return "<h3>Ihr Zugang zum Internen Bereich wurde deaktiviert,
                            wenn dies ohne vorherige ankündigung geschehen ist, 
                            dann informieren sie bitte den Webmaster</h3>";
            }
            if($password == $password2){
                $_SESSION["login"] = "ok";
                $_SESSION["name"] = $name['vorname'];
                if($special == 1){
                    $_SESSION["spezi"] = 1;
                    $special_text = '<div style="border:2px solid red;">Sie sind nun als Administrator eingeloggt.<br/>Untern den Menüpunkt "Admin" können sie diese Funktionen nutzen.</div>';
                }else{
                    $_SESSION["spezi"] = 0;
                    $special_text = '';
                }
                $vorname = $name['vorname'];
                return "Sie wurden erfolgreich eingeloggt<br/><h1>Herzlich willkommen im internen Bereich $vorname</h1><br/>$special_text";
            }
        }
        $content = str_replace("%error2%", "<td><img src='img/error_s.png' alt='Error'/></td>", $content);
        $content = str_replace("%error1%", "<td><img src='img/error_s.png' alt='Error'/></td>", $content);
        return $content;
    }else{
        $content = str_replace("%error1%", "", $content);
        $content = str_replace("%error2%", "", $content);
        return $content;
    }
}
?>
