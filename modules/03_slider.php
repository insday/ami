<script>
lmargin = new Array;
curslide = new Array;
slide_width = new Array;
slide_margin = new Array;
slide_shown = new Array;
lmargin[<?=$block_id;?>] = 0;
curslide[<?=$block_id;?>] =  1;
slide_width[<?=$block_id;?>] = 1000;
slide_margin[<?=$block_id;?>] = 0;
slide_shown[<?=$block_id;?>] = 1;
$(window).resize(function() {
	var wdth = $("body").width();
	$(".slide<?=$block_id;?>").css("width", wdth + "px");
	slide_width[<?=$block_id;?>] = wdth;
});
$(document).ready(function() {
	var wdth = $("body").width();
	$(".slide<?=$block_id;?>").css("width", wdth + "px");
	slide_width[<?=$block_id;?>] = wdth;
});
function slider_go1(slider, sl) {
	$(".snext").removeClass("snext");
	$(".scurrent").removeClass("scurrent").addClass("snext");
	$(".sl" + sl).css("opacity", 0);
	$(".sl" + sl).addClass("scurrent");
	$(".bullets" + slider).find(".active").removeClass("active");
	$("#bul_" + slider + "_" + sl).addClass("active");
	curslide[slider] = sl;
	$(".sl" + sl).animate({"opacity": 1}, 700);
}
function slider_go(slider, sl) {
	lmargin[slider] = - (slide_margin[slider] + slide_width[slider]) * (sl - 1);
	var slide_count = $(".sinner" + slider).find(".slide" + slider + ":visible").length;
	$(".sinner" + slider).animate({margin: '0 0 0 ' + lmargin[slider]}, 500);
	$(".bullets" + slider).find(".active").removeClass("active");
	$("#bul_" + slider + "_" + sl).addClass("active");
	curslide[slider] = sl;
	if (sl > 1)
		$(".nav_left").fadeIn();
	if (sl < slide_count)
		$(".nav_right").fadeIn();
	if (curslide[slider] <= 1)
		$(".nav_left").fadeOut(300);
	if (curslide[slider] >= slide_count)
		$(".nav_right").fadeOut(300);
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
		$(".nav_left").fadeIn(300);
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
		$(".nav_right").fadeOut(300);
}
function slider_left(slider) {
	var slide_count = $(".sinner" + slider).find(".slide" + slider + ":visible").length + 1;
	if (lmargin[slider] < 0) {
		lmargin[slider] = lmargin[slider] + (slide_margin[slider] + slide_width[slider]);
		$(".sinner" + slider).animate({margin: '0 0 0 ' + lmargin[slider]}, 500);
		curslide[slider]--;
		$(".bullets" + slider).find(".active").removeClass("active");
		$("#bul_" + slider + "_" + curslide[slider]).addClass("active");
		$(".nav_right").fadeIn(300);
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
		$(".nav_left").fadeOut(300);
}
</script>
<!--<div class="slider1 slider<?=$block_id;?>">
	<div class="scontainer1 scontainer<?=$block_id;?>">
		<div class="sinner1 sinner<?=$block_id;?>">
			<?
			$mcnt = 0;
			foreach ($subfields as $subfield)
				{
				$mcnt++;
				?>
				<div class="slide1 slide<?=$block_id;?>" style="background-image: url('/images/data/<?=$subfield["picture"];?>');">
					<?if ($subfield["header"] != "") {?><h5><?=$subfield["header"];?></h5><?}?>
					<?if ($subfield["text"] != "") {?><div class="slidertxt"><?=$subfield["text"];?></div><?}?>
					<?if ($subfield["url"] != "") {?><a href="<?=$subfield["url"];?>"><button>Подробнее</button></a><?}?>
				</div>
				<?
			}
			?>
		</div>
	</div>
	<div class="nav_left" onClick="slider_left(<?=$block_id;?>);"><img src="/images/arrl_.png" /></div>
	<div class="nav_right" onClick="slider_right(<?=$block_id;?>);"><img src="/images/arrr_.png" /></div>
	<div class="bullets1 group">
		<?
		$mcnt = 0;
		foreach ($subfields as $subfield)
			{
			$mcnt++;
			?>
			<div class="bullet1 bullet<?=$block_id;?><?if ($mcnt == 1) {?> active<?}?>" id="bul_<?=$block_id;?>_<?=$mcnt;?>" onClick="slider_go(<?=$block_id;?>, <?=$mcnt;?>);"></div>
			<?
		}
		?>
	</div>
</div>
-->
	<div class="slider_div">
		<div class="slider1">
			<div class="scontainer1">
				<div class="sinner1">
					<div class="slide1 sl1 scurrent">
						<div class="slideimg"><img src="images/slide_back1.jpg" /></div>
						<div class="shadow"></div>
						<div class="shadow1"></div>
						<div class="onslide">
							<h5>Санаторий<br />«Зеленый мыс»</h5>
							<h6>Красота природы для спорта, лечения, отдыха</h6>
							<div class="slidetxt">Cанаторий "зеленый мыс"- это уникальная здравница, многопрофильного круглогодичного действия, расположенная на территории 453 га на берегу верх-нейвинского пруда.</div>
						</div>
					</div>
					<div class="slide1 sl2">
						<div class="slideimg"><img src="images/slide_back2.jpg" /></div>
						<div class="shadow"></div>
						<div class="shadow1"></div>
						<div class="onslide">
							<h5>Тренировочные<br />условия спортсменам</h5>
							<h6>Тренировки, проживание,<br />восстановление</h6>
							<div class="slidetxt">Cанаторий "зеленый мыс"- это уникальная здравница, многопрофильного круглогодичного действия, расположенная на территории 453 га на берегу верх-нейвинского пруда.</div>
						</div>
					</div>
					<div class="slide1 sl3">
						<div class="slideimg"><img src="images/slide_back3.jpg" /></div>
						<div class="shadow"></div>
						<div class="shadow1"></div>
						<div class="onslide">
							<h5>Развлечения<br />и семейный отдых</h5>
							<h6>Прогулки, питание<br />и прекрасная природа</h6>
							<div class="slidetxt">Cанаторий "зеленый мыс"- это уникальная здравница, многопрофильного круглогодичного действия, расположенная на территории 453 га на берегу верх-нейвинского пруда.</div>
						</div>
					</div>
					<div class="slide1 sl4">
						<div class="slideimg"><img src="images/slide_back4.jpg" /></div>
						<div class="shadow"></div>
						<div class="shadow1"></div>
						<div class="onslide">
							<h5>Лечебные<br />направления</h5>
							<h6>Восстановление, лечение<br />заболеваний и профилактика</h6>
							<div class="slidetxt">Cанаторий "зеленый мыс"- это уникальная здравница, многопрофильного круглогодичного действия, расположенная на территории 453 га на берегу верх-нейвинского пруда.</div>
						</div>
					</div>
				</div>
			</div>
			<div class="smap" onClick="var hght = $(window).height() - 100; $('.map_container_').css('height', hght);"><img src="images/map_i.png" /></div>
			<!--<div class="nav_left" onClick="slider_left(1);"><img src="/images/arrl_.png" /></div>
			<div class="nav_right" onClick="slider_right(1);"><img src="/images/arrr_.png" /></div>-->
			<div class="bullets1 group">
				<div class="bullet1 active" id="bul_1_1" onClick="slider_go1(1, 1);"><img src="images/sicon_1.png" />САНАТОРИЙ</div>
				<div class="bullet1" id="bul_1_2" onClick="slider_go1(1, 2);"><img src="images/sicon_2.png" />СПОРТСМЕНАМ</div>
				<div class="bullet1" id="bul_1_3" onClick="slider_go1(1, 3);"><img src="images/sicon_3.png" />СЕМЕЙНЫЙ ОТДЫХ</div>
				<div class="bullet1" id="bul_1_4" onClick="slider_go1(1, 4);"><img src="images/sicon_4.png" />ОЗДОРОВЛЕНИЕ</div>
			</div>
		</div>
	</div>
