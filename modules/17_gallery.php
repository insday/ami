<?
if ($properties["back_color"] == "")
	$properties["back_color"] = "transparent";
else
	$properties["back_color"] = "#".str_replace("#", "", $properties["back_color"]);

if ($properties["text_color"] == "")
	$properties["text_color"] = "#333333";
else
	$properties["text_color"] = "#".str_replace("#", "", $properties["text_color"]);

foreach ($subfields as $subfield)
	{
	$arr_types = explode("^", $subfield["type"]);
	foreach ($arr_types as $type)
		{
		if ($type != str_replace("*", "", $type))
			$curtype = str_replace("*", "", $type);
	}
	$galleries[$curtype][] = $subfield;
}
?>
<script>
$(document).ready(function() {
	var options = {
		addActiveClass: true,
		arrowsNav: false,
		controlNavigation: 'bullets',
		autoScaleSlider: true, 
		autoScaleSliderHeight: 400,
		loop: true,
		fadeinLoadedSlide: false,
		globalCaption: true,
		keyboardNavEnabled: true,
		globalCaptionInside: false,

		visibleNearby: {
		  enabled: true,
		  centerArea: 0.7,
		  center: true,
		  breakpoint: 1024,
		  breakpointCenterArea: 0.6,
		  navigateByCenterClick: true
		}
	};
	jQuery(document).ready(function($) {
		<?
		$gcnt = 0;
		foreach ($galleries as $tid => $gallery)
			{
			$gcnt++;
			?>
			var si<?=$gcnt;?> = $('#gallery_<?=$gcnt;?>').royalSlider(options).data('royalSlider');
			<?
		}
		?>
	});
});
</script>
<div class="galleries galleries<?=$block_id;?> amiblock" style="<?if (!is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$properties["back_image"])) {?>background-image: url('/images/data/<?=$properties["back_image"];?>');<?}else{?>background-color: <?=$properties["back_color"];?>;<?}?>">
	<h2><?=$fields["header"];?></h2>
	<div class="g_text"><?=$fields["text"];?></div>
	<?
	if (count($galleries) > 1)
		{
		?>
		<div class="galnavs group">
			<?
			$gcnt = 0;
			foreach ($galleries as $typename => $gallery)
				{
				$gcnt++;
				?>
				<div class="galnav<?if ($gcnt == 1) {?> active<?}?>" onClick="$('.galnav.active').removeClass('active'); $(this).addClass('active'); $('.gal:visible').fadeOut(300, function() {$('.gal<?=$gcnt;?>').fadeIn(300);});"><?=$typename;?></div>
				<?
			}
			?>
		</div>
		<?
	}
	$gcnt = 0;
	foreach ($galleries as $typename => $gallery)
		{
		$gcnt++;
		?>
		<div id="gallery_<?=$gcnt;?>" class="gal gal<?=$gcnt;?> royalSlider rsDefault visibleNearby"<?if ($gcnt != 1) {?> style="display: none;"<?}?>>
			<?
			foreach ($gallery as $gid => $image)
				{
				?>
				<div class="rsContent">
					<img class="rsImg" src="images/data/<?=$image["image"];?>" />
					<?if ($image["descr"] != "") {?><div class="rsABlock" data-move-effect="bottom"><?=$image["descr"];?></div><?}?>
				</div>
				<?
			}
			?>
		</div>
		<?
	}
	?>
</div>
