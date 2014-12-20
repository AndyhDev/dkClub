<?php
include_once('run_admin.php');

function get_blank(){
    $options = array('1' => 'Hauptpunkt',
                     '2' => 'Hauptpunkt mit Untermenü',
                     '4' => 'Interner Hautpunkt');
    $op = "";
    foreach($options as $key => $value){
        if($key == '1'){
            $op .= "<option selected='selected' value='$key'>$value</option>";
        }else{
            $op .= "<option value='$key'>$value</option>";
        }
    }  
   
    $html = "<form method='post' action='admin.php?site=add_hmenu&new=1'>
    <table border='1' style='width:100%;border-color:gray;border-collapse:collapse;'>
    <tr style='background-color:#2EFE2E;'><td>Name</td><td>Seite</td><td>Typ</td></tr>";
    $html .= "<tr>
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
              </tr></table></form>";
    return $html;
}
function insert(){
    if(!isset($_POST['name']) or !isset($_POST['site']) or !isset($_POST['typ'])){
      return "Leider sind nicht alle Informationen angekommen!<br/>Vorgang abgebrochen";
    }
    $db = database_connect();
    $name = $_POST['name'];
    $typ = $_POST['typ'];
    $display = 0;
    $site = $_POST['site'];
    
    $res2 = mysql_query("SELECT id FROM menu WHERE typ=1 or typ=2 or typ=4");
    $last = mysql_num_rows($res2);
    $new_pos = $last + 1;
    
    database_add_menu($name, $typ, $display, $site, $new_pos);
    database_set_event("Neuer Hauptmenüpunkt '$name' erstellt");
    database_close($db);
    
    return "Menüpunkt erstellt";
}
if(isset($_GET['new'])){
  echo insert();
}else{
  echo get_blank();
}
?>
