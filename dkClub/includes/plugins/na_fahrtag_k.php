<?php
function plugin_na_fahrtag_k(){
    $db = database_connect();
    mysql_query( "SET NAMES 'utf8'");
    $result = mysql_query("SELECT * FROM days WHERE datum >= CurDate() ORDER BY datum LIMIT 1");
    $res = mysql_fetch_array($result);
    if(!empty($res)){
        $motto = $res['motto'];
        $eintritt = $res['eintritt'];
        $datum = $res['datum'];
        $year = substr($datum, 0, 4);
        $mon = substr($datum, 5, 2);
        $day = substr($datum, 8, 2);
        if($eintritt == "kostenpflichtig"){
            $text1 = "Eintritt zur Dampfbahn<br/> und Museum:";
        }else{
            $text1 = "Eintritt zur Dampfbahn:";
        }
        $start_zeit = $res['start_zeit'];
        $end_zeit = $res['end_zeit'];
        return "
<div style='background-image:url(img/next_day_border.png);position:relative;width:350px;height:220px;'>
  <table style='width:310px;position:absolute;left:15px;top:60px;'>
    <tr>
      <td style='width:60%;'>
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
        Fahrbetrieb:
      </td>
      <td>
        $start_zeit - $end_zeit
      </td>
    </tr>
    <tr>
      <td>
        $text1
      </td>
      <td>
        $eintritt
      </td>
    </tr>
  </table>
</div>";
    }else{
        $message = database_get('na_day_k');
        return "<div style='background-image:url(img/next_day_border.png);position:relative;width:350px;height:220px;'>
                  <div style='width:310px;position:absolute;left:15px;top:60px;'>
                     $message
                  </div>
                </div>";
    }
    database_close($db);
}

?>
