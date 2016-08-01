<script>
	ships = new Array();
	shiptitles = new Array();
	shipdescs = new Array();
	preload([<?
	$mcnt = 0;
	foreach ($subfields as $subfield)
		{
		$mcnt++;
		?><?if ($mcnt == 1) {?>'images/data/<?=$subfield["spicture"];?>'<?}else{?>,'images/data/<?=$subfield["spicture_"];?>'<?}?><?
	}
	?>]);
	<?
	$mcnt = 0;
	$margin = 0;
	foreach ($subfields as $subfield)
		{
		$mcnt++;
		$prev = (int)$file_info[0];
		$file_info = getImageSize($_SERVER["DOCUMENT_ROOT"]."/images/data/".$subfield["spicture"]);
		$margin += $prev/2 + (int)$file_info[0]/2;
		?>
		ships[<?=$mcnt;?>] = <?=$margin;?>;
		shiptitles[<?=$mcnt;?>] = "<?=$subfield["sheader"];?>";
		shipdescs[<?=$mcnt;?>] = "<?=addslashes($subfield["sdescr"]);?>";
		<?
	}
	?>
	function moveship(n) {
		var wdth = $(window).width()/2;
		var margin = wdth - ships[n];
		$("#shipsin").animate({marginLeft: margin}, 600);
		$("#shiptitle").fadeOut(200, function() {
			$(this).text(shiptitles[n]);
			$(this).fadeIn(200);
		});
		$("#shipdesc").fadeOut(200, function() {
			$(this).text(shipdescs[n]);
			$(this).fadeIn(200);
		});
		var src = $(".ship.sel img").attr("src");
		var src1 = $(".ship.sel img").attr("src1");
		$(".ship.sel img").attr("src1", src).attr("src", src1);
		$(".ship.sel").removeClass("sel");
		$(".ship" + n).addClass("sel");
		var src = $(".ship" + n + " img").attr("src");
		var src1 = $(".ship" + n + " img").attr("src1");
		$(".ship" + n + " img").attr("src1", src).attr("src", src1);
	}
</script>
<div class="projects" id="projects">
	<h2><?=$fields["header"];?></h2>
	<div class="projtext"><?=$fields["text"];?></div>
	<div class="shiper">
		<div id="shipsin" class="shipsin group">
			<?
			$mcnt = 0;
			foreach ($subfields as $subfield)
				{
				$mcnt++;
				if ($mcnt == 1)
					{
					$first_header = $subfield["sheader"];
					$first_descr = $subfield["sdescr"];
				}
				?>
				<div class="ship ship<?=$mcnt;?><?if ($mcnt == 1) {?> sel<?}?>" onClick="moveship(<?=$mcnt;?>);"><img src="/images/data/<?if ($mcnt == 1) {?><?=$subfield["spicture_"];?><?}else{?><?=$subfield["spicture"];?><?}?>" src1="/images/data/<?if ($mcnt == 1) {?><?=$subfield["spicture"];?><?}else{?><?=$subfield["spicture_"];?><?}?>" /></div>
				<?
			}
			?>
		</div>
	</div>
	<div class="aboutship">
		<h4 id="shiptitle"><?=$first_header;?></h4>
		<div id="shipdesc" class="shipdesc"><?=$first_descr;?></div>
		<a href="<?=$subfield["surl"];?>" class="shiplink"><button>Подробнее</button></a></div>
	</div>
</div>
