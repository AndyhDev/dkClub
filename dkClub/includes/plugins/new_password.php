<?php
function plugin_new_password(){
    if(isset($_GET['action'])){
        return set_passw();
    }
    if(isset($_GET['code'])){
        $code = mysql_real_escape_string($_GET['code']);
        
        $sql = "SELECT * FROM new_password WHERE code='$code'";
        $result = mysql_query($sql);
        if($result){
            $data = mysql_fetch_assoc($result);
            $user_id = $data["user"];
            if(is_numeric($user_id)){
                if($data["active"] == 1){
                    $sql = "SELECT * FROM mitglieder WHERE ID='$user_id'";
                    $result = mysql_query($sql);
                    if($result){
                        $data = mysql_fetch_assoc($result);
                        $vorname = $data["vorname"];
                        $nachname = $data["nachname"];
                        $old_name = $data["name"];
                        return "<h1 class='text_center'>ein neues Passwort festlegen</h1>
                        Hallo $vorname,<br/>
                        auf dieser Seite legst du ein neues Passwort für den Zugang zum Internen Bereich an.<br/>
                        Du wirst auch darauf hingewiesen, dass dein Benutzername geändert wird.<br/>
                        <br/>
                        Bitte beachte sobald du auf abschicken klickst wird der Link den du per E-Mail erhalten hast ungültig,<br/>
                        dass heist du kannst diesen Vorgang nicht noch einmal starten.
                        <p>
                          <form method='post' action='index.php?site=new_password&action=set'>
                            <input type='hidden' name='code' value='$code'/>
                            <table>
                              <tr>
                                <td>
                                  dein alter Benutzername:
                                </td>
                                <td>
                                  $old_name
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  dein neuer Benutzername:
                                </td>
                                <td>
                                  <span style='font-weight:bold;'>$vorname $nachname</span>
                                </td>
                              </tr>
                              <tr>
                                <td style='text-align:right;'>
                                  Neues Password:
                                </td>
                                <td>
                                  <input type='password' name='passw' size='10'/>
                                </td>
                              </tr>
                              <tr>
                                <td style='text-align:right;'>
                                  Password wiederholen:
                                </td>
                                <td>
                                  <input type='password' name='passw2' size='10'/>
                                </td>
                              </tr>
                              <tr>
                                <td></td>
                                <td>
                                  <input type='submit' value='abschicken'/>
                                </td>
                              </tr>
                            </table>
                          </form>
                        </p>
                        
                        ";
                    }else{
                        return "<h1>Fehler:</h1>Die Datenbank konnte ihr Konto nicht finden";
                    }
                }else{
                    return "<h1>Fehler:</h1>Dieser Code ist schon verbraucht, wenn sie einen neuen benötigen kontaktieren sie den Webmaster";
                }
            }else{
                return "<h1>Fehler:</h1>Ihr code ist nicht Inordung";
            }
        }else{
            return "<h1>Fehler:</h1>Ihr code ist nicht Inordung";
        }
    }
}
function set_passw(){
    $code = mysql_real_escape_string($_POST['code']);
    $passw = $_POST['passw'];
    $passw2 = $_POST['passw2'];
    
    $sql = "SELECT * FROM new_password WHERE code='$code'";
    $result = mysql_query($sql);
    if($result){
        $data = mysql_fetch_assoc($result);
        $passw_id = $data["id"]; 
        $user_id = $data["user"];
        if(is_numeric($user_id)){
            if($data["active"] == 1){
                if(strlen($passw) < 5){
                    return "<h1>Fehler:</h1>Das Passwort muss mindestens 5 Zeichen lang sein, gehen sie zurück und versuchen sie es erneut.";
                }
                if($passw != $passw2){
                    return "<h1>Fehler:</h1>Die Passwörter stimmen nicht überein, gehen sie zurück und versuchen sie es erneut.";
                }else{
                    $sql = "SELECT * FROM mitglieder WHERE ID='$user_id'";
                    $result = mysql_query($sql);
                    if($result){
                        $data = mysql_fetch_assoc($result);
                        $vorname = $data["vorname"];
                        $nachname = $data["nachname"];
                        $old_name = $data["name"];
                        $new_passw = sha1($passw);
                        
                        $sql = "UPDATE mitglieder
                                SET name='$vorname $nachname', passwort='$new_passw', active='1'
                                WHERE ID=$user_id";
                                
                        mysql_query($sql);
                        
                        $sql = "UPDATE new_password
                                SET active='0'
                                WHERE id=$passw_id";
                                
                        mysql_query($sql);
                        
                        return "<h1>Passwort und Benutzername geändert</h1>
                        Dein Passwort und Benutzername wurde erfolgreich geändert.
                        <table>
                          <tr>
                            <td style='text-align:right;'>
                              neuer Benutzername:
                            </td>
                            <td>
                              <span style='font-weight:bold;'>$vorname $nachname</span>
                            </td>
                          </tr>
                          <tr>
                            <td style='text-align:right;'>
                              neues Passwort:
                            </td>
                            <td>
                              <span style='font-weight:bold;'>$passw</span>
                            </td>
                          </tr>
                        </table>";
                        
                    }else{
                        return "<h1>Fehler:</h1>Die Datenbank konnte ihr Konto nicht finden";
                    }
                }
            }else{
                return "<h1>Fehler:</h1>Dieser Code ist schon verbraucht, wenn sie einen neuen benötigen kontaktieren sie den Webmaster";
            }
        }else{
            return "<h1>Fehler:</h1>Ihr code ist nicht Inordung";
        }
    }else{
        return "<h1>Fehler:</h1>Ihr code ist nicht Inordung";
    }
}
?>
