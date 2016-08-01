<?
if ($properties["back_color"] == "")
	$properties["back_color"] = "#FFFFFF";
if ($properties["text_color"] == "")
	$properties["text_color"] = "#333333";

foreach ($subfields as $nid => $subfield)
	{
	if ($subfield["list_id"] != "")
		{
		$lists[$subfield["list_id"]] = $subfield["list_list"];
	}
}
?>
<div class="form form<?=$block_id;?>">
	<h2><?=$fields["header"];?></h2>
	<div class="fclose" onClick="$('.mask').fadeOut(300); $('.form').fadeOut(300);"></div>
	<div class="form_text"><?=$fields["text"];?></div>
	<form name="form<?=$block_id;?>" action="/xp_sendform.php" method="post">
	<?
	$mcnt = 0;
	foreach ($subfields as $nid => $subfield)
		{
		if ($subfield["type"] != "")
			{
			$mcnt++;
			?>
			<div class="form_ group">
				<input type="hidden" name="fieldname<?=$mcnt;?>" value="<?=$subfield["fieldname"];?>">
				<div class="form_fieldname"><?=$subfield["fieldname"];?><?if ($subfield["ness"] == 1) {?> <sup class="red">*</sup><?}?></div>
				<div class="form_field"><?
				switch ($subfield["type"]) {
					default:
					// input text
						?><input id="fld<?=$mcnt;?>" name="fld<?=$mcnt;?>" <?if ($subfield["ness"] == 1) {?>class="ness" <?}?>type="text" placeholder="<?=$subfield["placeholder"];?>" value="<?=$subfield["def"];?>" /><?
					break;
					case 2:
					// input number
						?><input class="number" id="fld<?=$mcnt;?>" name="fld<?=$mcnt;?>" <?if ($subfield["ness"] == 1) {?>class="ness" <?}?>type="number" placeholder="<?=$subfield["placeholder"];?>" value="<?=$subfield["def"];?>" /><?
					break;
					case 3:
					// input email
						?><input id="fld<?=$mcnt;?>" name="fld<?=$mcnt;?>" <?if ($subfield["ness"] == 1) {?>class="ness" <?}?>type="email" placeholder="<?=$subfield["placeholder"];?>" value="<?=$subfield["def"];?>" /><?
					break;
					case 4:
					// input date
						?><input class="date1" id="fld<?=$mcnt;?>" name="fld<?=$mcnt;?>" <?if ($subfield["ness"] == 1) {?>class="ness" <?}?>type="text" placeholder="<?=$subfield["placeholder"];?>" value="<?=$subfield["def"];?>" /><?
					break;
					case 5:
					// input time
						?><input id="fld<?=$mcnt;?>" name="fld<?=$mcnt;?>" <?if ($subfield["ness"] == 1) {?>class="ness" <?}?>type="time" placeholder="<?=$subfield["placeholder"];?>" value="<?=$subfield["def"];?>" /><?
					break;
					case 10:
					// select
						?><select id="fld<?=$mcnt;?>" name="fld<?=$mcnt;?>" <?if ($subfield["ness"] == 1) {?>class="ness"<?}?>>
						<?
						if ($subfield["list"] != "")
							{
							?><option value="">выберите номер</option><?
							$arr_lists = explode(",", $lists[$subfield["list"]]);
							foreach ($arr_lists as $v => $list)
								{
								?><option value="<?=$list;?>"><?=$list;?></option><?
							}
						}
						?>
						</select><?
					break;
					case 11:
					// textarea
						?><textarea id="fld<?=$mcnt;?>" <?if ($subfield["ness"] == 1) {?>class="ness" <?}?>placeholder="<?=$subfield["placeholder"];?>"><?=$subfield["def"];?></textarea><?
					break;
				}
				?>
				</div>
			</div><?
		}
	}
	?>
	<button type="submit">Отправить</button>
	<input type="hidden" name="maxfields" value="<?=$mcnt;?>">
	<input type="hidden" name="fromemail" value="<?=$fields["fromemail"];?>">
	<input type="hidden" name="toemail" value="<?=$fields["toemail"];?>">
	</form>
</div>
<script src="/js/datepicker.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/datepicker.regional.ru.js" type="text/javascript" charset="utf-8"></script>
<script>
$.datepicker.setDefaults({
  showOn: "both",
  buttonImageOnly: true,
  buttonImage: "/images/calr.gif",
  buttonText: "Календарь"
});
$(document).ready(function () {
	$.datepicker.setDefaults( $.datepicker.regional[ "ru" ] );
	$(".date1").datepicker();
})
</script>