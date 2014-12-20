<?php
include_once('run_admin.php');

function get_list(){
    $html = "<table border='1' style='margin-left:50px;width:680px;border-color:gray;border-collapse:collapse;'>
             <tr style='background-color:#2EFE2E;'><td>Name</td><td>Größe</td><td>zuletzt geändert</td></tr>";
    
    $sites = scandir('styles');
    foreach($sites as $site){
        if($site != '.' and $site != '..'){
            $size =  filesize('styles/' . $site);
            $mdate = date('d M Y H:i:s', filemtime('styles/' . $site));
            $html .= "<tr><td>$site</td>
                      <td>$size Byte</td>
                      <td>$mdate</td>
                      <td>
                      <a href='admin.php?site=css&action=edit&id=styles/$site'><img src='admin/edit.png'/></a></td></tr>";
        }
    }
    $html .= '</table>';
    return $html;
}

function get_edit($id){
    $html = '<script src="admin/codemirror/lib/codemirror.js"></script>
             <link rel="stylesheet" href="admin/codemirror//lib/codemirror.css">
             <script src="admin/codemirror/mode/css/css.js"></script>
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
    
    $css = file_get_contents($id);
    $html .= "<textarea id='editor' style='width:800px;height:600px;'>$css</textarea>
              <form id='save_form' method='post' action='admin.php?site=css&action=save&id=$id'>
                <input type='hidden' id='css' name='css' value=''/>
              </form>
              <p><button id='save'>Speichern</button></p>";
    return $html;
}
function get_save($id){
    file_put_contents($id, $_POST['css']);
    
    $db = database_connect();
    database_set_event("CSS '$id' geändert");
    database_close($db);
    
    return "CSS geändert";
}
if(isset($_GET['id']) and isset($_GET['action'])){
  $id = $_GET['id'];
  $action = $_GET['action'];
  if($action == "edit"){
    echo get_edit($id);
  }elseif($action == "save"){
    echo get_save($id);
  }
}else{
  echo get_list();
}
?>

