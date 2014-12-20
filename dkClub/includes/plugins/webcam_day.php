<?php
include_once("/mnt/web8/a0/21/51434621/htdocs/webcams/day.php");
include_once("/mnt/web8/a0/21/51434621/htdocs/webcams/html.php");

function plugin_webcam_day(){
    if(isset($_GET["day"])){
        $day = $_GET["day"];
        if(!preg_match("/([0-9]{2}).([0-9]{2}).([0-9]{4})/", $day)){
            return "<h1>Tag ist ungültig!</h1>";
        }
    }else{
        return "<h1>Keinen Tag angegeben!</h1>";
    }
    $days_trans = array(1 => "Montag", 2 => "Dienstag", 3 => "Mittwoch", 4 => "Donnerstag", 5 => "Freitag", 6 => "Samstag", 7 => "Sonntag");
    
    $html = "<h1 class='text_center'>Bilder vom $day</h1><br/>";
    $html .= '<script type="text/javascript" language="Javascript1.2">
    //<![CDATA[
    $(document).ready(function(){
        $(".open_box").fancybox({
		openEffect	: "none",
		closeEffect	: "none"
	    });
	
    });
    //]]>
    </script>';
    $img_base_url = get_img_base_url();
    
	$html .= get_act_img_html("$img_base_url/");
	
	$html .= '<br/><br/>';
	$html .= '<table class="thumb_table"><tr>';
    $cams = day_get($day);
    $is_img = false;
    
    $pics = array();
    $temp_cams = array();
    foreach($cams as $key => $value){
        $temp_cams[$key] = array();
    }
    foreach($cams as $key => $value){
        $html .= "<th class='bold'>$value[name]</th>";
        foreach($value["files"] as $path){
            $array = array();
            if(preg_match("/([^\D])_([0-9]{2}).([0-9]{2}).([0-9]{4})_([0-9]{2}):([0-9]{2})/", $path, $array)){
                if(!array_key_exists($array[5], $pics)){
                    $pics[$array[5]] = array(1 => array(), 2 => array(), 3 => array(), 4 => array());
                }
                if(!array_key_exists($array[1], $pics[$array[5]])){
                    $pics[$array[5]][$array[1]] = array();
                }
                array_push($pics[$array[5]][$array[1]], $path);
            }
        }
    }
    
    $html .= '</tr>';
    
    $img_base = get_img_base_url();
    
    ksort($pics);
    foreach($pics as $time => $cams){
        
        $html .= "<tr><td colspan='4'>$time Uhr</td></tr><tr>";
        foreach($cams as $cam => $paths){
            $html .= '<td>';
            foreach($paths as $path){
                $name = basename($path);
                $html .= "<a class='open_box' rel='g1' href='$img_base/$name'><img alt='Webcambild' src='$img_base/thumb_$name' /></a>";
                $is_img = true;
            }
            $html .= '</td>';
        }
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    
    if(!$is_img){
        $html .= "<span class='no_pic'>Von diesem Tag liegen leider keine Bilder vor, versuchen sie doch einen anderen!</span>";
    }
    
	return $html;
}

?>
