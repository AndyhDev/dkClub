<?php
function guestbook_get_normal(){
    $html = "<h1 class='text_center'>Gästebuch</h1><br/>
             <a href='index.php?site=guestbook&amp;action=add'>
             <img src='img/guestbook_add.png' alt='eintragen'/>
             </a>";
     
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
    
    $sql = "SELECT * FROM guestbook WHERE ok=1 ORDER BY stamp DESC LIMIT $site,10";
    $result = mysql_query($sql);
    
    while($row = mysql_fetch_assoc($result)){
        $name = $row['name'];
        $e_mail = $row['e_mail'];
        $date = $row['stamp'];
        $na = $row['nachricht'];
        
        $html = $html . "<div class='guestbook_entry'><table style='width:100%;border-collapse:collapse;'><tr><td style='width:5em;'>Name:</td><td>$name</td></tr>
                         <tr><td>E-Mail:</td><td>$e_mail</td></tr>
                         <tr><td>Datum:</td><td>$date</td></tr>
                         <tr><td style='border-top:1px solid gray;'>Nachricht:</td><td style='border-top:1px solid gray;'>$na</td></tr></table></div>";
    }
    $result = mysql_query("SELECT count(*) FROM guestbook");
    $anz = mysql_result($result, 0);
    database_close($db);
    
    $pages = ceil($anz/10);
    $html = $html . '<br/>Seiten:<table><tr>';
    for($i=1;$i <= $pages;$i++) {  
        $page = $i - 1;
        if($page == $site2){
            $html = $html . "<td><a style='background-color:gray;' class='page_link' href='index.php?site=guestbook&amp;page=$page'>$i</a></td>";
        }else{
            $html = $html . "<td><a class='page_link' href='index.php?site=guestbook&amp;page=$page'>$i</a></td>";
        }
    }
    $html = $html . '</tr></table>';
    
    return $html;
}
function guestbook_error($msg){
    $html = guestbook_get_add();
    $html = $html . "<div class='error'>$msg</div>";
    return $html;
}
function guestbook_get_save(){
    if(isset($_POST['name']) and isset($_POST['e_mail']) and isset($_POST['na'])){
        if(!empty($_POST['name']) and !empty($_POST['e_mail']) and !empty($_POST['na'])){
            if(strlen($_POST['name']) < 3 or strlen($_POST['name']) > 30){
                return guestbook_error("Name zu lang/kurz, min. 3 max. 30 Zeichen");
            }
            if(!check_email($_POST['e_mail'])){
                return guestbook_error("Keine gültige E-Mail Adresse");
            }
            if(strlen($_POST['na']) < 3 or strlen($_POST['na']) > 200){
                return guestbook_error("Nachricht zu lang/kurz, min. 3 max. 200 Zeichen");
            }
            $id = database_add_guestbook($_POST['name'], $_POST['e_mail'], $_POST['na']);
            $name = $_POST['name'];
            $mail = $_POST['e_mail'];
            $na = $_POST['na'];
            
            $empfaenger = "AH2@gmx.de";
            $absendername = "Gaestebuch SEV";
            $absendermail = "AH2@gmx.de";
            $betreff = "Ein neuer Gästebuch Eintrag";
            $text = "Es wurde Gerade eben eine neuer Eintrag ins Gästebuch geschrieben

Name: $name
E-Mail: $mail
Nachricht:
$na


Zum Freichalten: http://sev-kuernbach.de/includes/gs_admin.php?action=ok&id=$id
Zum Löschen: http://sev-kuernbach.de/includes/gs_admin.php?action=delete&id=$id

";
            mail($empfaenger, $betreff, $text, "From: $absendername <$absendermail>");
            return "<h1 class='text_center'>Ihre Nachricht wurde übermittel und wird in kürze ins Gästebuch eingetragen!</h1>";
        }else{
            return guestbook_error("Es fehlen noch angaben, bitte ergänzen.");
        }
    }else{
        return guestbook_error("Es fehlen noch angaben, bitte ergänzen.");
    }
}
function guestbook_get_add(){
    $name = "";
    $e_mail = "";
    $na = "";
    if(isset($_POST['name'])){
        $name = $_POST['name'];
    }
    if(isset($_POST['e_mail'])){
        $e_mail = $_POST['e_mail'];
    }
    if(isset($_POST['na'])){
        $na = $_POST['na'];
    }
    $html = "<h1 class='text_center'>ins Gästebuch eintragen</h1><br/>
             <script type='text/javascript'>
             function check_len(obj){
                var max = 200
                var text = obj.value;
                var info = document.getElementById('max_chars');
                if (text.length >= max) {
                    obj.value = text.substring(0, max);
                }
                info.innerHTML = max - obj.value.length
             }
             </script>
             <form method='post' action='index.php?site=guestbook&amp;action=save'>
               <table>
                 <tr>
                   <td>
                     Name:
                   </td>
                   <td>
                     <input type='text' name='name' value='$name'/>
                   </td>
                 </tr>
                 <tr>
                   <td>
                     E-Mail:
                   </td>
                   <td>
                     <input type='text' name='e_mail' value='$e_mail'/>
                   </td>
                 </tr>
                 <tr>
                   <td>
                     Nachricht:
                   </td>
                   <td>
                     <textarea name='na' onkeyup='check_len(this)' cols='50' rows='10' style='border:1px solid gray;'>$na</textarea><br/>
                     Sie können noch <span id='max_chars'>200</span> Zeichen eingeben.
                   </td>
                 </tr>
                 <tr>
                   <td>
                   </td>
                   <td>
                     <input type='submit' value='Eintragen' />
                   </td>
                 </tr>
               </table>
               
             </form>";
    return $html;
}
function guestbook_get_content(){
    if(isset($_GET['action'])){
        if($_GET['action'] == 'add'){
            $action = 'add';
        }elseif($_GET['action'] == 'save'){
            $action = 'save';
        }else{
            $action = 'normal';
        }
    }else{
        $action = 'normal';
    }
    if($action == 'add'){
        $html = guestbook_get_add();
    }elseif($action == 'normal'){
        $html = guestbook_get_normal();
    }elseif($action == 'save'){
        $html = guestbook_get_save();
    }
    
    return $html;
    
}
?>
