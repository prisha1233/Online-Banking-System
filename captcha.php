<?php 
session_set_cookie_params (0,"/~pps48/A2/","web.njit.edu");
session_start();

$font  = "LaBelleAurore.ttf";

header ('Content-Type: image/png');

$image = imagecreatetruecolor(155,150);

$black = imagecolorallocate($image, 0,0,0);

$yellow = imagecolorallocate($image, 255,255,0);

$red =imagecolorallocate ($image,255,0,0);

imagefilledrectangle ($image, 8,8,155,500,$yellow); 

$randomGenerator1 = substr(str_shuffle(md5(time())),0,6);

$randomGenerator2 = substr(str_shuffle(md5(time())),0,6);
//concanate string 
$_SESSION["captcha"] = "$randomGenerator1$randomGenerator2";

// fontsize, tilt , move to right , down
imagettftext($image,25,0,25,35, $black, $font, $randomGenerator1);


imagettftext($image, 25,35 ,25,140, $red, $font, $randomGenerator2);


imagepng($image);
imagedestroy($image); 

?>