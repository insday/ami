<a name="contacts"></a>
<?
$skeys = array();
foreach ($subfields as $skey => $subfield)
	$skeys[] = $skey;
?>
<div class="footer group">
	<div class="col span_1_of_3">
		<img src="/images/data/<?=$fields["logo1"];?>" />
		<div class="links">
			<a href="<?=$fields["url1"];?>"><?=$fields["urltext1"];?></a><br />
			<a href="<?=$fields["url2"];?>"><?=$fields["urltext2"];?></a><br />
		</div>
	</div>
	<div class="col span_1_of_3 social">
		<?
		foreach ($subfields[$skeys[4]] as $socurls)
			{
			?>
			<a href="<?=$socurls["surl"];?>"><img src="/images/data/<?=$socurls["simg"];?>" /></a>
			<?
		}
		?>
	</div>
	<div class="col span_1_of_3 phone">
		<?=$fields["phone"];?>
	</div>
</div>
