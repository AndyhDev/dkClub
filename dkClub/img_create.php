<?php 
Header("Content-Type: image/png"); 

$font_size = 4;
$text = base64_decode($_GET['text']);
$text_len = strlen($text);

$text_width = imagefontwidth($font_size);
$text_height = imagefontheight($font_size);
$width = $text_width * $text_len + 10;
$height = $text_height + 4;
$img = ImageCreate($width, $height);

$black = ImageColorAllocate($img, 0, 0, 0);
$white = ImageColorAllocate($img, 255, 255, 255);

ImageFill($img, 0, 0, $white);
ImageString($img, $font_size, 5, 2, $text, $black); 

ImagePNG($img);
ImageDestroy($img)
?>