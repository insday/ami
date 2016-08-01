<?
if ($properties["back_color"] == "")
	$properties["back_color"] = "transparent";
else
	$properties["back_color"] = "#".str_replace("#", "", $properties["back_color"]);

if ($properties["text_color"] == "")
	$properties["text_color"] = "#999999";
else
	$properties["text_color"] = "#".str_replace("#", "", $properties["text_color"]);
?>
<div id="footer" class="footer" style="background-color: <?=$properties["back_color"];?>; color: <?=$properties["text_color"];?>">
	<div class="footer_">
		<div class="footer_left">
			<div class="footer_phone"><a style="color: <?=$properties["text_color"];?>" href="tel:<?=str_replace(" ", "", str_replace("(", "", str_replace(")", "", $fields["phone"])));?>"><?=$fields["phone"];?></a></div>
			<div class="footer_email"><a style="color: <?=$properties["text_color"];?>" href="mailto:<?=$fields["email"];?>"><?=$fields["email"];?></a></div>
		</div>
		<div class="footer_right">
			<a href="<?=$fields["url"];?>"><button style="color: <?=$properties["text_color"];?>"><?=$fields["button"];?></button></a>
		</div>
	</div>
	<div class="soc_buts">
	<?
	foreach ($subfields as $subfield)
		{
		?>
		<div class="soc_but"><a href="<?=$subfield["url"];?>"><img src="/images/data/<?=$subfield["icon"];?>" /></a></div>
		<?
	}
	?>
</div>