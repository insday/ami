<a name="bz"></a>
<div class="response" style="background-color: <?=$properties["rback_color"];?>');">
	<div class="picture group">
		<div class="video"><iframe width="460" height="290" src="https://www.youtube.com/embed/<?=$fields["video"];?>?rel=0" frameborder="0" allowfullscreen></iframe></div>
		<h2><?=$fields["rheader"];?></h2>
		<button onClick="$('.mask').fadeIn(200); $('#feedback').fadeIn(100);"><?=$fields["rbuttext"];?></button>
	</div>
	<div class="picture2 group">
		<img src="/images/data/<?=$fields["rimage"];?>" />
		<?=$fields["rtext"];?><br /><br />
		<strong><?=$fields["rfio"];?></strong><br />
		<em><?=$fields["roccup"];?></em>
	</div>
</div>
