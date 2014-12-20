<?php
include_once('run_admin.php');

function get_list(){
    $html = "<h1>Volgende Mitglieder haben sich Angemeldet:</h1><br/>
    <table border='1' style='width:100%;border-color:gray;border-collapse:collapse;'>
    <tr style='background-color:#2EFE2E;'><td>ID</td><td>Name</td></tr><tr></tr>";
    
    $types = array("Normal", "Externer Fahreinsatz", "Dampffest");
    
    $db = database_connect();
    
    $sql = "SELECT id, name FROM termin_abf ORDER BY id";
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
                    <td style='width:230px;'>
                      <a href='admin.php?site=termin_abf&action=edit&id=$id'><img src='admin/edit.png'/></a>
                      <a href='admin.php?site=termin_abf&action=delete&id=$id'><img src='admin/delete.png'/></a>
                      <a href='admin.php?site=termin_abf&action=show_user&id=$id'>Abfrage starten</a>
                    </td>
                  </tr>";
    }
    
    $html .= "</table>
        <br/><br/>Die Sql Abfrage lautete:
        <div style='border:2px solid #c3081d;padding:5px;background-color:#feff80;'>
          $sql
        </div>";
    
    $html .= "<h1>Abfrage nach Terminen</h1>
    <table border='1' style='width:100%;border-color:gray;border-collapse:collapse;'>
    <tr style='background-color:#2EFE2E;'><td>ID</td><td>Name</td><td>Datum</td><td>Typ</td></tr><tr></tr>";
    
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
                      <a href='admin.php?site=termin_abf&action=show_day&id=$id'>Abfrage starten</a>
                    </td>
                  </tr>";
    }
    $html .= "</table>
        <br/><br/>Die Sql Abfrage lautete:
        <div style='border:2px solid #c3081d;padding:5px;background-color:#feff80;'>
          $sql
        </div>";
           
    database_close($db);    
    return $html;
}
function get_show_user($id){
    $types = array('0' => 'Dienst', '1' => 'kein Dienst', '2' => 'nachfragen');
    database_connect();
    
    $sql1 = "SELECT * FROM termin_abf WHERE id='$id'";
    
    $result = mysql_query($sql1);
    $row1 = mysql_fetch_array($result);
    
    $u_name = $row1['name'];
    $u_hinweis = $row1['hinweis'];
    
    $html = "Name: <span style='font-weight:bold;'>$u_name</span><br/><br/>
    Hinweis:
    <div style='border:2px solid gray;padding:5px;'>$u_hinweis</div><br/><br/>
    <table border='1' style='border-color:gray;border-collapse:collapse;'>
    <tr style='background-color:#2EFE2E;'>
      <td>Termin</td>
      <td>Wunsch</td>
    </tr>";
    
    $sql2 = "SELECT * FROM termin_abf_config ORDER BY date";
    $result = mysql_query($sql2);
    while ($row = mysql_fetch_array($result)){
        $name = $row['name'];
        $date = $row['date'];
        $link = $row['link'];
        
        $wunsch = $types[$row1[$link]];
        
        $html .= "<tr>
          <td style='padding:5px;'>$name<br/>$date</td>
          <td style='padding:5px;'>$wunsch</td>
        </tr>";
    }
       
    $html .= "</table><br/><br/>Die Sql Abfragen lauteten:
        <div style='border:2px solid #c3081d;padding:5px;background-color:#feff80;'>
          $sql1
        </div>
        <div style='border:2px solid #c3081d;padding:5px;background-color:#feff80;'>
          $sql2
        </div>";
        
    return $html;
}
function get_show_day($id){
    database_connect();
    
    $sql1 = "SELECT link, name FROM termin_abf_config WHERE id='$id'";
    $result = mysql_query($sql1);
    $row = mysql_fetch_array($result);
    $link = $row['link'];
    $d_name = $row['name'];
    
    $sql2 = "SELECT name, hinweis FROM termin_abf WHERE `$link`='0'";
    $sql3 = "SELECT name, hinweis FROM termin_abf WHERE `$link`='2'";
    
    $html = "Termin: <span style='font-weight:bold;'>$d_name</span><br/><br/>
    <table border='1' style='border-color:gray;border-collapse:collapse;'>
    <tr style='background-color:#2EFE2E;'>
      <td>Name</td>
      <td>Wunsch</td>
      <td>Hinweis</td>
    </tr>";
    
    $result = mysql_query($sql2);
    while ($row = mysql_fetch_array($result)){
        $name = $row['name'];
        $hinweis = $row['hinweis'];
        
        $html .= "<tr>
          <td>$name</td>
          <td>Dienst</td>
          <td>$hinweis</td>
        </tr>";
    }
    
    $html .= "<tr style='background-color:#2EFE2E;'>
          <td> </td>
          <td> </td>
          <td> </td>
        </tr>";
        
    $result = mysql_query($sql3);
    while ($row = mysql_fetch_array($result)){
        $name = $row['name'];
        $hinweis = $row['hinweis'];
        
        $html .= "<tr>
          <td>$name</td>
          <td>Nachfragen</td>
          <td>$hinweis</td>
        </tr>";
    }
    $html .= "</table><br/><br/>Die Sql Abfragen lauteten:
        <div style='border:2px solid #c3081d;padding:5px;background-color:#feff80;'>
          $sql1
        </div>
        <div style='border:2px solid #c3081d;padding:5px;background-color:#feff80;'>
          $sql2
        </div>
        <div style='border:2px solid #c3081d;padding:5px;background-color:#feff80;'>
          $sql3
        </div>";
        
    return $html;
    
}
function get_edit($id){
     database_connect();
     
     $sql1 = "SELECT * FROM termin_abf_config ORDER BY date";
     $sql2 = "SELECT * FROM termin_abf WHERE id='$id'";
         
     $result = mysql_query($sql2);
     $row2 = mysql_fetch_array($result);
     
     $name = $row2['name'];
     
     $html = "Datensatz von <span style='font-weight:bold;'>$name</span> bearbeiten<br/><br/>
     <form method='post' action='admin.php?site=termin_abf&id=$id&action=save'>
     <table border='1' style='border-color:gray;border-collapse:collapse;'>
     <tr style='background-color:#2EFE2E;'>
      <td>Datum</td>
      <td>Wunsch</td>
     </tr>";
     
     $result = mysql_query($sql1);
     while ($row = mysql_fetch_array($result)){
        $link = $row['link'];
        $type = $row2[$link];
        $d_name = $row['name'];
        $html .= "<tr>
                    <td>
                      $d_name
                    </td>
                    <td><select name='link_$link' size='1'>";
                    
        $types = array("Dienst", "Kein Dienst", "Nachfragen");
    
        for($i=0; $i < count($types); $i++){
           if($i == $type){
                $html .= "<option selected='selected' value='$i'>" . $types[$i] . "</option>";
            }else{
                $html .= "<option value='$i'>" . $types[$i] . "</option>";
            }
        }              
        $html .= "</select></td>
                  </tr>";
     }
    
    $html .= "</table>
    <input type='submit' value='speichern'/>
    </form><br/><br/>Die Sql Abfragen lauteten:
        <div style='border:2px solid #c3081d;padding:5px;background-color:#feff80;'>
          $sql1
        </div>
        <div style='border:2px solid #c3081d;padding:5px;background-color:#feff80;'>
          $sql2
        </div>";
    return $html;
}
function get_save($id){
    database_connect();
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
    
    $sql2 = "UPDATE termin_abf
             SET";
    
    foreach($links as $key => $value){
        $sql2 .= " `$key`='$value',";
    }
    $sql2 = rtrim($sql2, ",");
    
    $sql2 .= " WHERE id='$id'"; 
    mysql_query($sql2);
    
    return "Datensatz wurde Aktualisiert<br/><br/>Die Sql Abfrage lautete:
        <div style='border:2px solid #c3081d;padding:5px;background-color:#feff80;'>
          $sql2
        </div>";
}
function get_delete($id){
  return "<form method='post' action='admin.php?site=termin_abf&action=true_delete&id=$id'>
    <input type='submit' value='Datensatz LÖSCHEN'/>
    </form>";
}
function get_true_delete($id){
    database_connect();
    mysql_query("DELETE FROM termin_abf WHERE id=$id");
    database_set_event("Datensatz '$id' gelöscht'");
    return "Datensatz gelöscht<br/><br/>Die Sql Abfrage lautete:
        <div style='border:2px solid #c3081d;padding:5px;background-color:#feff80;'>
          DELETE FROM termin_abf WHERE id=$id
        </div>";
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
  }elseif($action == "show_user"){
    echo get_show_user($id);
  }elseif($action == "show_day"){
    echo get_show_day($id);
  }
}else{
  echo get_list();
}
?>
