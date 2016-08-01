<?
if (is_array($fields))
	{
	foreach ($fields as $field)
		$arrfields[] = $fields["url"];
	$jsfields = "\"".implode("\", \"", $arrfields);
}
?>
<script>
$(document).ready(function() {
	lnks = new Array(<?=$jsfields;?>);
	hghts = new Array();
	for (var key in lnks) {
		if ($("a[name*=" + lnks[key] +"]").length) {
			hghts[key] = $("a[name*=" + lnks[key] +"]").offset().top;
		}
	}
	var i = document.location.hash.replace("#", "");
	$('a[href*=#]:not([href=#])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
			|| location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			   if (target.length) {
				scrolling = 1;
				 $('html,body').animate({
					 scrollTop: target.offset().top
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
});
</script>
<div class="mainmenu position<?=$properties["position"];?>">
	<ul>
	<?
	if (is_array($fields))
	foreach ($fields as $field)
		{
		?>
		<li<?if ($field["url"] == $url) {?> class="ch"<?}?>><a href="<?if ($properties["urltype"] == 1) {?>#<?}else{?>/<?}?><?=$field["url"];?>"><?=$field["name"];?></a></li>
		<?
	}
	?>
	</ul>
</div>
