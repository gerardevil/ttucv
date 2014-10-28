<?php 
$file=$_GET['ruta'];
$new_w=$_GET['ancho'];
$new_h=$_GET['alto'];

$imageinfo=getimagesize($file);
if($imageinfo[2]==1)
  $original_image=imagecreatefromgif($file);
if($imageinfo[2]==2)
  $original_image=imagecreatefromjpeg($file);
if($imageinfo[2]==3)
  $original_image=imagecreatefrompng($file);
if($imageinfo[2]==6)
  $original_image=imagecreatefrombmp($file);
if($imageinfo[2]>3)
  die('Image format not supported');

$img_w=imagesx($original_image); 
$img_h=imagesy($original_image); 

$im=imagecreatetruecolor($new_w,$new_h);

imagecopyresampled($im,$original_image,0,0,0,0,$new_w,$new_h,$img_w,$img_h);

if($imageinfo[2]==1){header("Content-type: image/gif");  imagegif($im);} 
if($imageinfo[2]==2){header("Content-type: image/jpeg"); imagejpeg($im);} 
if($imageinfo[2]==3){header("Content-type: image/png");  imagepng($im);}  
?>