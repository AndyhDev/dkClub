<?php
function webcam_is_valid_img($img){
    if(preg_match('/[0-9]{2}_[0-9]{2}_[0-9]{4}-[0-9]{2}_[0-9]{2}.jpg/', $img)){
        return true;
    }else{
        return false;
    }
}
function webcam_get_days(){
    $allow = array(".jpg", ".jpeg", "jpe", ".png", ".tiff");
    $path = "webcam";
    $files = scandir($path);
    $years = array();
    
    foreach($files as $name){
        $t_path = $path . "/" . $name;
        $ext = strtolower(strrchr($name, "."));
        if(in_array($ext, $allow) and !startswith($name, 'thumbnail') and webcam_is_valid_img($name)){
            $basename = substr($name, 0, strpos($name, "."));
			$tmp = explode('-', $basename);
			$date = explode('_', $tmp[0]);
			$time = explode('_', $tmp[1]);
			$stamp = $tmp[1];
			if(!array_key_exists($date[2], $years)){
			    $years[$date[2]] = array();
			}
			if(!array_key_exists($date[1], $years[$date[2]])){
			    $years[$date[2]][$date[1]] = array();
			}
			if(!array_key_exists($date[0], $years[$date[2]][$date[1]])){
			    $years[$date[2]][$date[1]][$date[0]] = array();
			}
			$years[$date[2]][$date[1]][$date[0]][$tmp[1]] = array($date, $time);
        }
    }
    return $years;
}
function webcam_get_list($day, $month, $year){
    $html = '';
    
    $path = "webcam";
    $files = scandir($path);
    $cam1 = array();
    $cam2 = array();
    $cam3 = array();
    $cam4 = array();
    
	$times = array();
	
    $allow = array(".jpg", ".jpeg", "jpe", ".png", ".tiff");
    foreach($files as $name){
        $t_path = $path . "/" . $name;
        $ext = strtolower(strrchr($name, "."));
        if(in_array($ext, $allow) and !startswith($name, 'thumbnail')){
			$basename = substr($name, 0, strpos($name, "."));
			$tmp = explode('-', $basename);
			$date = explode('_', $tmp[0]);
			$time = explode('_', $tmp[1]);
			if($date[0] == $day and $date[1] == $month and $date[2] == $year){
			    if(!in_array($time[0], $times)){
				    $times[] = $time[0];
				    $cam1[$time[0]] = array();
				    $cam2[$time[0]] = array();
				    $cam3[$time[0]] = array();
				    $cam4[$time[0]] = array();
				}
				
			    if(in_array($time[1], array('00', '20', '40'))){
			        $cam1[$time[0]][$time[1]] = array($time, $t_path);
			        
			    }elseif(in_array($time[1], array('05', '25', '45'))){
			        $cam2[$time[0]][$time[1]] = array($time, $t_path);
			        
			    }elseif(in_array($time[1], array('10', '30', '50'))){
			        $cam3[$time[0]][$time[1]] = array($time, $t_path);
			        
			    }elseif(in_array($time[1], array('15', '35', '55'))){
			        $cam4[$time[0]][$time[1]] = array($time, $t_path);
			    }
			    
				
			}            
        }
    }
	ksort($times);
	
	$html .= '
	<script type="text/javascript" src="js/fancybox2/jquery-1.9.0.min.js"></script>
    <link rel="stylesheet" href="js/fancybox2/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
    <script type="text/javascript" src="js/fancybox2/jquery.fancybox.pack.js?v=2.1.4"></script>
    <link rel="stylesheet" href="js/fancybox2/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
    <script type="text/javascript" src="js/fancybox2/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript">
        $(document).ready(function() {
	        $(".arch_img").fancybox({
	            nextClick : true,
	            playSpeed : 5000,
	            helpers		: {
			        title   : { type : "inside" },
			        buttons	: {}
		                      }
	        });
        });
    </script>
	<table style="width:100%;text-align:center;">
	  <tr>
	    <td>
	      <b>Kamera 1 - Bahnhof 1</b>
	    </td>
	    <td>
	      <b>Kamera 2 - Drehscheibe</b>
	    </td>
	    <td>
	      <b>Kamera 3 - Bahnhof 2</b>
	    </td>
	    <td>
	      <b>Kamera 4 - Einfahrt / Vereinsheim</b>
	    </td>
	  </tr>';
	foreach($times as $time){
	    $html .= "<tr>
	      <td colspan='4'>
	        $time Uhr
	      </td>
	    </tr><tr>";
	    
	    $cams = array($cam1, $cam2, $cam3, $cam4);
	    foreach($cams as $cam){
	        $html .= '<td style="width:25%;">';
	        
	        ksort($cam[$time]);
	        foreach($cam[$time] as $key => $pic){
	            $img = $pic[1];
	            $html .= "<a class='arch_img' rel='gal2' href='$img'><img style='width:190px;height:143px;' src='$img' alt=''/></a>";
	        }
	        
	        $html .= '</td>';
	    }
	    
	    $html .= '</tr>';
	}
	if(empty($times)){
	    if($day == date("d") and $month == date("m") and $year == date("Y") ){
	        $no_pic_msg = "die Webcams haben heute noch keine Bilder aufgenommen, sehen sie später wieder nach.";
	    }else{
	        $no_pic_msg = "leider wurden an diesem Tag keine Bilder aufgenommen";
	    }
	    $html .= "<tr>
	                <td colspan='4'>
	                  <h3>$no_pic_msg</h3>  
	                </td>
	              </tr>";
	                  
	}
	$html .= '</table>';
	return $html;
}
?>
