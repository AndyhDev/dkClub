<?php
include_once('run_admin.php');

echo "<h3>letzte Änderungen:</h3>
<table border='1' style='width:100%;border-color:gray;border-collapse:collapse;'>";
$db = database_connect();
$sql = "SELECT * FROM events ORDER BY date DESC LIMIT 0, 100";
$res = mysql_query($sql);
while ($row = mysql_fetch_array($res)){
    $date = $row['date'];
    $info = $row['info'];
    echo "<tr><td>$date</td><td>$info</td></tr>";
}
echo "</table>";
database_close($db);
?>
