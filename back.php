<?php

header("Content-Type: image/png");

// Coded by SmartGenius
// 2016 - Resistencia Colombia


//Variables de Control

if(!empty($_GET['plantilla'])){
		$plantilla=$_GET['plantilla'];
	}
	else{
		$plantilla="negro";
}
if(!empty($_GET['sello'])){
		$sello=$_GET['sello'];
	}
	else{
		$sello="false";
}
if(!empty($_GET['nickname'])){
		$nickname=$_GET['nickname'];
	}
	else{
		$nickname="Nickname";
}
if(!empty($_GET['faction'])){
		$faction=$_GET['faction'];
	}
	else{
		$faction="flyer";
}

if($plantilla == "negro" ){
			if($faction == "res" ){
						if(!empty($_GET['bgcolor'])){
							$borde="plantillas/backt_negro_res.png";
							$bgcolor=$_GET['bgcolor'];
						}
						else{
							$borde="plantillas/back_negro_res.png";
							$bgcolor="00AFEF";
						}
					}
					else{
						if(!empty($_GET['bgcolor'])){
							$borde="plantillas/backt_negro_enl.png";
							$bgcolor=$_GET['bgcolor'];
						}
						else{
							$borde="plantillas/back_negro_enl.png";
							$bgcolor="00A859";
						}
					}
			}
			else{
			if($faction == "res" ){
						if(!empty($_GET['bgcolor'])){
							$borde="plantillas/backt_gris_res.png";
							$bgcolor=$_GET['bgcolor'];
						}
						else{
							$borde="plantillas/back_gris_res.png";
							$bgcolor="00AFEF";
						}
					}
					else{
						if(!empty($_GET['bgcolor'])){
							$borde="plantillas/backt_gris_enl.png";
							$bgcolor=$_GET['bgcolor'];
						}
						else{
							$borde="plantillas/back_gris_enl.png";
							$bgcolor="00A859";
						}
					}
			}

if(!empty($_GET['logo'])){
		//$logo=$_GET['logo'];
		$logo="logos/logo_" . $_GET['logo'] . ".png";
	}
	else{
		$logo="logos/logo_default.png";
		//$logo="default";
}
if(!empty($_GET['title'])){
		$title=$_GET['title'];
	}
	else{
		$title="YOUR TITLE HERE";
}

if(!empty($_GET['desc'])){
		$description=$_GET['desc'];
	}
	else{
		$description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat lorem et tincidunt suscipit.";
}

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
        imagettftext($img, $textSize, 0, $locX, $locY, $color, $font, $line);
    }       
}

function hexColorAllocate($image,$hex){
    $hex = ltrim($hex,'#');
    $a = hexdec(substr($hex,0,2));
    $b = hexdec(substr($hex,2,2));
    $c = hexdec(substr($hex,4,2));
    return imagecolorallocate($image, $a, $b, $c); 
}


//$logo="logos/logo_" . $_GET['logo'] . ".png";
//echo $logo;
$logob = imagecreatefrompng($logo);

// Creamos la Biocard
$biocard = imagecreatetruecolor(756, 1064);

// agregamos transparencia
imagesavealpha ($biocard, true);

// rellenar con transparencia
$alphacolor	= imagecolorallocatealpha($biocard, 0,0,0,127);
imagefill($biocard,0,0,$alphacolor);


// si se define color de fondo
$color = hexColorAllocate($biocard, $bgcolor);
imagefill($biocard, 0, 0, $color);  


// Plantilla
$template = imagecreatefrompng($borde);

imagecopyresampled($biocard, $template, 0, 0, 1, 1, 756, 1064, 756, 1064);

// Aplicar logo
imagecopyresampled($biocard, $logob, 100, 15, 0, 0, 209, 196, 209, 196);

/// NICKNAME
$white = imagecolorallocate($biocard, 255, 255, 255);
$blue = imagecolorallocate($biocard, 0, 175, 240);
$green = imagecolorallocate($biocard, 0, 168, 90);

$font1 = "plantillas/GeomGraphicSemibold.ttf";
$font2 = "plantillas/AmarilloUSAF.ttf";


//Texto del Titulo
//$title1 = "FOR EVER IN FRIENDZONE";
//$title2 = "HONORIFIC MEMBER";

// Imprimir el titulo sin alineacion
//imagettftext($biocard, 25, 0, 65, 325, $white, $font2, $title1);
//imagettftext($biocard, 25, 0, 65, 370, $white, $font2, $title2);

// Imprimir el titulo Centrado
imageTextWrapped($biocard, 65, 300, 640, $font2, $white, $title, 25, Center);
//imageTextWrapped($biocard, 65, 340, 640, $font2, $white, $title2, 25, Center);

// Texto de Descripcion
//$dummy1 = "Lorem ipsum dolor sit amet, consect";
//$dummy2 = "etur adipiscing elit. Donec consequ";
//$dummy3 = "at lorem et tincidunt suscipit. Ves";
//$dummy4 = "tibulum ante ipsum primis in faucib";
//$dummy5 = "us orci luctus et ultrices posuere ";
//$dummy6 = "cubilia Curae; Praesent nec vulputa";
//$dummy7 = "te leo, vel scelerisque metus. Fusc";
//$dummy8 = "e ornare rutrum ex, et vehicula arc";
//$dummy9 = "u luctus at. Donec eleifend pellent";
//$dummy10 = "esque varius.                    RR";

//$dummy0 = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat lorem et tincidunt suscipit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent nec vulputate leo, vel scelerisque metus.";

// Imprimir la descripcion por lineas
//imagettftext($biocard, 25, 0, 65, 585, $white, $font1, $dummy1);
//imagettftext($biocard, 25, 0, 65, 630, $white, $font1, $dummy2);
//imagettftext($biocard, 25, 0, 65, 675, $white, $font1, $dummy3);
//imagettftext($biocard, 25, 0, 65, 720, $white, $font1, $dummy4);
//imagettftext($biocard, 25, 0, 65, 765, $white, $font1, $dummy5);
//imagettftext($biocard, 25, 0, 65, 810, $white, $font1, $dummy6);
//imagettftext($biocard, 25, 0, 65, 855, $white, $font1, $dummy7);
//imagettftext($biocard, 25, 0, 65, 900, $white, $font1, $dummy8);
//imagettftext($biocard, 25, 0, 65, 945, $white, $font1, $dummy9);
//imagettftext($biocard, 25, 0, 65, 990, $white, $font1, $dummy10);

// Imprimir la  Descripcion justificada y centrada
imageTextWrapped($biocard, 65, 560, 640, $font1, $white, $description, 25, Center);


// color del texto segun faccion
if(!empty($_GET['faction'])){
		$faction=$_GET['faction'];
		if($faction == "res" ){
			imagettftext($biocard, 50, 0, 325, 135, $blue, $font2, $nickname);
		}
		else{
			imagettftext($biocard, 50, 0, 325, 135, $green, $font2, $nickname);
		}
	}
	else{
		$faction="flyer";
		imagettftext($biocard, 50, 0, 325, 135, $white, $font2, $nickname);
}



// mostrar la imagen
imagepng($biocard);
?>