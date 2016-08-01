<?php
include "includes/connection.php";
include "includes/main_init.php";
include "includes/main_func.php";
include "includes/messages.php";
include "secure.php";

$id = (int)$_GET["id"];
$page_id = (int)$_GET["page_id"];
$block_id = (int)$_GET["block_id"];
$row = (int)$_GET["row"];
$format = (int)$_GET["format"];

$uploaddir = $_SERVER["DOCUMENT_ROOT"]."/images/data/";
$name = $block_id."_".$_FILES['uploadfile']['name'];
$ext = substr($name,strpos($name,'.'),strlen($name)-1);
if ($page_id == 0 && $block_id == 0 && $row == 0)
	$name = mt_rand().$ext;

$filetypes = array('.jpg','.gif','.bmp','.png','.JPG','.BMP','.GIF','.PNG','.jpeg','.JPEG','.svg','.SVG');
 
if(!in_array($ext,$filetypes)){
	echo "Error: Данный формат файлов не поддерживается";}
else
	{
	$file = $uploaddir.basename($name);
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file))
		{
		if ($page_id == 0 && $block_id == 0 && $row == 0)
			resize($file, $file, 500, 0);
		if ($wd_ != 0 and $ht_ != 0)
			{
			$file_info = getImageSize($file);
			if ($file_info[0]/$file_info[1] < $wd_/$ht_)
					{
					resize($file, $file, $wd_, 0);
					$file_info = getImageSize($file);
					$ht = round(($file_info[1] - $ht_)/2);
					if ($ht < 0)
					   $ht = 0;
					$coords = array(0, $ht, $wd_, $ht + $ht_);
					crop($file, $file, $coords);
			}
			else
					{
					resize($file, $file, 0, $ht_);
					$file_info = getImageSize($file);
					$wd = round(($file_info[0] - $wd_)/2);
					if ($wd < 0)
					   $wd = 0;
					$coords = array($wd, 0, $wd + $wd_, $ht_);
					crop($file, $file, $coords);
			}
		}
		if ($id != 0 && $row != 0)
			{
			if ($format == 2)
				{
				$slct = "select * from ".$prefix."_real_data where page_id = ".$page_id." and lang_id = ".$lang_id." and block_id = ".$block_id." and element_id = ".$id." and element_row = ".$row;
				$slct_q = mysql_query($slct) or die(mysql_error());
				if (mysql_num_rows($slct_q) == 0)
					{
					$replace_query = "insert into ".$prefix."_real_data (page_id, block_id, element_id, element_data, element_row, lang_id)
					values (".$page_id.", ".$block_id.", ".$id.", '".$name."', ".$row.", ".$lang_id.")";
					mysql_query($replace_query) or die(mysql_error());
				}
				else
					{
					$replace_query = "update ".$prefix."_real_data
					set element_data = TRIM(LEADING '=' FROM CONCAT_WS('=', element_data, '".$name."'))
					where page_id = ".$page_id." and lang_id = ".$lang_id." and block_id = ".$block_id." and element_id = ".$id." and element_row = ".$row;
					mysql_query($replace_query) or die(mysql_error());
				}
			}
			else
				{
				$replace_query = "replace into ".$prefix."_real_data (page_id, block_id, element_id, element_data, element_row, lang_id)
				values (".$page_id.", ".$block_id.", ".$id.", '".$name."', ".$row.", ".$lang_id.")";
				mysql_query($replace_query) or die(mysql_error());
			}
		}
		$file_info = getImageSize($_SERVER["DOCUMENT_ROOT"]."/images/data/".$name);
		echo $name."|".$file_info[0]."|".$file_info[1];
	}
	else
		echo "Error: Папка не создана";
}
/**
* Масштабирование изображения
*
* Функция работает с PNG, GIF и JPEG изображениями.
* Масштабирование возможно как с указаниями одной стороны, так и двух, в процентах или пикселях.
*
* @param string Расположение исходного файла
* @param string Расположение конечного файла
* @param integer Ширина конечного файла
* @param integer Высота конечного файла
* @param bool Размеры даны в пискелях или в процентах
* @return bool
*/
function resize($file_input, $file_output, $w_o, $h_o, $percent = false) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		echo 'Невозможно получить длину и ширину изображения';
		return;
    }
    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
    	echo 'Некорректный формат файла';
		return;
    }
	if ($percent) {
		$w_o *= $w_i / 100;
		$h_o *= $h_i / 100;
	}
	if (!$h_o) $h_o = $w_o/($w_i/$h_i);
	if (!$w_o) $w_o = $h_o/($h_i/$w_i);
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,100);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}

/**
* Обрезка изображения
*
* Функция работает с PNG, GIF и JPEG изображениями.
* Обрезка идёт как с указанием абсоютной длины, так и относительной (отрицательной).
*
* @param string Расположение исходного файла
* @param string Расположение конечного файла
* @param array Координаты обрезки
* @param bool Размеры даны в пискелях или в процентах
* @return bool
*/
function crop($file_input, $file_output, $crop = 'square',$percent = false) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		echo 'Невозможно получить длину и ширину изображения';
		return;
    }
    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
    	echo 'Некорректный формат файла';
		return;
    }
	if ($crop == 'square') {
		$min = $w_i;
		if ($w_i > $h_i) $min = $h_i;
		$w_o = $h_o = $min;
	} else {
		list($x_o, $y_o, $w_o, $h_o) = $crop;
		if ($percent) {
			$w_o *= $w_i / 100;
			$h_o *= $h_i / 100;
			$x_o *= $w_i / 100;
			$y_o *= $h_i / 100;
		}
    	if ($w_o < 0) $w_o += $w_i;
	    $w_o -= $x_o;
	   	if ($h_o < 0) $h_o += $h_i;
		$h_o -= $y_o;
	}
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,100);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}
?>