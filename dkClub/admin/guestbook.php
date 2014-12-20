<?php
include_once('run_admin.php');

function get_list(){
    $site = 0;
    $site2 = 0;
    if(isset($_GET['page'])){
        if(!empty($_GET['page'])){
            if(check_int($_GET['page'])){
                $site = $_GET['page'] * 10;
                $site2 = $_GET['page'];
            }
        }
    }

    $db = database_connect();
    
    $sql = "SELECT * FROM guestbook ORDER BY stamp DESC LIMIT $site,10";
    $result = mysql_query($sql);
    
    $html = "<table border='1' style='width:100%;border-color:gray;border-collapse:collapse;'>
             <tr style='background-color:#2EFE2E;'><td>ID</td><td>Name</td><td>E-Mail</td><td>Datum</td><td>Nachricht</td><td>Sichtbar</td><td></td></tr>";
    while($row = mysql_fetch_assoc($result)){
        $id = $row['ID'];
        $name = $row['name'];
        $e_mail = $row['e_mail'];
        $date = $row['stamp'];
        $na = $row['nachricht'];
        $ok = $row['ok'];
        $html .= "<tr>
                    <td>$id</td>
                    <td>$name</td>
                    <td>$e_mail</td>
                    <td>$date</td>
                    <td>$na</td>
                    <td>$ok</td>
                    <td><a href='admin.php?site=guestbook&action=edit&id=$id'><img src='admin/edit.png'/></a>
                    <a href='admin.php?site=guestbook&action=delete&id=$id'><img src='admin/delete.png'/></a></td>
                  </tr>";
    }
    $html .= "</table>";
    $result = mysql_query("SELECT count(*) FROM guestbook");
    $anz = mysql_result($result, 0);
    
    $pages = ceil($anz/10);
    $html = $html . '<br/>Seiten:<table><tr>';
    for($i=1;$i <= $pages;$i++) {  
        $page = $i - 1;
        if($page == $site2){
            $html = $html . "<td><a style='background-color:gray;' class='page_link' href='admin.php?site=guestbook&amp;page=$page'>$i</a></td>";
        }else{
            $html = $html . "<td><a class='page_link' href='admin.php?site=guestbook&amp;page=$page'>$i</a></td>";
        }
    }
    $html = $html . '</tr></table>';
        
    return $html;
}
function get_edit($id){
    database_connect();
    
    $res = mysql_query("SELECT * FROM guestbook WHERE ID=$id");
    $row = mysql_fetch_array($res);
    $name = $row['name'];
    $e_mail = $row['e_mail'];
    $date = $row['stamp'];
    $na = $row['nachricht'];
    $ok = $row['ok'];
    $html = "<form method='post' action='admin.php?site=guestbook&action=save&id=$id'>
             <table border='1' style='width:100%;border-color:gray;border-collapse:collapse;'>
               <tr style='background-color:#2EFE2E;'><td>ID</td><td>Name</td><td>E-Mail</td><td>Datum</td><td>Nachricht</td><td>Sichtbar</td></tr>
               <tr>
                 <td>$id</td>
                 <td><input type='text' size='12' name='name' value='$name'/></td>
                 <td><input type='text' size='12' name='e_mail' value='$e_mail'/></td>
                 <td>$date</td>
                 <td><textarea name='na'>$na</textarea></td>
                 <td><input type='text' size='1' name='ok' value='$ok'/></td>
               </tr>
             </table>
             <input type='submit' value='Speichern'/>
             </form>";
    return $html;
}
function get_save($id){
    database_connect();
    $name = $_POST['name'];
    $e_mail = $_POST['e_mail'];
    $na = $_POST['na'];
    $ok = $_POST['ok'];
    mysql_query("UPDATE guestbook
                 SET name='$name', e_mail='$e_mail', nachricht='$na', ok='$ok'
                 WHERE ID='$id'");
    
    database_set_event("Gästebucheintrag '$id' bearbeitet");
    return "Gästebucheintrag gespeichert";
}
function get_delete($id){
  return "<form method='post' action='admin.php?site=guestbook&action=true_delete&id=$id'>
    <input type='submit' value='Gästebucheintrag LÖSCHEN'/>
    </form>";
}
function get_true_delete($id){
    database_connect();
    mysql_query("DELETE FROM guestbook WHERE ID=$id");
    database_set_event("Gästebucheintrag '$id' gelöscht'");
    return "Gästebucheintrag gelöscht";
}

if(isset($_GET['id']) and isset($_GET['action'])){
  $id = $_GET['id'];
  $action = $_GET['action'];
  if($action == "edit"){
    echo get_edit($id);
  }elseif($action == "save"){
    echo get_save($id);
  }elseif($action == "delete"){
    echo get_delete($id);
  }elseif($action == "true_delete"){
    echo get_true_delete($id);
  }
}else{
  echo get_list();
}
?>
