<?php
function statistic_do($site){
    $db = database_connect();
    
    $result = mysql_query("SELECT count(*) FROM sites WHERE day=CURDATE() AND site='$site';");
    
    $count = mysql_result($result, 0);
    if($count == 0){
        mysql_query("INSERT INTO sites (day, site, clicks) VALUES(CURDATE(), '$site', 1);");
    }else{
        mysql_query("UPDATE sites SET clicks=clicks+1 WHERE day=CURDATE() AND site='$site';");
    }
    
    
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $client_domain = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $referer = $_SERVER['HTTP_REFERER'];
    if(isset($_SESSION["login"])){
        if($_SESSION["login"] == "ok"){
            $name = $_SESSION['name'];
            mysql_query("INSERT INTO log (browser, site, client_domain, referer, user) VALUES ('$browser', '$site', '$client_domain', '$referer', '$name');");
        }else{
            mysql_query("INSERT INTO log (browser, site, client_domain, referer) VALUES ('$browser', '$site', '$client_domain', '$referer');");
        }
    }else{
        mysql_query("INSERT INTO log (browser, site, client_domain, referer) VALUES ('$browser', '$site', '$client_domain', '$referer');");
    }
    
    database_close($db);  
}
?>
