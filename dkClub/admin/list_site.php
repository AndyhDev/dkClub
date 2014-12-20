<?php
include_once('run_admin.php');

function get_list(){
    $html = "<table border='1' style='margin-left:50px;width:680px;border-color:gray;border-collapse:collapse;'>
             <tr style='background-color:#2EFE2E;'><td>Name</td><td>Größe</td><td>zuletzt geändert</td></tr>";
    
    $sites = scandir('content');
    foreach($sites as $site){
        if($site != '.' and $site != '..'){
            $size =  filesize('content/' . $site);
            $mdate = date('d M Y H:i:s', filemtime('content/' . $site));
            $html .= "<tr><td>$site</td>
                      <td>$size Byte</td>
                      <td>$mdate</td>
                      <td>
                      <a href='admin.php?site=list_site&action=edit&id=content/$site'><img src='admin/edit.png'/></a>
                      <a href='admin.php?site=list_site&action=html_edit&id=content/$site'><img src='admin/html.png'/></a>
                      <a href='admin.php?site=list_site&action=delete&id=content/$site'><img src='admin/delete.png'/></a></td></tr>";
        }
    }
    $sites = scandir('intern');
    foreach($sites as $site){
        if($site != '.' and $site != '..' and $site != 'img' and $site != 'pdf' and $site != '.htacces'){
            $size =  filesize('intern/' . $site);
            $mdate = date('d M Y H:i:s', filemtime('intern/' . $site));
            $html .= "<tr><td>$site</td>
                      <td>$size Byte</td>
                      <td>$mdate</td>
                      <td>
                      <a href='admin.php?site=list_site&action=edit&id=intern/$site'><img src='admin/edit.png'/></a>
                      <a href='admin.php?site=list_site&action=html_edit&id=intern/$site'><img src='admin/html.png'/></a>
                      <a href='admin.php?site=list_site&action=delete&id=intern/$site'><img src='admin/delete.png'/></a></td></tr>";
        }
    }
    $html .= '</table>';
    return $html;
}
function get_delete($id){
  return "<form method='post' action='admin.php?site=list_site&action=true_delete&id=$id'>
    <input type='submit' value='Seite LÖSCHEN'/>
    </form>";
}
function get_true_delete($id){
    $db = database_connect();
    unlink($id);
    database_set_event("Seite '$id' gelöscht'");
    database_close($db);
    return "Seite gelöscht";
}
function get_edit($id){
    $value = file_get_contents($id);
    $content = stripslashes($value);
    $content = htmlspecialchars($content);
    $html = "
    <script type='text/javascript' src='ckeditor/ckeditor.js'></script>
    <form method='post' action='admin.php?site=list_site&action=prev_site&id=$id'>
    <textarea cols='100' id='editor1' name='value' rows='100'>
    $content
    </textarea>
    <script type='text/javascript'>
      var editor = CKEDITOR.replace('editor1',{
          contentsCss : ['styles/default.css', 'styles/html.css'],
          height : '600px',
          width : '830px',
          enterMode : CKEDITOR.ENTER_BR
	      });
    </script>
    </form>";
    return $html;
}
function get_html_edit($id){
    $value = file_get_contents($id);
    $content = stripslashes($value);
    $content = htmlspecialchars($content);
    $html = '<script src="admin/codemirror/lib/codemirror.js"></script>
             <link rel="stylesheet" href="admin/codemirror//lib/codemirror.css">
             <script src="admin/codemirror/mode/xml/xml.js"></script>
             <script src="admin/codemirror/mode/javascript/javascript.js"></script>
             <script src="admin/codemirror/mode/css/css.js"></script>
             <script src="admin/codemirror/mode/htmlmixed/htmlmixed.js"></script>
             <script type="text/javascript">
               $(document).ready(function(){
                 el = document.getElementById("editor");
                 var myCodeMirror = CodeMirror.fromTextArea(el);
                 $("#save").click(function(){
                   css = myCodeMirror.getValue();
                   $("#css").val(css);
                   $("#save_form").submit();
                 });
               });
             </script>';
    $html .= "<textarea id='editor' style='width:800px;height:600px;'>$content</textarea>
              <form id='save_form' method='post' action='admin.php?site=list_site&action=prev_site&id=$id'>
                <input type='hidden' id='css' name='value' value=''/>
              </form>
              <p><button id='save'>Speichern</button></p>";
    return $html;
}
function save_site($id){
    $content = $_SESSION['site_preview'];
    include_once('lib/Diff.php');
    include_once('lib/Diff/Renderer/Html/SideBySide.php');
    
    $old_content = file_get_contents($id);
    
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
                 VALUES ('$id', '$old_content', '$html')");
                 
    $i_id = mysql_insert_id();
                
    file_put_contents($id, $content);
    
    database_set_event("Seite '$id' bearbeitet.<br/><a href='admin.php?site=diff_site&action=show&id=$i_id'>Änderungen ansehen</a>");
    database_close($db);
    return "Seite gespeichert";
    
}
function prev_site($id){
    $content = stripslashes($_POST['value']);
    $_SESSION['site_preview'] = $content;
    $html = "<h3>Dies ein die Vorschau ihrer Seite</h3><br/>
            <a href='admin.php?site=list_site&action=save_site&id=$id'>Speichern</a><hr/>$content";
    return $html;
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
  }elseif($action == "html_edit"){
    echo get_html_edit($id);
  }elseif($action == "save_site"){
    echo save_site($id);
  }elseif($action == "prev_site"){
    echo prev_site($id);
  }
}else{
  echo get_list();
}
?>
