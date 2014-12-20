<?php
include_once("form_validate.php");

function trans($var){
    if($var == 'X' or $var == 'x'){
        return 'Ja';
    }else{
        return 'Nein';
    }
}
function plugin_intern_join_dampf_2014(){
    $ok = True;
    $fields = array('Name' => array('reg' => True, 'min' => 3),
                    'Vorname' => array('reg' => True, 'min' => 3),
                    'Strasse' => array('reg' => True, 'min' => 3),
                    'Land' => array('reg' => True),
                    'PLZ' => array('reg' => True, 'min' => 4, 'max' => 5),
                    'Ort' => array('reg' => True, 'min' => 3),
                    'email' => array('reg' => True, 'min' => 5, 'type' => 'mail'),
                    'Tel' => array('reg' => True, 'min' => 3),
                    'Samstag' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Sonntag' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Montag' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Anzahl_Personen' => array('reg' => True, 'min' => 1, 'max' => 1, 'type' => 'int', 'default' => '0'),
                    'Samstag_Essen' => array('reg' => True, 'min' => 1, 'max' => 1, 'type' => 'int', 'default' => '0'),
                    '_5_Zoll' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    '_7_Zoll' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    '_10_Zoll' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Lok_Meter' => array('default' => ''),
                    'Zug_Meter' => array('default' => ''),
                    'strassendampf' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'stat_D_Modelle' => array('type' => 'ckeckbox', 'choice' => array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), 'default' => ''),
                    'Anzahl_Tisch' => array('max' => 1),
                    'Stromanschl' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Druckluft' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Modell_Zeile1' => array('max' => 90),
                    'Modell_Zeile2' => array('max' => 90),
                    'Zeltplatz' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Womo_WoWa_Platz' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Auto_schlafen' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Anreise_CP' => array('type' => 'ckeckbox', 'choice' => array('--', 'Mi', 'Do', 'Fr', 'Sa'), 'default' => '--'),
                    'Nachricht1' => array('max' => 90),
                    'Nachricht2' => array('max' => 90),
                    'Kuchenanzahl' => array('type' => 'int'),
                    'Freitag_Personal' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Samstag_Vormittag_Personal' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Samstag_Nachmittag_Personal' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Sonntag_Vormittag_Personal' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Sonntag_Nachmittag_Personal' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Montag__Vormittag_Personal' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Montag_Nachmittag_Personal' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    'Dienstag_Abbau' => array('type' => 'ckeckbox', 'choice' => array('X', ''), 'default' => ''),
                    );
    $erg = validate_form($_POST, $fields);
    $html = '';
    
    $name = mysql_real_escape_string($erg['Name']['value']);
    $vorname = mysql_real_escape_string($erg['Vorname']['value']);
    $strasse = mysql_real_escape_string($erg['Strasse']['value']);
    $land = mysql_real_escape_string($erg['Land']['value']);
    $plz = mysql_real_escape_string($erg['PLZ']['value']);
    $ort = mysql_real_escape_string($erg['Ort']['value']);
    $email = mysql_real_escape_string($erg['email']['value']);
    $tel = mysql_real_escape_string($erg['Tel']['value']);
    $sa = mysql_real_escape_string($erg['Samstag']['value']);
    $so = mysql_real_escape_string($erg['Sonntag']['value']);
    $mo = mysql_real_escape_string($erg['Montag']['value']);
    $anz_p = mysql_real_escape_string($erg['Anzahl_Personen']['value']);
    $sa_essen = mysql_real_escape_string($erg['Samstag_Essen']['value']);
    $zoll5 = mysql_real_escape_string($erg['_5_Zoll']['value']);
    $zoll7 = mysql_real_escape_string($erg['_7_Zoll']['value']);
    $zoll10 = mysql_real_escape_string($erg['_10_Zoll']['value']);
    $lok_m = mysql_real_escape_string($erg['Lok_Meter']['value']);
    $zug_m = mysql_real_escape_string($erg['Zug_Meter']['value']);
    $str_dampf = mysql_real_escape_string($erg['strassendampf']['value']);
    $stat_modelle = mysql_real_escape_string($erg['stat_D_Modelle']['value']);
    $anz_tisch = mysql_real_escape_string($erg['Anzahl_Tisch']['value']);
    $strom = mysql_real_escape_string($erg['Stromanschl']['value']);
    $luft = mysql_real_escape_string($erg['Druckluft']['value']);
    $modell_z1 = mysql_real_escape_string($erg['Modell_Zeile1']['value']);
    $modell_z2 = mysql_real_escape_string($erg['Modell_Zeile2']['value']);
    $zelt = mysql_real_escape_string($erg['Zeltplatz']['value']);
    $womo = mysql_real_escape_string($erg['Womo_WoWa_Platz']['value']);
    $auto = mysql_real_escape_string($erg['Auto_schlafen']['value']);
    $anreise = mysql_real_escape_string($erg['Anreise_CP']['value']);
    $na1 = mysql_real_escape_string($erg['Nachricht1']['value']);
    $na2 = mysql_real_escape_string($erg['Nachricht2']['value']);
    
    $kuchen = mysql_real_escape_string($erg['Kuchenanzahl']['value']);
    $afr = mysql_real_escape_string($erg['Freitag_Personal']['value']);
    $sa1 = mysql_real_escape_string($erg['Samstag_Vormittag_Personal']['value']);
    $sa2 = mysql_real_escape_string($erg['Samstag_Nachmittag_Personal']['value']);
    $so1 = mysql_real_escape_string($erg['Sonntag_Vormittag_Personal']['value']);
    $so2 = mysql_real_escape_string($erg['Sonntag_Nachmittag_Personal']['value']);
    $mo1 = mysql_real_escape_string($erg['Montag__Vormittag_Personal']['value']);
    $mo2 = mysql_real_escape_string($erg['Montag_Nachmittag_Personal']['value']);
    $di = mysql_real_escape_string($erg['Dienstag_Abbau']['value']);
    
    $_SESSION['df'] = array('name' => $name,
                            'vorname' => $vorname,
                            'strasse' => $strasse,
                            'land' => $land,
                            'plz' => $plz,
                            'ort' => $ort,
                            'email' => $email,
                            'tel' => $tel,
                            'sa' => $sa,
                            'so' => $so,
                            'mo' => $mo,
                            'anz_p' => $anz_p,
                            'sa_essen' => $sa_essen,
                            '5zoll' => $zoll5,
                            '7zoll' => $zoll7,
                            '10zoll' => $zoll10,
                            'lok_m' => $lok_m,
                            'zug_m' => $zug_m,
                            'str_dampf' => $str_dampf,
                            'stat_modelle' => $stat_modelle,
                            'anz_tisch' => $anz_tisch,
                            'strom' => $strom,
                            'luft' => $luft,
                            'modell_z1' => $modell_z1,
                            'modell_z2' => $modell_z2,
                            'zelt' => $zelt,
                            'womo' => $womo,
                            'auto' => $auto,
                            'anreise' => $anreise,
                            'na1' => $na1,
                            'na2' => $na2,
                            'kuchen' => $kuchen,
                            'afr' => $afr,
                            'sa1' => $sa1,
                            'sa2' => $sa2,
                            'so1' => $so1,
                            'so2' => $so2,
                            'mo1' => $mo1,
                            'mo2' => $mo2,
                            'di' => $di,
                            );
                                
    foreach($erg as $key => $value){
        if(!$value['ok']){
            $ok = False;
            $fname = $value['field'];
            $html = $html . "Das Feld <span style='font-weight:bold;'>'$fname'</span> hat foldgende Fehler:<ul>";
            foreach($value['errors'] as $error){
                $html = $html . "<li>$error</li>";
            }
            $html = $html . "</ul>";
        }
    }
    if(!$ok){
        $html = $html . "<span style='font-weight:bold;'><a href='index.php?site=i_join_dampf'>Bitte gehen sie zurück zum Formular und korrigieren sie die Fehler</a></span>";
        return $html;
    }else{
        
        
        $sql = "INSERT INTO dampffest (Name, Vorname, Strasse, Land, PLZ, Ort, email, Tel, Samstag, Sonntag, Montag, Anzahl_Personen, Sa_Essen, _5_Zoll,
                                       _7_Zoll, _10_Zoll, Lok_Meter, Zug_Meter, strassendampf, stat_D_Modelle, Anzahl_Tisch, Stromanschl, Druckluft,
                                       Modell_Zeile1, Modell_Zeile2, Zeltplatz, Womo_WoWa_Platz, Auto_schlafen, Anreise_CP, Nachricht1, Nachricht2, Kuchenanzahl,
                                       Freitag_Personal, Samstag_Vormittag_Personal, Samstag_Nachmittag_Personal, Sonntag_Vormittag_Personal, Sonntag_Nachmittag_Personal,
                                       Montag__Vormittag_Personal, Montag_Nachmittag_Personal, Dienstag_Abbau, Mitglied)
                                       
                VALUES ('$name', '$vorname', '$strasse', '$land', '$plz', '$ort', '$email', '$tel', '$sa', '$so', '$mo', '$anz_p', '$sa_essen', '$zoll5',
                        '$zoll7', '$zoll10', '$lok_m', '$zug_m', '$str_dampf', '$stat_modelle', '$anz_tisch', '$strom', '$luft',
                        '$modell_z1', '$modell_z2', '$zelt', '$womo', '$auto', '$anreise', '$na1', '$na2', '$kuchen',
                        '$afr', '$sa1', '$sa2', '$so1', '$so2',
                        '$mo1', '$mo2', '$di', 'X')";
                        
        $res = mysql_query($sql);
        if(!$res){
            $error = mysql_error();
            return "<h1 class='text_center'>Anmeldung zum 16. Kürnbacher Dampffest 2014</h1>
                    <h3 class='text_center' style='color:red;'>Leider ist bei Ihrer Anmeldung ein Datenbankfehler aufgetretten.</h3>
                    Versuchen sie es erneut, sollte der Fehler weiter bestehen benarichtigen sie uns bitte unter: <p>info@sev-kuernbach.de</p>
                    <p>
                      Der genaue Fehler ist:<br/>
                      $error
                    </p>";
        }
        $sa = trans($sa);
        $so = trans($so);
        $zoll5 = trans($zoll5);
        $zoll7 = trans($zoll7);
        $zoll10 = trans($zoll10);
        $str_dampf = trans($str_dampf);
        $stat_modelle = trans($stat_modelle);
        $strom = trans($strom);
        $luft = trans($luft);
        $zelt = trans($zelt);
        $womo = trans($womo);
        $auto = trans($auto);
        
        $afr = trans($afr);
        $sa1 = trans($sa1);
        $sa2 = trans($sa2);
        $so1 = trans($so1);
        $so2 = trans($so2);
        $mo1 = trans($mo1);
        $mo2 = trans($mo2);
        
        
        $empfaenger = $email;
        $absendername = "Schwaebische Eisenbahnverein Kuernbach";
        $absendermail = "info@sev-kuernbach.de";
        $betreff = "Dampffest-Anmeldung";
        $text = "Lieber Dampffreund, vielen Dank für Ihre 
