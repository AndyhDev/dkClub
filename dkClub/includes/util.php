<?php
function startswith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function endswith($haystack, $needle)
{
    $length = strlen($needle);
    $start  = $length * -1; //negative
    return (substr($haystack, $start) === $needle);
}
function check_email($email){        
    if(preg_match('/^[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)*\@[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)+$/i', $email)){
        return true;
    }else{
        return false;
    }
}
function check_int($int){
    if(is_numeric($int) === TRUE){
        if((int)$int == $int){
            return TRUE;
        }else{
            return FALSE;
        }
    }else{
        return FALSE;
    }
}
if(!function_exists('scandir')) {
    function scandir($directory, $sorting_order = 0) {
        $dh  = opendir($directory);
        while( false !== ($filename = readdir($dh)) ) {
            $files[] = $filename;
        }
        closedir($dh);
        if( $sorting_order == 0 ) {
            sort($files);
        } else {
            rsort($files);
        }
        return($files);
    }
}
function get_menu_typ_name($typ){
    $options = array('1' => 'Hauptpunkt',
                     '2' => 'Hauptpunkt mit Untermenü',
                     '3' => 'Unterpunkt',
                     '4' => 'Interner Hautpunkt',
                     '5' => 'Interner Unterpunkt');
                     
    return $options[$typ];
}
?>
