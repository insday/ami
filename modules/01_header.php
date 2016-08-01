<div class="top_div">
	<div class="group top">
		<div class="booking" onClick="$('.mask').fadeIn(300); $('.form').fadeIn(300);">Забронировать проживание <img src="images/cal.png" /></div>
		<div class="table">
			<div class="table_">
				<div class="way"><a href="/contacts"><button>Как добраться</button></a></div>
				<div class="address"><?=$fields["address"];?></div>
				<div class="phone"><?=$fields["phone"];?></div>
				<div class="socials">
				<?
				foreach ($subfields as $subfield)
					{
					if ($subfield["surl"] != "")
						{
						?>
						<a href="<?=$subfield["surl"];?>"><img src="images/data/<?=$subfield["spicture"];?>" /></a>
						<?
					}
				}
				?>
				</div>
			</div>
		</div>
	</div>
	<div class="group">
		<div class="logo"><a href="/"><img src="/images/data/<?=$fields["logo"];?>" /></a></div>
		<div class="table">
			<div class="table_">
				<div class="nav">
					<ul>
					<?
					foreach ($subfields as $subfield)
						{
						if ($subfield["url"] != "")
							{
							?>
							<li><a href="<?=$subfield["url"];?>"><?=$subfield["url_text"];?></a></li>
							<?
						}
					}
					?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
