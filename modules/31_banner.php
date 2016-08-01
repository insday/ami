<?
if ($properties["back_color"] == "")
	$properties["back_color"] = "transparent";
else
	$properties["back_color"] = "#".str_replace("#", "", $properties["back_color"]);

if ($_COOKIE["bclosed"] != 1)
{
?>
<script>
<?if ($fields["image"] != "") {?>
$(document).ready(function() {
	var hght = $(".banner_through").height();
	$(".top_div").css("margin-top", hght);
})
<?}?>
function setCookie (name, value, expires, path, domain, secure) {
      document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}
</script>
<div class="banner_through" style="background-color: <?=$properties["back_color"];?>;">
	<?if ($fields["image"] != "") {?><div class="bclose" onClick="setCookie('bclosed', 1); $('.top_div').css('margin-top', 0); $('.banner_through').fadeOut(500);"></div>
	<a href="<?=$fields["url"];?>"><img src="/images/data/<?=$fields["image"];?>" /></a><?}?>
</div>
<?
}
?>