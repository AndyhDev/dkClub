<?php
include_once('run_admin.php');

function get_show($id){
    $html = "<link rel='stylesheet' href='admin/diff.css' type='text/css' charset='utf-8'/>";
    
    database_connect();
    $res = mysql_query("SELECT site, date, diff FROM backup WHERE id='$id'");
    $row = mysql_fetch_array($res);
    
    $site = $row['site'];
    $date = $row['date'];
    $diff = stripslashes($row['diff']);
    
    $html .= "Seite: $site<br/>Datum: $date<br/>Änderungen:<br/>$diff";
    
    $html .= "<p>
                <a href='admin.php?site=diff_site&action=prev&id=$id'>Vorschau</a><br/>
                <a href='admin.php?site=diff_site&action=restore&id=$id'>Auf diese Version zurücksetzten</a><br/>
              </p>";
    return $html;  
}
function get_restore($id){
    database_connect();
    $res = mysql_query("SELECT old, site FROM backup WHERE id='$id'");
    $row = mysql_fetch_array($res);
    $content = $row['old'];
    $site = $row['site'];

    include_once('lib/Diff.php');
    include_once('lib/Diff/Renderer/Html/SideBySide.php');
    
    $old_content = file_get_contents($site);
    
    $old = explode("\n", $old_content);
    $new = explode("\n", $content);
    
    $options = array(
        //'ignoreWhitespace' => true,
        //'ignoreCase' => true,
    );
    $diff = new Diff($old, $new, $options);
    
    $renderer = new Diff_Renderer_Html_SideBySide;
    $html = $diff->Render($renderer);
    $db = database_connect();
    $html = html_entity_decode($html);
    $html = str_replace("\xA0", ' ', $html);
    
    mysql_query("INSERT INTO backup (site, old, diff)
                 VALUES ('$site', '$old_content', '$html')");
                 
    $i_id = mysql_insert_id();
                
    file_put_contents($site, $content);
    
    database_set_event("Seite '$site' wurde zurückgesetzt.<br/><a href='admin.php?site=diff_site&action=show&id=$i_id'>Änderungen ansehen</a>");
    return "Seite zurückgesetzt";
}

function get_prev($id){
    database_connect();
    $res = mysql_query("SELECT old FROM backup WHERE id='$id'");
    $row = mysql_fetch_array($res);
    
    $content = $row['old'];
    $html = "<div style='background-color:red;color:#FFF;font-size:25px;'>Dies ist eine Vorschau</div>";
    $html .= $content;
    return $html;
}
function get_list(){
    database_connect();
    $html = "<table border='1' style='margin-left:50px;width:680px;border-color:gray;border-collapse:collapse;'>
             <tr style='background-color:#2EFE2E;'><td>id</td><td>Seite</td><td>Datum</td><td></td></tr>";
    
    $res = mysql_query('SELECT id, site, date FROM backup');
    while ($row = mysql_fetch_array($res)){
        $id = $row['id'];
        $site = $row['site'];
        $date = $row['date'];
        $html .= "<tr>
                    <td>$id</td>
                    <td>$site</td>
                    <td>$date</td>
                    <td><a href='admin.php?site=diff_site&action=show&id=$id'>Änderungen ansehen</a><br/>
                        <a href='admin.php?site=diff_site&action=prev&id=$id'>Vorschau</a></td>
                  </tr>";
    }
    $html .= "</table>";
    return $html;
}
if(isset($_GET['id']) and isset($_GET['action'])){
  $id = $_GET['id'];
  $action = $_GET['action'];
  if($action == "show"){
    echo get_show($id);
  }elseif($action == "restore"){
    echo get_restore($id);
  }elseif($action == "prev"){
    echo get_prev($id);
  }
}else{
  echo get_list();
}
?>
