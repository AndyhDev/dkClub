<?php
function plugin_image($text){
    return "<img src='img_create.php?text=" . base64_encode($text) . "' alt=''/>";
}
?>