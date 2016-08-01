<?
if ($properties["back_color"] == "")
	$properties["back_color"] = "transparent";
else
	$properties["back_color"] = "#".str_replace("#", "", $properties["back_color"]);

if ($properties["back_color_left"] == "")
	$properties["back_color_left"] = "transparent";
else
	if (str_replace("rgba", "", $properties["back_color_left"]) == $properties["back_color_left"])
		$properties["back_color_left"] = "#".str_replace("#", "", $properties["back_color_left"]);

if ($properties["back_color_right"] == "")
	$properties["back_color_right"] = "transparent";
else
	if (str_replace("rgba", "", $properties["back_color_right"]) == $properties["back_color_right"])
		$properties["back_color_right"] = "#".str_replace("#", "", $properties["back_color_right"]);

if ($properties["text_color"] == "")
	$properties["text_color"] = "#999999";
else
	$properties["text_color"] = "#".str_replace("#", "", $properties["text_color"]);
?>
<div class="uni" style="background-color: <?=$properties["back_color"];?>;">
	<?
	if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back"]))
		{
		?>
		<div class="uni_back"><img src="/images/data/<?=$fields["back"];?>" /></div>
		<?
		}
	?>
	<div class="uni_on"<?if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back"])) {?> style="position: absolute;	top: 0; left: 0;"<?}?>>
		<div class="uni_table">
			<div class="uni_left60" style="background-color: <?=$properties["back_color_left"];?>;">
				<?
				if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back_left"]))
					{
					?>
					<div class="uni_back"><img src="/images/data/<?=$fields["back_left"];?>" /></div>
					<?
				}
				if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["img_left"]))
					{
					?>
					<img src="/images/data/<?=$fields["img_left"];?>" />
					<?
				}
				else
					{
					if ($fields["header_left"] != "" || $fields["text_left"] != "")
						{
						?>
						<div class="uni_in" style="color: <?=$properties["text_color"];?>;">
							<?if ($fields["header_left"] != "") {?><h2><?=$fields["header_left"];?></h2><?}?>
							<?=$fields["text_left"];?>
						</div>
						<?
					}
				}
				?>
			</div>
			<div class="uni_right40" style="background-color: <?=$properties["back_color_right"];?>;">
				<?
				if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back_right"]))
					{
					?>
					<div class="uni_back"><img src="/images/data/<?=$fields["back_right"];?>" /></div>
					<?
				}
				if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["img_right"]))
					{
					?>
					<img src="/images/data/<?=$fields["img_right"];?>" />
					<?
				}
				else
					{
					if ($fields["header_right"] != "" || $fields["text_right"] != "")
						{
						?>
						<div class="uni_in" style="color: <?=$properties["text_color"];?>;">
							<?if ($fields["header_right"] != "") {?><h2><?=$fields["header_right"];?></h2><?}?>
							<?=$fields["text_right"];?>
						</div>
						<?
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
