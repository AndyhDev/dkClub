<?php
function plugin_terminabfrage(){
    if(isset($_POST['name'])){
        $links = array();
        foreach($_POST as $key => $value){
            if(startswith($key, 'link_')){
                $link = str_replace('link_', '', $key);
                if(is_numeric($value)){
                    $links[$link] = $value;
                }else{
                    return "Fehlerhafte Formular Übermittlung, bitte erneut versuchen!";
                }
            }
        }
        
        $name = mysql_real_escape_string($_POST['name']);
        $hinweis = mysql_real_escape_string($_POST['hinweis']);
        
        $sql1 = "INSERT INTO termin_abf (name, hinweis)
                 VALUES ('$name', '$hinweis')";
        
        $sql2 = "UPDATE termin_abf
                 SET";
        
        foreach($links as $key => $value){
            $sql2 .= " `$key`='$value',";
        }
        $sql2 = rtrim($sql2, ",");
          
        mysql_query($sql1);
        $id = mysql_insert_id();
        
        $sql2 .= " WHERE id='$id'"; 
        mysql_query($sql2);
        
        return "<h3>Vielen Dank $name, ihre Daten wurden übernommen</h3>";
        
    }else{
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        $html = "<script type='text/javascript'>
          function submit_abf(){
            var name = $('#termin_abf #name').val();
            if(name.length > 3){
              $('#termin_abf').submit();
            }
         
            $('#name_error').show();
            $('#name_td').css({'border' : '2px solid #a60000'});
          }
        </script>
        <h1 class='text_center'>Terminabfrage</h1>
        <br/>
        <h3>Anmeldeschluss: 20.02.2015</h3>
        <p style='font-weight:bold;'>
          Bei nicht Eintragung oder Meldung wird davon ausgegangen dass Zeit für Dienst zur Verfügung steht und dadurch eingesetzt werden kann.
        </p>
        <form id='termin_abf' method='post' action='$_SERVER[REQUEST_URI]'>
        <table class='middle_table' style='width:600px;border-collapse:collapse;border-spacing:0px;vertical-align:middle;'>
          <tr>
            <td id='name_td' colspan='2'>
              <span style='font-weight:bold;'>Name:</span> <input style='width:300px;' id='name' name='name' type='text' />
            </td>
            <td>
              <div id='name_error' style='display:none;'>Name vergessen <br/> oder zu kurz!</div>
            </td>
          </tr>
          <tr><td>&nbsp;</td><td>&nbsp;</td<td>&nbsp;</td></tr>
          <tr>
            <td style='font-weight:bold;padding-bottom:10px;border-bottom:1px solid black;'>
              Fahrtag
            </td>
            <td style='font-weight:bold;border-bottom:1px solid black;'>
              Datum
            </td>
            <td style='font-weight:bold;border-bottom:1px solid black;text-align:right;padding-right:30px;'>
              Wunsch für<br/>diesen Tag
            </td>
          </tr>";
        
        $days = array("So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");
        $colors = array("#ffffff", "#A9F5F2", "#F3F781");
        
        $result = mysql_query("SELECT * FROM termin_abf_config ORDER BY date");
        while ($row = mysql_fetch_array($result)){
            $name = $row['name'];
            $date = $row['date'];
            $type = $row['type'];
            $link = $row['link'];
            
            $phpdate = strtotime($date);
            $disp_date = date('d.m.Y', $phpdate);
            $day = $days[date('w', $phpdate)];
            
            $color = $colors[$type];
            
            $html .= "<tr style='background-color:$color;'>
              <td style='border-bottom:1px solid black;'>$name</td>
              <td style='border-bottom:1px solid black;'>$day $disp_date</td>
              <td style='border-bottom:1px solid black;text-align:right;padding-right:30px;'>
                <select name='link_$link' size='1'>
                  <option value='0'>Dienst</option>
                  <option value='1'>Kein Dienst</option>
                  <option value='2'>Nachfragen</option>
                </select>
              </td>
            </tr>";
        }
        
        $html .= "</table>
        <br/>
        Anmerkungen, Dienstwünsche:<br/>
        <textarea name='hinweis' style='width:600px;height:70px;'></textarea>
        <p style='font-weight:bold;'>
          Bei nicht Eintragung oder Meldung wird davon ausgegangen dass Zeit für Dienst zur Verfügung steht und dadurch eingesetzt werden kann.
        </p>
        <input type='button' style='font-size:16px;' onclick='submit_abf();' value='abschicken' />
        </form>";
        return $html;
    }
}
?>
