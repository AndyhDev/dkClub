<?php
include_once('run_admin.php');

function get_raw_menu(){
    $html = "<table border='1' style='width:800px;border-color:gray;border-collapse:collapse;'>
    <tr style='background-color:#2EFE2E;'><td>ID</td><td>Name</td><td>Seite</td><td>Typ</td></tr>";
    $db = database_connect();
    $result = mysql_query("SELECT * FROM menu WHERE typ=1 OR typ=2 or typ=4 ORDER BY pos");
    while ($row = mysql_fetch_array($result)) {
        $name = stripslashes($row['name']);
        $site = $row['site'];
        $id = $row['id'];
        if($row['typ' ] == '1'){
            $type = "Hauptpunkt";
        }elseif($row['typ' ] == '2'){
            $type = "Hauptpunkt mit Untermenü";
        }elseif($row['typ' ] == '4'){
            $type = "Interner Hautpunkt";
        }
        $html .= "<tr>
                    <td>
                      $id
                    </td>
                    <td>
                      $name
                    </td>
                    <td>
                      $site
                    </td>
                    <td>
                      $type
                    </td>
                    <td>
                      <a href='admin.php?site=admin_menu&action=up&id=$id'><img src='admin/up.png'/></a>
                      <a href='admin.php?site=admin_menu&action=down&id=$id'><img src='admin/down.png'/></a>
                      <a href='admin.php?site=admin_menu&action=delete&id=$id'><img src='admin/delete.png'/></a>
                    </td>
                    <td>
                      <a href='admin.php?site=admin_menu&id=$id&action=edit'>Bearbeiten</a>
                    </td>
                  </tr>";
        if($row['typ' ] == '2'){
            $html .= "<tr><td colspan='6'>
            <table border='1' style='margin-left:50px;width:740px;border-color:gray;border-collapse:collapse;'>
            <tr style='background-color:#2EFE2E;'><td>ID</td><td>Name</td><td>Seite</td><td>Typ</td></tr>";
            $res = mysql_query("SELECT * FROM menu WHERE typ=3 AND display=$id ORDER BY pos"); 
            while ($row2 = mysql_fetch_array($res)){
                $name = $row2['name'];
                $site = $row2['site'];
                $id = $row2['id'];
                $html .= "<tr>
                    <td>
                      $id
                    </td>
                    <td>
                      $name
                    </td>
                    <td>
                      $site
                    </td>
                    <td>
                      Unterpunkt
                    </td>
                    <td>
                      <a href='admin.php?site=admin_menu&action=up&id=$id'><img src='admin/up.png'/></a>
                      <a href='admin.php?site=admin_menu&action=down&id=$id'><img src='admin/down.png'/></a>
                      <a href='admin.php?site=admin_menu&action=delete&id=$id'><img src='admin/delete.png'/></a>
                    </td>
                    <td>
                      <a href='admin.php?site=admin_menu&id=$id&action=edit'>Bearbeiten</a>
                    </td>
                  </tr>";
            }
            $html .= "</table></td></tr>";
        }
        if($row['typ' ] == '4'){
            $html .= "<tr><td colspan='6'>
            <table border='1' style='margin-left:50px;width:740px;border-color:gray;border-collapse:collapse;'>
            <tr style='background-color:#2EFE2E;'><td>ID</td><td>Name</td><td>Seite</td><td>Typ</td></tr>";
            $res = mysql_query("SELECT * FROM menu WHERE typ=5 AND display=$id ORDER BY pos"); 
            while ($row2 = mysql_fetch_array($res)){
                $name = $row2['name'];
                $site = $row2['site'];
                $id = $row2['id'];
                $html .= "<tr>
                    <td>
                      $id
                    </td>
                    <td>
                      $name
                    </td>
                    <td>
                      $site
                    </td>
                    <td>
                      Interner Unterpunkt
                    </td>
                    <td>
                      <a href='admin.php?site=admin_menu&action=up&id=$id'><img src='admin/up.png'/></a>
                      <a href='admin.php?site=admin_menu&action=down&id=$id'><img src='admin/down.png'/></a>
                      <a href='admin.php?site=admin_menu&action=delete&id=$id'><img src='admin/delete.png'/></a>
                    </td>
                    <td>
                      <a href='admin.php?site=admin_menu&id=$id&action=edit'>Bearbeiten</a>
                    </td>
                  </tr>";
            }
            $html .= "</table></td></tr>";
        }
    }
    database_close($db);
    $html .= "</table>";
    return $html;
}
function get_edit($id){
    $db = database_connect();
    
    $id = mysql_real_escape_string($id);
    
    $sql = "SELECT * FROM menu WHERE id=$id";
    $sql2 = "SELECT id, name FROM menu WHERE typ=2 or typ=4";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $name = stripslashes($row['name']);
    $id = $row['id'];
    $site = $row['site'];
    $typ = $row['typ'];
           
    if($typ == '1' or $typ == '2' or $typ == '4'){
        $options = array('1' => 'Hauptpunkt',
                         '2' => 'Hauptpunkt mit Untermenü',
                         '4' => 'Interner Hautpunkt');
        $op = "";
        foreach($options as $key => $value){
            if($key == $typ){
                $op .= "<option selected='selected' value='$key'>$value</option>";
            }else{
                $op .= "<option value='$key'>$value</option>";
            }
        }  
       
        $html = "<form method='post' action='admin.php?site=admin_menu&id=$id&action=update'>
        <table border='1' style='width:100%;border-color:gray;border-collapse:collapse;'>
        <tr style='background-color:#2EFE2E;'><td>ID</td><td>Name</td><td>Seite</td><td>Typ</td></tr>";
        $html .= "<tr>
                    <td>
                      $id
                    </td>
                    <td>
                      <input type='text' name='name' value='$name'/> 
                    </td>
                    <td>
                      <input type='text' name='site' value='$site'/>
                    </td>
                    <td>
                      <select name='typ' size='1'>
                        $op
                      </select>
                    </td>
                    <td>
                      <input type='submit' value='Speichern' />
                    </td>
                  </tr>";
    }elseif($typ == '3' or $typ == '5'){
        $html = "<form method='post' action='admin.php?site=admin_menu&id=$id&action=update'>
        <table border='1' style='width:100%;border-color:gray;border-collapse:collapse;'>
        <tr style='background-color:#2EFE2E;'><td>ID</td><td>Name</td><td>Seite</td><td>Hauptpunkt</td><td>Typ</td></tr>";
        $options3 = array('3' => 'Unterpunkt',
                          '5' => 'Interner Unterpunkt');
        $op3 = "";
        foreach($options3 as $key => $value){
            if($key == $typ){
                $op3 .= "<option selected='selected' value='$key'>$value</option>";
            }else{
                $op3 .= "<option value='$key'>$value</option>";
            }
        }
    
        $result2 = mysql_query($sql2);
        $op2 = "";
        while ($row2 = mysql_fetch_array($result2)){
            $name2 = stripslashes($row2['name']);
            $id2 = $row2['id'];
            if($row['display'] == $id2){
                $op2 .= "<option selected='selected' value='$id2'>$name2</option>";
            }else{
                $op2 .= "<option value='$id2'>$name2</option>";
            }
        }
        $html .= "<tr>
                    <td>
                      $id
                    </td>
                    <td>
                      <input size='14' type='text' name='name' value='$name'/> 
                    </td>
                    <td>
                      <input size='9' type='text' name='site' value='$site'/>
                    </td>
                    <td>
                      <select name='display' size='1'>
                        $op2
                      </select>
                    </td>
                    <td>
                      <select name='typ' size='1'>
                        $op3
                      </select>
                    </td>
                    <td>
                      <input type='submit' value='Speichern' />
                    </td>
                  </tr>";
    }
    database_close($db);
    $html .= "</table></form>";
    return $html;
}
function get_update($id){
    if(!isset($_POST['name']) or !isset($_POST['site']) or !isset($_POST['typ'])){
      return "Leider sind nicht alle Informationen angekommen!<br/>Vorgang abgebrochen";
    }
    if($_POST['typ'] == '3' or $_POST['typ'] == '5'){
      if(!isset($_POST['display'])){
        return "Leider sind nicht alle Informationen angekommen!<br/>Vorgang abgebrochen";
      }
      $display = $_POST['display'];
    }else{
      $display = '0';
    }
    $db = database_connect();
    $id = mysql_real_escape_string($id);
    $name = mysql_real_escape_string($_POST['name']);
    $display = mysql_real_escape_string($display);
    $site = mysql_real_escape_string($_POST['site']);
    $typ = mysql_real_escape_string($_POST['typ']);
    
    $sql = "UPDATE menu
            SET name='$name', site='$site', typ=$typ, display=$display
            WHERE id=$id";
    
    $res = mysql_query("SELECT * FROM menu WHERE id=$id"); 
    $row = mysql_fetch_array($res);
    $name2 = $row['name'];
    $site2 = $row['site'];
    $typ2 = get_menu_typ_name($row['typ']);
    $typn = get_menu_typ_name($typ); 
    $display2 = $row['display'];
    if($display == '0'){
        $displayn = '';
    }else{
        $res = mysql_query("SELECT name FROM menu WHERE id=$display");
        $row = mysql_fetch_array($res);
        $displayn = $row['name'];
    }
    if($display2 == '0'){
        $display2n = '';
    }else{
        $res = mysql_query("SELECT name FROM menu WHERE id=$display2");
        $row = mysql_fetch_array($res);
        $display2n = $row['name'];
    }
    $old = database_get($name);
    database_set_event("Der Menüpunkt '$id' wurde geändert.<br/>
                        <table border='1' style='margin-left:50px;width:680px;border-color:gray;border-collapse:collapse;'>
                          <tr style='background-color:#2EFE2E;'><td>Status</td><td>Name</td><td>Seite</td><td>Typ</td><td>Hauptpunkt</td></tr>
                          <tr>
                            <td>ALT</td><td>$name2</td><td>$site2</td><td>$typ2</td><td>$display2n</td>
                          </tr>
                          <tr>
                            <td>NEU</td><td>$name</td><td>$site</td><td>$typn</td><td>$displayn</td>
                          </tr>
                        </table>");
                          
    mysql_query($sql);
    database_close($db);
    return "Datensatz erfolgreich geändert";
}
function get_up($id){
    $db = database_connect();
    $id = mysql_real_escape_string($id);
    $result = mysql_query("SELECT name, pos, typ, display FROM menu WHERE id=$id");
    $row = mysql_fetch_array($result);
    $pos = $row['pos'];
    $name = $row['name'];
    $typ = $row['typ'];
    $display = $row['display'];
    
    if($pos <= 1){
        return "Menüpunkt ist schon ganz oben";
    }
    
    $new_pos = $pos - 1;
    if($typ == 1 or $typ == 2 or $typ == 4){
        $res = mysql_query("SELECT id FROM menu WHERE pos=$new_pos and (typ=1 or typ=2 or typ=4)");
    }else{
        $res = mysql_query("SELECT id FROM menu WHERE pos=$new_pos and display=$display");
    }
    $row2 = mysql_fetch_array($res);
    $id2 = $row2['id'];
    mysql_query("UPDATE menu
             SET pos=$pos
             WHERE id=$id2");

    mysql_query("UPDATE menu
                 SET pos=$new_pos
                 WHERE id=$id");
                 
    database_set_event("Menüpunkt '$name' von Platz '$pos' auf '$new_pos' verschoben");            
    database_close($db);
    return "Menüpunkt verschoben";
}
function get_down($id){
    $db = database_connect();
    $id = mysql_real_escape_string($id);
    $result = mysql_query("SELECT name, pos, typ, display FROM menu WHERE id=$id");
    $row = mysql_fetch_array($result);
    $pos = $row['pos'];
    $name = $row['name'];
    $typ = $row['typ'];
    $display = $row['display'];
    
    $new_pos = $pos + 1;
    if($typ == 1 or $typ == 2 or $typ == 4){
        $res = mysql_query("SELECT id FROM menu WHERE pos=$new_pos and (typ=1 or typ=2 or typ=4)");
        $res2 = mysql_query("SELECT id FROM menu WHERE typ=1 or typ=2 or typ=4");
    }else{
        $res = mysql_query("SELECT id FROM menu WHERE pos=$new_pos and display=$display");
        $res2 = mysql_query("SELECT id FROM menu WHERE display=$display");
    }
    
    $max = mysql_num_rows($res2);
    if($pos >= $max){
        return "Menüpunkt ist schon ganz unten";
    }

    $row2 = mysql_fetch_array($res);
    $id2 = $row2['id'];
    var_dump($id2);
    echo "<br>";
    var_dump($pos);
    mysql_query("UPDATE menu
             SET pos=$pos
             WHERE id=$id2");
                 
        
    
    mysql_query("UPDATE menu
                 SET pos=$new_pos
                 WHERE id=$id");
                 
    database_set_event("Menüpunkt '$name' von Platz '$pos' auf '$new_pos' verschoben");            
    database_close($db);
    return "Menüpunkt verschoben";
}
function get_delete($id){
    return "<form method='post' action='admin.php?site=admin_menu&action=true_delete&id=$id'>
    <input type='submit' value='Menüpunkt LÖSCHEN'/>
    </form>";
}

function get_true_delete($id){
    $db = database_connect();
    $id = mysql_real_escape_string($id);
    
    $result = mysql_query("SELECT name, pos, typ, display FROM menu WHERE id=$id");
    $row = mysql_fetch_array($result);
    $pos = $row['pos'];
    $name = $row['name'];
    $typ = $row['typ'];
    $display = $row['display'];
    
    if($typ == 1 or $typ == 2 or $typ == 4){
        mysql_query("UPDATE menu SET pos=pos-1 WHERE (typ=1 or typ=2 or typ=4) and pos>$pos");
    }elseif($typ == 3 or $typ == 5){
        mysql_query("UPDATE menu SET pos=pos-1 WHERE (typ=3 or typ=5) and pos>$pos and display=$display");
    }
    if($typ == 1 or $typ == 3 or $typ == 5){
        mysql_query("DELETE FROM menu WHERE id=$id");
    }elseif($typ == 2 or $typ == 4){
        mysql_query("DELETE FROM menu WHERE id=$id");
        mysql_query("DELETE FROM menu WHERE display=$id");
    }
    database_set_event("Menüpunkt '$name' gelöscht");
    database_close($db);
    return "Menüpunkt gelöscht";
}

if(isset($_GET['id']) and isset($_GET['action'])){
  $id = $_GET['id'];
  $action = $_GET['action'];
  if($action == "edit"){
    echo get_edit($id);
  }elseif($action == "update"){
    echo get_update($id);
  }elseif($action == "up"){
    echo get_up($id);
  }elseif($action == "down"){
    echo get_down($id);
  }elseif($action == "delete"){
    echo get_delete($id);
  }elseif($action == "true_delete"){
    echo get_true_delete($id);
  }
}else{
  echo get_raw_menu();
}
?>
