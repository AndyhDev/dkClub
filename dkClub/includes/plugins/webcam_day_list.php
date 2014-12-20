<?php
include_once("webcam.php");

function plugin_webcam_day_list(){
    $years = webcam_get_days();
    $html = '<ul>';
    
    foreach($years as $year => $y_a){
        $html .= "<ul><li>Jahr: $year</li>";
        
        foreach($y_a as $month => $m_a){
            $html .= "<ul><li>Monat: $month</li>";
            
            foreach($m_a as $day => $d_a){
                $html .= "<ul><li>Tag: $day</li>";
                
                foreach($d_a as $hour => $info){
                    $html .= "<li>Uhrzeit: $hour</li>";
                }
                
                $html .= '</ul>';
            }
            
            $html .= '</ul>';
        }
        
        $html .= '</ul>';
    }
    
    $html .= '</ul>';
    return $html;
}
?>
