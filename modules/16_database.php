<div class="db_div">
<?
foreach ($subfields as $subfield)
	{
	$arr_types = explode("^", $subfield["theme"]);
	foreach ($arr_types as $type)
		{
		if ($type != str_replace("*", "", $type))
			$curtype = str_replace("*", "", $type);
	}
	$databases[$curtype][] = $subfield;
}
?>
<div class="themes">
	<?
	$gcnt = 0;
	foreach ($databases as $typename => $gallery)
		{
		$gcnt++;
		?>
		<div class="theme<?if ($gcnt == 1) {?> active<?}?>" onClick="$('.theme.active').removeClass('active'); $(this).addClass('active'); $('.databases:visible').fadeOut(300, function() {$('.dbtheme<?=$gcnt;?>').fadeIn(300);});"><?=$typename;?></div>
		<?
	}
	?>
</div>
<?
$gcnt = 0;
foreach ($databases as $typename => $database)
	{
	$gcnt++;
	?>
	<div class="group dbtheme<?=$gcnt;?> databases"<?if ($gcnt != 1) {?> style="display: none;"<?}?>>
		<div class="questions">
			<?
			foreach ($database as $qid => $subfield)
				{
				?>
				<div class="question<?if ($qid == 0) {?> active<?}?>" onClick="$('.question.active').removeClass('active'); $(this).addClass('active'); $('.answer:visible').fadeOut(300, function() {$('.answer<?=$gcnt;?>').fadeIn(300);});"><?=$subfield["header"];?></div>
				<?
			}
			?>
		</div>
		<div class="answers">
		<?
		foreach ($database as $qid => $subfield)
			{
			?>
			<div class="answer answer<?=$qid;?>"<?if ($qid != 0) {?> style="display: none;"<?}?>>
				<h2><?=$subfield["header"];?></h2>
				<div class="db_txt"><?=nl2br($subfield["text"]);?></div>
			</div>
			<?
		}
		?>
		</div>
	</div>
	<?
}
?>
</div>
