<?
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
<div class="uni">
	<div class="uni_on"<?if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back"])) {?> style="position: absolute;	top: 0; left: 0;"<?}?>>
		<div class="uni_table">
			<div class="goals_left" style="background-color: <?=$properties["back_color_left"];?>;">
				<div class="uni_in" style="color: <?=$properties["text_color"];?>;">
					<h3><?=$fields["header1"];?></h3>
					<div class="uni_margined">
						<?=$fields["text1"];?>
						<h3><?=$fields["header2"];?></h3>
						<?=$fields["text2"];?>
					</div>
				</div>
			</div>
			<div class="goals_right" style="background-color: <?=$properties["back_color_right"];?>;">
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
				?>
			</div>
		</div>
	</div>
</div>
