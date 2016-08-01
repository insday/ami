<script>
var scrolling = 0;
window.onscroll = function() {
	var scrolled = window.pageYOffset || document.documentElement.scrollTop;
	if (scrolled > 650) {
		$("#top").removeClass("top").addClass("top1");
	}
	else {
		$("#top").removeClass("top1").addClass("top");
	}
	if (scrolling == 0)
		{
		for (var key in hghts)
			{
			if (scrolled >= hghts[key]) {
				$(".ch").removeClass("ch");
				$("#mi" + lnks[key]).addClass("ch");
				break;
			}
		}
	}
}
$(document).ready(function() {
	lnks = new Array("contacts", "portfolio", "whatwedo", "projects", "top");
	hghts = new Array();
	for (var key in lnks) {
		if ($("#" + lnks[key]).length) {
			hghts[key] = $("#" + lnks[key]).offset().top;
		}
	}
	var i = document.location.hash.replace("#", "");
	if (i == "contacts") {
		$("#micontacts").addClass("ch");
		var timeout0 = setTimeout(function() {
			scrolling = 1;
			 $('html,body').animate({
				 scrollTop: $("a[name='contacts']").offset().top - 40
			}, 1000, function() {
				scrolling = 0;
				// alert(target.offset().top);
			});
			clearTimeout(timeout0);
		}, 100);
	}
	if (i == "portfolio") {
		$("#miportfolio").addClass("ch");
		var timeout0 = setTimeout(function() {
			scrolling = 1;
			 $('html,body').animate({
				 scrollTop: $("a[name='portfolio']").offset().top - 40
			}, 1000, function() {
				scrolling = 0;
				// alert(target.offset().top);
			});
			clearTimeout(timeout0);
		}, 100);
	}
	$('a[href*=#]:not([href=#])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
			|| location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			   if (target.length) {
				scrolling = 1;
				 $('html,body').animate({
					 scrollTop: target.offset().top - 40
				}, 1000, function() {
					scrolling = 0;
					// alert(target.offset().top);
				});
				$(".ch").removeClass("ch");
				$(this).parent().addClass("ch");
				return false;
			}
		}
	});
	if (parseInt(i) == "1" || parseInt(i) == "2" || parseInt(i) == "3")
		{
		shslider(i);
	}
	/*
	$('#countdown_dashboard').countDown({
		targetDate: {
			'day': 		1,
			'month': 	5,
			'year': 	2015,
			'hour': 	23,
			'min': 		0,
			'sec': 		0
		}
	});
	*/
});
</script>
<?
if (str_replace("facebook.com", "", $fields["fblink"] == $fields["fblink"]))
	$fields["fblink"] = "https://facebook.com/".$fields["fblink"];
elseif (str_replace("http", "", $fields["fblink"] == $fields["fblink"]))
	$fields["fblink"] = "https://".$fields["fblink"];
?>
<div id="top" class="top">
	<div class="top_back"></div>
	 <div class="group pad">
		<div class="col span_1_of_4 logo"><a href="/"><img src="/images/data/<?=$fields["logo"];?>" /></a></div>
		<div class="col span_2_of_4">
			<div id="nav" class="nav">
				<ul>
					<?
					$mcnt = 0;
					foreach ($subfields as $subfield)
						{
						?>
						<li<?if ($subfield["url"] == $page_url || $subfield["url"] == $parent_url) {?> class="sel"<?}?>><a href="<?=$subfield["url"];?>"><?=$subfield["header"];?></a></li>
						<?
					}
					?>
				</ul>
			</div>
		</div>
		<div class="col span_1_of_4 aright">
			<a target="_blank" href="<?=$fields["fblink"];?>"><img class="fb1" src="/images/fb1.png" /><img class="fb2" src="/images/fb2.png" /></a><span id="phone" class="phone"><a href="tel:<?=str_replace(" ", "", str_replace("(", "", str_replace(")", "", $fields["phone"])));?>"><?=$fields["phone"];?></a></span>
		</div>
	</div>
</div>
