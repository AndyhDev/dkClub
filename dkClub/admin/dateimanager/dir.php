<?php
function format_size($size){
    if($size > 1099511627776){
        $size = ($size / 1099511627776);
        $size = round($size, 2) . ' TB';
        return $size;
    }else if($size > 1073741824){
        $size = ($size / 1073741824);
        $size = round($size, 2) . ' GB';
        return $size;
    }else if($size > 1048576){
        $size = ($size / 1048576);
        $size = round($size, 2) . ' MB';
        return $size;
    }
    else if($size > 1024){
        $size = ($size / 1024);
        $size = round($size, 2) . ' KB';
        return $size;
    }else if($size < 1024){
        return $size . ' Bytes';
    }
    return $size;
}
function aphp_starts_with($string, $char){
    $length = strlen($char);
    return (substr($string, 0, $length) === $char);
}

function aphp_ends_with($string, $char){
    $length = strlen($char);
    $start =  $length *-1;
    return (substr($string, $start, $length) === $char);
}
function path_join($array){
    $path = "";
    $first = true;
    foreach($array as $k => $name){
        if(aphp_starts_with($name, "/")){
            if(!$first){
                $lenght = strlen($name) -1;
                $name = substr($name, 1, $lenght);
            }
        }
        if(aphp_ends_with($path, "/")){
            $path = $path . $name;
        }else{
            if($first){
                $first = false;
                $path = $path . $name;
            }else{
                $path = $path . "/" . $name;
            }
        }
    }
    return $path;
}
function make_bar($r_dir, $dir){
    $html = "<p><div style=''>
             <a href='admin.php?site=dateim&dir=/'><span style='border:2px solid gray;padding:5px;'>/ ></span></a>";
    $folders =  explode('/', $dir);
    $path = "";
    foreach($folders as $folder){
        if($folder){
            $path = path_join(array($path, $folder));
            $html .= "<a href='admin.php?site=dateim&dir=$path'><span style='border:2px solid gray;padding:5px;'>$folder ></span></a>";
        }
    }
    $html .= '</div></p>';
    return $html;
    
}
function get_icon($name){
    if(aphp_ends_with($name, '.pdf') or aphp_ends_with($name, '.PDF')){
        return "<img src='admin/dateimanager/pdf.png'/>";
    }elseif(aphp_ends_with($name, '.php') or aphp_ends_with($name, '.PHP')){
        return "<img src='admin/dateimanager/php.png'/>";
    }elseif(aphp_ends_with($name, '.jpg') or aphp_ends_with($name, '.JPG')){
        return "<img src='admin/dateimanager/image.png'/>";
    }elseif(aphp_ends_with($name, '.jpeg') or aphp_ends_with($name, '.JPEG')){
        return "<img src='admin/dateimanager/image.png'/>";
    }elseif(aphp_ends_with($name, '.png') or aphp_ends_with($name, '.PNG')){
        return "<img src='admin/dateimanager/image.png'/>";
    }
    return "<img src='admin/dateimanager/file.png'/>";
}
function js($real_dir, $dir){
    $new_folder = '<h3>Neuer Ordner erstellen</h3>
                   <form method="post" action="admin.php?site=dateim&action=new_folder&dir=' . $dir .'">
                     Name: <input type="text" name="folder_name" />
                     <input type="hidden" name="real_dir" value="' . $real_dir . '"/><br/>
                     <input type="submit" value="erstellen"/>
                   </form>';
    $new_folder = preg_replace('/\s\s+/', ' ', $new_folder);
    
    $upload = '<h3>Datei Hochladen</h3>
               <form method="post" action="admin.php?site=dateim&action=upload&dir=' . $dir .'" enctype="multipart/form-data">
                 Datei: <input type="file" name="datei" /><br/>
                 <input type="hidden" name="real_dir" value="' . $real_dir . '"/><br/>
                 <input type="submit" value="hochladen"/>
               </form>';
    $upload = preg_replace('/\s\s+/', ' ', $upload);
    
    $js_var = "'  + path + '";
    $js_var2 = "'  + name + '";
    $remove = '<h3>Datei "' . $js_var2 . '" LÖSCHEN</h3>
               <form method="post" action="admin.php?site=dateim&action=remove&dir=' . $dir .'">
                 <input type="hidden" name="path" value="' . $js_var . '"/>
                 <input type="hidden" name="real_dir" value="' . $real_dir . '"/><br/>
                 <input type="submit" value="Löschen"/>
               </form>';
    $remove = preg_replace('/\s\s+/', ' ', $remove);
    
    $js_var = "'  + path + '";
    $js_var2 = "'  + name + '";
    $rename = '<h3>Datei "' . $js_var2 . '" Umbenennen</h3>
               <form method="post" action="admin.php?site=dateim&action=rename&dir=' . $dir .'">
                 <input type="hidden" name="old_path" value="' . $js_var . '"/>
                 <input type="hidden" name="real_dir" value="' . $real_dir . '"/>
                 Neuer Name: <input type="text" name="new_name" value="' . $js_var2 . '"/><br/>
                 <input type="submit" value="Umbenennen"/>
               </form>';
    $rename = preg_replace('/\s\s+/', ' ', $rename);
    
    return "<script type='text/javascript' src='admin/dateimanager/jquery.js'></script>
            <link rel='stylesheet' href='admin/dateimanager/fancybox/source/jquery.fancybox.css?v=2.1.3' type='text/css' media='screen' />
            <script type='text/javascript' src='admin/dateimanager/fancybox/source/jquery.fancybox.pack.js?v=2.1.3'></script>

            <script type='text/javascript'>
              function new_folder(){
                $.fancybox.open('$new_folder');
              }
              function upload(){
                $.fancybox.open('$upload');
              }
              function remove_obj(path, name){
                $.fancybox.open('$remove');
              }
              function rename(path, name){
                $.fancybox.open('$rename');
              }
            </script>";
}
function read_dir($dir){
    $root = $_SERVER['DOCUMENT_ROOT']; #path_join(array($_SERVER['DOCUMENT_ROOT'], 'test', 'sev'));
    $real_dir = path_join(array($root, $dir));
    if(!is_dir($real_dir)){
        return "Kein Verzeichniss";
    }
    $files = scandir($real_dir);
    $not_show = array('.', '..', '.htaccess');
    $js = js($real_dir, $dir);
    $html = $js . "<table border='1' style='margin-left:50px;width:680px;border-color:gray;border-collapse:collapse;line-height:32px;'>
             <tr>
               <td colspan='6'>
                 Neuer Ordner: <img style='cursor:pointer;' onclick='new_folder();' src='admin/dateimanager/folder.png'/>&nbsp;&nbsp;&nbsp;
                 Datei Hochladen: <img style='cursor:pointer;' onclick='upload();' src='admin/dateimanager/up.png'/>&nbsp;&nbsp;&nbsp;
               </td>
               
             </tr>
             <tr>
               <td colspan='6'>
                 &nbsp;&nbsp;&nbsp;
               </td>
             </tr>
             <tr style='background-color:#2EFE2E;'><td style='width:32px;'></td><td>Name</td><td>Typ</td><td>Größe</td><td>zuletzt geändert</td><td></td></tr>";
             
    $html .= make_bar($root, $dir);
    $folders_html = "";
    $files_html = "";
    foreach($files as $file){
        if(!in_array($file, $not_show)){
            $path = path_join(array($real_dir, $file));
            $r_dir = path_join(array($dir, $file));
            $ctime = filectime($path);
            $cdate = date("d.m.Y - G:i:s", $ctime); 
            $size = format_size(filesize($path));
            $js_var = '"' . $path . '"';
            $js_var2 = '"' . basename($path) . '"';
            if(is_dir($path)){
                $folders_html .= "<tr><td><img src='admin/dateimanager/folder.png'/></td>
                                  <td><a href='admin.php?site=dateim&dir=$r_dir'>$file</a></td>
                                  <td>Ordner</td>
                                  <td>$size</td>
                                  <td>$cdate</td>
                                  <td>
                                    <img style='cursor:pointer;' onclick='remove_obj($js_var, $js_var2);' src='admin/dateimanager/delete.png'/>
                                    <img style='cursor:pointer;' onclick='rename($js_var, $js_var2);' src='admin/dateimanager/rename.png'/>
                                  </td></tr>";
            }else{
                $typ = mime_content_type($path);
                $icon = get_icon($file);
                $files_html .= "<tr><td>$icon</td>
                                  <td>$file</td>
                                  <td>$typ</td>
                                  <td>$size</td>
                                  <td>$cdate</td>
                                  <td>
                                    <img style='cursor:pointer;' onclick='remove_obj($js_var, $js_var2);' src='admin/dateimanager/delete.png'/>
                                    <img style='cursor:pointer;' onclick='rename($js_var, $js_var2);' src='admin/dateimanager/rename.png'/>
                                    <a target='_blank' href='admin/dateimanager/download.php?file=$path'><img style='cursor:pointer;' src='admin/dateimanager/down.png'/></a>
                                  </td></tr>";
            }
        }
    }
    $html .= $folders_html . $files_html;
    return $html;
}
?>
