<script>
slide_shown = new Array;
slide_shown[<?=$block_id;?>] = 1;
lmargin = new Array;
curslide = new Array;
slide_width = new Array;
slide_margin = new Array;
lmargin[<?=$block_id;?>] = 0;
curslide[<?=$block_id;?>] =  1;
slide_width[<?=$block_id;?>] = 1000;
slide_margin[<?=$block_id;?>] = 0;
$(document).ready(function() {
	var wdth = $("body").width();
	$(".cov_slide<?=$block_id;?>").css("width", wdth);
	slide_width[<?=$block_id;?>] = wdth;
});
$(window).resize(function() {
	var wdth = $("body").width();
	$(".cov_slide<?=$block_id;?>").css("width", wdth);
	slide_width[<?=$block_id;?>] = wdth;
});
var cov_navl = 0;
var cov_navr = 1;
function show() {
	$(".cov_left").animate({marginLeft: -300}, 800);
	$(".cov_browse").animate({marginBottom: -300, opacity: 0}, 800);
	$(".cov_right").animate({marginRight: -300}, 800);
	$(".cover_top h1").fadeOut(300);
	$(".cover_top h4").fadeOut(300);
	$(".cover_top_").css("opacity", "1");
	if (cov_navl == 1)
		$(".cov_navl").fadeIn(500);
	if (cov_navr == 1)
		$(".cov_navr").fadeIn(500);
	$(".cov_close").fadeIn(500);
	var wdth = $("body").width();
	var prop = 1400/660;
	var hght = wdth/prop;
	$(".cover_top").css("height", hght + "px");
	$(".cov_slider").css("height", hght + "px");
	$(".cover_in").swipe({
		//Generic swipe handler for all directions
		swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
			slider_right(4);
		},
		swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
			slider_left(4);
		},
		//Default is 75px, set to 0 for demo so any distance triggers swipe
	   threshold: 75
	});
}
function cov_back_l() {
	if (cpic > 0) {
		cpic = cpic - 1;
		$(".cover_top_").css("backgroundImage", "url('/images/data/" + pictures[cpic] + "')");
	}
	if (cpic == 0) {
		$(".cov_navl").fadeOut(500);
		cov_navl = 0;
	}
	if (cpicmax > 0) {
		$(".cov_navr").fadeIn(500);
		cov_navr = 1;
	}
}
function cov_back_r() {
	if (cpic < cpicmax - 1) {
		cpic = cpic + 1;
		$(".cover_top_").css("backgroundImage", "url('/images/data/" + pictures[cpic] + "')");
	}
	if (cpic == cpicmax - 1) {
		$(".cov_navr").fadeOut(500);
		cov_navr = 0;
	}
	if (cpicmax > 0) {
		$(".cov_navl").fadeIn(500);
		cov_navl = 1;
	}
}
function cov_close() {
	$(".cov_menu").animate({marginLeft: 0}, 800);
	$(".cov_browse").animate({marginBottom: 0, opacity: 1}, 800);
	$(".cov_time").animate({marginRight: 0}, 800);
	$(".cover_top h1").fadeIn(300);
	$(".cover_top h4").fadeIn(300);
	$(".cover_top_").css("opacity", "0.5");
	$(".cov_navr").fadeOut(500);
	$(".cov_navl").fadeOut(500);
	$(".cov_close").fadeOut(500);
	$(".cover_top").css("height", "500px");
}
function cov_slider_right(slider) {
	var slide_count = $(".cov_inner" + slider).find(".cov_slide" + slider + ":visible").length;
	var limit = (slide_count - slide_shown[slider]) * (slide_margin[slider] + slide_width[slider]);
	if (lmargin[slider] > -limit) {
		lmargin[slider] = lmargin[slider] - (slide_margin[slider] + slide_width[slider]);
		$(".cov_inner" + slider).animate({margin: '0 0 0 ' + lmargin[slider]}, 500);
		$(".cov_bullets" + slider).find(".active").removeClass("active");
		curslide[slider]++;
		$(".cov_bullets" + slider).find(".active").removeClass("active");
		$("#cov_bul_" + slider + "_" + curslide[slider]).addClass("active");
		$(".cov_nav_left").fadeIn(300);
		cov_navl = 1;
	}
	else {
		if (cycling == 1) {
			// зацикливание
			lmargin[slider] = 0;
			$(".cov_inner" + slider).animate({margin: '0 0 0 ' + lmargin[slider]}, 600);
			curslide[slider] = 1;
			$(".cov_bullets" + slider).find(".active").removeClass("active");
			$("#cov_bul_" + slider + "_" + curslide[slider]).addClass("active");
		}
		else {
			// без зацикливания
			$(".cov_inner" + slider).animate({margin: '0 0 0 ' + (lmargin[slider] - 20)}, 200, function() {
				$(".cov_inner" + slider).animate({margin: '0 0 0 ' + lmargin[slider]}, 200);
			});
		}
	}
	if (curslide[slider] >= slide_count) {
		$(".cov_nav_right").fadeOut(300);
		cov_navr = 0;
	}
}
function cov_slider_left(slider) {
	var slide_count = $(".cov_inner" + slider).find(".cov_slide" + slider + ":visible").length + 1;
	if (lmargin[slider] < 0) {
		lmargin[slider] = lmargin[slider] + (slide_margin[slider] + slide_width[slider]);
		$(".cov_inner" + slider).animate({margin: '0 0 0 ' + lmargin[slider]}, 500);
		curslide[slider]--;
		$(".cov_bullets" + slider).find(".active").removeClass("active");
		$("#cov_bul_" + slider + "_" + curslide[slider]).addClass("active");
		$(".cov_nav_right").fadeIn(300);
		cov_navr = 1;
	}
	else {
		if (cycling == 1) {
			// зацикливание
			lmargin[slider] = -(slide_count - slide_shown[slider]) * (slide_margin[slider] + slide_width[slider]);
			$(".cov_inner" + slider).animate({margin: '0 0 0 ' + lmargin[slider]}, 600);
			curslide[slider] = slide_count;
			$(".cov_bullets" + slider).find(".active").removeClass("active");
			$("#cov_bul_" + slider + "_" + curslide[slider]).addClass("active");
		}
		else {
			// без зацикливания
			$(".cov_inner" + slider).animate({margin: '0 0 0 20'}, 200, function() {
				$(".cov_inner" + slider).animate({margin: '0 0 0 0'}, 200);
			});
		}
	}
	if (curslide[slider] <= 1) {
		$(".cov_nav_left").fadeOut(300);
		cov_navl = 0;
	}
}
<?
$pictures = explode("=", $fields["picture"]);
?>
pictures = new Array();
<?
foreach ($pictures as $picture)
	{
	?>
	pictures[pictures.length] = "<?=$picture;?>";
	<?
}
?>
cpic = 0;
cpicmax = pictures.length;
</script>
<div class="cover_top">
	<div class="cover_top_">
		<div class="cov_slider cov_slider<?=$block_id;?>">
			<div class="cov_container cov_container<?=$block_id;?>">
				<div class="cov_inner cov_inner<?=$block_id;?>">
				<?
				foreach ($pictures as $picture)
					{
					?>
					<div class="cov_slide cov_slide<?=$block_id;?>"><img src="/images/data/<?=$picture;?>" /></div>
					<?
				}
				?>
				</div>
			</div>
		</div>
	</div>
	<div class="cover_in">
		<h1><?=$fields["header"];?></h1>
		<h4><?=$fields["subheader"];?></h4>
	</div>
	<?if ($fields["text_left"] != "") {?><div class="cov_left"><img src="/images/data/<?=$fields["icon_left"];?>" /><?=$fields["text_left"];?></div><?}?>
	<div class="cov_browse" onClick="show();"><?=$fields["view_text"];?></div>
	<?if ($fields["text_right"] != "") {?><div class="cov_right"><img src="/images/data/<?=$fields["icon_right"];?>" /><?=$fields["text_right"];?></div><?}?>
	<div class="cov_close" onClick="cov_close();"><img src="/images/close1_.png" /></div>
	<div class="cov_nav_left cov_navl" onClick="cov_slider_left(<?=$block_id;?>);"><img src="/images/arrl_.png" /></div>
	<div class="cov_nav_right cov_navr" onClick="cov_slider_right(<?=$block_id;?>);"><img src="/images/arrr_.png" /></div>
</div>
