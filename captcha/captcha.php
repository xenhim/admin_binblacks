<?php
session_start();

$count=5;	/* количество символов */
$width=120; /* ширина картинки */
$height=32; /* высота картинки */
$font_size_min=25; /* минимальная высота символа */
$font_size_max=25; /* максимальная высота символа */
$font_file="./font.ttf"; /* путь к файлу относительно w3captcha.php */
$char_angle_min=-10; /* максимальный наклон символа влево */
$char_angle_max=10;	/* максимальный наклон символа вправо */
$char_angle_shadow=9;	/* размер тени */
$char_align=30;	/* выравнивание символа по-вертикали */
$start=5;	/* позиция первого символа по-горизонтали */
$interval=19;	/* интервал между началами символов */
$chars="0123456789"; /* набор символов */

$image=imagecreatetruecolor($width, $height);

$background_color=imagecolorallocate($image, 255, 255, 255); /* rbg-цвет фона */
$font_color=imagecolorallocate($image, 32, 64, 96); /* rbg-цвет тени */

imagefill($image, 0, 0, $background_color);

$str="";

$num_chars=strlen($chars);
for ($i=0; $i<$count; $i++)
{
	$char=$chars[rand(0, $num_chars-1)];
	$font_size=rand($font_size_min, $font_size_max);
	$char_angle=rand($char_angle_min, $char_angle_max);
	imagettftext($image, $font_size, $char_angle, $start, $char_align, $font_color, $font_file, $char);
	imagettftext($image, $font_size, $char_angle+$char_angle_shadow*(rand(0, 1)*2-1), $start, $char_align, $background_color, $font_file, $char);
	$start+=$interval;
	$str.=$char;
}

$_SESSION["captcha"]=$str;

if (function_exists("imagepng"))
{
	header("Content-type: image/png");
	imagepng($image);
}
elseif (function_exists("imagegif"))
{
	header("Content-type: image/gif");
	imagegif($image);
}
elseif (function_exists("imagejpeg"))
{
	header("Content-type: image/jpeg");
	imagejpeg($image);
}

imagedestroy($image);

?>
