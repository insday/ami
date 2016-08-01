<div class="err"></div>
<script>
function showerr(txt) {
	$(".err").append("<br />" + txt).css("display", "block").fadeOut(3000, function() {$(".err").text("")});
}
var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel";
var pfscroll = 0;
var pfscrolling = 0;
$(window).resize(function() {
	$('.portf_top').css("height", $(window).height());
	$('.portf_back').css("height", $(window).height());
});
$(document).ready(function() {
	$('.portf_top').css("height", $(window).height());
	$('.portf_back').css("height", $(window).height());
	$('.portf_top').bind(mousewheelevt, function(e) {
		if (pfscrolling == 0)
			{
			var evt = window.event || e; //equalize event object     
			evt = evt.originalEvent ? evt.originalEvent : evt; //convert to originalEvent if possible               
			var delta = evt.detail ? evt.detail*(-40) : evt.wheelDelta; //check for detail first, because it is used by Opera and FF
			// var bluring = $(window).scrollTop()/10;
			if (delta > 0) {
				//scroll up
				// showerr("up");
				if (pfscroll == 1 && $(window).scrollTop() < 20) {
					pfscrolling = 1;
					e.preventDefault();
					// showerr("prevent up");
					$(".portf_back").removeClass("blurred");
					$(".portf_top").animate({scrollTop: 0}, 800, function() {
						pfscroll = 0;
						// showerr("pf 0");
						pfscrolling = 0;
					});
				}
				else
					pfscrolling = 0;
			}
			else {
				//scroll down
				if (pfscroll == 0) {
					pfscrolling = 1;
					e.preventDefault();
					// showerr("prevent down");
					$(".portf_back").addClass("blurred");
					$(".portf_top").animate({scrollTop: ($(".phead").height() + 170)}, 800, function() {
						pfscroll = 1;
						// showerr("pf 1");
						pfscrolling = 0;
					});
				}
				else
					pfscrolling = 0;
			}
		}
		else {
			if (pfscroll == 0) {
				e.preventDefault();
			}
		}
	});
});
</script>
<div class="pcont">
	<div id="pbc" class="pbc"><a href="/">Главная</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/#portfolio">Проекты</a>&nbsp;&nbsp;|&nbsp;&nbsp;<?=$fields["work_name"];?></div>
	<div class="close1 group"><div class="pleft"<?if ($prev != "") {?> onClick="document.location='/portfolio/<?=$prev;?>'"<?}else{?> style="visibility: hidden;"<?}?>><img src="/images/arrl.png" /></div><div class="pright" <?if ($next != "") {?> onClick="document.location='/portfolio/<?=$next;?>'"<?}else{?> style="visibility: hidden;"<?}?>><img src="/images/arrr.png" /></div><div class="close_it" onClick="document.location='/#portfolio'"><img src="/images/close1.png" /></div></div>
	<div class="portf_top">
	<div class="portf_back"><img src="/images/data/<?=$fields["back"];?>" /></div>
		<div id="phead" class="phead">
			<span><?=$fields["work_theme"];?></span>
			<h2><?=$fields["work_title"];?></h2>
			<div class="text1"><?=$fields["work_descr"];?></div>
			<div class="wdate"><?=$fields["work_date"];?></div>
		</div>
		<div id="pmac" class="pmac">
			<img src="/images/br_contour_header.png" />
			<img src="/images/data/<?=$fields["work_pic"];?>" />
			<img src="/images/br_contour_footer.png" />
		</div>
	</div>
</div>
