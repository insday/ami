<?
$editable = 1;

include "includes/connection.php";
include "includes/main_init.php";
include "includes/main_func.php";
include "includes/messages.php";
include "secure.php";

mysql_query("set SESSION group_concat_max_len = 65535");

if ((int)$_GET["page_id"] != 0)
  $page_id = (int)$_GET["page_id"];
else
  $page_id = 1;

$page_query = mysql_query("select * from ".$prefix."_pages_data pd left join ".$prefix."_meta_words md on md.page_id = pd.page_id and md.lang_id = ".$lang_id." where pd.page_id = ".$page_id." and pd.lang_id = ".$lang_id);
if ($arr_page = mysql_fetch_array($page_query))
	{
	$pg_title = $arr_page["page_title"];
	$pg_url = $arr_page["page_url"];
	$pg_mtitle = $arr_page["meta_title"];
	$pg_kw = $arr_page["meta_keywords"];
	$pg_dscr = $arr_page["meta_description"];
}

if ((int)$_GET["block_id"] != "")
	$parent_id = (int)$_GET["block_id"];
	
$admin_title = show_mess("TTLDeptEdit");

include "includes/header.php";
include "includes/top.php";
include "includes/sidebar.php";
include "includes/depts.php";

$del = (int)$_GET["del"];
if ($del != 0)
	mysql_query("delete from ".$prefix."_real_data where element_id in (select element_id from ".$prefix."_elements where block_id = ".$parent_id.") and element_row = ".$del);

if ($pg_url == "/")
	$pg_url = "";
