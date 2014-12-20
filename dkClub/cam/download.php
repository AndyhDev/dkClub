<?php
header('HTTP/1.1 200 OK');
header('Content-type: application/octet-stream');

$root_dir = getenv("DOCUMENT_ROOT");

function glue2path()
{
    $i     = 0;
    $stack     = array();
    $args     = func_get_args();
    $tmp     = join('/', $args);
    $tmp = preg_replace ('#//+#','/', $tmp);
    return $tmp;
}
$path = $_GET["file_name"];#glue2path($root_dir, "cam", $_GET["file_name"]);
header('Content-Disposition: attachment; filename=' . basename($path));
readfile($path);
?>