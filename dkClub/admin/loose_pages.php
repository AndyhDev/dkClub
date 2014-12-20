<?php
include_once('run_admin.php');

function get_blank(){
    $html = "<table border='1' style='width:100%;border-color:gray;border-collapse:collapse;'>
    <tr style='background-color:#2EFE2E;'><td>ID</td><td>Seiten Name</td><td>verknüpfte Seite</td><td></td></tr>";
    database_connect();
    $res = mysql_query("SELECT * FROM loose_pages");
    while ($row = mysql_fetch_array($res)){
        $id = $row['id'];
        $name = $row['name'];
        $display_id = $row['display'];
        $res2 = mysql_query("SELECT name FROM menu WHERE id=$display_id");
        $row2 = mysql_fetch_array($res2);
        $display = $row2['name'];
        $html .= "<tr>
                    <td>$id</td>
                    <td>$name</td>
                    <td>$display</td>
                    <td><a href='admin.php?site=loose_pages&action=delete&id=$id'><img src='admin/delete.png'/></a></td>
                  </tr>";
    }
    $res = mysql_query("SELECT * FROM menu WHERE typ=1 or typ=3 or typ=5");
    $op = "";
    while ($row = mysql_fetch_array($res)){
        $id = $row['id'];
        $name = $row['name'];
        $op .= "<option value='$id'>$name</option>";
    }
    $html .= "<table><p>
                <form method='post' action='admin.php?site=loose_pages&action=new&id=0'>
                  <h3>Neu:</h3>
                  Dateiname: <input type='text' name='name'/><br/>
                  verknüpfte Seite:<select size='1' name='display'>
                    $op
                  </select><br/>
                  <input type='submit' value='speichern'/>
                </form>
              </p>";
    
    return $html;
}
function get_new(){
    if(!isset($_POST['name']) or !isset($_POST['display'])){
      return "Leider sind nicht alle Informationen angekommen!<br/>Vorgang abgebrochen";
    }
    database_connect();
    $name = $_POST['name'];
    $display = $_POST['display'];
    
    $res2 = mysql_query("INSERT INTO loose_pages (name, display) VALUES ('$name', '$display')");
    database_set_event("Verknüpfung '$name' erstellt");

    return "Verknüpfung erstellt";
}
function get_delete($id){
  return "<form method='post' action='admin.php?site=loose_pages&action=true_delete&id=$id'>
    <input type='submit' value='Verknüpfung LÖSCHEN'/>
    </form>";
}
function get_true_delete($id){
    database_connect();
    mysql_query("DELETE FROM loose_pages WHERE id=$id");
    database_set_event("Verküpfung '$id' gelöscht'");
    return "Verknüpfung gelöscht";
}
if(isset($_GET['id']) and isset($_GET['action'])){
  $id = $_GET['id'];
  $action = $_GET['action'];
  if($action == "delete"){
    echo get_delete($id);
  }elseif($action == "true_delete"){
    echo get_true_delete($id);
  }elseif($action == "new"){
    echo get_new($id);
  }
}else{
  echo get_blank();
}
?>
