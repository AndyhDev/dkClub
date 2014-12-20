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
}
?>
