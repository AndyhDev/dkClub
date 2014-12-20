<?php
include_once('run_admin.php');

function gen_code($len){
    $numbers = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0);
    $chars = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
    $chars2 = array("A", "b", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    
    $pool = array($numbers, $chars, $chars2);
    
    $code = "";
    for ($i = 1; $i <= $len; $i++) {
        $tmp = $pool[rand(0, 2)];
        $code .= $tmp[rand(0, count($tmp)-1)];
    }
    return $code;
}

function get_list(){
    database_connect();
    $sql = "SELECT * FROM mitglieder";
    $result = mysql_query($sql);
    
    $html = "<h3>einen Link erstellen</h3>
             bitte ein Mitglied auswählen:<br/>
             <form method='post' action='admin.php?site=new_password&action=create'>";
    
    $select = "<select name='user' size='1'>";
    while ($row = mysql_fetch_array($result)){
        $id = $row['ID'];
        $vorname = $row['vorname'];
        $nachname = $row['nachname'];
        $select .= "<option value='$id'>$vorname $nachname</option>";
    }
    $select .= "</select>";
    
    $html .= $select;
    $html .= "<input type='submit' value='Link erstellen'/>
              </form>";
    return $html;
}
function create(){
    $code = gen_code(5) . "_" . gen_code(5) . "_" . gen_code(5) . "_" . gen_code(5) . "_" . gen_code(5);
    
    database_connect();
    $id = mysql_real_escape_string($_POST["user"]);
    
    $sql = "INSERT INTO new_password (user, code, active)
            VALUES ($id, '$code', 1)";
            
    mysql_query($sql);
    return "Link erstellt!<br/>
            Der Link lautet:<br>
            <h3>http://sev-kuernbach.de/index.php?site=new_password&code=$code</h3>";
}

if(isset($_GET["action"])){
    $action = $_GET["action"];
    if($action == "create"){
        echo create();
    }
}else{
    echo get_list();
}
?>
