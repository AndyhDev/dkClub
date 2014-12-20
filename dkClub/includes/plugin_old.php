<?php
function get_plugins($text){
    if(!preg_match_all('/(<|&lt;)plugin name=".*?" vars=".*?" \/(>|&gt;)/', $text, $matches)){
        return array();
    }
    $plugins = array();
    $founds = $matches[0];
    foreach($founds as $found){
        if (preg_match('/name="(.*?)"/', $found, $matches)) {
            $function = $matches[1];
            $name = "includes/plugins/" . $function . ".php";
            if(!is_file($name)){
                $name = false;
            }
        }else{
	    $name = false;
        }
        if (preg_match('/vars="(.*?)"/', $found, $matches)) {
            $data = explode(",", $matches[1]);
            $vars = array();
            foreach($data as $var){
                $var = trim($var);
                array_push($vars, $var);
            }
        }else{
            $vars = false;
        }
	if($name){
            $plugin = array();
            $plugin['name'] = $name;
            $plugin['function'] = $function;
            $plugin['replace'] = $found;
            $plugin['vars'] = $vars; 
            array_push($plugins, $plugin);
        }
    }
    return $plugins;
}
function run_plugin($plugin){
    include_once($plugin["name"]);
    $ausgabe = call_user_func_array("plugin_" . $plugin["function"], $plugin["vars"]);
    return $ausgabe;
}
function do_plugins($text){
    $plugins = get_plugins($text);
    foreach($plugins as $plugin){
        $replace = run_plugin($plugin);
        $text = str_replace($plugin['replace'], $replace, $text);
    }
    return $text;
}
?>