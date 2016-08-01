<script src="/js/jquery.touchSwipe.min.js" type="text/javascript"></script>
<?
if ($properties["back_color"] == "")
	$properties["back_color"] = "FFFFFF";
if ($properties["text_color"] == "")
	$properties["text_color"] = "000000";
?>
<script>
var cycling = 0;
if (typeof(slide_shown) != "object") {
	lmargin = new Array;
	curslide = new Array;
	slide_width = new Array;
	slide_margin = new Array;
	slide_shown = new Array;
}
lmargin[<?=$block_id;?>] = 0;
curslide[<?=$block_id;?>] =  1;
slide_width[<?=$block_id;?>] = 1220;
slide_margin[<?=$block_id;?>] = 0;
slide_shown[<?=$block_id;?>] = 1;
$(document).ready(function() {
	var wdth = $("body").width();
	$(".slide<?=$block_id;?>").css("width", wdth + "px");
	slide_width[<?=$block_id;?>] = wdth;
	$("#slider<?=$block_id;?>").swipe({
		//Generic swipe handler for all directions
		swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
			slider_right(<?=$block_id;?>);
		},
		swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
			slider_left(<?=$block_id;?>);
		},
		//Default is 75px, set to 0 for demo so any distance triggers swipe
	   threshold: 75
	});
});
$(window).resize(function() {
	var wdth = $("body").width();
	$(".slide<?=$block_id;?>").css("width", wdth + "px");
	slide_width[<?=$block_id;?>] = wdth;
});
function slider_go(slider, sl) {
	lmargin[slider] = - (slide_margin[slider] + slide_width[slider]) * (sl - 1);
	var slide_count = $(".sinner" + slider).find(".slide" + slider + ":visible").length;
	$(".sinner" + slider).animate({margin: '0 0 0 ' + lmargin[slider]}, 500);
	$(".bullets" + slider).find(".active").removeClass("active");
	$("#bul_" + slider + "_" + sl).addClass("active");
	curslide[slider] = sl;
	if (sl > 1)
		$(".nav_left" + slider).fadeIn();
	if (sl < slide_count)
		$(".nav_right" + slider).fadeIn();
	if (curslide[slider] <= 1)
		$(".nav_left" + slider).fadeOut(300);
	if (curslide[slider] >= slide_count)
		$(".nav_right" + slider).fadeOut(300);
}
function slider_right(slider) {
	var slide_count = $(".sinner" + slider).find(".slide" + slider + ":visible").length;
	var limit = (slide_count - slide_shown[slider]) * (slide_margin[slider] + slide_width[slider]);
	if (lmargin[slider] > -limit) {
		lmargin[slider] = lmargin[slider] - (slide_margin[slider] + slide_width[slider]);
		$(".sinner" + slider).animate({margin: '0 0 0 ' + lmargin[slider]}, 500);
		$(".bullets" + slider).find(".active").removeClass("active");
		curslide[slider]++;
		$(".bullets" + slider).find(".active").removeClass("active");
		$("#bul_" + slider + "_" + curslide[slider]).addClass("active");
		$(".nav_left" + slider).fadeIn(300);
	}
	else {
		if (cycling == 1) {
			// зацикливание
			lmargin[slider] = 0;
			$(".sinner" + slider).animate({margin: '0 0 0 ' + lmargin[slider]}, 600);
			curslide[slider] = 1;
			$(".bullets" + slider).find(".active").removeClass("active");
			$("#bul_" + slider + "_" + curslide[slider]).addClass("active");
		}
		else {
			// без зацикливания
			$(".sinner" + slider).animate({margin: '0 0 0 ' + (lmargin[slider] - 20)}, 200, function() {
				$(".sinner" + slider).animate({margin: '0 0 0 ' + lmargin[slider]}, 200);
			});
		}
	}
	if (curslide[slider] >= slide_count)
		$(".nav_right" + slider).fadeOut(300);
}
function slider_left(slider) {
	var slide_count = $(".sinner" + slider).find(".slide" + slider + ":visible").length + 1;
	if (lmargin[slider] < 0) {
		lmargin[slider] = lmargin[slider] + (slide_margin[slider] + slide_width[slider]);
		$(".sinner" + slider).animate({margin: '0 0 0 ' + lmargin[slider]}, 500);
		curslide[slider]--;
		$(".bullets" + slider).find(".active").removeClass("active");
		$("#bul_" + slider + "_" + curslide[slider]).addClass("active");
		$(".nav_right" + slider).fadeIn(300);
	}
	else {
		if (cycling == 1) {
			// зацикливание
			lmargin[slider] = -(slide_count - slide_shown[slider]) * (slide_margin[slider] + slide_width[slider]);
			$(".sinner" + slider).animate({margin: '0 0 0 ' + lmargin[slider]}, 600);
			curslide[slider] = slide_count;
			$(".bullets" + slider).find(".active").removeClass("active");
			$("#bul_" + slider + "_" + curslide[slider]).addClass("active");
		}
		else {
			// без зацикливания
			$(".sinner" + slider).animate({margin: '0 0 0 20'}, 200, function() {
				$(".sinner" + slider).animate({margin: '0 0 0 0'}, 200);
			});
		}
	}
	if (curslide[slider] <= 1)
		$(".nav_left" + slider).fadeOut(300);
}
</script>
<div class="slider slider<?=$block_id;?>" id="slider<?=$block_id;?>" style="<?if ($fields["back"] != "") {?>background-image: url('/images/data/<?=$fields["back"];?>');<?}else{?>background-color: #<?=str_replace("#", "", $properties["back_color"]);?>;<?}?>">
	<?if ($fields["header"] != "") {?><h2 style="color: #<?=str_replace("#", "", $properties["text_color"]);?>;"><?=$fields["header"];?></h2><?}?>
	<?if ($fields["text"] != "") {?><div class="txt" style="color: #<?=str_replace("#", "", $properties["text_color"]);?>;"><?=$fields["text"];?></div><?}?>
	<div class="slider_">
		<div class="scontainer">
			<div class="sinner sinner<?=$block_id;?>">
				<?
				$mcnt = 0;
				foreach ($subfields as $subfield)
					{
					$mcnt++;
					?>
					<div class="slide slide<?=$block_id;?>">
						<img src="/images/data/<?=$subfield["picture"];?>" />
					</div>
					<?
				}
				?>
			</div>
		</div>
		<?
		if (count($subfields) > 1)
			{
			?>
			<div class="nav_left nav_left<?=$block_id;?>" onClick="slider_left(<?=$block_id;?>);"><img src="/images/arrleft.png" /></div>
			<div class="nav_right nav_right<?=$block_id;?>" onClick="slider_right(<?=$block_id;?>);"><img src="/images/arrright.png" /></div>
			<div class="bullets bullets<?=$block_id;?> group">
				<?
				$mcnt = 0;
				foreach ($subfields as $subfield)
					{
					$mcnt++;
					?>
					<div class="bullet<?if ($mcnt == 1) {?> active<?}?>" id="bul_<?=$block_id;?>_<?=$mcnt;?>" onClick="slider_go(<?=$block_id;?>, <?=$mcnt;?>);"></div>
					<?
				}
				?>
			</div>
			<?
		}
		?>
	</div>
</div>
