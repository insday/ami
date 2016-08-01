<script src="/js/jquery.touchSwipe.min.js" type="text/javascript"></script>
<?
if ($properties["back_color_left"] == "")
	$properties["back_color_left"] = "FFFFFF";
if ($properties["back_color_right"] == "")
	$properties["back_color_right"] = "FFFFFF";
if ($properties["text_color"] == "")
	$properties["text_color"] = "000000";
?>
<script>
var cursld = 1;
var sldtot = 1;
$(document).ready(function() {
	sldtot = $(".sldesc_left_").length;
	$("#sldesc").swipe({
		//Generic swipe handler for all directions
		swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
			sl_right();
		},
		swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
			sl_left();
		},
		//Default is 75px, set to 0 for demo so any distance triggers swipe
	   threshold: 75
	});
});
function sld_right() {
	if (cursld < sldtot) {
		$(".sldesc_left_:not(#sldl" + cursld + "):not(#sldr" + cursld + ")").css("z-index", 1).css("opacity", 0);
		$("#sldl" + cursld).css("z-index", 2);
		$("#sldr" + cursld).css("z-index", 2);
		var prevsld = cursld;
		cursld++;
		$("#sldl" + cursld).css("z-index", 3).css("opacity", 1);
		$("#sldr" + cursld).css("z-index", 3).css("opacity", 1);
		$("#sldl" + prevsld).css("opacity", 0);
		$("#sldr" + prevsld).css("opacity", 0);
		/*
		setTimeout(function () {
			$("#sldl" + prevsld).css("opacity", 0);
			$("#sldr" + prevsld).css("opacity", 0);
		}, 200);
		*/
		$("#sldnum").text(cursld);
	}
}
function sld_left() {
	if (cursld > 1) {
		$(".sldesc_left_:not(#sldl" + cursld + "):not(#sldr" + cursld + ")").css("z-index", 1).css("opacity", 0);
		$("#sldl" + cursld).css("z-index", 2);
		$("#sldr" + cursld).css("z-index", 2);
		var prevsld = cursld;
		cursld--;
		$("#sldl" + cursld).css("z-index", 3).css("opacity", 1);
		$("#sldr" + cursld).css("z-index", 3).css("opacity", 1);
		$("#sldl" + prevsld).css("opacity", 0);
		$("#sldr" + prevsld).css("opacity", 0);
		/*
		setTimeout(function () {
			$("#sldl" + prevsld).css("opacity", 0);
			$("#sldr" + prevsld).css("opacity", 0);
		}, 200);
		*/
		$("#sldnum").text(cursld);
	}
}
</script>
<div class="sldesc group">
	<div class="sldesc_left" style="background-color: #<?=str_replace("#", "", $properties["back_color_left"]);?>;">
		<?
		$mcnt = 0;
		foreach ($subfields as $subfield)
			{
			$mcnt++;
			?>
			<div class="sldesc_left_" id="sldl<?=$mcnt;?>"<?if ($mcnt == 1) {?> style="z-index: 3; opacity: 1;"<?}?>>
				<img src="/images/data/<?=$subfield["picture"];?>" />
			</div>
			<?
		}
		?>
	</div>
	<div class="sldesc_right" style="background-color: #<?=str_replace("#", "", $properties["back_color_right"]);?>;">
		<div class="sldesc_num">
			<span id="sldnum">1</span> / <span><?=$mcnt;?></span>
		</div>
		<div class="sldesc_nav">
			<div class="sldesc_nav_l" onClick="sld_left();">&lt;</div>
			<div class="sldesc_nav_r" onClick="sld_right();">&gt;</div>
		</div>
		<?
		$mcnt = 0;
		foreach ($subfields as $subfield)
			{
			$mcnt++;
			?>
			<div class="sldesc_right_" id="sldr<?=$mcnt;?>"<?if ($mcnt == 1) {?> style="z-index: 3; opacity: 1;"<?}?>>
				<h2 style="color: #<?=str_replace("#", "", $properties["text_color"]);?>;"><?=$subfield["header"];?></h2>
				<div class="sldtext" style="color: #<?=str_replace("#", "", $properties["text_color"]);?>;"><?=$subfield["text"];?></div>
			</div>
			<?
		}
		?>
	</div>
</div>
