<?php
function plugin_na_fahrtag_k(){
    $db = database_connect();
    mysql_query( "SET NAMES 'utf8'");
    $result = mysql_query("SELECT * FROM days WHERE datum >= CurDate() LIMIT 1");
    if($result){
        $res = mysql_fetch_array($result);
        
        $motto = $res['motto'];
        $eintritt = $res['eintritt'];
        $datum = $res['datum'];
        $year = substr($datum, 0, 4);
        $mon = substr($datum, 5, 2);
        $day = substr($datum, 8, 2);
        
        $start_zeit = $res['start_zeit'];
        $end_zeit = $res['end_zeit'];
        return "
<div style='background-image:url(img/next_day_border.png);position:relative;width:350px;height:220px;margin:20px auto;'>
  <table style='width:310px;position:absolute;left:15px;top:60px;'>
    <tr>
      <td>
        Motto:
      </td>
      <td>
        $motto
      </td>
    </tr>
    <tr>
      <td>
        Datum:
      </td>
      <td>
        $day.$mon.$year
      </td>
    </tr>
    <tr>
      <td>
        Fahrzeit:
      </td>
      <td>
        $start_zeit - $end_zeit
      </td>
    </tr>
    <tr>
      <td>
        Eintritt zur Dampfbahn:
      </td>
      <td>
        $eintritt
      </td>
    </tr>
  </table>
</div>";
    }else{
        return 'Leider konnte die Datenback keinen Fahrtag finden';
    }
    database_close($db);
}

?>