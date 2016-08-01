<script>
initmap = 1;
var x = <?=$fields["cx"];?>;
var y = <?=$fields["cy"];?>;
var myLatlng = new google.maps.LatLng(x, y);
var map;
var marker;
function initialize_map() {
	var mapOptions = {
		center: myLatlng,
		mapTypeControl:!1,
		streetViewControl:!1,
		scrollwheel:!1,
		panControl:!1,
		zoomControlOptions:{position:google.maps.ControlPosition.LEFT_TOP},
		zoom: 15,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map_canvas1"),
		mapOptions);
	marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title: "<?=$fields["header"];?>"
	});
}
$(document).ready(function() {
	initialize_map();
});
</script>
<div class="contacts group">
	<div class="contacts_left">
		<div class="contacts_left_">
			<h3><?=$fields["header"];?></h3>
			<p><?=$fields["text"];?></p>
			<p><?=$fields["address"];?></p>
			<?
			$acnt = 0;
			foreach ($subfields as $subfield)
				{
				$acnt++;
				$subheader = $subfield["subheader"];
				$phone1 = $subfield["phone1"];
				$phone2 = $subfield["phone2"];
				$email = $subfield["email"];
				?>
				<h4><?=$subheader;?></h4>
				<?if ($phone1 != "") {?><a href="tel:<?=$phone1;?>"><?=$phone1;?></a><br /><?}?>
				<?if ($phone2 != "") {?><a href="tel:<?=$phone2;?>"><?=$phone2;?></a><br /><?}?>
				<?if ($email != "") {?><a href="mailto:<?=$email;?>"><?=$email;?></a><?}?>
				<?
			}
			?>
		</div>
	</div>
	<div class="contacts_right">
		<div id="map_canvas1"></div>
	</div>
</div>
