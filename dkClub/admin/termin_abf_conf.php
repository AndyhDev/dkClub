<?php
include_once('run_admin.php');

function get_list(){
    $html = "<table border='1' style='width:100%;border-color:gray;border-collapse:collapse;'>
    <tr style='background-color:#2EFE2E;'><td>ID</td><td>Name</td><td>Datum</td><td>Typ</td><td>Verknüpfung</td></tr><tr></tr>";
    
    $types = array("Normal", "Externer Fahreinsatz", "Dampffest");
    
    $db = database_connect();
    
    $sql = "SELECT * FROM termin_abf_config ORDER BY date";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result)){
        $id = $row['id'];
        $name = $row['name'];
        $date = $row['date'];
        $link = $row['link'];
        $type = $types[$row['type']];
        $html .= "<tr>
                    <td>
                      $id
                    </td>
                    <td>
                      $name
                    </td>
                    <td>
                      $date
                    </td>
                    <td>
                      $type
                    </td>
                    <td>
                      $link
                    </td>
                    <td>
                      <a href='admin.php?site=termin_abf_conf&action=edit&id=$id'><img src='admin/edit.png'/></a>
                      <a href='admin.php?site=termin_abf_conf&action=delete&id=$id'><img src='admin/delete.png'/></a>
                    </td>
                  </tr>";
    }
    database_close($db);
    $html .= "</table><p>
        <a href='admin.php?site=termin_abf_conf&action=new&id=0'><img style='vertical-align:middle;' src='admin/add.png'/>Neuer Termin</a>
    </p>";
    return $html;
}
function get_new(){
    $html = "<form method='post' action='admin.php?site=termin_abf_conf&id=0&action=create'>
    <table>
      <tr>
        <td>Name:</td>
        <td><input type='text' name='name'/></td>
      </tr>
      <tr>
        <td>Datum:</td>
        <td><input type='text' name='date'/></td>
        <td>Format: JJJJ-MM-TT ohne Leerzeichen!!!</td>
      </tr>
      <tr>
        <td>Typ:</td>
        <td>
          <select name='type' size='1'>
            <option value='0'>Normal</option>
            <option value='1'>Externer Fahreinsatz</option>
            <option value='2'>Dampffest</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Verknüpfung</td>
        <td><select name='link' size='1'>";
    
    for ($i = 1; $i <= 50; $i++) {
        $html .= "<option value='$i'>" . $i . "</option>";
    }
    $html .= "</select></td>
        <td>jede Zahl darf nur 1mal benützt werden</td>
      </tr>
    </table>
    <input type='submit' value='erstellen'/>
    </form>";
    return $html;
}
function get_create(){
    $name = $_POST["name"];
    $date = $_POST["date"];
    $type = $_POST["type"];
    $link = $_POST["link"];
    
    database_connect();
    mysql_query("INSERT INTO termin_abf_config (name, date, type, link)
                 VALUES ('$name', '$date', '$type', '$link')");
                 
    database_set_event("Neure Termin '$name' erstellt");
    return "Neure Termin '$name' erstellt";
}
function get_edit($id){
     database_connect();
     $result = mysql_query("SELECT * FROM termin_abf_config WHERE id='$id'");
     $row = mysql_fetch_array($result);
     
     $name = $row['name'];
     $date = $row['date'];
     $type = $row['type'];
     $link = $row['link'];
     
     $html = "<form method='post' action='admin.php?site=termin_abf_conf&id=$id&action=save'>
    <table>
      <tr>
        <td>Name:</td>
        <td><input type='text' name='name' value='$name'/></td>
      </tr>
      <tr>
        <td>Datum:</td>
        <td><input type='text' name='date' value='$date'/></td>
        <td>Format: JJJJ-MM-TT ohne Leerzeichen!!!</td>
      </tr>
      <tr>
        <td>Typ:</td>
        <td>
          <select name='type' size='1'>";
    $types = array("Normal", "Externer Fahreinsatz", "Dampffest");
    
    for($i=0; $i < count($types); $i++){
       if($i == $type){
            $html .= "<option selected='selected' value='$i'>" . $types[$i] . "</option>";
        }else{
            $html .= "<option value='$i'>" . $types[$i] . "</option>";
        }
    }
            
    $html .= "</select>
        </td>
      </tr>
      <tr>
        <td>Verknüpfung</td>
        <td><select name='link' size='1'>";
    
    for ($i = 1; $i <= 50; $i++) {
        if($i == $link){
            $html .= "<option selected='selected' value='$i'>" . $i . "</option>";
        }else{
            $html .= "<option value='$i'>" . $i . "</option>";
        }
    }
    $html .= "</select></td>
        <td>jede Zahl darf nur 1mal benützt werden</td>
      </tr>
    </table>
    <input type='submit' value='speichern'/>
    </form>";
    return $html;
}
function get_save($id){
    $name = $_POST["name"];
    $date = $_POST["date"];
    $type = $_POST["type"];
    $link = $_POST["link"];
    
    database_connect();
    mysql_query("UPDATE termin_abf_config
                 SET name='$name', date='$date', type='$type', link='$link'
                 WHERE id='$id'");
                 
    database_set_event("Termin '$name', '$id' geändert");
    return "Termin '$name', '$id' geändert";
}
function get_delete($id){
  return "<form method='post' action='admin.php?site=termin_abf_conf&action=true_delete&id=$id'>
    <input type='submit' value='Termin LÖSCHEN'/>
    </form>";
}
function get_true_delete($id){
    database_connect();
    mysql_query("DELETE FROM termin_abf_config WHERE id=$id");
    database_set_event("Termin '$id' gelöscht'");
    return "Termin gelöscht";
}
if(isset($_GET['id']) and isset($_GET['action'])){
  $id = $_GET['id'];
  $action = $_GET['action'];
  if($action == "delete"){
    echo get_delete($id);
  }elseif($action == "true_delete"){
    echo get_true_delete($id);
  }elseif($action == "edit"){
    echo get_edit($id);
  }elseif($action == "save"){
    echo get_save($id);
  }elseif($action == "new"){
    echo get_new();
  }elseif($action == "create"){
    echo get_create();
  }
}else{
  echo get_list();
}
?>
