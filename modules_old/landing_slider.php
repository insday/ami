<a name="achieve"></a>
<?
foreach ($subfields as $skey => $subfield)
	$skeys[] = $skey;
?>
<div class="map">
	<div class="mapinner" style="background-color: <?=$properties["back_color"];?>; background-image: url('/images/data/<?=$fields["back"];?>');">
		<h2><?=$fields["header"];?><br /><span><?=$fields["subheader"];?></span></h2>
		<div class="group">
			<div class="slidernav larr" onClick="slider_left(1);">
				<img src="images/arrl.svg" />
			</div>
			<div class="slider1">
				<div class="scontainer1">
					<div class="sinner1">
						<?
						foreach ($subfields[$skeys[8]] as $slides)
							{
							?>
							<div class="slide">
								<div class="group">
									<div class="col span_1_of_4 slideleft">
										<img src="/images/data/<?=$slides["pic"];?>" /><br />
										<div class="imgdesc">
										<strong><?=$slides["fio"];?></strong><br /><br />
										<em><?=$slides["occup"];?></em>
										</div>
									</div>
									<div class="col span_3_of_4 slideright">
										<?=$slides["text"];?>
										<div class="group images">
											<div class="col image">
												<?
												$arrimages = explode("=", $slides["pics"]);
												foreach ($arrimages as $img)
													{
													if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$img))
														{
														?>
														<a href="/images/data/<?=$img;?>" rel="prettyPhoto[<?=$gcnt;?>]" title="<?=htmlspecialchars($slides["occup"], ENT_QUOTES);?>"><s><img src="/images/data/<?=$img;?>" /></s></a>
														<?
													}
												}
												?>
												</div>
										</div>
									</div>
								</div>
							</div>
							<?
						}
						?>
					</div>
				</div>
			</div>
			<div class="slidernav rarr" onClick="slider_right(1);">
				<img src="images/arrr.svg" />
			</div>
		</div>
		<div class="bullets1">
			<?
			$cnt = 0;
			foreach ($subfields[$skeys[8]] as $slides)
				{
				?>
				<div id="bul_1_<?=$cnt + 1;?>" class="bullet<?if ($cnt++ == 0) {?> active<?}?>" onClick="slider_go(1, <?=$cnt;?>);"></div>
				<?
			}
			?>
		</div>			
	</div>			
</div>
