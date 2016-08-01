<div class="priced_div amiblock group">
	<div class="priced_left">
		<div class="breadcrumbs1" style="background-color: <?=$properties["back_color"];?>; color: <?=$properties["text_color"];?>;">
			<?
			$pid = $page_id;
			$pth = $fields["delimiter"].$allpages[$pid];
			while ($allparents[$pid] > 1)
				{
				$pth = $fields["delimiter"]."<a style=\"color: ".$properties["text_color"].";\" href=\"/".$allurls[$allparents[$pid]]."\">".$allpages[$allparents[$pid]]."</a>".$pth;
				$pid = $allparents[$pid];
			}
			$pth = "<a style=\"color: ".$properties["text_color"].";\" href=\"/\">Главная</a>".$pth;
			print $pth;
			?>
		</div>
		<div class="priced_in">
			<h1><?=$fields["header"];?></h1>
			<div class="priced_txt"><?=$fields["announce"];?></div>
			<h4><?=$fields["subheader"];?></h4>
			<div class="priced_table">
				<div class="priced_price"><?=$fields["price1"];?><br /><span><?=$fields["pricename1"];?></span></div>
				<div class="priced_price"><?=$fields["price2"];?><br /><span><?=$fields["pricename2"];?></span></div>
				<div class="priced_price darker"><?=$fields["price3"];?><br /><span><?=$fields["pricename3"];?></span></div>
			</div>
			<button onClick="$('#fld5').val('<?=$fields["header"];?>'); $('.mask').fadeIn(300); $('.form').fadeIn(300);"><?=$fields["but_text"];?></button>
		</div>
	</div>
	<div class="priced_right">
		<img src="/images/data/<?=$fields["image"];?>" />
	</div>
</div>
