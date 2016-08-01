<script>
$(document).ready(function() {
	var subdivs = $(".amiblock");
	var first = 1;
	var sel = " sel";
	$(subdivs).each(function(index) {
		$(this).addClass("aggdiv" + index);
		if (first == 1) {
			first = 0;
		}
		else {
			sel = "";
			$(this).fadeOut(300);
		}
		var hdr = $(this).find("h2").html();
		$(".agg_divs").append("<div class=\"agg_div agg_div" + index + sel + "\" onClick=\"go_aggdiv(" + index + ");\">" + hdr + "</div>");
		if (index == 7)
			$(".agg_divs").append("<br /><br />");
	});
});
function go_aggdiv(num) {
	$(".amiblock:visible").fadeOut(300, function() {
		$(".aggdiv" + num).fadeIn(300);
		$(".agg_div.sel").removeClass("sel")
		$(".agg_div" + num).addClass("sel")
	});
}
</script>
<div class="block_agg_div">
	<?if ($fields["header"] != "") {?><h1><?=$fields["header"];?></h1><?}?>
	<div class="agg_divs group">
	</div>
</div>
