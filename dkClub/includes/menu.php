<?php
function get_menu(){
    $html = "<ul id='menu_list'>";
    
    $db = database_connect();

    $result = mysql_query("SELECT * FROM menu WHERE typ=1 OR typ=2 or typ=4 ORDER BY pos");
    while ($row = mysql_fetch_array($result)) {
        $name = $row['name'];
        $site = $row['site'];
        $id = $row['id'];
        
        if($row['typ'] == '1'){
            $html .= "<li>
                    <a href='index.php?site=$site'>$name</a>
                  </li>";
        }elseif($row['typ'] == 2){
            $html .= "<li><a class='fake_link'>$name</a>
                  <ul class='sub_menu'>";
                  
            $res = mysql_query("SELECT * FROM menu WHERE typ=3 AND display=$id ORDER BY pos"); 
            while ($row2 = mysql_fetch_array($res)){
                $name = $row2['name'];
                $site = $row2['site'];
                if($site == "ext1"){
                    $html .= "<li>
                          <a href='index.php?template=webcam&site=cam_today'>$name</a>
                          </li>";
                }elseif($site == "ext2"){
                    $html .= "<li>
                          <a href='index.php?template=webcam&site=cam_archive'>$name</a>
                          </li>";
                }else{
                    $html .= "<li>
                          <a href='index.php?site=$site'>$name</a>
                          </li>";
                }
            }  
            $html .= "</ul></li>";
        }elseif($row['typ'] == 4){
            if($_SESSION['login'] != 'ok'){
                $html .= "<li>
                  <a href='index.php?site=$site'>$name</a>
                </li>";
            }else{
                $html .= "<li><a class='fake_link'>$name</a>
                       <ul class='sub_menu'>";
                
                if($_SESSION["spezi"] == 1){
                    $html .= "<li>
                          <a href='admin.php'>Admin</a>
                          </li>";
                }
                 
                $res = mysql_query("SELECT * FROM menu WHERE typ=5 AND display=$id ORDER BY pos"); 
                while ($row2 = mysql_fetch_array($res)){
                    $name = $row2['name'];
                    $site = $row2['site'];
                    $html .= "<li>
                          <a href='index.php?site=$site'>$name</a>
                          </li>";
                }  
                $html .= "</ul></li>";
            }
        }
    }

    database_close($db);
    $html .= "</ul>";
    return $html;
}
function get_pos($site){
    $db = database_connect();
    if(in_array($site, array("cam_archive", "cam_today", "cam_day"))){
        $result = mysql_query("SELECT * FROM menu WHERE site='ext1'");
        $row = mysql_fetch_array($result);
        $id = $row['display'];
        $result = mysql_query("SELECT pos FROM menu WHERE id=$id");
        $row = mysql_fetch_array($result);
        database_close($db);
        return $row['pos'] -1;
    }
    $result = mysql_query("SELECT * FROM menu WHERE site='$site'");
    $row = mysql_fetch_array($result);
    if($row['typ'] == 3 or $row['typ'] == 5){
        $id = $row['display'];
        $result = mysql_query("SELECT pos FROM menu WHERE id=$id");
        $row = mysql_fetch_array($result);
        database_close($db);
        return $row['pos'] - 1;
        
    }elseif($row['typ'] == 1 or $row['typ'] == 2 or $row['typ'] == 4){
        database_close($db);
        return $row['pos'] - 1;
    }else{
        $result = mysql_query("SELECT * FROM loose_pages WHERE name='$site'");
        if($result){
            $row = mysql_fetch_array($result);
            $id = $row['display'];
            $result = mysql_query("SELECT * FROM menu WHERE id=$id");
            if($result){
                $row = mysql_fetch_array($result);
                database_close($db);
                return get_pos($row['site']);
            }else{
                return 0;
            }
        }
    }
    
}
function get_menu_point_from_site($site){
    $db = database_connect();
    $result = mysql_query("SELECT * FROM menu WHERE site='$site'");
    if($result){
        $row = mysql_fetch_array($result);
        return $row;
    }
}
?>
