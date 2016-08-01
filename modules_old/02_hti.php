<?
if ($properties["back_color"] == "")
	$properties["back_color"] = "FFFFFF";
if ($properties["text_color"] == "")
	$properties["text_color"] = "000000";
?>
<div class="hti" style="background-color: #<?=str_replace("#", "", $properties["back_color"]);?>; <?if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back"]) && is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["image"])) {?> background-image: url('/images/data/<?=$fields["back"];?>');<?}?>">
	<?
	if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back"]) && !is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["image"]))
		{
		?>
		<div class="hti_back"><img src="/images/data/<?=$fields["back"];?>" /></div>
		<?
		}
	?>
	<div class="hti_on"<?if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["back"]) && !is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["image"])) {?> style="position: absolute;	top: 0; left: 0; padding: 8% 0;"<?}?>>
		<div class="hti_table">
			<div class="hti_cell">
				<?if ($fields["header"] != "") {?><h2 style="color: #<?=str_replace("#", "", $properties["text_color"]);?>;"><?=$fields["header"];?></h2><?}?>
				<?if ($fields["text"] != "") {?><div class="txt" style="color: #<?=str_replace("#", "", $properties["text_color"]);?>;"><?=$fields["text"];?></div><?}?>
				<?
				if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["image"]))
					{
					?>
					<img src="/images/data/<?=$fields["image"];?>" />
					<?
				}
				?>
			</div>
		</div>
	</div>
</div>
