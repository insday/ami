<script>
$(document).ready(function() {
	$(".map_container").mapbox({mousewheel: false, defaultX: -1400, defaultY: -680});
	$(".map_content img").attr("src", $(".map_content img").attr("src1"));
})
$(window).load(function() {
	$(".map_content img").attr("src", $(".map_content img").attr("src1"));
})
</script>
<div class="map_container_">
	<div class="mclose" onClick="$('.map_container_').css('height', '0');"></div>
	<div class="map_container">
		<?
		$file_info = getImageSize($_SERVER["DOCUMENT_ROOT"]."/images/data/".$fields["image"]);
		$wd = $file_info[0];
		$ht = $file_info[1];
		?>
		<div class="map_content"><img width="<?=$wd;?>" height="<?=$ht;?>" src1="/images/data/<?=$fields["image"];?>" src="/images/dmap.jpg" /></div>
	</div>
</div>