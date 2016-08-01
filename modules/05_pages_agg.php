<?
$agg_slides = 3;
?>
<script>
agg_slide_shown = new Array;
agg_slide_shown[<?=$block_id;?>] = 3;
agg_lmargin = new Array;
agg_curslide = new Array;
agg_slide_width = new Array;
agg_slide_margin = new Array;
agg_lmargin[<?=$block_id;?>] = 0;
agg_curslide[<?=$block_id;?>] =  1;
agg_slide_width[<?=$block_id;?>] = 1000;
agg_slide_margin[<?=$block_id;?>] = 0;
$(document).ready(function() {
	var wdth = $(".aggregs_div_").width();
	$(".agg_slide<?=$block_id;?>").css("width", wdth/3 + "px");
	agg_slide_width[<?=$block_id;?>] = wdth/3;
});
$(window).resize(function() {
	var wdth = $(".aggregs_div_").width();
	$(".agg_slide<?=$block_id;?>").css("width", wdth/3 + "px");
	agg_slide_width[<?=$block_id;?>] = wdth/3;
});
function agg_slider_right(slider) {
	var slide_count = $(".agg_inner" + slider).find(".agg_slide" + slider + ":visible").length;
	var limit = (slide_count - agg_slide_shown[slider]) * (agg_slide_margin[slider] + agg_slide_width[slider]);
	if (agg_lmargin[slider] > -limit) {
		agg_lmargin[slider] = agg_lmargin[slider] - (agg_slide_margin[slider] + agg_slide_width[slider]);
		$(".agg_inner" + slider).animate({margin: '0 0 0 ' + agg_lmargin[slider]}, 500);
		$(".agg_bullets" + slider).find(".active").removeClass("active");
		agg_curslide[slider]++;
		$(".agg_bullets" + slider).find(".active").removeClass("active");
		$("#agg_bul_" + slider + "_" + agg_curslide[slider]).addClass("active");
		$(".agg_nav_left").fadeIn(300);
	}
	else {
		if (cycling == 1) {
			// зацикливание
			agg_lmargin[slider] = 0;
			$(".agg_inner" + slider).animate({margin: '0 0 0 ' + agg_lmargin[slider]}, 600);
			agg_curslide[slider] = 1;
			$(".agg_bullets" + slider).find(".active").removeClass("active");
			$("#agg_bul_" + slider + "_" + agg_curslide[slider]).addClass("active");
		}
		else {
			// без зацикливания
			$(".agg_inner" + slider).animate({margin: '0 0 0 ' + (agg_lmargin[slider] - 20)}, 200, function() {
				$(".agg_inner" + slider).animate({margin: '0 0 0 ' + agg_lmargin[slider]}, 200);
			});
		}
	}
	if (agg_curslide[slider] >= slide_count)
		$(".agg_nav_right").fadeOut(300);
}
function agg_slider_left(slider) {
	var slide_count = $(".agg_inner" + slider).find(".agg_slide" + slider + ":visible").length + 1;
	if (agg_lmargin[slider] < 0) {
		agg_lmargin[slider] = agg_lmargin[slider] + (agg_slide_margin[slider] + agg_slide_width[slider]);
		$(".agg_inner" + slider).animate({margin: '0 0 0 ' + agg_lmargin[slider]}, 500);
		agg_curslide[slider]--;
		$(".agg_bullets" + slider).find(".active").removeClass("active");
		$("#agg_bul_" + slider + "_" + agg_curslide[slider]).addClass("active");
		$(".agg_nav_right").fadeIn(300);
	}
	else {
		if (cycling == 1) {
			// зацикливание
			agg_lmargin[slider] = -(slide_count - agg_slide_shown[slider]) * (agg_slide_margin[slider] + agg_slide_width[slider]);
			$(".agg_inner" + slider).animate({margin: '0 0 0 ' + agg_lmargin[slider]}, 600);
			agg_curslide[slider] = slide_count;
			$(".agg_bullets" + slider).find(".active").removeClass("active");
			$("#agg_bul_" + slider + "_" + agg_curslide[slider]).addClass("active");
		}
		else {
			// без зацикливания
			$(".agg_inner" + slider).animate({margin: '0 0 0 20'}, 200, function() {
				$(".agg_inner" + slider).animate({margin: '0 0 0 0'}, 200);
			});
		}
	}
	if (agg_curslide[slider] <= 1)
		$(".agg_nav_left").fadeOut(300);
}
</script>
<div class="aggregs_div amiblock">
	<div class="aggregs_div_">
		<h2><?=$fields["header"];?></h2>
		<?
		if (1 == 2 && ($fields["limit"] == 0 || $fields["limit"] > $agg_slides) && count($subfields) > $agg_slides)
			{
			?>
			<button onClick="agg_slider_left(<?=$block_id;?>);"><img src="/images/orarr_.png" /></button>
			<button onClick="agg_slider_right(<?=$block_id;?>);"><img src="/images/orarr.png" /></button>
			<?
		}
		?>
		<div class="agg_slider agg_slider<?=$block_id;?>">
			<div class="agg_container agg_container<?=$block_id;?>">
				<div class="agg_inner agg_inner<?=$block_id;?>">
					<?
					$mcnt = 0;
					foreach ($subfields as $sid => $subfield)
						{
						$mcnt++;
						if ($fields["limit"] == 0 || $mcnt < $fields["limit"])
							{
							?>
							<div class="agg_slide agg_slide<?=$block_id;?>" data-last="0">
								<div class="aggreg" onClick="document.location='<?=$subfield["url_p"];?>';">
									<div class="aggregimg">
										<img src="/images/data/<?=$subfield["image_p"];?>" />
									</div>
									<h4><?=$subfield["header_p"];?></h4>
									<div class="p_text"><?=$subfield["text_p"];?></div>
									<button>Подробнее</button>
									<div class="aggreg_action group">
										<div class="aggreg_price"><span><?=$subfield["price"];?> р.</span><br />Цена за сутки</div>
									</div>
								</div>
								<div class="aggreg_button"><button onClick="$('#fld5').val('<?=$subfield["header_p"];?>'); $('.mask').fadeIn(300); $('.form').fadeIn(300); return false;">Бронировать</button></div>
							</div>
							<?
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
