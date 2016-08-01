<script>
	var hash = window.location.pathname;
	// alert(hash);
window.addEventListener('popstate', function(e) {
	if (!$.browser.safari) {
        if (e.state == 0) {
			$('.mask').fadeOut(300);
			$('.fullposts').fadeOut(300);
		}
		else {
			$('.mask').fadeIn(300);
			var stop = $('body').scrollTop() + 70;
			$('.fullposts').css('top', stop);
			$('.fullposts').fadeOut(300);
			$('#fullposts' + e.state).fadeIn(300);
		}
    }
});
function showposts(nid, ntitle, nurl) {
	$('.mask').fadeIn(300);
	var stop = $('body').scrollTop() + 70;
	$('.fullposts').css('top', stop);
	$('.fullposts').fadeOut(300);
	$('#fullposts' + nid).fadeIn(300);
	window.history.pushState(nid, ntitle, nurl);
	document.title = ntitle;
}
</script>
<div class="posts_div">
<?
$postsID = $_VARS["postsID"];
if ($postsID == "")
	{
	?>
	<?if ($fields["header"] != "") {?><h2><?=$fields["header"];?></h2><?}?>
	<div class="posts group">
		<?
		$mcnt = 0;
		foreach ($subfields as $nid => $subfield)
			{
			$mcnt++;
			if ($mcnt % 5 == 0)
				{
				?>
				</div>
				<div class="posts group">
				<?
			}
			?>
			<div class="post" id="post<?=$nid;?>" onClick="$('#fullposts<?=$nid;?>').css({top: $('body').scrollTop() + 80}); $('#fullposts<?=$nid;?>').fadeIn(300); $('.mask').fadeIn(300);">
				<?if ($subfield["date_pub"] != "") {?><time><?=$subfield["date_pub"];?></time><?}?>
				<?if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$subfield["preview"])) {?><img src="/images/data/<?=$subfield["preview"];?>" /><?}?>
				<h4><?=$subfield["header"];?></h4>
				<div class="announce"><?=$subfield["announce"];?></div>
				<div class="hovered">
					<button>Подробнее</button>
				</div>
			</div>
			<?
			if ($_SERVER["REQUEST_URI"] == "/".mytranslit($subfield["header"]))
				{
				?>
				<script>
					$(document).ready(function() {
						showposts(<?=$nid;?>, '<?=$subfield["header"];?>', '/<?=mytranslit($subfield["header"]);?>');
					});
				</script>
				<?
			}
			?>
			<div class="fullposts" id="fullposts<?=$nid;?>">
				<div class="fullposts_">
					<div class="close" onClick="$('.mask').fadeOut(300); $('.fullposts').fadeOut(300); window.history.pushState(0, '<?=$page_title;?>', '/<?=$page_url;?>'); document.title = '<?=$page_title;?>';"><img src="/images/close_.png" /></div>
					<?if ($subfield["date_n"] != "") {?><time><?=$subfield["date_n"];?></time><?}?>
					<h2><?=$subfield["header"];?></h2>
					<div class="n_text"><?=$subfield["text"];?></div>
					<img src="/images/data/<?=$subfield["picture"];?>" />
					<div class="p_descr"><?=$subfield["p_descr"];?></div>
					<div class="text_d"><?=$subfield["text_d"];?></div>
				</div>
			</div>
			<?
		}
		?>
		</ul>
	</div>
<?
}
?>
</div>
<?
function mytranslit($string) {
	$replace=array(
		" "=>"",
		"–"=>"",
		"'"=>"",
		"`"=>"",
		"а"=>"a","А"=>"a",
		"б"=>"b","Б"=>"b",
		"в"=>"v","В"=>"v",
		"г"=>"g","Г"=>"g",
		"д"=>"d","Д"=>"d",
		"е"=>"e","Е"=>"e",
		"ж"=>"zh","Ж"=>"zh",
		"з"=>"z","З"=>"z",
		"и"=>"i","И"=>"i",
		"й"=>"y","Й"=>"y",
		"к"=>"k","К"=>"k",
		"л"=>"l","Л"=>"l",
		"м"=>"m","М"=>"m",
		"н"=>"n","Н"=>"n",
		"о"=>"o","О"=>"o",
		"п"=>"p","П"=>"p",
		"р"=>"r","Р"=>"r",
		"с"=>"s","С"=>"s",
		"т"=>"t","Т"=>"t",
		"у"=>"u","У"=>"u",
		"ф"=>"f","Ф"=>"f",
		"х"=>"h","Х"=>"h",
		"ц"=>"c","Ц"=>"c",
		"ч"=>"ch","Ч"=>"ch",
		"ш"=>"sh","Ш"=>"sh",
		"щ"=>"sch","Щ"=>"sch",
		"ъ"=>"","Ъ"=>"",
		"ы"=>"y","Ы"=>"y",
		"ь"=>"","Ь"=>"",
		"э"=>"e","Э"=>"e",
		"ю"=>"yu","Ю"=>"yu",
		"я"=>"ya","Я"=>"ya",
		"і"=>"i","І"=>"i",
		"ї"=>"yi","Ї"=>"yi",
		"є"=>"e","Є"=>"e"
	);
	return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
}
?>
