<?
if ($fields["back_color"] == "")
	$fields["back_color"] = "transparent";
else
	$fields["back_color"] = "#".str_replace("#", "", $fields["back_color"]);

if ($fields["text_color"] == "")
	$fields["text_color"] = "#999999";
else
	$fields["text_color"] = "#".str_replace("#", "", $fields["text_color"]);
?>
<div class="uniicons" style="background-color: <?=$fields["back_color"];?>;">
	<?
	if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back"]))
		{
		?>
		<div class="uni_back"><img src="/images/data/<?=$fields["back"];?>" /></div>
		<?
	}
	?>
	<div<?if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back"])) {?> style="position: absolute; top: 0; left: 0;"<?}?>>
		<?if ($fields["header"] != "") {?><h2><?=$fields["header"];?></h2><?}?>
		<div class="uniicons_ group">
			<?
			$wd = 100/count($subfields);
			foreach ($subfields as $iid => $icon)
				{
				?>
				<div class="uniicon" style="width: <?=$wd;?>%;">
					<div class="uniicon_table">
						<div class="uniicon_row">
							<div class="uniicon_cell uniicon_middle">
								<img src="/images/data/<?=$icon["icon"];?>" />
							</div>
						</div>
						<div class="uniicon_row">
							<div class="uniicon_cell uniicon_top">
								<div class="uniicon_desc"><?=$icon["iheader"];?></div>
								<div  class="uniicon_txt"><?=stripslashes(nl2br($icon["itext"]));?></div>
							</div>
						</div>
					</div>
				</div>
				<?
			}
			?>
		</div>
	</div>
</div>
