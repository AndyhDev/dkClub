<?php
include_once('run_admin.php');

function get_blank(){
    return "<form method='post' action='admin.php?site=new_site&action=new'>
            <p>
            Name der neuen Seite (keine Leerzeichen): <input type='text' name='name'/>
            </p>
            <p>
            Überschrift der Seite: <input type='text' name='title'/>
            </p>
            diese Seite ist:<br/>
            <input type='radio' name='typ' value='0' checked='checked'/> öffentlich<br/>
            <input type='radio' name='typ' value='1' /> Intern (es wird automatisch ein 'i_' an den Dateinamen angehängt')
            <p>
            <input type='submit' value='erstellen'/>
            </p>
            </form>";
}
function get_new($id){
    if(!isset($_POST['name']) or !isset($_POST['title']) or !isset($_POST['typ'])){
      return "Leider sind nicht alle Informationen angekommen!<br/>Vorgang abgebrochen";
    }
    if($_POST['typ'] == '1'){
        $path = 'intern/i_' . $_POST['name'];
    }else{
        $path = 'content/' . $_POST['name'];
    }
    if(file_exists($path)){
        return "Datei existiert bereits";
    }
    $title = $_POST['title'];
    file_put_contents($path, "<h1 class='text_center'>$title</h1><br/>");
    $db = database_connect();
    database_set_event("Seite '$path' erstellt'");
    database_close($db);
    return "Datei wurde erstellt<br/><a href='admin.php?site=list_site&action=edit&id=$path'>direkt Bearbeiten</a>";
}
if(isset($_GET['action'])){
  $action = $_GET['action'];
  if($action == "new"){
    echo get_new($id);
  }
}else{
  echo get_blank();
}
?>
