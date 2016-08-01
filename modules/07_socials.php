<div class="socials_div">
	<div class="social_txt">Следите за нами в социальных медиа</div>
	<div class="socials">
		<?
		$mcnt = 0;
		foreach ($subfields as $subfield)
			{
			$mcnt++;
			?>
			<div class="social"><a href="<?=$subfield["url"];?>"><img src="/images/data/<?=$subfield["picture"];?>" /></a></div>
			<?
		}
		?>
	</div>
</div>
