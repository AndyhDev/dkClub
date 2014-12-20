<?php
#function counter_up(){
#    $db = database_connect();
#    $sql = "INSERT INTO statistik () VALUES ()";
#    mysql_query($sql);
#    database_close($db);
#}
function counter_up(){
    $db = database_connect();
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $result = mysql_query("SELECT count(*) FROM ips WHERE ip='$ip'");
    
    $count = mysql_result($result, 0);
    if($count == 0){
        mysql_query("INSERT INTO ips (ip, date) VALUES('$ip', CURDATE());");
        
        $result = mysql_query("SELECT count(*) FROM statistic WHERE day=CURDATE();");
    
        $count = mysql_result($result, 0);
        if($count == 0){
            mysql_query("INSERT INTO statistic (day, clicks) VALUES(CURDATE(), 1);");
        }else{
            mysql_query("UPDATE statistic SET clicks=clicks+1 WHERE day=CURDATE();");
        }
    
    }
    database_close($db);
}

function counter_get(){
    $db = database_connect();
    $sql = "SELECT clicks FROM statistic";
    $result = mysql_query($sql);
    $anz_gesamt = 0;
    while ($row = mysql_fetch_array($result)){ 
        $anz_gesamt += $row['clicks'];
    }
    
    $sql = "SELECT clicks FROM statistic WHERE day = DATE_SUB(CURDATE(), INTERVAL 1 DAY);";
    $result = mysql_query($sql);
    $anz_gestern = mysql_fetch_array($result);
    
    $sql = "SELECT clicks FROM statistic WHERE DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= day";
    $result = mysql_query($sql);
    $anz_monat = 0;
    while ($row = mysql_fetch_array($result)){ 
        $anz_monat += $row['clicks'];
    }
    
    $sql = "SELECT clicks FROM statistic WHERE day = CURDATE()";
    $result = mysql_query($sql);
    $anz_heute = mysql_fetch_array($result);
     
    database_close($db);
    
    return array('gesamt' => $anz_gesamt, 'heute' => $anz_heute['clicks'], 'gestern' => $anz_gestern['clicks'], 'monat' => $anz_monat);
}
?>
