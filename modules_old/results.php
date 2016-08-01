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

if ($properties["text_color_left"] == "")
	$properties["text_color_left"] = "#999999";
else
	$properties["text_color_left"] = "#".str_replace("#", "", $properties["text_color_left"]);

if ($properties["text_color_right"] == "")
	$properties["text_color_right"] = "#999999";
else
	$properties["text_color_right"] = "#".str_replace("#", "", $properties["text_color_right"]);

if ($fields["url"] != "")
	$fields["url"] = "http://".str_replace("http://", "", str_replace("https://", "", $fields["url"]));
?>
<div class="uni">
	<div class="uni_on"<?if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back"])) {?> style="position: absolute;	top: 0; left: 0;"<?}?>>
		<div class="uni_table">
			<div class="results_left" style="background-color: <?=$properties["back_color_left"];?>;">
				<div class="results_in" style="color: <?=$properties["text_color_left"];?>;">
					<h3><?=$fields["header1"];?></h3>
					<div class="uni_margined">
						<?=$fields["text1"];?>
						<h3><?=$fields["header2"];?></h3>
						<?=$fields["text2"];?>
					</div>
					<?
					if ($fields["url"] != "")
						{
						?>
						<a target="_blank" href="<?=$fields["url"];?>"><button style="background-color:  <?=$properties["back_color_right"];?>; color: <?=$properties["text_color_right"];?>;;"><?=$fields["url_text"];?></button></a>
						<?
					}
					?>
				</div>
			</div>
			<div class="results_right" style="background-color: <?=$properties["back_color_right"];?>;">
				<div class="results_in" style="color: <?=$properties["text_color_right"];?>;">
					<h3><?=$fields["header3"];?></h3>
					<?=$fields["text3"];?>
					<div class="results group">
						<?
						$cnt = 0;
						foreach ($subfields as $subfield)
							{
							if ($cnt++ % 2 == 0)
								{
								?>
								</div>
								<div class="results group">
								<?
							}
							?>
							<div class="result">
								<div class="result_">
									<img src="/images/data/<?=$subfield["picture"];?>" />
									<div class="res"><?=$subfield["ptxt"];?></div>
								</div>
							</div>
							<?
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
