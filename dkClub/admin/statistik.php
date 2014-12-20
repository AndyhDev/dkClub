<?php
include_once('run_admin.php');

database_connect();

$sites = scandir('content');
foreach($sites as $site){
    if($site != '.' and $site != '..'){
        $res = mysql_query("SELECT clicks FROM sites WHERE site='$site'");
        $clicks = 0;
        echo $site . ':';
        while ($row = mysql_fetch_array($res)){
            $clicks += $row['clicks'];
        }
        echo $clicks . '<br/>';
        
    }
}
?>
