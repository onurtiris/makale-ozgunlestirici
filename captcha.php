<?php
session_start();
$code = substr(md5(uniqid(rand(0, 6))), 0, 6);
$_SESSION['code'] = $code;
session_start();
$code = substr(md5(uniqid(rand(0, 6))), 0, 6);
$_SESSION['code'] = $code;

header('Content-type: image/png');
$code_length = strlen($code);
$width = imagefontwidth(5) * $code_length;
$height = imagefontheight(5);

$picture = imagecreate($width, $height);
$back_color = imagecolorallocate($picture, 255, 255, 255);
$font_color = imagecolorallocate($picture, 68, 68, 68);

imagefill($picture, 0, 0, $back_color);
imagestring($picture, 5, 0, 0, $code, $font_color);
imagepng($picture);
?>