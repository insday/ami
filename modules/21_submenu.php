<?
if ($properties["back_color"] == "")
	$properties["back_color"] = "transparent";
else
	$properties["back_color"] = "#".str_replace("#", "", $properties["back_color"]);

if ($properties["text_color"] == "")
	$properties["text_color"] = "#999999";
else
	$properties["text_color"] = "#".str_replace("#", "", $properties["text_color"]);
?>
<div class="submenu_div submenu_div<?=$block_id;?>" style="background-color: <?=$properties["back_color"];?>;">
	<h2><?=$fields["header"];?></h2>
	<div class="submenus">
		<?
		$mcnt = 0;
		$total = 100/count($subfields);
		foreach ($subfields as $sid => $subfield)
			{
			$mcnt++;
			?>
			<div class="submenu<?if ($mcnt == 1) {?> active"><?}else{?>"><a href="<?=$subfield["url_p"];?>"><?}?><?=$subfield["header_p"];?><?if ($mcnt != 1) {?></a><?}?></div>
			<?
		}
		?>
	</div>
</div>
