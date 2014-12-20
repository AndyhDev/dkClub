<?php
include_once('run_admin.php');

function get_blank(){
    $options = array('3' => 'Unterpunk',
                     '5' => 'Interner Unterpunkt');
    $op = "";
    foreach($options as $key => $value){
        if($key == '1'){
            $op .= "<option selected='selected' value='$key'>$value</option>";
        }else{
            $op .= "<option value='$key'>$value</option>";
        }
    }
    $db = database_connect();
    $sql2 = "SELECT id, name FROM menu WHERE typ=2 or typ=4";
    $result2 = mysql_query($sql2);
    $op2 = "";
    while ($row2 = mysql_fetch_array($result2)){
        $name2 = stripslashes($row2['name']);
        $id2 = $row2['id'];
        $op2 .= "<option value='$id2'>$name2</option>";
    }
    database_close($db);   
    $html = "<form method='post' action='admin.php?site=add_umenu&new=1'>
    <table border='1' style='width:800px;border-color:gray;border-collapse:collapse;'>
    <tr style='background-color:#2EFE2E;'><td>Name</td><td>Seite</td><td>Hauptpunkt</td><td>Typ</td></tr>";
    $html .= "<tr>
                <td>
                  <input size='14' type='text' name='name' value='$name'/> 
                </td>
                <td>
                  <input size='10' type='text' name='site' value='$site'/>
                </td>
                <td>
                  <select name='display' size='1'>
                    $op2
                  </select>
                </td>
                <td>
                  <select name='typ' size='1'>
                    $op
                  </select>
                </td>
                <td>
                  <input type='submit' value='Speichern' />
                </td>
              </tr></table></form>";
    return $html;
}
function insert(){
    if(!isset($_POST['name']) or !isset($_POST['site']) or !isset($_POST['typ']) or !isset($_POST['display'])){
      return "Leider sind nicht alle Informationen angekommen!<br/>Vorgang abgebrochen";
    }
    $db = database_connect();
    $name = $_POST['name'];
    $typ = $_POST['typ'];
    $display = mysql_real_escape_string($_POST['display']);
    $site = $_POST['site'];
    
    $res2 = mysql_query("SELECT id FROM menu WHERE display=$display");
    $last = mysql_num_rows($res2);
    $new_pos = $last + 1;
    
    database_add_menu($name, $typ, $display, $site, $new_pos);
    database_set_event("Neuer Untermenüpunkt '$name' erstellt");
    database_close($db);
    
    return "Menüpunkt erstellt";
}
if(isset($_GET['new'])){
  echo insert();
}else{
  echo get_blank();
}
?>