Anmeldung zum Kürnbacher Dampffest 2014. Dies ist nur eine Bestätigung, 
dass Ihre Anmeldung zum Dampffest 2014 korrekt war und bei uns 
registriert ist. Die offiziellen Teilnehmerunterlagen bekommen Sie nach 
Abschluß der Anmeldefrist an diese Emailaddresse zugesandt.
MfG SEV Kürnbach";
        mail($empfaenger, $betreff, $text, "From: $absendername <$absendermail>");
        
        unset($_SESSION['df']);
        
        return "<h1 class='text_center'>Anmeldung zum 16. Kürnbacher Dampffest 2014</h1>
        <h3 class='text_center' style='color:red;'>Vielen Dank für ihre Anmeldung.</h3>
        
        <p>Ihre Daten wurden wie folgt aufgenommen:</p>
        <table style='border-spacing:10px;'>
          <tr>
            <td style='text-align:right;'>
              Name:
            </td>
            <td>
              $name
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Vorname:
            </td>
            <td>
              $vorname
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Strasse:
            </td>
            <td>
              $strasse
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Land:
            </td>
            <td>
              $land
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              PLZ:
            </td>
            <td>
              $plz
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Ort:
            </td>
            <td>
              $ort
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              E-Mail
            </td>
            <td>
              $email
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Tel.Nr.:
            </td>
            <td>
              $tel
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Teilnahme Samstag:
            </td>
            <td>
              $sa
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Teilnahme Sonntag:
            </td>
            <td>
              $so
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Anzahl Personen:
            </td>
            <td>
              $anz_p
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Samstag Abendessen (Personen):
            </td>
            <td>
              $sa_essen
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Lok-/Wagen 5&quot;:
            </td>
            <td>
              $zoll5
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Lok-/Wagen 7 1/4&quot;:
            </td>
            <td>
              $zoll7
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Lok-/Wagen 10 1/4&quot; :
            </td>
            <td>
              $zoll10
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Platzbedarf für Lok und Bedienwagen (m):
            </td>
            <td>
              $lok_m
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Platzbedarf für ganze Züge (m): 
            </td>
            <td>
              $zug_m
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Dampftraktoren / Straßendampf:
            </td>
            <td>
              $str_dampf
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Stationäre Dampfmodelle:
            </td>
            <td>
              $stat_modelle
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Anzahl Tisch(e):
            </td>
            <td>
              $anz_tisch
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Stromanschluß:
            </td>
            <td>
              $strom
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Druckluft:
            </td>
            <td>
              $luft
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Modellbeschreibung:
            </td>
            <td>
              $modell_z1<br/>
              $modell_z2
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Campingplatz (Zelt):
            </td>
            <td>
              $zelt
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Campingplatz (Wohnwagen/Wohnmobil):
            </td>
            <td>
              $womo
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Campingplatz (schlafe im Pkw):
            </td>
            <td>
              $auto
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Anreise für Campingplatz am: 
            </td>
            <td>
              $anreise
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Nachricht:
            </td>
            <td>
              $na1<br/>
              $na2
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Kuchenanzahl:
            </td>
            <td>
              $kuchen
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Freitag Aufbau:
            </td>
            <td>
              $afr
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Samstag Vormittag:
            </td>
            <td>
              $sa1
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Samstag Nachmittag:
            </td>
            <td>
              $sa2
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Sonntag Vormittag:
            </td>
            <td>
              $so1
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Sonntag Nachmittag:
            </td>
            <td>
              $so2
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Montag Vormittag:
            </td>
            <td>
              $mo1
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Montag Nachmittag:
            </td>
            <td>
              $mo2
            </td>
          </tr>
          <tr>
            <td style='text-align:right;'>
              Dienstag -Abbau:
            </td>
            <td>
              $di
            </td>
          </tr>
        </table>";
    }
}
?>
