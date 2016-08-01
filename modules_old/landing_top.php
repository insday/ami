<a name="top"></a>
<div class="top" style="background-image: url('/images/data/<?=$fields["back"];?>');">
	<div class="header">
		<div class="nav">
			<?
			foreach ($subfields as $skey => $subfield)
				$skeys[] = $skey;
			foreach ($subfields[$skeys[0]] as $menuitem)
				{
				?>
				<div class="mi"<?if ($menuitem["spec"] == 1) {?> onClick="$('.mask').fadeIn(200); $('#feedback').fadeIn(100);"<?}else{?>><a href="<?=$menuitem["url"];?>"<?}?>><?=$menuitem["name"];?></a></div>
				<?
			}
			?>
		</div>
	</div>
	<div class="group">
		<div class="col span_3_of_5 coa">
			<img src="/images/data/<?=$fields["logo"];?>" />
			<h1><?=$fields["header"];?></h1>
			<h2><?=$fields["subheader"];?></h2>
			<button onClick="$('.mask').fadeIn(200); $('#feedback').fadeIn(100);"><?=$fields["button"];?></button>
		</div>
		<div class="col span_2_of_5 right">
			<div class="group slider_right">
				<div class="slidernav2 larr2" onClick="slider_left(2);"></div>
				<div class="slider2">
					<div class="scontainer2">
						<div class="sinner2">
							<?
							foreach ($subfields[$skeys[1]] as $slider)
								{
								$cnt++;
								?>
								<div class="slide">
									<a href="<?=$slider["url"];?>"><img src="/images/data/<?=$slider["pic"];?>" /></a>
									<div class="inslide">
										<?=$slider["header"];?>
										<br />
										<?=$slider["text"];?>
										<div class="bz"><a href="<?=$slider["url"];?>"><?=$slider["urltext"];?></a></div>
									</div>
								</div>
								<?
							}
							?>
						</div>
					</div>
				</div>
				<div class="slidernav2 rarr2" onClick="slider_right(2);"></div>
			</div>
			<div class="bullets2">
				<?
				for ($i = 0; $i < $cnt; $i++)
					{
					?>
					<div id="bul_2_<?=$i + 1;?>" class="bullet<?if ($i == 0) {?> active<?}?>" onClick="slider_go(2, <?=$i + 1;?>);"></div>
					<?
				}
				?>
			</div>
		</div>
	</div>
</div>
