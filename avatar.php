<?php

header("Content-Type: image/png");

// Coded by SmartGenius
// 2016 - Resistencia Colombia


//Variables de Control


if(!empty($_GET['nickname'])){
		$nickname=$_GET['nickname'];
	}
	else{
		$nickname="Nickname";
}
if(!empty($_GET['image'])){
		$image=$_GET['image'];
	}
	else{
		$image="plantillas/player_template.png";
}

$borde="plantillas/avatar2.png";

$target="generated/avatar_" . $_GET['nickname'] . ".png";

//////////////
//A function for pixel precise text Wrapping
function imageTextWrapped(&$img, $x, $y, $width, $font, $color, $text, $textSize, $align) {
    $y += $textSize;
    $dimensions = imagettfbbox($textSize, 0, $font, " ");
    $x -= $dimensions[4]-$dimensions[0];

    $text = str_replace ("\r", '', $text);
    $srcLines = split ("\n", $text);
    $dstLines = Array();
    foreach ($srcLines as $currentL) {
        $line = '';
        $words = split (" ", $currentL);
        foreach ($words as $word) {
            $dimensions = imagettfbbox($textSize, 0, $font, $line.$word);
            $lineWidth = $dimensions[4] - $dimensions[0];
            if ($lineWidth > $width && !empty($line) ) {
                $dstLines[] = ' '.trim($line);
                $line = '';
            }
            $line .= $word.' ';
        }
        $dstLines[] =  ' '.trim($line);
    }
    $dimensions = imagettfbbox($textSize, 0, $font, "MXQJPmxqjp123");
    $lineHeight = $dimensions[1] - $dimensions[5];

    $align = strtolower(substr($align,0,1));
    foreach ($dstLines as $nr => $line) {
        if ($align != "l") {
            $dimensions = imagettfbbox($textSize, 0, $font, $line);
            $lineWidth = $dimensions[4] - $dimensions[0];
            if ($align == "r") { //If the align is Right
                $locX = $x + $width - $lineWidth;
            } else { //If the align is Center
                $locX = $x + ($width/2) - ($lineWidth/2);
            }
        } else { //if the align is Left
            $locX = $x;
        }
        $locY = $y + ($nr * $lineHeight);
        imagettftext($img, $textSize, 30, $locX, $locY, $color, $font, $line);
    }       
}

// Creamos la avatar
$avatar = imagecreatetruecolor(900, 900);

// agregamos transparencia
imagesavealpha ($avatar, true);

// rellenar con transparencia
$alphacolor	= imagecolorallocatealpha($avatar, 0,0,0,127);
imagefill($avatar,0,0,$alphacolor);

// imagen del usuario
// modificar con imagen subida
$imgagente = imagecreatefromjpeg($image);

// copiar al contenedor
imagecopyresampled($avatar, $imgagente, 140, 145, 0, 0, 620, 620, 620, 620);


// Plantilla
$template = imagecreatefrompng($borde);

imagecopyresampled($avatar, $template, 0, 0, 0, 0, 900, 900, 900, 900);

/// NICKNAME
$white = imagecolorallocate($avatar, 255, 255, 255);
$blue = imagecolorallocate($avatar, 0, 175, 240);
$green = imagecolorallocate($avatar, 0, 168, 90);

$font1 = "plantillas/GeomGraphicSemibold.ttf";
$font2 = "plantillas/AmarilloUSAF.ttf";

//imagettftext($avatar, 25, 30, 180, 270, $white, $font1, $nickname);

imageTextWrapped($avatar, 185, 240, 300, $font1, $white, $nickname, 30, Center);

// mostrar la imagen
//imagepng($avatar,$target);
imagepng($avatar);
//imagedestroy($avatar);
//Echo "<a href='$target'> Avatar de $nickname generado </a>"
?>