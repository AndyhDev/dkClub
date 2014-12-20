<?php
include_once("/mnt/web8/a0/21/51434621/htdocs/webcams/day.php");
include_once("/mnt/web8/a0/21/51434621/htdocs/webcams/html.php");

function plugin_webcam_archive_overview(){
    $days_trans = array(1 => "Montag", 2 => "Dienstag", 3 => "Mittwoch", 4 => "Donnerstag", 5 => "Freitag", 6 => "Samstag", 7 => "Sonntag");
	$html = '<div class="act_title">Übersicht über alle verfügbaren Tage mit Bildern</div><table class="overview_table">
	<tr><td class="date_td">Datum</td><td class="date_td">Zufallsbilder des Tages</td></tr>';
	
	$img_base = get_img_base_url();
	
	foreach(day_get_days() as $date){
	    $imgs = day_get_random_pic($date, 2);
	    $html .= "<tr>
	                <td class='date_td'>
	                    <a href='index.php?template=webcam&amp;site=cam_day&amp;day=$date'>$date</a>
	                </td>
	                <td>";
	    
	    foreach($imgs as $img){
	        $name = basename($img);
	        $html .= "<img alt='Zufallsbild' src='$img_base/thumb_$name'/>";
	    }               
	    $html .= "  </td>
	              </tr>";
	}
	
	$html .= '</table>';
	return $html;
}

?>
