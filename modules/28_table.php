<?
if ($fields["even_color"] == "")
	$fields["even_color"] = "#CCCCCC";
if ($fields["odd_color"] == "")
	$fields["odd_color"] = "#EEEEEE";
if ($fields["text_color"] == "")
	$fields["text_color"] = "#333333";
?>
<div class="etable amiblock">
	<h2><?=$fields["header"];?></h2>
	<div class="etable_">
		<div class="eheaders">
			<?$ccnt = 2;?>
			<div class="eheader"><?=$fields["header1"];?></div>
			<div class="eheader"><?=$fields["header2"];?></div>
			<?
			if ($fields["header3"] != "")
				{
				$ccnt++;
				?>
				<div class="eheader"><?=$fields["header3"];?></div>
				<?
			}
			if ($fields["header4"] != "")
				{
				$ccnt++;
				?>
				<div class="eheader"><?=$fields["header4"];?></div>
				<?
			}
			if ($fields["header5"] != "")
				{
				$ccnt++;
				?>
				<div class="eheader"><?=$fields["header5"];?></div>
				<?
			}
			if ($fields["header6"] != "")
				{
				$ccnt++;
				?>
				<div class="eheader"><?=$fields["header6"];?></div>
				<?
			}
		?>
		</div>
		<?
		$mcnt = 0;
		foreach ($subfields as $nid => $subfield)
			{
			$mcnt++;
			?>
			<div class="erow<?if ($subfield["field2"] == "") {?> fullw"<?}else{?>" style="color: <?=$fields["text_color"];?>; background-color: <?if ($mcnt % 2 == 0) {?><?=$fields["odd_color"];?><?}else{?><?=$fields["even_color"];?><?}?>"<?}?>>
				<div class="ecol<?if ($subfield["field2"] == "") {?> fullw<?}?>"><?=$subfield["field1"];?></div>
				<?
				if ($subfield["field2"] == "")
					{
					for ($i = 1; $i < $ccnt; $i++)
						{
						?><div class="ecol"></div><?
					}
				}
				if ($subfield["field2"] != "")
					{
					?>
					<div class="ecol"><?=$subfield["field2"];?></div>
					<?
				}
				if ($subfield["field3"] != "")
					{
					?>
					<div class="ecol"><?=$subfield["field3"];?></div>
					<?
				}
				if ($subfield["field4"] != "")
					{
					?>
					<div class="ecol"><?=$subfield["field4"];?></div>
					<?
				}
				if ($subfield["field5"] != "")
					{
					?>
					<div class="ecol"><?=$subfield["field5"];?></div>
					<?
				}
				if ($subfield["field6"] != "")
					{
					?>
					<div class="ecol"><?=$subfield["field6"];?></div>
					<?
				}
				?>
			</div>
			<?
		}
		?>
	</div>
</div>
