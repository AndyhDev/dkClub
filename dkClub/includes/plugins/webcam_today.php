<?php
include_once("/mnt/web8/a0/21/51434621/htdocs/webcams/today.php");
include_once("/mnt/web8/a0/21/51434621/htdocs/webcams/html.php");

function plugin_webcam_today(){
    $img_base_url = get_img_base_url();
    
    $days_trans = array(1 => "Montag", 2 => "Dienstag", 3 => "Mittwoch", 4 => "Donnerstag", 5 => "Freitag", 6 => "Samstag", 7 => "Sonntag");
	$html = get_act_img_html("$img_base_url/");
	
	$html .= '<table class="info_box">
	<tr><td><span id="clock"></span><br/><span id="date"></span></td></tr>
	<tr><td>Bilder vom heutigen <span class="bold">';
	
	$html .= $days_trans[date("N")];
	
	$html .= '</span></td></tr>
	<tr><td><div id="archive"></div></td></tr>
	</table>';
	
	$html .= '
	<script type="text/javascript" language="Javascript1.2">
    //<![CDATA[
    var month_names = new Array("Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
    var day_names_small = new Array("So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");
    
	function clock(){
        var date = new Date();
        var hour = date.getHours();
        var minutes = date.getMinutes();
        var sec = date.getSeconds();
        if(minutes<10){
            minutes = "0" + minutes;
        }
        if(sec<10){
            sec = "0" + sec;
        }
        var text = hour + ":" + minutes + ":" + sec;
        document.getElementById("clock").innerHTML = text;
        setTimeout("clock()",1000);
    }
    function date(){
        var date = new Date();
        var year = date.getFullYear();
        var month = date.getMonth();
        var w_day = date.getDay();
        var day = date.getDate();
        if(day<10){
            day = "0" + day;
        }
        var text = day_names_small[w_day] + ", " + day + ". " + month_names[month] + " " + year;
        document.getElementById("date").innerHTML = text;
        setTimeout("date()",10000);
    }
    $(document).ready(function(){
        clock();
        date();
        $(document).on("click", "#archive", function(){window.location.href="index.php?template=webcam&site=cam_archive"});
        
        $(".open_box").fancybox({
		openEffect	: "none",
		closeEffect	: "none"
	    });
	
    });
    //]]>
    </script>
    ';
    
    $html .= '<table class="thumb_table"><tr>';
    $cams = today_get();
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
    
    ksort($pics);
    foreach($pics as $time => $cams){
        //asort($cams);
        $html .= "<tr><td colspan='4'>$time Uhr</td></tr><tr>";
        foreach($cams as $cam => $paths){
            $html .= '<td>';
            foreach($paths as $path){
                $name = basename($path);
                $html .= "<a class='open_box' rel='g1' href='$img_base_url/$name'><img alt='Vorschaubild' src='$img_base_url/thumb_$name' /></a>";
                $is_img = true;
            }
            $html .= '</td>';
        }
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    
    if(!$is_img){
        $html .= "<span class='no_pic'>Bis jetzt wurden heute noch keine Bilder gemacht, schauen sie doch einfach später nocheinmal vorbei!</span>";
    }
	return $html;
}
?>
