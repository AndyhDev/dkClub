<?php
function trans_check($var){
    if($var == 'X' or $var == 'x'){
        return ' checked="checked" ';
    }else{
        return '';
    }
}
function plugin_dampff_form_2014(){
    if(isset($_SESSION['df'])){
        $name = $_SESSION['df']['name'];
        $vorname = $_SESSION['df']['vorname'];
        $strasse = $_SESSION['df']['strasse'];
        $land = $_SESSION['df']['land'];
        $op_land = '';
        foreach(array('D', 'A', 'CH', 'I', 'F', 'NL', 'B', 'L', 'Sonst.') as $l){
            if($l == $land){
                $op_land .= "<option selected='selected'>$l</option>";
            }else{
                $op_land .= "<option>$l</option>";
            }
        }
        $plz = $_SESSION['df']['plz'];
        $ort = $_SESSION['df']['ort'];
        $email = $_SESSION['df']['email'];
        $tel = $_SESSION['df']['tel'];
        $sa = trans_check($_SESSION['df']['sa']);
        $so = trans_check($_SESSION['df']['so']);
        $mo = trans_check($_SESSION['df']['mo']);
        $anp_p = $_SESSION['df']['anz_p'];
        $sa_essen = $_SESSION['df']['sa_essen'];
        $zoll5 = trans_check($_SESSION['df']['5zoll']);
        $zoll7 = trans_check($_SESSION['df']['7zoll']);
        $zoll10 = trans_check($_SESSION['df']['10zoll']);
        $lok_m = $_SESSION['df']['lok_m'];
        $zug_m = $_SESSION['df']['zug_m'];
        $str_dampf = trans_check($_SESSION['df']['str_dampf']);
        $stat_modelle = trans_check($_SESSION['df']['stat_modelle']);
        $anz_tisch = $_SESSION['df']['anz_tisch'];
        $strom = trans_check($_SESSION['df']['strom']);
        $luft = trans_check($_SESSION['df']['luft']);
        $modell_z1 = $_SESSION['df']['modell_z1'];
        $modell_z2 = $_SESSION['df']['modell_z2'];
        $zelt = trans_check($_SESSION['df']['zelt']);
        $womo = trans_check($_SESSION['df']['womo']);
        $auto = trans_check($_SESSION['df']['auto']);
        $anreise = $_SESSION['df']['anreise'];
        $op_anreise = '';
        foreach(array('--', 'Mi', 'Do', 'Fr', 'Sa') as $l){
            if($l == $anreise){
                $op_anreise .= "<option selected='selected'>$l</option>";
            }else{
                $op_anreise .= "<option>$l</option>";
            }
        }
        $na1 = $_SESSION['df']['na1'];
        $na2 = $_SESSION['df']['na1'];
        $kuchen = $_SESSION['df']['kuchen'];
        $op_kuchen = '';
        foreach(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10') as $l){
            if($l == $kuchen){
                $op_kuchen .= "<option selected='selected'>$l</option>";
            }else{
                $op_kuchen .= "<option>$l</option>";
            }
        }
        
        return "<h1 class='text_center'>Anmeldung zum 16. Kürnbacher Dampffest 2014</h1>
    <span style='color:red;'>Anmeldeschluß 1.Mai 2014</span>
    <form method='post' action='index.php?site=join_dampf2'>
    <table>
      <tr>
        <td>
          Name*:
        </td>
        <td>
          <input style='width:350px;' type='text' size='40' name='Name' value='$name'/><!--req=True min=3 -->
        </td>
      </tr>
      <tr>
        <td>
          Vorname*:
        </td>
        <td>
          <input style='width:350px;' type='text' size='40' name='Vorname' value='$vorname'/><!--req=True min=3 -->
        </td>
      </tr>
      <tr>
        <td>
          Straße*:
        </td>
        <td>
          <input style='width:350px;' type='text' size='40' name='Strasse' value='$strasse'/><!--req=True min=3 -->
        </td>
      </tr>
      <tr>
        <td>
          PLZ / Ort*:
        </td>
        <td>
          <select style='width:70px;' size='1' name='Land'><!--req=True-->
            $op_land
          </select>
          <input style='width:100px;' type='text' size='5' maxlength='5' name='PLZ' value='$plz'/><!--req=True min=4 max=5 type=int-->
          <input style='width:166px;' type='text' size='23' name='Ort' value='$ort'/><!--req=True min=3 -->
        </td>
      </tr>
      <tr>
        <td>
          E-Mail*:
        </td>
        <td>
          <input style='width:350px;' type='text' size='40' name='email' value='$email'/><!--req=True min=5 type=mail -->
        </td>
      </tr>
      <tr>
        <td>
          Tel.Nr.*:
        </td>
        <td>
          <input style='width:250px;' type='text' size='20' name='Tel' value='$tel'/>
        </td>
      </tr>
    </table>
    <p>
    Ich werde teilnehmen am: 
    Sa, 07.06.14 <input type='checkbox' name='Samstag' value='X' $sa/>
    So, 08.06.14 <input type='checkbox' name='Sonntag' value='X' $so/>
    Mo, 09.06.14 <input type='checkbox' name='Montag' value='X' $mo/>
    </p>
    <p>
    Anzahl Personen*: <input type='text' size='2' maxlength='1' name='Anzahl_Personen' value='0' /><!--req=True min=1 max=1 type=int-->
    </p>
    <p>
    Teilnahme am Abendessen am Samstag mit* <input type='text' name='Samstag_Essen' size='2' maxlength='1' value='$sa_essen' /> Personen<!--req=True min=1 max=1 type=int-->
    </p>
    <p>
    Lok-/Wagenmodelle:
    <input type='checkbox' name='_5_Zoll' value='X' $zoll5/> 5'
    <input type='checkbox' name='_7_Zoll' value='X' $zoll7/> 7 1/4'
    <input type='checkbox' name='_10_Zoll' value='X' $zoll10/> 10 1/4'
    </p>
    <p>
    Platzbedarf für Lok und Bedienwagen: <input type='text' size='4' name='Lok_Meter' value='$lok_m'/> Meter
    </p>
    <p>
    Platzbedarf für ganze Züge: <input type='text' size='4' name='Zug_Meter' value='$zug_m'/> Meter<br/>
    (Bei mehreren Fahrzeugen Gesamtlänge angeben,
    der Veranstalter behält sich eine Begrenzung der Zuglänge vor)
    </p>
    <p>
    <input type='checkbox' name='strassendampf' value='X' $str_dampf/> Dampftraktoren / Straßendampf
    </p>
    <p>
    <input type='checkbox' name='stat_D_Modelle' value='X' $stat_modelle> Stationäre Dampfmodelle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Anzahl Tisch(e)<input type='text' name='Anzahl_Tisch' size='2' maxlength='1' value='$anz_tisch'/><!--min=1 max=1 type=int-->
    </p>
    <p>
    <input type='checkbox' name='Stromanschl' value='X' $strom> Stromanschluß
    </p>
    <p>
    <input type='checkbox' name='Druckluft' value='X' $luft> Druckluft
    </p>
    <p>
    <span style='color:#000080'>Wasserhärte im Bahnhof und Drehscheibe: 6 dH</span>
    </p>
    <p>
    Modellbeschreibung:<br/>
    <input style='width:750px;' type='text' name='Modell_Zeile1' size='90' maxlength='90' value='$modell_z1'><br><!--req=True max=90-->
    <input style='width:750px;' type='text' name='Modell_Zeile2' size='90' maxlength='90' value='$modell_z2'><!--req=True max=90-->
    </p>
    <p>
    Benötigen Sie einen Campingplatz?<br/>
    <input type='checkbox' name='Zeltplatz' value='X' $zelt> ja, Zelt&nbsp;&nbsp;&nbsp;
    <input type='checkbox' name='Womo_WoWa_Platz' value='X' $womo> ja, Wohnwagen/Wohnmobil&nbsp;&nbsp;&nbsp;
    <input type='checkbox' name='Auto_schlafen' value='X' $auto> schlafe im Pkw
    </p>
    <p>
    <span style='color:#000080'>Für Caravan / Wohnmobile steht ein eigener Stromanschluss pro Fahrzeug zur Verfügung (SCHUKO-Steckdose 230 V / 4 A)</span>
    </p>
    <p>
    Anreise für Campingplatz am: 
    <select size='1' name='Anreise_CP'>
      $op_anreise
    </select>
    </p>
    <p>
    Platz für eine Nachricht:<br>
    <input style='width:750px;' type='text' name='Nachricht1' size='90' maxlength='90' value='$na1'><br/><!--req=True max=90-->
    <input style='width:750px;' type='text' name='Nachricht2' size='90' maxlength='90' value='$na2'><!--req=True max=90-->
    </p>
    <p style='margin-left:100px;'>
    <input type='submit' value='Abschicken' name='b1'>
    <input type='reset' value='Eingaben löschen' name='Reset'>
    </p>
    </form>
    <p>
      * = Pflichtfeld
    </p>
    Wenn das Anmeldeformular richtig an uns übermittelt wurde, erhalten Sie eine
    Bestätigungsseite.";
    
    }else{
    return "<h1 class='text_center'>Anmeldung zum 16. Kürnbacher Dampffest 2014</h1>
    <span style='color:red;'>Anmeldeschluß 1.Mai 2014</span>
    <form method='post' action='index.php?site=join_dampf2'>
    <table>
      <tr>
        <td>
          Name*:
        </td>
        <td>
          <input style='width:350px;' type='text' size='40' name='Name' /><!--req=True min=3 -->
        </td>
      </tr>
      <tr>
        <td>
          Vorname*:
        </td>
        <td>
          <input style='width:350px;'type='text' size='40' name='Vorname' /><!--req=True min=3 -->
        </td>
      </tr>
      <tr>
        <td>
          Straße*:
        </td>
        <td>
          <input style='width:350px;'type='text' size='40' name='Strasse' /><!--req=True min=3 -->
        </td>
      </tr>
      <tr>
        <td>
          PLZ / Ort*:
        </td>
        <td>
          <select style='width:70px;' size='1' name='Land'><!--req=True-->
            <option selected='selected'>D</option>
            <option>A</option>
            <option>CH</option>
            <option>I</option>
            <option>F</option>
            <option>NL</option>
            <option>B</option>
            <option>L</option>
            <option>Sonst.</option>
          </select>
          <input style='width:100px;' type='text' size='5' maxlength='5' name='PLZ' /><!--req=True min=4 max=5 type=int-->
          <input style='width:166px;' type='text' size='23' name='Ort' /><!--req=True min=3 -->
        </td>
      </tr>
      <tr>
        <td>
          E-Mail*:
        </td>
        <td>
          <input style='width:350px;' type='text' size='40' name='email' /><!--req=True min=5 type=mail -->
        </td>
      </tr>
      <tr>
        <td>
          Tel.Nr.*:
        </td>
        <td>
          <input style='width:250px;' type='text' size='20' name='Tel' />
        </td>
      </tr>
    </table>
    <p>
    Ich werde teilnehmen am: 
    Sa, 07.06.14 <input type='checkbox' name='Samstag' value='X' />
    So, 08.06.14 <input type='checkbox' name='Sonntag' value='X' />
    Mo, 09.06.14 <input type='checkbox' name='Montag' value='X' />
    </p>
    <p>
    Anzahl Personen*: <input type='text' size='2' maxlength='1' name='Anzahl_Personen' value='0' /><!--req=True min=1 max=1 type=int-->
    </p>
    <p>
    Teilnahme am Abendessen am Samstag mit* <input type='text' name='Samstag_Essen' size='2' maxlength='1' value='0' /> Personen<!--req=True min=1 max=1 type=int-->
    </p>
    <p>
    Lok-/Wagenmodelle:
    <input type='checkbox' name='_5_Zoll' value='X' /> 5'
    <input type='checkbox' name='_7_Zoll' value='X' /> 7 1/4'
    <input type='checkbox' name='_10_Zoll' value='X' /> 10 1/4'
    </p>
    <p>
    Platzbedarf für Lok und Bedienwagen: <input type='text' size='4' name='Lok_Meter' /> Meter
    </p>
    <p>
    Platzbedarf für ganze Züge: <input type='text' size='4' name='Zug_Meter' /> Meter<br/>
    (Bei mehreren Fahrzeugen Gesamtlänge angeben,
    der Veranstalter behält sich eine Begrenzung der Zuglänge vor)
    </p>
    <p>
    <input type='checkbox' name='strassendampf' value='X' /> Dampftraktoren / Straßendampf
    </p>
    <p>
    <input type='checkbox' name='stat_D_Modelle' value='X'> Stationäre Dampfmodelle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Anzahl Tisch(e)<input type='text' name='Anzahl_Tisch' size='2' maxlength='1' /><!--min=1 max=1 type=int-->
    </p>
    <p>
    <input type='checkbox' name='Stromanschl' value='X'> Stromanschluß
    </p>
    <p>
    <input type='checkbox' name='Druckluft' value='X'> Druckluft
    </p>
    <p>
    <span style='color:#000080'>Wasserhärte im Bahnhof und Drehscheibe: 6 dH</span>
    </p>
    <p>
    Modellbeschreibung:<br/>
    <input style='width:750px;' type='text' name='Modell_Zeile1' size='90' maxlength='90'><br><!--req=True max=90-->
    <input style='width:750px;' type='text' name='Modell_Zeile2' size='90' maxlength='90'><!--req=True max=90-->
    </p>
    <p>
    Benötigen Sie einen Campingplatz?<br/>
    <input type='checkbox' name='Zeltplatz' value='X'> ja, Zelt&nbsp;&nbsp;&nbsp;
    <input type='checkbox' name='Womo_WoWa_Platz' value='X'> ja, Wohnwagen/Wohnmobil&nbsp;&nbsp;&nbsp;
    <input type='checkbox' name='Auto_schlafen' value='X'> schlafe im Pkw
    </p>
    <p>
    <span style='color:#000080'>Für Caravan / Wohnmobile steht ein eigener Stromanschluss pro Fahrzeug zur Verfügung (SCHUKO-Steckdose 230 V / 4 A)</span>
    </p>
    <p>
    Anreise für Campingplatz am: 
    <select size='1' name='Anreise_CP'>
      <option selected='selected'>--</option>
      <option>Mi</option>
      <option>Do</option>
      <option>Fr</option>
      <option>Sa</option>
    </select>
    </p>
    <p>
    Platz für eine Nachricht:<br>
    <input style='width:750px;' type='text' name='Nachricht1' size='90' maxlength='90'><br/><!--req=True max=90-->
    <input style='width:750px;' type='text' name='Nachricht2' size='90' maxlength='90'><!--req=True max=90-->
    </p>
    <p style='margin-left:100px;'>
    <input type='submit' value='Abschicken' name='b1'>
    <input type='reset' value='Eingaben löschen' name='Reset'>
    </p>
    </form>
    <p style='display:inline-block;border:2px solid red;padding:8px;'>
      Die bei der Anmeldung zum Dampffest vom SEV erhobenen Daten werden für<br/>
      die Durchführung der Dampffeste des SEV verwendet und zur Korrespondenz<br/> 
      des SEV mit dem entsprechenden Dampffreund.<br/><br/>
      * = Pflichtfeld
    </p>
    <br/>
    Wenn das Anmeldeformular richtig an uns übermittelt wurde, erhalten Sie eine
    Bestätigungsseite.";
    }
}
?>
