<div id="depts"  class="depts lightergrey">
<?
$query_text = "select * from ".$prefix."_pages p
left join ".$prefix."_pages_data pd on pd.page_id = p.page_id
where lang_id = ".$lang_id." order by page_order";
$query = mysql_query($query_text) or header("Location: install/index.php?ref=notables&a=1");
while ($arr_pages = mysql_fetch_array($query))
	{
	$parents[$arr_pages["page_id"]] = (int)$arr_pages["parent_id"];
	$includes[$arr_pages["page_id"]] = (int)$arr_pages["page_on"];
	$alldepts[(int)$arr_pages["parent_id"]][$arr_pages["page_id"]] = $arr_pages["page_title"];
}
// print_r($alldepts);
?>
	<div class="dept60 plusbig">РАЗДЕЛЫ САЙТА</div>
	<div id="adddept" class="dept40 adddept" onClick="$('.mask').fadeIn(200); $('#newpage').fadeIn(300);">Добавить раздел</div>
	<?
	show_all(0);
	?>
	<div id="adddept" class="dept40 adddept" onClick="$('.mask').fadeIn(200); $('#newpage').fadeIn(300);">Добавить раздел</div>
</div>
<?
function show_all($id)
	{
	global $alldepts, $indent, $page_id;

	if (is_array($alldepts[$id]))
		{
		?>
		<div<?if ($indent == 2) {?> class="deptsort"<?}?>>
		<?
		foreach ($alldepts[$id] as $cpage_id => $cpage_title)
			{
			?>
			<div id="page<?=$cpage_id;?>" class="dept40 indent<?=$indent;?><?if ($cpage_id == $page_id) {?> lightgrey<?}?>" onClick="document.location='main.php?page_id=<?=$cpage_id;?>'"><?=$cpage_title;?></div>
			<?
			$indent++;
			show_all($cpage_id);
		}
		?>
		</div>
		<?
  }
  $indent--;
}
?>