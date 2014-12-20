<?php
include_once('run_admin.php');

function get_list(){
    $html = "<table border='1' style='width:100%;border-color:gray;border-collapse:collapse;'>
    <tr style='background-color:#2EFE2E;'><td>ID</td><td>Name</td><td>Wert</td><td>Info</td></tr>";
    $db = database_connect();

    $sql = "SELECT * FROM settings";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result)) {
        $name = stripslashes($row['name']);
        $id = $row['id'];
        $value = stripslashes($row['value']);
        $info = stripslashes($row['info']);
        $html .= "<tr>
                    <td>
                      $id
                    </td>
                    <td>
                      $name
                    </td>
                    <td>
                      $value
                    </td>
                    <td>
                      $info
                    </td>
                    <td style='width:150px;'>
                      <a href='admin.php?site=settings&id=$id&action=edit'>-Bearbeiten</a><br/>
                      <a href='admin.php?site=settings&id=$id&action=html_edit'>-HTML Bearbeiten</a>
                    </td>
                  </tr>";
    }
    database_close($db);
    $html .= "</table>";
    return $html;
}
function get_edit($id){
    $html = "<form method='post' action='admin.php?site=settings&id=$id&action=update'>
    <table border='1' style='width:100%;border-color:gray;border-collapse:collapse;'>
    <tr style='background-color:#2EFE2E;'><td>ID</td><td>Name</td><td>Wert</td><td>Info</td></tr>";
    $db = database_connect();
    
    $id = mysql_real_escape_string($id);
    
    $sql = "SELECT * FROM settings WHERE id=$id";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $name = stripslashes($row['name']);
    $id = $row['id'];
    $value = stripslashes($row['value']);
    $info = stripslashes($row['info']);
    $html .= "<tr>
                <td>
                  $id
                </td>
                <td>
                  $name
                  <input type='hidden' name='name' value='$name'/> 
                </td>
                <td>
                  <input type='text' name='value' value='$value'/>
                </td>
                <td>
                  <input type='text' name='info' value='$info'/>
                </td>
                <td>
                  <input type='submit' value='Speichern' />
                </td>
              </tr>";
    database_close($db);
    $html .= "</table></form>";
    return $html;
}
function get_html_edit($id){
    $db = database_connect();
    
    $id = mysql_real_escape_string($id);
    
    $sql = "SELECT * FROM settings WHERE id=$id";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $name = stripslashes($row['name']);
    $id = $row['id'];
    $value = stripslashes($row['value']);
    $info = stripslashes($row['info']);
    $html = "<form method='post' action='admin.php?site=settings&id=$id&action=update'>
    <script type='text/javascript' src='ckeditor/ckeditor.js'></script>
    <table border='1' style='width:100%;border-color:gray;border-collapse:collapse;'>
      <tr>
        <td>
          Name:
        </td>
        <td>
          $name
          <input type='hidden' name='name' value='$name'/> 
        </td>
      </tr>
      <tr>
        <td>
          Value:
        </td>
        <td>
          <textarea cols='100' id='editor1' name='value' rows='100'>
            $value
          </textarea>
          <script type='text/javascript'>
            var editor = CKEDITOR.replace('editor1',{
		        contentsCss : ['styles/default.css', 'styles/html.css'],
		        height : '300px',
		        width : '100%',
		        enterMode : CKEDITOR.ENTER_BR
			    });
		  </script>
        </td>
      </tr>
      <tr>
        <td>
          Info:
        </td>
        <td>
          <input type='text' name='info' value='$info'/>
        </td>
      </tr>
    </table>  
    <input type='submit' value='Speichern'/>      
    </form>
    ";
    
    database_close($db);
    return $html;
}
function get_update($id){
    if(!isset($_POST['value']) or !isset($_POST['info']) or !isset($_POST['name'])){
      return "Leider sind nicht alle Informationen angekommen!<br/>Vorgang abgebrochen";
    }
    $db = database_connect();
    $id = mysql_real_escape_string($id);
    $value = mysql_real_escape_string($_POST['value']);
    $info = mysql_real_escape_string($_POST['info']);
    $name = mysql_real_escape_string($_POST['name']);
    
    $sql = "UPDATE settings
            SET value='$value', info='$info'
            WHERE id=$id";
            
    $old = database_get($name);
    database_set_event("Die Einstellung '$name' wurde von '$old' auf '$value' geändert.");
    mysql_query($sql);
    database_close($db);
    return "Datensatz erfolgreich geändert";

}
if(isset($_GET['id']) and isset($_GET['action'])){
  $id = $_GET['id'];
  $action = $_GET['action'];
  if($action == "edit"){
    echo get_edit($id);
  }elseif($action == "html_edit"){
    echo get_html_edit($id);
  }elseif($action == "update"){
    echo get_update($id);
  }
}else{
  echo get_list();
}
?>
