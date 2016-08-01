<script>
function getnew() {
	$(".grid_type").removeClass("sel");
	$(".type_new").addClass("sel");
	$(".grid_cell:not(.new)").fadeOut(300).promise().done(function() {
		$(".new").fadeIn(300);
	});
}
function gettype(type) {
	$(".grid_type").removeClass("sel");
	$(".type" + type).addClass("sel");
	$(".grid_cell:not(.type" + type + ")").fadeOut(300).promise().done(function() {
		$(".type" + type).fadeIn(300);
	});
}
</script>
<?
if ($properties["back_color"] == "")
	$properties["back_color"] = "FFFFFF";
if ($properties["text_color"] == "")
	$properties["text_color"] = "000000";

// $fields["url"] = "http://".str_replace("http://", "", $fields["url"]);
?>
<div class="grid" style="background-color: #<?=str_replace("#", "", $properties["back_color"]);?>;">
	<?if ($fields["url"] != "") {?><a href="<?=$fields["header"];?>"><?}?><h2><?=$fields["header"];?></h2><?if ($fields["url"] != "") {?></a><?}?>
	<?
	$new = 0;
	foreach ($subfields as $subfield)
		{
		if ($subfield["new"] != "")
			$new = 1;
		if ($subfield["type"] != "")
			$arr_types = explode("^", str_replace("*", "", $subfield["type"]));
	}
	?>
	<div class="grid_types">
		<?
		if ($new == 1)
			{
			?>
			<div class="grid_type type_new" onClick="getnew();">Все новые</div>
			<?
		}
		$tcnt = 0;
		foreach ($arr_types as $arr_type)
			{
			$tcnt++;
			?>
			<div class="grid_type type<?=$tcnt;?>" onClick="gettype(<?=$tcnt;?>);"><?=$arr_type;?></div>
			<?
		}
		?>
	</div>
	<div class="grid_table group">
		<?
		foreach ($subfields as $subfield)
			{
			$type = "";
			$arr_types_ = explode("^", $subfield["type"]);
			$tcnt = 0;
			foreach ($arr_types_ as $arr_type_)
				{
				$tcnt++;
				if ($arr_type_ != str_replace("*", "", $arr_type_))
					$type = $tcnt;
			}
			?>
			<div class="grid_cell<?if ($subfield["new"] == 1) {?> new<?}?> type<?=$type;?>"<?if ($subfield["url"] != "") {?> onClick="document.location='<?=$subfield["url"];?>'"<?}?>>
				<?
				if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$subfield["image"]))
					{
					?>
					<div class="grid_img"><img src="/images/data/<?=$subfield["image"];?>" /></div>
					<?
				}
				?>
				<div class="grid_text">
					<h2><?=$subfield["header"];?></h2>
					<div class="txt"><?=$subfield["text"];?></div>
				</div>
			</div>
			<?
		}
		?>
	</div>
</div>