?>
<div id="content" class="content">
<h2><?=$pg_title;?></h2>
<div class="preview"><a target="_blank" href="/<?=$pg_url;?>"><button>Просмотр</button></a></div><?if ($editable > 0) {?><div class="pedit"><img src="images/edit.svg" onClick="$('#editpage<?=$page_id;?>').fadeIn(200);" /></div><div class="pclose"><img src="images/close.svg" onClick="if (confirm('Все блоки на странице будут безвозвратно удалены! Вы уверены?')) {delpage(<?=$page_id;?>);}" /></div><?}?>
<?
if (chdir($_SERVER["DOCUMENT_ROOT"]."/admin/modules"))
	{
	$d = opendir(getcwd());
	while (($e = readdir($d)) != false)
		{
		if (substr($e,strlen($e)-4,4) == ".xml")
			{
			$fp = simplexml_load_file($e);
			$mid = (int)$fp->attributes()->id;
			$allmodules[$mid] = $fp->attributes()->name;
			if (is_object($fp->modules->module_id))
				$b_modules[$mid] = (int)$fp->modules->module_id;
			if (is_object($fp->properties->property))
			foreach ($fp->properties->property as $property)
				{
				$pid = (string)$property->id;
				$b_props[$mid][$pid]["name"] = (string)$property->name;
				$b_props[$mid][$pid]["type"] = (string)$property->type;
				$b_props[$mid][$pid]["format"] = (string)$property->format;
				if (count($property->values->value))
				foreach ($property->values->value as $values)
					$b_props[$mid][$pid]["values"][(int)$values->id] = (string)$values->val;
				$b_props[$mid][$pid]["default"] = (int)$property->default;
			}
		}
	}
}
$query = mysql_query("
select * from ".$prefix."_blocks b
left join ".$prefix."_blocks_data bd on bd.block_id = b.block_id
where (parent_id is NULL or parent_id = 0) and lang_id = ".$lang_id." and page_id = ".$page_id." order by block_order
") or die("ERR1: ".mysql_error());
if (mysql_num_rows($query) == 0)
	{
	?>
	<div id="nodata">Записей не обнаружено</div>
<?
}
else
	{
	?>
	<form name="mainform" action="xp_update.php" method="POST">
	<input type="hidden" name="page_id" value="<?=$page_id;?>" />
	<input type="hidden" name="parent_id" value="<?=$parent_id;?>" />
	<button name="submit_que">обновить</button>
	<?
	if ($parent_id == 0)
		{
		?>
		<div id="container">
			<?
			while ($arr_query = mysql_fetch_array($query))
				{
				$block_id = $arr_query["block_id"];
				$block_title = $arr_query["block_title"];
				$module_id = $arr_query["module_id"];
				if ($module_id == 5)
					{
					$query1 = mysql_query("select rd.element_data from
					".$prefix."_elements e 
					left join ".$prefix."_real_data rd on rd.element_id = e.element_id and rd.lang_id = ".$lang_id."
					where e.element_symbolic = 'page_id' and e.block_id = ".$block_id." and element_data != '' order by e.element_order") or die("ERR2.1: ".mysql_error());
					if ($arr_q1 = mysql_fetch_array($query1))
						{
						$query2 = mysql_query("select * from ".$prefix."_pages p left join ".$prefix."_pages_data pd on pd.page_id = p.page_id and lang_id = ".$lang_id." where parent_id = ".$arr_q1["element_data"]." order by page_order") or die("ERR2.2: ".mysql_error());
						while ($arr_q2 = mysql_fetch_array($query2))
							{
							$realdata["header_p"] = $arr_q2["page_title"];
							$realdata["url_p"] = "/".$arr_q2["page_url"];
							$realdata["image_p"] = "default.jpg";
							$realdata["text_p"] = "Описание по-умолчанию";
							$query4 = mysql_query("select max(element_row) as max_row from ".$prefix."_blocks b left join ".$prefix."_elements e on e.block_id = b.block_id left join ".$prefix."_real_data rd on rd.element_id = e.element_id and lang_id = ".$lang_id." where parent_id = ".$block_id) or die("ERR2.3: ".mysql_error());
							if ($arr_q4 = mysql_fetch_array($query4))
								$row = $arr_q4["max_row"] + 1;
							else
								$row = 1;
							$query3 = mysql_query("select b.block_id, e.element_id, e.element_symbolic, e.element_order, rd.element_data from ".$prefix."_blocks b left join ".$prefix."_elements e on e.block_id = b.block_id left join ".$prefix."_real_data rd on rd.element_id = e.element_id and lang_id = ".$lang_id." where element_symbolic = 'url_p' and element_data = '/".$arr_q2["page_url"]."' and parent_id = ".$block_id) or die("ERR2.3: ".mysql_error());
							$insert = 0;
							if (mysql_num_rows($query3) == 0)
								$insert = 1;
							if ($insert == 1)
								{
								$query3 = mysql_query("select b.block_id, e.element_id, e.element_symbolic, e.element_order from ".$prefix."_blocks b left join ".$prefix."_elements e on e.block_id = b.block_id where parent_id = ".$block_id) or die("ERR2.3: ".mysql_error());
								while ($arr_q3 = mysql_fetch_array($query3))
									{
									// print "<br />-------<br />insert into ".$prefix."_real_data (element_id, block_id, page_id, element_data, element_row, element_order, lang_id)
									// values (".$arr_q3["element_id"].", ".$arr_q3["block_id"].", ".$page_id.", '".$realdata[$arr_q3["element_symbolic"]]."', ".$row.", ".$arr_q3["element_order"].", ".$lang_id.")";
									mysql_query("insert into ".$prefix."_real_data (element_id, block_id, page_id, element_data, element_row, element_order, lang_id)
									values (".$arr_q3["element_id"].", ".$arr_q3["block_id"].", ".$page_id.", '".$realdata[$arr_q3["element_symbolic"]]."', ".$row.", ".$arr_q3["element_order"].", ".$lang_id.")") or die("ERR2.4: ".mysql_error());
								}
							}
						}
					}
				}
				if ($module_id == 21)
					{
					$query1 = mysql_query("select rd.element_data from
					".$prefix."_elements e 
					left join ".$prefix."_real_data rd on rd.element_id = e.element_id and rd.lang_id = ".$lang_id."
					where e.element_symbolic = 'page_id' and e.block_id = ".$block_id." and element_data != '' order by e.element_order") or die("ERR2.1: ".mysql_error());
					if ($arr_q1 = mysql_fetch_array($query1))
						$qpage_id = $arr_q1["element_data"];
					else
						$qpage_id = $page_id;
					$query2 = mysql_query("select * from ".$prefix."_pages p left join ".$prefix."_pages_data pd on pd.page_id = p.page_id and lang_id = ".$lang_id." where parent_id = ".$qpage_id." order by page_order") or die("ERR2.2: ".mysql_error());
					while ($arr_q2 = mysql_fetch_array($query2))
						{
						$realdata["header_p"] = $arr_q2["page_title"];
						$realdata["url_p"] = "/".$arr_q2["page_url"];
						$query4 = mysql_query("select max(element_row) as max_row from ".$prefix."_blocks b left join ".$prefix."_elements e on e.block_id = b.block_id left join ".$prefix."_real_data rd on rd.element_id = e.element_id and lang_id = ".$lang_id." where parent_id = ".$block_id) or die("ERR2.3: ".mysql_error());
						if ($arr_q4 = mysql_fetch_array($query4))
							$row = $arr_q4["max_row"] + 1;
						else
							$row = 1;
						$query3 = mysql_query("select b.block_id, e.element_id, e.element_symbolic, e.element_order, rd.element_data from ".$prefix."_blocks b left join ".$prefix."_elements e on e.block_id = b.block_id left join ".$prefix."_real_data rd on rd.element_id = e.element_id and lang_id = ".$lang_id." where element_symbolic = 'url_p' and element_data = '/".$arr_q2["page_url"]."' and parent_id = ".$block_id) or die("ERR2.3: ".mysql_error());
						$insert = 0;
						if (mysql_num_rows($query3) == 0)
							$insert = 1;
						if ($insert == 1)
							{
							$query3 = mysql_query("select b.block_id, e.element_id, e.element_symbolic, e.element_order from ".$prefix."_blocks b left join ".$prefix."_elements e on e.block_id = b.block_id where parent_id = ".$block_id) or die("ERR2.3: ".mysql_error());
							while ($arr_q3 = mysql_fetch_array($query3))
								{
								// print "<br />-------<br />insert into ".$prefix."_real_data (element_id, block_id, page_id, element_data, element_row, element_order, lang_id)
								// values (".$arr_q3["element_id"].", ".$arr_q3["block_id"].", ".$page_id.", '".$realdata[$arr_q3["element_symbolic"]]."', ".$row.", ".$arr_q3["element_order"].", ".$lang_id.")";
								mysql_query("insert into ".$prefix."_real_data (element_id, block_id, page_id, element_data, element_row, element_order, lang_id)
								values (".$arr_q3["element_id"].", ".$arr_q3["block_id"].", ".$page_id.", '".$realdata[$arr_q3["element_symbolic"]]."', ".$row.", ".$arr_q3["element_order"].", ".$lang_id.")") or die("ERR2.4: ".mysql_error());
							}
						}
					}
				}
				@$module_name = $allmodules[$arr_query["module_id"]];
				$query1 = mysql_query("select e.*, ed.element_title, rd.element_data from
				".$prefix."_elements e 
				left join ".$prefix."_elements_data ed on ed.element_id = e.element_id and ed.lang_id = ".$lang_id."
				left join ".$prefix."_real_data rd on rd.element_id = e.element_id and rd.lang_id = ".$lang_id."
				where e.block_id = ".$block_id." order by e.element_order") or die("ERR2.4: ".mysql_error());
				?>
				<div class="block" id="block<?=$block_id;?>">
					<?
					if ($editable == 2)
						{
						?>
						<div class="take">
							<img src="images/take.svg" onClick="takedata(<?=$block_id;?>, $('#takelang<?=$block_id;?>').val(), <?=$lang_id;?>)" />
							<select name="takelang<?=$block_id;?>" id="takelang<?=$block_id;?>">
								<?
								foreach ($alllangs as $lid => $lang)
									{
									if ($lid != $lang_id)
										{
										?>
										<option value="<?=$lid;?>"><?=$lang;?></option>
										<?
									}
								}
								?>
							</select>
						</div>
						<?
					}
					?>
					<div class="buttons">
						<?if ($editable > 0) {?><div class="move"><img src="images/take.svg" onClick="$('#move_block_id').val('<?=$block_id;?>'); $('.mask').fadeIn('fast'); $('#moveblock').fadeIn(200);" /></div><?}?>
						<?if (is_array($b_props[$module_id])) {?><div class="edit"><img src="images/edit.svg" onClick="$('#editprops<?=$block_id;?>').fadeIn(200);" /></div><?}?>
						<?if ($editable > 0) {?><div class="close_b"><img src="images/close.svg" onClick="if (confirm('Все элементы и вложенные блоки будут также удалены! Вы уверены?')) {delblock(<?=$block_id;?>);}" /></div><?}?>
					</div>
					<h3><?=$block_title;?><?if ($module_name != "") {?> (Модуль &laquo;<?=$module_name;?>&raquo;<?}?>)</h3>
					<?
					while ($arr_query1 = mysql_fetch_array($query1))
						{
						$eid = $arr_query1["element_id"];
						$type = $arr_query1["element_type"];
						$format = $arr_query1["element_format"];
						$eproperties = $arr_query1["element_properties"];
						$value = stripslashes($arr_query1["element_data"]);
						?>
						<div class="group" id="element<?=$eid;?>_<?=$block_id;?>">
							<div class="ttl"><?=$arr_query1["element_title"];?></div>
							<div class="fld">
							<?
							/*
							Поля в родительском блоке
							-------------------------
							field -> type -> format
							-> 1 Строка
								1 - Текстовая
								2 - Число
								3 - Цвет

							-> 2 Текст
								1 - Только текст
								2 - Простой редактор
								3 - Сложный редактор

							-> 3 Изображение
								1 - Одно изображение
								2 - Массив изображений

							-> 4 Список
								1 - Список значений
								2 - Единичный выбор из списка
								3 - Множественный выбор из списка
								4 - Единичный выбор из другого блока
								5 - Множественный выбор из другого блока

							-> 5 Чекбокс
								1 - Да / нет

							-> 6 Дата
								1 - ДД.ММ.ГГГГ
								2 - ДД МЕСЯЦ ГГГГ
								3 - Особый
							*/
							$arr_properties = explode("|", $eproperties);
							if (is_array($arr_properties))
							foreach ($arr_properties as $properties)
								{
								$arr_property = explode("=", $properties);
								$eproperty[$arr_property[0]] = $arr_property[1];
							}
							switch ($type) {
								case 1:
									switch ($format) {
										case 1:
											?>
											<input size="20" name="element<?=$eid;?>" value="<?=htmlspecialchars($value, ENT_QUOTES);?>" />
											<?
										break;
										case 2:
											?>
											<input size="3" name="element<?=$eid;?>" value="<?=htmlspecialchars($value, ENT_QUOTES);?>" />
											<?
										break;
										case 3:
											?>
											<input size="5" name="element<?=$eid;?>" value="<?=htmlspecialchars($value, ENT_QUOTES);?>" />
											<?
										break;
									}
								break;
								case 2:
									?>
									<textarea <?if ($format != 2) {?>class="tiny" <?}?>name="element<?=$eid;?>" id="element<?=$eid;?>" cols="40" rows="5"><?=htmlspecialchars($value, ENT_QUOTES);?></textarea><br />
									<!--<img align="left" class="newpic" data-id="element<?=$eid;?>" title="Вставить изображение" src="images/image.svg" width="32" height="32" />
									<img align="left" title="Вставить видео" src="images/movie.svg" width="32" height="32" style="margin: 3px;" onClick="insertvideo('element<?=$eid;?>');" />-->
									<?
								break;
								case 3:
									if ($format == 2)
										{
										$values1 = explode("=", $value);
										?>
										<div class="pic" id="pic1_<?=$eid;?>">
										<?
										$picval = "";
										foreach ($values1 as $picval)
										if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$picval))
											{
											$file_info = getImageSize($_SERVER["DOCUMENT_ROOT"]."/images/data/".$picval);
											?><img width="100" src="/images/data/<?=$picval;?>" /><span onClick="del_pic(<?=$eid;?>, 1);">X</span>
											<br />
											Размер <?=$file_info[0];?>x<?=$file_info[1];?>px
											<?
										}
										?>
										</div>
										<br />
										<input type="button" class="newpic" data-id="<?=$eid;?>" data-format="2" data-row="1" data-page="<?=$page_id;?>" data-block="<?=$block_id;?>" value="Загрузить" />
										<?
									}
									else
										{
										?>
										<div class="pic" id="pic1_<?=$eid;?>">
										<?if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$value))
											{
											$file_info = getImageSize($_SERVER["DOCUMENT_ROOT"]."/images/data/".$value);
											?><img width="100" src="/images/data/<?=$value;?>" /><span onClick="del_pic(<?=$eid;?>, 1);">X</span>
											<br />
											Размер <?=$file_info[0];?>x<?=$file_info[1];?>px
											<?
										}
										?>
										</div>
										<input type="button" class="newpic" data-id="<?=$eid;?>" data-row="1" data-page="<?=$page_id;?>" data-block="<?=$block_id;?>" value="Загрузить" />
										<?
									}
								break;
								case 4:
									switch ($format) {
										case 1:
											?>В доработке<?
										break;
										case 2:
											?>
											<div id="options<?=$eid;?>" class="options">
												<div class="close"><img src="images/close.svg" onClick="$('#options<?=$eid;?>').fadeOut('fast'); $('.mask').fadeOut('fast');" /></div>
												<h3>Редактирование списка:</h3>
												<?
												$query_p = mysql_query("select * from ".$prefix."_real_data where element_id = ".$eid) or die("ERR5: ".mysql_error());
												if ($arr_query_p = mysql_fetch_array($query_p))
													{
													if ($arr_query_p["element_data"] != "")
														{
														$fitems = explode("^", $arr_query_p["element_data"]);
														foreach ($fitems as $fcnt => $fitem)
															{
															?>
															<div class="fitem" id="fitem<?=$eid;?>_<?=$fcnt;?>"><?=$fitem;?>&nbsp;<img onClick="delfitem(<?=$eid;?>, <?=$fcnt;?>);" src="images/delete.svg" /></div>
															<?
														}
													}
												}
												?>
												<input name="newfitem<?=$eid;?>" id="newfitem<?=$eid;?>" /><button onClick="if ($('#newfitem').val() != '') {addfitem(<?=$eid;?>, $('#newfitem<?=$eid;?>').val(), <?=++$fcnt;?>)}; return false;">Добавить</button>
												<?
												?>
											</div>
											<select class="lelement<?=$eid;?>" name="element0_<?=$eid;?>" id="element0_<?=$eid;?>" onChange="if (this.value == 'NEW') { $('.mask').fadeIn('fast'); $('#options<?=$eid;?>').fadeIn(300);}; if (this.value != '') {checklistitem(<?=$eid;?>, 0, $('#element0_<?=$eid;?> option:selected').val(), $('#element0_<?=$eid;?> option:selected').text(), true);}">
												<option value="">Не выбрано</option>
												<?
												if ($value != "")
													$lvalues = explode("^", $value);
												if (is_array($lvalues))
													{
													foreach ($lvalues as $lkey => $lvalue)
														{
														$selected = "";
														if ($lvalue != str_replace("*", "", $lvalue))
															$selected = " selected";
														$lvalue = str_replace("*", "", $lvalue);
														?>
														<option value="<?=$lkey;?>"<?=$selected;?>><?=$lvalue;?></option>
														<?
													}
													$value = implode("^", $lvalues);
												}
												?>
												<option value="NEW">Изменить список</option>
											</select>
											<input type="hidden" name="element<?=$eid;?>" id="hiddenlist0_<?=$eid;?>" value="<?=$value;?>" />
											<?
										break;
										case 3:
											$lvalues = implode("|", $value);
											if (is_array($lvalues))
											foreach ($lvalues as $lkey => $lvalue)
												{
												?>
												<div class="lelement"><?=$lvalue;?><button><img class="delel" src="images/close.svg" /></button></div>
												<?
											}
											?>
											<input size="5" name="element<?=$eid;?>" value="" />&nbsp;<button>+</button>
											<?
										break;
										case 4:
											if ($eproperty["module_id"] != "")
												{
												$query_p = mysql_query("select * from ".$prefix."_blocks where parent_id in (select block_id from ".$prefix."_blocks where module_id = ".$eproperty["module_id"].")") or die("ERR5: ".mysql_error());
												if (mysql_num_rows($query_p) == 1 && $arr_query_p = mysql_fetch_array($query_p))
													{
													?>
													<select name="element<?=$eid;?>">
														<option value="">-= не выбрано =-</option>
													<?
													$query_e = mysql_query("select element_row, group_concat(rd.element_id order by rd.element_order separator '|') as ids, group_concat(element_data order by rd.element_order separator ' | ') as data from ".$prefix."_real_data rd left join ".$prefix."_elements e on e.element_id = rd.element_id where rd.block_id = ".$arr_query_p["block_id"]." and element_type = 1 and element_format = 1 group by element_row order by rd.element_order") or die("ERR5: ".mysql_error());
													while ($arr_query_e = mysql_fetch_array($query_e))
														{
														$arr_elids = explode("|", $arr_query_e["ids"]);
														$arr_vals = explode("|", $arr_query_e["data"]);
														?>
														<option value="<?=$arr_elids[0];?>^<?=$arr_query_e["element_row"];?>"><?=$arr_query_e["data"];?></option>
														<?
													}
													?>
													</select>
													<?
												}
												else
													{
													$query_p = mysql_query("select * from ".$prefix."_blocks b left join ".$prefix."_blocks_data bd on bd.block_id = b.block_id where module_id = ".$eproperty["module_id"]) or die("ERR5: ".mysql_error());
													?>
													<select name="element<?=$eid;?>">
														<option value="">-= не выбрано =-</option>
													<?
													while ($arr_query_p = mysql_fetch_array($query_p))
														{
														?>
														<option value="<?=$arr_query_p["page_id"];?>^0"<?if ($value == $arr_query_p["page_id"]."^0") {?> selected<?}?>><?=$arr_query_p["block_title"];?></option>
														<?
													}
													?>
													</select>
													<?
												}
											}
											else
												{
												?>Не задан модуль, <span onClick=" $('.mask').fadeIn('fast');$('#allmodules<?=$eid;?>').fadeIn(300);" class="link">задать</span>
												<div class="allmodules" id="allmodules<?=$eid;?>">
													<div class="close"><img src="images/close.svg" onClick="$('#allmodules<?=$eid;?>').fadeOut('fast'); $('.mask').fadeOut('fast');" /></div>
													<h3>Задать модуль для выбора</h3>
													<div class="allmodules_">
														<?
														foreach ($allmodules as $mid => $module)
															{
															?>
															<span class="link" onClick="setmodule(<?=$eid;?>, <?=$mid;?>);"><?=$module;?></span><br />
															<?
														}
														?>
													</div>
												</div>
												<?
											}
										break;
									}
								break;
								case 5:
									?>
									<input type="checkbox" name="element<?=$eid;?>" value="1"<?if ($value == 1) {?> checked<?}?> />
									<?
								break;
							}
							?>
							<?if ($editable == 2) {?><img class="delel" src="images/close.svg" onClick="if (confirm('Вы уверены?')) {delelement(<?=$eid;?>, <?=$block_id;?>);}" /><?}?>
							</div>
						</div>
						<?
					}
					$query2 = mysql_query("select * from ".$prefix."_blocks b left join ".$prefix."_blocks_data bd on bd.block_id = b.block_id where lang_id = ".$lang_id." and parent_id = ".$block_id." order by block_order") or die("ERR3: ".mysql_error());
					while ($arr_query2 = mysql_fetch_array($query2))
						{
						$bid = $arr_query2["block_id"];
						$bname = $arr_query2["block_title"];
						?>
						<div class="inblock"><a href="?page_id=<?=$page_id;?>&block_id=<?=$bid;?>"><?=$bname;?></a><?if ($editable == 2) {?><img class="delbl" src="images/close.svg" onClick="if (confirm('Все элементы и вложенные блоки будут также удалены! Вы уверены?')) {delblock(<?=$bid;?>);}" /><?}?></div>
						<?
					}
					if ($b_modules[$module_id] != "")
						{
						$s_query = mysql_query("select * from ".$prefix."_blocks b left join ".$prefix."_pages p on p.page_id = b.page_id left join ".$prefix."_pages_data pd on pd.page_id = p.page_id where module_id = ".$b_modules[$module_id]." and lang_id = ".$lang_id." order by page_order") or die(mysql_error());
						while ($arr_s_query = mysql_fetch_array($s_query))
							{
							?>
							<div class="inblock"><a href="?page_id=<?=$arr_s_query["page_id"];?>"><?=$arr_s_query["page_title"];?></a></div>
							<?
						}
						if ($editable > 0)
							{
							?>
							<div class="inblock_"><span class="link" onClick="$('.mask').fadeIn(200); $('#newpage').fadeIn(300);">Добавить новый</span></div>
							<?
						}
					}
					if ($editable == 2)
						{
						?>
						<div class="addelement" id="addelement<?=$block_id;?>"><button onClick="addelement(<?=$block_id;?>); return false;">Добавить элемент</button></div>
						<div class="addsubblock" id="addsubblock<?=$block_id;?>"><button onClick="addblock(<?=$page_id;?>, <?=$block_id;?>); return false;">Добавить вложенный блок</button></div>
						<?
					}
					?>
				</div>
				<?
			}
			?>
		</div>
		<?
	}
	else
		{
		?>
		<div class="subblock">
		<?
		$query1 = mysql_query("select b.*, bd.*, bd1.block_title as parent_title from ".$prefix."_blocks b left join ".$prefix."_blocks_data bd on bd.block_id = b.block_id and bd.lang_id = ".$lang_id." left join ".$prefix."_blocks_data bd1 on bd1.block_id = b.parent_id and bd1.lang_id = ".$lang_id." where b.block_id = ".$parent_id) or die("ERR4: ".mysql_error());
		if (mysql_num_rows($query1) == 0)
			{
			?>
			<div id="nodata">Вложенных блоков не обнаружено</div>
			<?
		}
		else
			{
			$arr_query1 = mysql_fetch_array($query1);
			$block_id = $parent_id;
			$parent_id = $arr_query1["parent_id"];
			$page_id = $arr_query1["page_id"];
			$block_title = $arr_query1["block_title"];
			$parent_title = $arr_query1["parent_title"];
			$sortable = 1; // $arr_query1["sortable"];
			?>
			<a href="?page_id=<?=$page_id;?>#block<?=$parent_id;?>"><< вернуться к родительскому блоку</a>
			<h2>Редактирование блока «<?=$block_title;?>» для «<?=$parent_title;?>»</h2>
			<?
			if ($editable == 2)
				{
				?>
				<div class="take1">
					<img src="images/take.svg" onClick="takedata(<?=$block_id;?>, $('#takelang<?=$block_id;?>').val(), <?=$lang_id;?>)" />
					<select name="takelang<?=$block_id;?>" id="takelang<?=$block_id;?>">
						<?
						foreach ($alllangs as $lid => $lang)
							{
							if ($lid != $lang_id)
								{
								?>
								<option value="<?=$lid;?>"><?=$lang;?></option>
								<?
							}
						}
						?>
					</select>
				</div>
				<br />
				<?
			}
			$query2 = mysql_query("select * from ".$prefix."_elements e left join ".$prefix."_elements_data ed on ed.element_id = e.element_id where lang_id = ".$lang_id." and block_id = ".$block_id." order by element_order") or die("ERR5: ".mysql_error());
			while ($arr_query2 = mysql_fetch_array($query2))
				{
				$mainfields[$arr_query2["element_id"]] = $arr_query2["element_title"];
				$types[$arr_query2["element_id"]] = $arr_query2["element_type"];
				$eformats[$arr_query2["element_id"]] = $arr_query2["element_format"];
				$eproperties[$arr_query2["element_id"]] = $arr_query2["element_properties"];
			}
			if (is_array($mainfields))
				{
				foreach ($types as $field => $type)
					{
					if ($type == 3)
						{
						?>
						<input type="hidden" name="pic<?=$field;?>" id="picfile<?=$field;?>" value="" />
						<?
					}
					if ($type == 4)
						{
						?>
						<input type="hidden" name="list<?=$field;?>" id="hiddenlist<?=$field;?>" value="" />
						<?
					}
				}
			}
			?>
			<input type="hidden" name="sort_bid" id="sort_bid" value="<?=$block_id;?>">
			<table border="0" cellspacing="3" cellpadding="3"<?if ($sortable != "") {?> id="sorting"<?}?> class="table">
				<tr class="nodrop nodrag">
					<?
					if ($sortable != "")
						{
						?>
						<th>&nbsp;&nbsp;</th>
						<?
					}
					if (is_array($mainfields))
						{
						foreach ($mainfields as $field => $fieldname)
							{
							?>
							<th><?=$fieldname;?></th>
							<?
						}
					}
					if ($editable == 1 || $editable == 0)
						{
						?>
						<th><img style="width: 24px; height: 24px;" src="images/delete.svg" /></th>
						<?
					}
					?>
				</tr>
				<?
				if ($editable == 1 || $editable == 0)
					{
					?>
					<tr style="background-color: #DDFFDD;" class="nodrop nodrag">
						<?
						$fcnt = 1;
						if ($sortable != "")
							{
							$fcnt++;
							?>
							<td></td>
							<?
						}
						if (is_array($mainfields))
							{
							foreach ($types as $field => $type)
								{
								$fcnt++;
								?>
								<td valign="top">
									<?
									/*
									Поля при добавлении новой строки в блоке с родителем
									----------------------------------------------------
									field -> type -> format
									-> 1 Строка
										1 - Текстовая
										2 - Число
										3 - Цвет

									-> 2 Текст
										1 - Только текст
										2 - Простой редактор
										3 - Сложный редактор

									-> 3 Изображение
										1 - Одно изображение
										2 - Массив изображений

									-> 4 Список
										1 - Список значений
										2 - Единичный выбор из списка
										3 - Множественный выбор из списка
										4 - Единичный выбор из другого блока
										5 - Множественный выбор из другого блока

									-> 5 Чекбокс
										1 - Да / нет

									-> 6 Дата
										1 - ДД.ММ.ГГГГ
										2 - ДД МЕСЯЦ ГГГГ
										3 - Особый
									*/
									$format = $eformats[$field];
									$arr_properties = explode("|", $eproperties[$field]);
									if (is_array($arr_properties))
									foreach ($arr_properties as $properties)
										{
										$arr_property = explode("=", $properties);
										$eproperty[$arr_property[0]] = $arr_property[1];
									}
									switch ($type) {
										case 1:
											switch ($format) {
												case 1:
												?>
												<input size="20" name="element<?=$field;?>" value="" />
												<?
												break;
												case 2:
												?>
												<input size="3" name="element<?=$field;?>" value="" />
												<?
												break;
												case 3:
												?>
												<input size="5" name="element<?=$field;?>" value="" />
												<?
												break;
											}
										break;
										case 2:
											?>
											<textarea <?if ($format != 2) {?>class="tiny" <?}?>name="element<?=$field;?>" id="element<?=$field;?>" cols="40" rows="5"></textarea>
											<!--<img align="left" class="newpic" data-id="element<?=$field;?>" title="Вставить изображение" src="images/image.svg" width="32" height="32" style="margin: 3px;" />
											<img align="left" title="Вставить видео" src="images/movie.svg" width="32" height="32" style="margin: 3px;" onClick="insertvideo('element<?=$field;?>');" />-->
											<?
										break;
										case 3:
											?>
											<div class="pic" id="pic0_<?=$field;?>">
											</div>
											<br />
											<input type="button" class="newpic" data-id="<?=$field;?>" data-row="0" data-page="<?=$page_id;?>" data-block="<?=$block_id;?>" value="Загрузить" />
											<?
										break;
										case 4:
											switch ($format) {
												case 1:
												?>
												<input size="5" id="list<?=$field;?>" name="element<?=$field;?>" value="" />&nbsp;<button class="inlist" onClick="addlistitem(<?=$field;?>, 1, 0, $('#list<?=$field;?>').val()); return false;">+</button><br />
												<?
												break;
												case 2:
													?>Выберите после добавления
													<div id="options<?=$field;?>" class="options">
														<div class="close"><img src="images/close.svg" onClick="$('#options<?=$field;?>').fadeOut('fast'); $('.mask').fadeOut('fast');" /></div>
														<h3>Редактирование списка:</h3>
														<?
														$query_p = mysql_query("select * from ".$prefix."_real_data where element_id = ".$field) or die("ERR5: ".mysql_error());
														if ($arr_query_p = mysql_fetch_array($query_p))
															{
															if ($arr_query_p["element_data"] != "")
																{
																$fitems = explode("^", $arr_query_p["element_data"]);
																foreach ($fitems as $fcnt => $fitem)
																	{
																	?>
																	<div class="fitem" id="fitem<?=$field;?>_<?=$fcnt;?>"><?=$fitem;?>&nbsp;<img onClick="delfitem(<?=$field;?>, <?=$fcnt;?>);" src="images/delete.svg" /></div>
																	<?
																}
															}
															?>
															<input name="newfitem<?=$field;?>" id="newfitem<?=$field;?>" /><button onClick="if ($('#newfitem').val() != '') {addfitem(<?=$field;?>, $('#newfitem<?=$field;?>').val(), <?=++$fcnt;?>)}; return false;">Добавить</button>
															<?
														}
														?>
													</div>
													<?
												break;
												// доделать
												case 3:
													?>!<?
												break;
												case 4:
													if ($eproperty["module_id"] != "")
														{
														$query_p = mysql_query("select * from ".$prefix."_blocks where parent_id = (select block_id from ".$prefix."_blocks where module_id = ".$eproperty["module_id"].")") or die("ERR5: ".mysql_error());
														if (mysql_num_rows($query_p) == 1 && $arr_query_p = mysql_fetch_array($query_p))
															{
															?>
															<select name="list<?=$field;?>">
																<option value="">-= не выбрано =-</option>
															<?
															$query_e = mysql_query("select element_row, group_concat(rd.element_id order by rd.element_order separator '|') as ids, group_concat(element_data order by rd.element_order separator ' | ') as data from ".$prefix."_real_data rd left join ".$prefix."_elements e on e.element_id = rd.element_id where rd.block_id = ".$arr_query_p["block_id"]." and element_type = 1 and element_format = 1 group by element_row order by rd.element_order") or die("ERR5: ".mysql_error());
															while ($arr_query_e = mysql_fetch_array($query_e))
																{
																$arr_elids = explode("|", $arr_query_e["ids"]);
																$arr_vals = explode("|", $arr_query_e["data"]);
																?>
																<option value="<?=$arr_elids[0];?>^<?=$arr_query_e["element_row"];?>"><?=$arr_query_e["data"];?></option>
																<?
															}
															?>
															</select>
															<?
														}
														else
															{
															?>Блоков больше одного, выберите другой модуль<?
														}
													}
													else
														{
														?>Не задан модуль, <span onClick=" $('.mask').fadeIn('fast');$('#allmodules<?=$field;?>').fadeIn(300);" class="link">задать</span>
														<div class="allmodules" id="allmodules<?=$field;?>">
															<div class="close"><img src="images/close.svg" onClick="$('#allmodules<?=$field;?>').fadeOut('fast'); $('.mask').fadeOut('fast');" /></div>
															<h3>Задать модуль для выбора</h3>
															<div class="allmodules_">
																<?
																foreach ($allmodules as $mid => $module)
																	{
																	?>
																	<span class="link" onClick="setmodule(<?=$field;?>, <?=$mid;?>);"><?=$module;?></span><br />
																	<?
																}
																?>
															</div>
														</div>
														<?
													}
												break;
												// доделать
												case 5:
													?>!<?
												break;
											}
										break;
										case 5:
											?>
											<input type="checkbox" name="element<?=$field;?>" value="1" />
											<?
										break;
									}
									?>
								</td>
								<?
							}
						}
						?>
						<td valign="top"><button class="empty"><img style="width: 24px; height: 24px;" src="images/add.svg" /></td>
					</tr>
				<?
			}
			$query3 = mysql_query("select rd.*,
			group_concat(element_data order by e.element_order, rd.element_order separator '|') as element_value,
			group_concat(e.element_format order by e.element_order, rd.element_order separator '|') as element_formats,
			group_concat(e.element_id order by e.element_order, rd.element_order separator '|') as element_ids
			from ".$prefix."_elements e
			left join ".$prefix."_real_data rd on rd.element_id = e.element_id and rd.lang_id = ".$lang_id."
			where e.block_id = ".$block_id."
			group by element_row
			having element_row is not null
			order by e.element_order, rd.element_order") or die("ERR6: ".mysql_error());
			if (mysql_num_rows($query3) == 0)
				{
				?>
				<tr>
					<td colspan="<?=$fcnt;?>">Записей не обнаружено</td>
				</tr>
			<?
			}
			else
				{
				while ($arr_query3 = mysql_fetch_array($query3))
					{
					$erow = $arr_query3["element_row"];
					$values = explode("|", stripslashes($arr_query3["element_value"]));
					// print_r($values);
					// print "<br />";
					$elids = explode("|", $arr_query3["element_ids"]);
					$eformats = explode("|", $arr_query3["element_formats"]);
					// print_r($elids);
					// print "<br />";
					$value = array();
					foreach ($elids as $k => $elid)
						$value[$elid] = $values[$k];
					foreach ($elids as $k => $elid)
						$eformat[$elid] = $eformats[$k];
					// print_r($value);
					// print "<hr>";
					?>
					<tr id="<?=$erow;?>">
						<?if ($sortable != "")
							{
							?>
							<td class="dragHandle"></td>
							<?
						}
						foreach ($types as $field => $type)
							{
							?>
							<td valign="top" class="element<?=$field;?>">
								<?
								/*
								Поля для редактирования в блоке с родителем
								-------------------------------------------
								field -> type -> format
								-> 1 Строка
									1 - Текстовая
									2 - Число
									3 - Цвет

								-> 2 Текст
									1 - Только текст
									2 - Простой редактор
									3 - Сложный редактор

								-> 3 Изображение
									1 - Одно изображение
									2 - Массив изображений

								-> 4 Список
									1 - Список значений
									2 - Единичный выбор из списка
									3 - Множественный выбор из списка
									4 - Единичный выбор из другого блока
									5 - Множественный выбор из другого блока

								-> 5 Чекбокс
									1 - Да / нет

								-> 6 Дата
									1 - ДД.ММ.ГГГГ
									2 - ДД МЕСЯЦ ГГГГ
									3 - Особый
								*/
								switch ($type) {
									// строка
									case 1:
										switch ($eformat[$field]) {
											// просто текстовая строка
											case 1:
												?>
												<input size="20" name="element<?=$erow;?>_<?=$field;?>" value="<?=htmlspecialchars($value[$field], ENT_QUOTES);?>" />
												<?
											break;
											// число
											case 2:
												?>
												<input size="3" name="element<?=$erow;?>_<?=$field;?>" value="<?=htmlspecialchars($value[$field], ENT_QUOTES);?>" />
												<?
											break;
											// цвет
											case 3:
												?>
												<input size="5" name="element<?=$erow;?>_<?=$field;?>" value="<?=htmlspecialchars($value[$field], ENT_QUOTES);?>" />
												<?
											break;
										}
									break;
									case 2:
										?>
										<textarea <?if ($format != 2) {?>class="tiny" <?}?>name="element<?=$erow;?>_<?=$field;?>" id="element<?=$erow;?>_<?=$field;?>" cols="40" rows="5"><?=htmlspecialchars($value[$field], ENT_QUOTES);?></textarea>
										<!--<img align="left" class="newpic" data-id="element<?=$erow;?>_<?=$field;?>" title="Вставить изображение" src="images/image.svg" width="32" height="32" />
										<img align="left" title="Вставить видео" src="images/movie.svg" width="32" height="32" style="margin: 3px;" onClick="insertvideo('element<?=$erow;?>_<?=$field;?>');" />-->
										<?
									break;
									case 3:
										switch ($eformat[$field]) {
											default:
												?>
												<div class="pic" id="pic<?=$erow;?>_<?=$field;?>">
												<?if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$value[$field]))
													{
													$file_info = getImageSize($_SERVER["DOCUMENT_ROOT"]."/images/data/".$value[$field]);
													?><img width="100" src="/images/data/<?=$value[$field];?>" /><span onClick="del_pic(<?=$field;?>, <?=$erow;?>);">X</span>
													<br />
													Размер <?=$file_info[0];?>x<?=$file_info[1];?>px
													<?
												}
												?>
												</div>
												<br />
												<input type="button" class="newpic" data-id="<?=$field;?>" data-format="1" data-row="<?=$erow;?>" data-page="<?=$page_id;?>" data-block="<?=$block_id;?>" value="Загрузить" />
												<?
											break;
											case 2:
												$values1 = explode("=", $value[$field]);
												?>
												<div class="pic" id="pic<?=$erow;?>_<?=$field;?>">
												<?
												$picval = "";
												foreach ($values1 as $picval)
												if (is_file($_SERVER["DOCUMENT_ROOT"]."/images/data/".$picval))
													{
													$file_info = getImageSize($_SERVER["DOCUMENT_ROOT"]."/images/data/".$picval);
													?><img width="100" src="/images/data/<?=$picval;?>" /><span onClick="del_pic(<?=$field;?>, <?=$erow;?>);">X</span>
													<br />
													Размер <?=$file_info[0];?>x<?=$file_info[1];?>px
													<?
												}
												?>
												</div>
												<br />
												<input type="button" class="newpic" data-id="<?=$field;?>" data-format="2" data-row="<?=$erow;?>" data-page="<?=$page_id;?>" data-block="<?=$block_id;?>" value="Загрузить" />
												<?
											break;
										}
									break;
									case 4:
										switch ($eformat[$field]) {
											case 1:
												?>
												<input type="hidden" name="list<?=$erow;?>_<?=$field;?>" id="hiddenlist<?=$erow;?>_<?=$field;?>" value="<?=$value[$field];?>" />
												<?
												$lvalues = explode("^", $value[$field]);
												if (is_array($lvalues))
												foreach ($lvalues as $lkey => $lvalue)
													{
													?>
													<div class="lelement" id="lelement<?=$erow;?>_<?=$field;?>_<?=$lkey;?>"><?=$lvalue;?>&nbsp;<button onClick="dellistitem(<?=$field;?>, <?=$erow;?>, <?=$lkey;?>); return false;">X</button></div>
													<?
												}
												?>
												<input size="5" name="element<?=$erow;?>_<?=$field;?>" id="list<?=$erow;?>_<?=$field;?>" value="" />&nbsp;<button class="inlist" onClick="addlistitem(<?=$field;?>, <?=$eformat[$field];?>, <?=$erow;?>, $('#list<?=$erow;?>_<?=$field;?>').val()); return false;">+</button><br />
												<?
											break;
											case 2:
												if ($value[$field] != "")
													$lvalues[$field] = explode("^", $value[$field]);
												if ($value[$field] == "") {
													$arr_lvalues = array();
													if (is_array($lvalues[$field]))
														{
														foreach ($lvalues[$field] as $lkey => $lvalue)
															{
															$arr_lvalues[] = str_replace("*", "", $lvalue);
														}
														$value[$field] = implode("^", $arr_lvalues);
														$lvalues[$field] = explode("^", $value[$field]);
													}
												}
												// print $value[$field];
												?>
												<input type="hidden" name="list<?=$erow;?>_<?=$field;?>" id="hiddenlist<?=$erow;?>_<?=$field;?>" value="<?=$value[$field];?>" />
												<select class="list<?=$field;?>" name="lelement<?=$erow;?>_<?=$field;?>" id="list<?=$erow;?>_<?=$field;?>" onChange="if (this.value == 'NEW') { $('.mask').fadeIn('fast'); $('#options<?=$field;?>').fadeIn(300);}; if (this.value != '') {checklistitem(<?=$field;?>, <?=$erow;?>, $('#list<?=$erow;?>_<?=$field;?> option:selected').val(), $('#list<?=$erow;?>_<?=$field;?> option:selected').text(), true);}">
													<option value="">Не выбрано</option>
													<?
													if (is_array($lvalues[$field]))
													foreach ($lvalues[$field] as $lkey => $lvalue)
														{
														$selected = "";
														if ($lvalue != str_replace("*", "", $lvalue))
															$selected = " selected";
														$lvalue = str_replace("*", "", $lvalue);
														?>
														<option value="<?=$lkey;?>"<?=$selected;?>><?=$lvalue;?></option>
														<?
													}
													?>
													<option value="NEW">Изменить список</option>
												</select>
												<!--<input size="5" name="element<?=$erow;?>_<?=$field;?>" id="list<?=$erow;?>_<?=$field;?>" value="" />&nbsp;<button class="inlist" onClick="addlistitem(<?=$field;?>, <?=$eformat[$field];?>, <?=$erow;?>, $('#list<?=$erow;?>_<?=$field;?>').val()); return false;">+</button><br />-->
												<?
											break;
											// доделать
											case 3:
												?>!<?
											break;
											case 4:
												if ($eproperty["module_id"] != "")
													{
													$query_p = mysql_query("select * from ".$prefix."_blocks where parent_id = (select block_id from ".$prefix."_blocks where module_id = ".$eproperty["module_id"].")") or die("ERR5: ".mysql_error());
													if (mysql_num_rows($query_p) == 1 && $arr_query_p = mysql_fetch_array($query_p))
														{
														?>
														<select name="list<?=$erow;?>_<?=$field;?>">
															<option value="">-= не выбрано =-</option>
														<?
														$query_e = mysql_query("select element_row, group_concat(rd.element_id order by rd.element_order separator '|') as ids, group_concat(rd.element_data order by rd.element_order separator '|') as data from ".$prefix."_real_data rd left join ".$prefix."_elements e on e.element_id = rd.element_id where rd.block_id = ".$arr_query_p["block_id"]." and element_type = 1 and element_format = 1 group by element_row order by rd.element_order") or die("ERR5: ".mysql_error());
														while ($arr_query_e = mysql_fetch_array($query_e))
															{
															$arr_elids = explode("|", $arr_query_e["ids"]);
															$arr_vals = explode("|", $arr_query_e["data"]);
															?>
															<option value="<?=$arr_elids[0];?>^<?=$arr_query_e["element_row"];?>"<?if ($value[$field] == $arr_elids[0]."^".$arr_query_e["element_row"]) {?> selected<?}?>><?=$arr_vals[0];?></option>
															<?
														}
														?>
														</select>
														<?
													}
													else
														{
														?>Блоков больше одного, выберите другой модуль<?
													}
												}
												else
													{
													?>Не задан модуль, <span onClick=" $('.mask').fadeIn('fast');$('#allmodules<?=$field;?>').fadeIn(300);" class="link">задать</span>
													<div class="allmodules" id="allmodules<?=$field;?>">
														<div class="close"><img src="images/close.svg" onClick="$('#allmodules<?=$field;?>').fadeOut('fast'); $('.mask').fadeOut('fast');" /></div>
														<h3>Задать модуль для выбора</h3>
														<div class="allmodules_">
															<?
															foreach ($allmodules as $mid => $module)
																{
																?>
																<span class="link" onClick="setmodule(<?=$field;?>, <?=$mid;?>);"><?=$module;?></span><br />
																<?
															}
															?>
														</div>
													</div>
													<?
												}
											break;
											// доделать
											case 5:
												?>!<?
											break;
										}
									break;
									case 5:
										?>
										<input type="checkbox" name="element<?=$erow;?>_<?=$field;?>" value="1"<?if ($value[$field] == 1) {?> checked<?}?> />
										<?
									break;
									case 6:
										// доделать полностью
										switch ($eformat[$field]) {
											case 1:
												?>
												<input size="5" name="element<?=$erow;?>_<?=$field;?>" value="<?=htmlspecialchars($value[$field], ENT_QUOTES);?>" />
												<?
											break;
											case 2:
												?>
												<input size="5" name="element<?=$erow;?>_<?=$field;?>" value="<?=htmlspecialchars($value[$field], ENT_QUOTES);?>" />
												<?
											break;
											case 3:
												?>
												<input size="5" name="element<?=$erow;?>_<?=$field;?>" value="<?=htmlspecialchars($value[$field], ENT_QUOTES);?>" />
												<?
											break;
										}
									break;
								}
								?>
							</td>
							<?
							$fcnt++;
						}
						?>
						<td class="button" valign="top"><span class="pointer" onClick="if (confirm('Вы уверены?')) {document.location='?page_id=<?=$page_id;?>&block_id=<?=$block_id;?>&del=<?=$erow;?>'}"><img style="width: 24px; height: 24px;" src="images/delete.svg" /></span></td>
					</tr>
				<?
				}
			}
			?>
			</table>
			<?
			if ($editable == 2)
				{
				?>
				<div class="blockfields">
				<h2>Поля блока:</h2>
					<?
					if (is_array($mainfields))
						{
						foreach ($mainfields as $field => $fieldname)
							{
							?>
							<?=$fieldname;?> <?if ($editable > 0) {?><img class="delbl" src="images/close.svg" onClick="if (confirm('Вы уверены?')) {delelement(<?=$field;?>, <?=$block_id;?>);}" /><?}?><br />
							<?
						}
					}
					if ($editable > 0)
						{
						?>
						<div class="addelement" id="addelement<?=$block_id;?>" onClick="addelement(<?=$block_id;?>); return false;"><button>Добавить элемент</button></div>
						<?
					}
					?>
				</div>
				<?
				}
			}
			?>
			</div>
			<?
		}
		?>
		<button name="submit_que">обновить</button>
		</form>
		<?
	}
	if ($editable > 0)
		{
		?>
		<div class="addblock" id="addblock" onMouseOver="$(this).find('#hov').attr('src', 'images/add1.svg');" onMouseOut="$(this).find('#hov').attr('src', 'images/add.svg');" onClick="addblock(<?=$page_id;?>, 0);"><div class="incenter"><img class="hov" style="width: 24px; height: 24px;" src="images/add.svg" /></div></div>
		<?
	}
	?>
</div>
<div class="newblock" id="newblock">
	<div class="close"><img src="images/close.svg" onClick="$('#newblock').fadeOut('fast'); $('.mask').fadeOut('fast');" /></div>
	<h3>Добавление блока:</h3>
	<form id="b_form" onSubmit="return false;">
	<input type="hidden" name="b_page_id" id="b_page_id" />
	<input type="hidden" name="b_parent_id" id="b_parent_id" />
	<div class="group">
		<div class="ttl">Наименование блока</div>
		<div class="fld"><input type="text" name="b_name" id="b_name" /></div>
	</div>
	<div class="group">
		<div class="ttl">Подключенный модуль</div>
		<div class="fld"><select name="b_module_id" id="b_module_id" onChange="var aaa = this.value; $('.b_prop').fadeOut(100, function() {$('#b_prop' + aaa).fadeIn(100);});">
				<option value="">без модуля</option>
			<?
			if (chdir($_SERVER["DOCUMENT_ROOT"]."/admin/modules"))
				{
				$d = opendir(getcwd());
				while (($e = readdir($d)) != false)
					{
					if (substr($e,strlen($e)-4,4) == ".xml")
						{
						$fp = simplexml_load_file($e);
						$mid = (int)$fp->attributes()->id;
						$modules[$mid] = $fp->attributes()->name;
						foreach ($fp->properties->property as $property)
							{
							$pid = (string)$property->id;
							$b_props[$mid][$pid]["name"] = (string)$property->name;
							$b_props[$mid][$pid]["type"] = (string)$property->type;
							foreach ($property->values->value as $values)
								$b_props[$mid][$pid]["values"][(int)$values->id] = (string)$values->val;
							$b_props[$mid][$pid]["default"] = (int)$property->default;
						}
						?>
						<option value="<?=$fp->attributes()->id;?>"><?=(string)$fp->attributes()->name;?></option>
						<?
					}
				}
			}
			?>
			</select>
		</div>
	</div>
	<?
	if (is_array($b_props))
	foreach ($b_props as $mid => $b_prop)
		{
		?>
		<div class="b_prop" id="b_prop<?=$mid;?>" style="display: none;">
			<?
			foreach ($b_prop as $pid => $prop)
				{
				?>
				<div class="group">
					<div class="ttl"><?=$prop["name"];?></div>
					<div class="fld">
					<?
					switch ($prop["type"]) {
						case "list":
							?>
							<select name="b_prop_<?=$pid;?>" id="b_prop_<?=$pid;?>">
								<?
								foreach ($prop["values"] as $vid => $pval)
									{
									?>
									<option value="<?=$vid;?>"<?if ($vid == $prop["default"]) {?> selected<?}?>><?=$pval;?></option>
									<?
								}
								?>
							</select>
							<?
						break;
						case "bool":
							?>
							<input type="checkbox" name="b_prop_<?=$pid;?>" id="b_prop_<?=$pid;?>" value="1" <?if ($prop["default"] == 1) {?> checked<?}?>/>
							<?
						break;
						case "color":
							?>
							<input size="6" name="b_prop_<?=$pid;?>" id="b_prop_<?=$pid;?>" value="" />
							<script>
								$(function(){
									$('#b_prop_<?=$pid;?>').colorpicker();
								});
							</script>
							<?
						break;
						case "num":
							?>
							<input size="3" name="b_prop_<?=$pid;?>" id="b_prop_<?=$pid;?>" value="" />
							<?
						break;
						default:
							?>
							<input size="10" name="b_prop_<?=$pid;?>" id="b_prop_<?=$pid;?>" value="" />
							<?
						break;
					}
					?>
					</div>
				</div>
				<?
			}
			?>
		</div>
		<?
	}
	?>
	<div class="group">
		<button onClick="addnewblock();">Добавить</button>
	</div>
	</form>
</div>
<div class="newelement" id="newelement">
	<div class="close"><img src="images/close.svg" onClick="$('#newelement').fadeOut('fast'); $('.mask').fadeOut('fast');" /></div>
	<h3>Добавление элемента:</h3>
	<form id="e_form" onSubmit="return false;">
	<input type="hidden" name="e_block_id" id="e_block_id" />
	<div class="group">
		<div class="ttl">Наименование элемента</div>
		<div class="fld"><input type="text" name="e_name" id="e_name" /></div>
	</div>
	<div class="group">
		<div class="ttl">Тип элемента</div>
		<div class="fld"><select name="e_type" id="e_type" onChange="$('.e_format').hide(); $('#format_' + this.value).show(); $('.e_properties').hide(); $('#properties_' + this.value).show();">
				<option value="1">Строка</option>
				<option value="2">Текст</option>
				<option value="3">Изображение</option>
				<option value="4">Список</option>
				<option value="5">Чекбокс</option>
				<option value="6">Дата</option>
			</select>
		</div>
	</div>
	<div class="group">
		<div class="ttl">Формат элемента</div>
		<div class="fld e_format" id="format_1"><select name="e_format_1" id="e_format_1">
				<option value="1">Текстовая</option>
				<option value="2">Число</option>
			</select>
		</div>
		<div class="fld e_format" id="format_2" style="display: none;"><select name="e_format_2" id="e_format_2">
				<option value="1">Только текст</option>
				<option value="2">Простой редактор</option>
				<option value="3">Сложный редактор</option>
			</select>
		</div>
		<div class="fld e_format" id="format_3" style="display: none;"><select name="e_format_3" id="e_format_3">
				<option value="1">Одно изображение</option>
				<option value="2">Массив изображений</option>
			</select>
		</div>
		<div class="fld e_format" id="format_4" style="display: none;"><select name="e_format_4" id="e_format_4">
				<option value="1">Список значений</option>
				<option value="2">Единичный выбор из списка</option>
				<option value="3">Множественный выбор из списка</option>
			</select>
		</div>
		<div class="fld e_format" id="format_5" style="display: none;"><select name="e_format_5">
				<option value="1">Да / нет</option>
			</select>
		</div>
		<div class="fld e_format" id="format_6" style="display: none;"><select name="e_format_6">
				<option value="1">ДД.ММ.ГГГГ</option>
				<option value="2">ДД МЕСЯЦ ГГГГ</option>
				<option value="3">Особый</option>
			</select>
		</div>
	</div>
	<div class="properties">
		<h4>Свойства элемента</h4>
		<div class="e_properties" id="properties_1">
		<input type="hidden" name="e_properties_1" id="e_properties_1" value="limit|size" />
			<div class="group">
				<div class="ttl">Ограничение длины</div>
				<div class="fld"><input type="text" name="property_1_limit" id="property_1_limit" value="" /></div>
			</div>
			<div class="group">
				<div class="ttl">Размер текста</div>
				<div class="fld"><select name="property_1_size" id="property_1_size">
					<option value="0">по умолчанию</option>
					<option value="1">H1</option>
					<option value="2">H2</option>
					<option value="3">H3</option>
					<option value="4">H4</option>
					<option value="5">H5</option>
					<option value="6">H6</option>
					<option value="7">сноска</option>
				</select>
				</div>
			</div>
		</div>
		<div class="e_properties" id="properties_2" style="display: none;">
		<input type="hidden" name="e_properties_2" id="e_properties_2" value="limit" />
			<div class="group">
				<div class="ttl">Ограничение длины</div>
				<div class="fld"><input type="text" name="property_2_limit" id="property_2_limit" value="" /></div>
			</div>
		</div>
		<div class="e_properties" id="properties_3" style="display: none;">
		<input type="hidden" name="e_properties_3" id="e_properties_3" value="width|height" />
			<div class="group">
				<div class="ttl">Ширина</div>
				<div class="fld"><input type="text" name="property_3_width" id="property_3_width" value="" /></div>
			</div>
			<div class="group">
				<div class="ttl">Высота</div>
				<div class="fld"><input type="text" name="property_3_height" id="property_3_height" value="" /></div>
			</div>
		</div>
		<div class="e_properties" id="properties_4" style="display: none;">
		<input type="hidden" name="e_properties_4" id="e_properties_4" value="list|addon" />
			<div class="group">
				<div class="ttl">Список</div>
				<div class="fld"><select name="property_4_list" id="property_4_list">
					<option value="0">Свой список</option>
					<?
					$query = mysql_query("select * from ".$prefix."_blocks b left join ".$prefix."_blocks_data bd on bd.block_id = b.block_id where (parent_id is not NULL and parent_id != 0) and lang_id = ".$lang_id." and page_id = ".$page_id." order by block_order") or die("ERR1: ".mysql_error());
					while ($arr_query = mysql_fetch_array($query))
						{
						$block_id = $arr_query["block_id"];
						$block_title = $arr_query["block_title"];
						?>
						<option value="<?=$block_id;?>"><?=$block_title;?></option>
						<?
					}
					?>
				</select>
				</div>
			</div>
			<div class="group">
				<div class="ttl">Доп. поле</div>
				<div class="fld"><input type="text" name="property_4_addon" id="property_4_addon" value="" /></div>
			</div>
		</div>
		<div class="e_properties" id="properties_5" style="display: none;">
		<input type="hidden" name="e_properties_5" id="e_properties_5" value="width" />
			<div class="group">
				<div class="ttl">Ширина</div>
				<div class="fld"><input type="text" name="property_5_width" id="property_5_width" value="" /></div>
			</div>
		</div>
	</div>
	<button onClick="addnewelement();">Добавить</button>
	</form>
</div>
<div class="newpage" id="newpage">
	<div class="close"><img src="images/close.svg" onClick="$('#newpage').fadeOut('fast'); $('.mask').fadeOut('fast');" /></div>
	<h3>Добавление страницы:</h3>
	<form id="p_form" onSubmit="return false;">
	<div class="group">
		<div class="ttl">Наименование страницы</div>
		<div class="fld"><input type="text" name="p_name" id="p_name" /></div>
	</div>
	<div class="group">
		<div class="ttl">URL (<?=$_SERVER["SERVER_NAME"];?>/...)</div>
		<div class="fld"><input type="text" name="p_url" id="p_url" /></div>
	</div>
	<div class="group">
		<div class="ttl">Родительская страница</div>
		<div class="fld"><select name="p_parent" id="p_parent">
			<option value="NEW">-= нет =-</option>
			<?
			$query = mysql_query("select * from ".$prefix."_pages p left join ".$prefix."_pages_data pd on pd.page_id = p.page_id and lang_id = ".$lang_id) or die("ERR9: ".mysql_error());
			while ($arr_query = mysql_fetch_array($query))
				{
				?>
				<option value="<?=$arr_query["page_id"];?>"><?=$arr_query["page_title"];?></option>
				<?
			}
			?>
			</select>
		</div>
	</div>
	<div class="group">
		<div class="ttl">На основе</div>
		<div class="fld"><select name="p_type" id="p_type">
			<option value="NEW">Новая страница</option>
			<?
			$query = mysql_query("select * from ".$prefix."_pages p left join ".$prefix."_pages_data pd on pd.page_id = p.page_id and lang_id = ".$lang_id) or die("ERR10: ".mysql_error());
			while ($arr_query = mysql_fetch_array($query))
				{
				?>
				<option value="<?=$arr_query["page_id"];?>"><?=$arr_query["page_title"];?></option>
				<?
			}
			?>
			</select>
		</div>
	</div>
	<div class="group">
		<button onClick="addnewpage();">Добавить</button>
	</div>
	</form>
</div>
<div class="moveblock" id="moveblock">
	<div class="close"><img src="images/close.svg" onClick="$('#moveblock').fadeOut('fast'); $('.mask').fadeOut('fast');" /></div>
	<h3>Перемещение блока:</h3>
	<input type="hidden" id="move_block_id" value="" />
	<input type="hidden" id="move_block_from" value="" />
	<h4>На страницу:</h4>
		<?
		$query = mysql_query("select * from ".$prefix."_pages p left join ".$prefix."_pages_data pd on pd.page_id = p.page_id and lang_id = ".$lang_id." order by parent_id, page_order") or die("ERR10: ".mysql_error());
		while ($arr_query = mysql_fetch_array($query))
			{
			?>
			<span onClick="moveblock($('#move_block_id').val(), <?=$arr_query["page_id"];?>);"><?=$arr_query["page_title"];?></span>
			<?
		}
		?>
	<span>
</div>
<?
$query = mysql_query("
select * from ".$prefix."_blocks b
left join ".$prefix."_blocks_data bd on bd.block_id = b.block_id
where (parent_id is NULL or parent_id = 0) and lang_id = ".$lang_id." and page_id = ".$page_id." order by block_order
") or die("ERR1: ".mysql_error());
while ($arr_query = mysql_fetch_array($query))
	{
	$block_id = $arr_query["block_id"];
	$module_id = $arr_query["module_id"];
	?>
	<div class="editprops" id="editprops<?=$block_id;?>">
		<div class="close"><img src="images/close.svg" onClick="$('#editprops<?=$block_id;?>').fadeOut('fast'); $('.mask').fadeOut('fast');" /></div>
		<form id="b_form_<?=$block_id;?>" onSubmit="return false;">
		<input type="hidden" name="mid" id="mid" value="<?=$module_id;?>" />
		<?
		$query3 = mysql_query("select * from ".$prefix."_blocks_properties where block_id = ".$block_id) or die("ERR31: ".mysql_error());
		$block_props = "";
		while ($arr_query3 = mysql_fetch_array($query3))
			$block_props[$arr_query3["b_property_name"]] = $arr_query3["b_property_value"];
		
		if (is_array($b_props[$module_id]))
		foreach ($b_props[$module_id] as $pid => $prop)
			{
			?>
			<div class="group">
				<div class="ttl"><?=$prop["name"];?></div>
				<div class="fld">
				<?
				switch ($prop["type"]) {
					case "4":
						?>
						<select name="b_propval_<?=$block_id;?>_<?=$pid;?>" id="b_propval_<?=$block_id;?>_<?=$pid;?>">
							<?
							foreach ($prop["values"] as $vid => $pval)
								{
								?>
								<option value="<?=$vid;?>"<?if ($vid == $block_props[$pid]) {?> selected<?}?>><?=$pval;?></option>
								<?
							}
							?>
						</select>
						<?
					break;
					case "5":
						?>
						<input type="checkbox" name="b_propval_<?=$block_id;?>_<?=$pid;?>" id="b_propval_<?=$block_id;?>_<?=$pid;?>" value="1" <?if ($block_props[$pid] == 1) {?> checked<?}?>/>
						<?
					break;
					case "1":
						if ($prop["format"] == 3)
							{
							?>
							<input size="6" name="b_propval_<?=$block_id;?>_<?=$pid;?>" id="b_propval_<?=$block_id;?>_<?=$pid;?>" value="<?=$block_props[$pid];?>" />
							<script>
								$(document).ready(function() {
									$("#b_propval_<?=$block_id;?>_<?=$pid;?>").colorpicker();
								});
							</script>
							<?
						}
						else
							{
							?>
							<input size="10" name="b_propval_<?=$block_id;?>_<?=$pid;?>" id="b_propval_<?=$block_id;?>_<?=$pid;?>" value="<?=$block_props[$pid];?>" />
							<?
						}
					break;
					default:
						?>
						<input size="10" name="b_propval_<?=$block_id;?>_<?=$pid;?>" id="b_propval_<?=$block_id;?>_<?=$pid;?>" value="<?=$block_props[$pid];?>" />
						<?
					break;
				}
				?>
				</div>
			</div>
			<?
		}
		?>
		<div class="group">
			<button onClick="editblockprops(<?=$block_id;?>);">Сохранить</button>
		</div>
		</form>
	</div>
	<?
}
?>
</div>
<div class="editpage" id="editpage<?=$page_id;?>">
	<div class="close"><img src="images/close.svg" onClick="$('#editpage<?=$page_id;?>').fadeOut('fast'); $('.mask').fadeOut('fast');" /></div>
	<h3>Настройки страницы:</h3>
	<form id="p_form<?=$page_id;?>" onSubmit="return false;">
	<input type="hidden" name="lang_id" id="lang_id" value="<?=$lang_id;?>" />
	<div class="group">
		<div class="ttl">URL (<?=$_SERVER["SERVER_NAME"];?>/...)</div>
		<div class="fld"><input type="text" name="p_url" id="p_url" value="<?=$pg_url;?>" /></div>
	</div>
	<div class="group">
		<div class="ttl">Название страницы</div>
		<div class="fld"><input type="text" name="p_name" id="p_name" value="<?=$pg_title;?>" /></div>
	</div>
	<div class="group">
		<div class="ttl">МЕТА-Заголовок</div>
		<div class="fld"><input size="30" type="text" name="p_title" id="p_title" value="<?=$pg_mtitle;?>" /></div>
	</div>
	<div class="group">
		<div class="ttl">МЕТА-Ключевые слова</div>
		<div class="fld"><input size="30" type="text" name="p_kw" id="p_kw" value="<?=$pg_kw;?>" /></div>
	</div>
	<div class="group">
		<div class="ttl">МЕТА-Описание</div>
		<div class="fld"><textarea cols="80" rows="2" name="p_dscr" id="p_dscr"><?=$pg_dscr;?></textarea></div>
	</div>
	<div class="group">
		<button onClick="editpage(<?=$page_id;?>);">Сохранить</button>
	</div>
	</form>
</div>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector: ".tiny",  elementpath: false, width: 500, plugins: "link charmap code table", relative_urls : true, document_base_url : "http://<?=$_SERVER["HTTP_HOST"];?>", removed_menuitems: "newdocument", force_br_newlines : true, force_p_newlines : false, forced_root_block : "" });</script>
<?
mysql_close();
include "includes/footer.php";
?>
