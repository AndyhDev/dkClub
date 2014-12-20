<?php
$path = $_GET['file'];
$type =  mime_content_type($path);
$name = basename($path);

header("Content-Type: $type");

header("Content-Disposition: attachment; filename=\"$name\"");

readfile($path);
?>
