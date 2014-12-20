<?php
include_once('run_admin.php');

function get_list(){
    $html = "<table border='1' style='margin-left:50px;width:680px;border-color:gray;border-collapse:collapse;'>
             <tr style='background-color:#2EFE2E;'><td>ID</td><td>motto</td><td>datum</td><td>start_zeit</td><td>end_zeit</td><td>eintritt</td><td>zusatz</td><td></td></tr>";
    database_connect();
    $res = mysql_query('SELECT * FROM days ORDER BY datum');
    while ($row = mysql_fetch_array($res)){
        $id = $row['ID'];
        $motto = $row['motto'];
        $datum = $row['datum'];
        $start_zeit = $row['start_zeit'];
        $end_zeit = $row['end_zeit'];
        $eintritt = $row['eintritt'];
        $zusatz = $row['zusatz'];
        $html .= "<tr>
                    <td>$id</td>
                    <td>$motto</td>
                    <td>$datum</td>
                    <td>$start_zeit</td>
                    <td>$end_zeit</td>
                    <td>$eintritt</td>
                    <td>$zusatz</td>
                    <td><a href='admin.php?site=days&action=edit&id=$id'><img src='admin/edit.png'/></a>
                    <a href='admin.php?site=days&action=delete&id=$id'><img src='admin/delete.png'/></a></td>
                  </tr>";
    }
    return $html;
}
function get_edit($id){
    database_connect();
    $res = mysql_query("SELECT * FROM days WHERE id=$id");
    $row = mysql_fetch_array($res);
    $motto = $row['motto'];
    $datum = $row['datum'];
    $start_zeit = $row['start_zeit'];
    $end_zeit = $row['end_zeit'];
    $eintritt = $row['eintritt'];
    $zusatz = $row['zusatz'];
    if($eintritt == "kostenpflichtig"){
        $op = '<option value="kostenlos">kostenlos</option>
               <option value="kostenpflichtig" selected="selected">kostenpflichtig</option>';
    }else{
        $op = '<option value="kostenlos" selected="selected">kostenlos</option>
               <option value="kostenpflichtig">kostenpflichtig</option>';
    }
    $html = "<form method='post' action='admin.php?site=days&action=save&id=$id'>
      <table>
        <tr>
          <td>
            ID:
          </td>
          <td>
            $id
          </td>
        </tr>
        <tr>
          <td>
            Motto:
          </td>
          <td>
            <input type='text' name='motto' value='$motto'/>
          </td>
        </tr>
        <tr>
          <td>
            Datum:
          </td>
          <td>
            <input type='text' name='datum' value='$datum'/>
          </td>
          <td>
            Format: JJJJ-MM-TT ohne Leerzeichen!!!
          </td>
        </tr>
        <tr>
          <td>
            Startzeit:
          </td>
          <td>
            <input type='text' name='start_zeit' value='$start_zeit'/>
          </td>
          <td>
            Format: HH:MM
          </td>
        </tr>
        <tr>
          <td>
            Endzeit
          </td>
          <td>
            <input type='text' name='end_zeit' value='$end_zeit'/>
          </td>
          <td>
            Format: HH:MM
          </td>
        </tr>
        <tr>
          <td>
            Eintritt
          </td>
          <td>
            <select size='1' name='eintritt'>
              $op
            </select>
          </td>
        </tr>
        <tr>
          <td>
            Zusatz:
          </td>
          <td>
            <input type='text' name='zusatz' value='$zusatz'/>
          </td>
        </tr>
      </table>
      <input type='submit' value='Speichern'/>
    </form>";
    return $html;
}
function get_new($id){
    $html = "<form method='post' action='admin.php?site=days&action=save_new&id=0'>
      <table>
        <tr>
          <td>
            Motto:
          </td>
          <td>
            <input type='text' name='motto' value=''/>
          </td>
        </tr>
        <tr>
          <td>
            Datum:
          </td>
          <td>
            <input type='text' name='datum' value=''/>
          </td>
          <td>
            Format: JJJJ-MM-TT ohne Leerzeichen!!!
          </td>
        </tr>
        <tr>
          <td>
            Startzeit:
          </td>
          <td>
            <input type='text' name='start_zeit' value='11:00'/>
          </td>
          <td>
            Format: HH:MM
          </td>
        </tr>
        <tr>
          <td>
            Endzeit
          </td>
          <td>
            <input type='text' name='end_zeit' value='17:00'/>
          </td>
          <td>
            Format: HH:MM
          </td>
        </tr>
        <tr>
          <td>
            Eintritt
          </td>
          <td>
            <select size='1' name='eintritt'>
              <option value='kostenlos'>kostenlos</option>
             <option value='kostenpflichtig'>kostenpflichtig</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            Zusatz:
          </td>
          <td>
            <input type='text' name='zusatz' value=''/>
          </td>
        </tr>
      </table>
      <input type='submit' value='Erstellen'/>
    </form>";
    return $html;
}
function get_save($id){
    $motto = $_POST['motto'];
    $datum = $_POST['datum'];
    $start_zeit = $_POST['start_zeit'];
    $end_zeit = $_POST['end_zeit'];
    $eintritt = $_POST['eintritt'];
    $zusatz = $_POST['zusatz'];
    database_connect();
    mysql_query("UPDATE days
                 SET motto='$motto', datum='$datum', start_zeit='$start_zeit', end_zeit='$end_zeit', eintritt='$eintritt', zusatz='$zusatz'
                 WHERE ID='$id'");
    database_set_event("Fahrtag '$ID' geändert");
    return "Fahrtag geändert"; 
}
function get_save_new(){
    $motto = $_POST['motto'];
    $datum = $_POST['datum'];
    $start_zeit = $_POST['start_zeit'];
    $end_zeit = $_POST['end_zeit'];
    $eintritt = $_POST['eintritt'];
    $zusatz = $_POST['zusatz'];
    database_connect();
    mysql_query("INSERT INTO days (motto, datum, start_zeit, end_zeit, eintritt, zusatz)
                 VALUES ('$motto', '$datum', '$start_zeit', '$end_zeit', '$eintritt', '$zusatz')");
    database_set_event("Fahrtag '$motto' erstellt");
    return "Fahrtag erstellt";
}
function get_delete($id){
  return "<form method='post' action='admin.php?site=days&action=true_delete&id=$id'>
    <input type='submit' value='Fahrtag LÖSCHEN'/>
    </form>";
}
function get_true_delete($id){
    database_connect();
    mysql_query("DELETE FROM days WHERE id=$id");
    database_set_event("Fahrtag '$id' gelöscht'");
    return "Fahrtag gelöscht";
}
if(isset($_GET['id']) and isset($_GET['action'])){
  $id = $_GET['id'];
  $action = $_GET['action'];
  if($action == "edit"){
    echo get_edit($id);
  }elseif($action == "new"){
    echo get_new($id);
  }elseif($action == "save"){
    echo get_save($id);
  }elseif($action == "save_new"){
    echo get_save_new($id);
  }elseif($action == "delete"){
    echo get_delete($id);
  }elseif($action == "true_delete"){
    echo get_true_delete($id);
  }
}else{
  echo get_list();
}
?>
