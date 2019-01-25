<?php
session_start();
 $name = rand();
 $_SESSION['object'] = serialize($name);
$im = imagegrabscreen();
imagepng($im, $name.".png");
imagedestroy($im);
header('location:fetch.php');
?>

