<div class="triple_div group">
	<?
	$wd = 100/count($subfields);
	foreach ($subfields as $subfield)
		{
		?>
		<div class="triple">
			<a href="<?=$subfield["url"];?>"><div class="triple_back"><img src="/images/data/<?=$subfield["back"];?>" /></div>
			<div class="triple_content">
				<div class="triple_table">
					<div class="triple_cell">
						<?if ($subfield["icon"] != "") {?><img src="/images/data/<?=$subfield["icon"];?>" /><?}?>
						<?if ($subfield["header"] != "") {?><h2><?=$subfield["header"];?></h2><?}?>
					</div>
				</div>
			</div></a>
		</div>
		<?
	}
	?>
</div>
