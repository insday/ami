<?
if ($properties["back_color"] == "")
	$properties["back_color"] = "transparent";
else
	$properties["back_color"] = "#".str_replace("#", "", $properties["back_color"]);

if ($properties["text_color"] == "")
	$properties["text_color"] = "#333333";
else
	$properties["text_color"] = "#".str_replace("#", "", $properties["text_color"]);

$padding = "padding";
if ($fields["header1"] != "")
	$padding = "paddingh1";
if ($fields["header2"] != "")
	$padding = "paddingh2";
if ($fields["header3"] != "")
	$padding = "paddingh3";
if ($fields["header4"] != "")
	$padding = "paddingh4";
?>
<div class="elements_div elements_div<?=$block_id;?><?if (!is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back"])) {?> <?=$padding;?><?}?>" style="background-color: <?=$properties["back_color"];?>;">
	<div class="elements_div_">
	<?if ($fields["header1"] != "") {?><h1 style="color: <?=$properties["text_color"];?>;"><?=$fields["header1"];?></h1><?}?>
	<?if ($fields["header2"] != "") {?><h2 style="color: <?=$properties["text_color"];?>;"><?=$fields["header2"];?></h2><?}?>
	<?if ($fields["header3"] != "") {?><h3 style="color: <?=$properties["text_color"];?>;"><?=$fields["header3"];?></h3><?}?>
	<?if ($fields["header4"] != "") {?><h4 style="color: <?=$properties["text_color"];?>;"><?=$fields["header4"];?></h4><?}?>
	<?
	if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back"]))
		{
		$file_info = getImageSize($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back"]);
		$hght = $file_info[1];
		?><div class="stripe" style="background-image: url('/images/data/<?=$fields["back"];?>'); background-position: top center; background-size: cover; height: <?=$hght;?>px;"></div><?
	}
	?>
	<?if ($fields["button_text"] != "" && $fields["button_url"] != "") {?><a href="<?=$fields["button_url"];?>"><button><?=$fields["button_text"];?></button></a><?}?>
	</div>
</div>