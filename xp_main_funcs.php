<?
if ($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" && (preg_match("/^http:\/\/".$_SERVER["SERVER_NAME"]."\/admin\//", $_SERVER["HTTP_REFERER"]) || preg_match("/^http:\/\/www.".$_SERVER["SERVER_NAME"]."\/admin\//", $_SERVER["HTTP_REFERER"])))
	{
	include "includes/connection.php";
	include "includes/main_init.php";
	include "includes/main_func.php";
	include "includes/messages.php";
	include "secure.php";

	switch ((int)$_POST["section"])
		{
		case 1:
			// добавление раздела
			if ($lang_id != "" && $_POST["ttl"] != "" && intval($_POST["dept_id"]) != 0)
				{
				$dept_id = intval($_POST["dept_id"]);
				$dept_ename = Translit(iconv("utf-8", "cp1251", $_POST["ttl"]));
				$dept_name = mysql_real_escape_string($_POST["ttl"]);
				
				$slct = mysql_query("select * from ".$prefix."_dept_names where dept_name = '".$dept_name."' or dept_ename = '".$dept_ename."'") or die("2:".mysql_error());
				if (mysql_num_rows($slct) > 0)
					echo 0;
				else
					{
					$max_dept_order_query = mysql_query("select max(dept_order) as max_dept_order from ".$prefix."_depts where parent_id = ".$dept_id) or die("1:".mysql_error());
					if ($arr_max_dept = mysql_fetch_array($max_dept_order_query))
						$order = $arr_max_dept["max_dept_order"] + 1;
					else
						$order = 1;
				
					mysql_query("insert into ".$prefix."_depts (parent_id, dtype_id, dept_order, secured)
											values (".$dept_id.", 1, ".$order.", 0)") or die("4:".mysql_error());
					$id = mysql_insert_id();
					$langs = mysql_query("select * from ".$prefix."_langs order by lang_order") or die("4:".mysql_error());
					while ($arr_langs = mysql_fetch_array($langs))
						{
						mysql_query("insert into ".$prefix."_dept_names (dept_id, lang_id, dept_name, dept_ename, dept_text, m_include)
						values (".$id.", '".$arr_langs["lang_id"]."', '".$dept_name."', '".$dept_ename."', '', 0)") or die("3:".mysql_error());
					}
					$data = "
					<tr id=\"line".$id."\">
						<td class=\"dragHandle\" align=\"center\" id=\"mv\"><img src=\"img/move.png\" /></td>
						<td><a href=\"main.php?dept_id=".$id."\" class=\"cms_razdel\">".$dept_name."</a></td>
						<td align=\"center\"><input type=\"checkbox\" name=\"n".$id."\" value=\"1\" onClick=\"dept_inc(".$id.", this.checked);\"></td>
						<td align=\"center\"><select name=\"dtype_id".$id."\" onchange=\"chmodule(".$id.", this.value);\">
						
							<option value=\"0\">----</option>";
					$dept_types_query = mysql_query("select * from ".$prefix."_dept_types");
					while ($arr_dept_types = mysql_fetch_array($dept_types_query))
						$data .= "<option value=\"".$arr_dept_types["dtype_id"]."\">".$arr_dept_types["dept_type"]."</option>";
					$data .= "
							</select></td>
						<td align=\"center\"><a href=\"main.php?dept_id=".$id."\"><img src=\"img/edit.gif\" width=\"24\" height=\"24\" border=\"0\"></a></td>
						<td align=\"center\"><a href=\"#\" onClick=\"if (confirm('".show_mess("ConfDel")."'))	{dept_del(".$dept_id.", ".$id.");};\"><img src=\"img/del.gif\" width=\"20\" height=\"19\" border=\"0\" alt=\"".show_mess("TTLDeleteDept")."\"></a></td>
					</tr>
					";
					echo $data;
				}
				
			}
		break;
		case 2:
			// удаление страницы
			if (intval($_POST["page_id"]) != 0)
				{
				$pid = intval($_POST["page_id"]);

				mysql_query("delete from ".$prefix."_pages_data where page_id = ".$pid) or die("Error 2.1: ".mysql_error());
				mysql_query("delete from ".$prefix."_pages where page_id = ".$pid) or die("Error 2.2: ".mysql_error());
				mysql_query("delete from ".$prefix."_blocks_data where block_id in (select block_id from ".$prefix."_blocks where page_id = ".$pid.")") or die("Error 2.3: ".mysql_error());
				mysql_query("delete from ".$prefix."_elements_data where element_id in (select element_id from ".$prefix."_elements where block_id in (select block_id from ".$prefix."_blocks where page_id = ".$pid."))") or die("Error 2.4: ".mysql_error());
				mysql_query("delete from ".$prefix."_elements where block_id in (select block_id from ".$prefix."_blocks where page_id = ".$pid.")") or die("Error 2.5: ".mysql_error());
				mysql_query("delete from ".$prefix."_blocks where page_id = ".$pid) or die("Error 2.6: ".mysql_error());
				mysql_query("delete from ".$prefix."_real_data where page_id = ".$pid) or die("Error 2.7: ".mysql_error());
				
				echo "OK";
			}
		break;
		case 3:
			// включение и выключение раздела
			if ($lang_id != "" && intval($_POST["id"]) != 0)
				{
				$id = intval($_POST["id"]);

				if ($_POST["inc"] == "true")
					$state = 1;
				else
					$state = 0;
				
				mysql_query("update ".$prefix."_dept_names set m_include = ".$state." where lang_id = ".$lang_id." and dept_id = ".$id);
			}
		break;
		case 4:
			// изменение порядка разделов
			if ($_POST["id"] != "")
				{
				$str_tmp = str_replace("lastest","",substr_replace($_POST["id"], "", strrpos($_POST["id"], "|")));
				$id = explode("line", $str_tmp);
			
				foreach ($id as $sort => $id)
					{
					mysql_query("update ".$prefix."_depts set dept_order = ".$sort." where dept_id = ".intval($id));
				}
			}
		break;
		case 5:
			// добавление типа раздела
			if ($_POST["id"] != "")
				{
				$new_dname = $_POST["id"];
				
				$insert_module = mysql_query("insert into ".$prefix."_dept_types values ('','".$new_dname."', 1)") or die(mysql_error());
				
				$new_dept_id = mysql_insert_id();
				
				$chk_file = "modules/".$new_dname."/".$new_dname."_init.php";
				
				if (is_file($chk_file))
					require $chk_file;
				
				if ($multiple_dept == 1)
					mysql_query("update ".$prefix."_dept_types set once = 0 where dtype_id = ".$new_dept_id) or die(mysql_error());
			}
		break;
		case 6:
			// изменение типа раздела
			if ($_POST["did"] != "" && $_POST["mid"] != "")
				{
				$did = $_POST["did"];
				$mid = $_POST["mid"];
				
				mysql_query("update ".$prefix."_depts set dtype_id = ".$mid." where dept_id = ".$did) or die(mysql_error());
				echo "UPDATE DONE!";
			}
		break;
		case 7:
			// Добавление блока (контейнера)
			if ((int)$_POST["b_page_id"] != 0)
				{
				$pid = (int)$_POST["b_page_id"];
				$parid = (int)$_POST["b_parent_id"];
				$name = mysql_real_escape_string($_POST["b_name"]);
				if ($name != "")
					{
					$mid = (int)$_POST["b_module_id"];
					if ($mid == 0)
						$mid = "NULL";
					$max_block_order_query = mysql_query("select max(block_order) as max_block_order from ".$prefix."_blocks where parent_id = ".$parid) or die("7.1:".mysql_error());
					if ($arr_max_block = mysql_fetch_array($max_block_order_query))
						$order = $arr_max_block["max_block_order"] + 1;
					else
						$order = 1;
					
					mysql_query("insert into ".$prefix."_blocks (page_id, parent_id, module_id, block_order) values (".$pid.", ".$parid.", ".$mid.", ".$order.")") or die("7.2: ".mysql_error());
					$id = mysql_insert_id();
					$langs = mysql_query("select * from ".$prefix."_langs order by lang_order") or die("7.3: ".mysql_error());
					while ($arr_langs = mysql_fetch_array($langs))
						{
						mysql_query("insert into ".$prefix."_blocks_data (block_id, block_title, lang_id)
						values (".$id.", '".$name."', ".(int)$arr_langs["lang_id"].")") or die("7.4: ".mysql_error());
					}
					if (chdir($_SERVER["DOCUMENT_ROOT"]."/admin/modules") && $mid != "NULL")
						{
						$d = opendir(getcwd());
						while (($e = readdir($d)) != false)
							{
							if (substr($e,strlen($e)-4,4) == ".xml")
								{
								$fp = simplexml_load_file($e);
								if ($fp->attributes()->id == $mid)
									{
									// добавление свойств блока
									if (is_object($fp->properties->property))
									foreach ($fp->properties->property as $property)
										{
										$prop_name = (string)$property->id;
										$prop_val = $_POST["b_prop_".(string)$property->id];
										mysql_query("INSERT INTO ".$prefix."_blocks_properties (block_id, b_property_name, b_property_value)
										VALUES (".$id.", '".$prop_name."', '".$prop_val."') ON DUPLICATE KEY UPDATE b_property_value = '".$prop_val."'") or die("7.5: ".mysql_error());
									}
									$f_ids = array();
									$f_names = array();
									// добавление данных блока
									if (is_object($fp->fields->field))
									foreach ($fp->fields->field as $field)
										{
										$field_id = (string)$field->id;
										$field_name = (string)$field->name;
										// $symbolic = Translit($field_name);
										$symbolic = $field_id;
										$field_type = (int)$field->type;
										$field_format = (int)$field->format;
										$f_ids[] = $field_id;
										$f_names[] = $field_name;
										$f_types[] = $field_type;
										$f_formats[] = $field_format;
										$max_element_order_query = mysql_query("select max(element_order) as max_element_order from ".$prefix."_elements where block_id = ".$id) or die("7.6:".mysql_error());
										if ($arr_max_element = mysql_fetch_array($max_element_order_query))
											$order = $arr_max_element["max_element_order"] + 1;
										else
											$order = 1;
										
										mysql_query("insert into ".$prefix."_elements (block_id, element_symbolic, element_type, element_format, element_properties, element_order)
										values (".$id.", '".$symbolic."', ".$field_type.", ".$field_format.", '', ".$order.")") or die("7.7: ".mysql_error());
										$eid = mysql_insert_id();
										$langs = mysql_query("select * from ".$prefix."_langs order by lang_order") or die("7.8: ".mysql_error());
										while ($arr_langs = mysql_fetch_array($langs))
											{
											mysql_query("insert into ".$prefix."_elements_data (element_id, element_title, lang_id)
											values (".$eid.", '".$field_name."', ".(int)$arr_langs["lang_id"].")") or die("7.9: ".mysql_error());
										}										
									}
									// добавление данных модуля блока (доделать!)
									$ds_names = array();
									$ds_ids = array();
									if (is_object($fp->datasets->dataset))
									foreach ($fp->datasets->dataset as $dataset)
										{
										$ds_name = (string)$dataset->name;
										$max_block_order_query = mysql_query("select max(block_order) as max_block_order from ".$prefix."_blocks where parent_id = ".$id) or die("7.10:".mysql_error());
										if ($arr_max_block = mysql_fetch_array($max_block_order_query))
											$order = (int)$arr_max_block["max_block_order"] + 1;
										else
											$order = 1;
										
										mysql_query("insert into ".$prefix."_blocks (page_id, parent_id, module_id, block_order) values (".$pid.", ".$id.", NULL, ".$order.")") or die("7.11: ".mysql_error());
										$subbid = mysql_insert_id();
										$ds_ids[] = $subbid;
										$ds_names[] = $ds_name;
										$langs = mysql_query("select * from ".$prefix."_langs order by lang_order") or die("7.12: ".mysql_error());
										while ($arr_langs = mysql_fetch_array($langs))
											{
											mysql_query("insert into ".$prefix."_blocks_data (block_id, block_title, lang_id)
											values (".$subbid.", '".$ds_name."', ".(int)$arr_langs["lang_id"].")") or die("7.13: ".mysql_error());
										}
										foreach ($dataset->fields->field as $field)
											{
											$field_id = (string)$field->id;
											$field_name = (string)$field->name;
											// $symbolic = Translit($field_name);
											$symbolic = $field_id;
											$field_type = (int)$field->type;
											$field_format = (int)$field->format;
											$max_element_order_query = mysql_query("select max(element_order) as max_element_order from ".$prefix."_elements where block_id = ".$subbid) or die("7.14:".mysql_error());
											if ($arr_max_element = mysql_fetch_array($max_element_order_query))
												$order = (int)$arr_max_element["max_element_order"] + 1;
											else
												$order = 1;
											
											mysql_query("insert into ".$prefix."_elements (block_id, element_symbolic, element_type, element_format, element_properties, element_order)
											values (".$subbid.", '".$symbolic."', ".$field_type.", ".$field_format.", '', ".$order.")") or die("7.15: ".mysql_error());
											$eid = mysql_insert_id();
											$langs = mysql_query("select * from ".$prefix."_langs order by lang_order") or die("7.16: ".mysql_error());
											while ($arr_langs = mysql_fetch_array($langs))
												{
												mysql_query("insert into ".$prefix."_elements_data (element_id, element_title, lang_id)
												values (".$eid.", '".$field_name."', ".(int)$arr_langs["lang_id"].")") or die("7.17: ".mysql_error());
											}										
										}
									}
								}
							}
						}
					}
					echo $id."|".$name."|".implode("^",$ds_names)."|".implode("^",$ds_ids)."|".implode("^",$f_ids)."|".implode("^",$f_names)."|".implode("^",$f_types)."|".implode("^",$f_formats);
				}
				else
					echo "error:Не указано название блока";
			}
		break;
		case 8:
			// Добавление элемента
			if ((int)$_POST["e_block_id"] != 0)
				{
				$bid = (int)$_POST["e_block_id"];
				$name = mysql_real_escape_string($_POST["e_name"]);
				$type = (int)$_POST["e_type"];
				$format = (int)$_POST["e_format_".$type];
				$properties = explode("|", $_POST["e_properties_".$type]);
				foreach ($properties as $property)
					$pval .= $property."=".mysql_real_escape_string($_POST["property_".$type."_".$property])."|";
				$pval = trim($pval, "|");

				$max_element_order_query = mysql_query("select max(element_order) as max_element_order from ".$prefix."_elements where block_id = ".$bid) or die("8.1:".mysql_error());
				if ($arr_max_element = mysql_fetch_array($max_element_order_query))
					$order = $arr_max_element["max_element_order"] + 1;
				else
					$order = 1;
				
				mysql_query("insert into ".$prefix."_elements (block_id, element_type, element_format, element_properties, element_order) values (".$bid.", ".$type.", ".$format.", '".$pval."', ".$order.")") or die("8.2: ".mysql_error());
				$id = mysql_insert_id();
				$langs = mysql_query("select * from ".$prefix."_langs order by lang_order") or die("8.3: ".mysql_error());
				while ($arr_langs = mysql_fetch_array($langs))
					{
					mysql_query("insert into ".$prefix."_elements_data (element_id, element_title, lang_id)
					values (".$id.", '".$name."', ".(int)$arr_langs["lang_id"].")") or die("8.4: ".mysql_error());
				}
				$html = "<input name=\"element".$id."\" value=\"\" />";
				/*
				1 - текст до 255 символов
				2 - текст до 65535 символов
				3 - картинка
				4 - список
				5 - чекбокс
				6 - дата
				*/
				if ($type == 2)
					$html = "<textarea name=\"element".$id."\"></textarea>";
				if ($type == 3)
					$html = "<div class=\"element".$id."\" id=\"element".$id."\"></div><br /><input type=\"button\" class=\"newpic\" data-id=\"\" value=\"Загрузить\" />";
				$html .= "<img class=\"delel\" src=\"images/close.png\" onClick=\"if (confirm('Вы уверены?')) {delelement(".$id.", ".$bid.");}\" />";
				echo "<div class=\"group\"><div class=\"ttl\">".$name."</div><div class=\"fld\">".$html."</div></div>";
			}
		break;
		case 9:
			// удаление блоков
			if ((int)$_POST["block_id"] != 0)
				{
				$block_id = (int)$_POST["block_id"];
				mysql_query("delete from ".$prefix."_blocks where block_id = ".$block_id) or die("8.4.1: ".mysql_error());
				mysql_query("delete from ".$prefix."_blocks_data where block_id = ".$block_id) or die("8.4.2: ".mysql_error());
				mysql_query("delete from ".$prefix."_blocks_properties where block_id = ".$block_id) or die("8.4.3: ".mysql_error());
				mysql_query("delete from ".$prefix."_elements_data where element_id in (select element_id from ".$prefix."_elements where block_id = ".$block_id.")") or die("8.4.4: ".mysql_error());
				mysql_query("delete from ".$prefix."_elements where block_id = ".$block_id) or die("8.4.5: ".mysql_error());
				mysql_query("delete from ".$prefix."_blocks_data where block_id in (select block_id from ".$prefix."_blocks where parent_id = ".$block_id.")") or die("8.4.6: ".mysql_error());
				mysql_query("delete from ".$prefix."_blocks where parent_id = ".$block_id) or die("8.4.7: ".mysql_error());
				mysql_query("delete from ".$prefix."_real_data where block_id = ".$block_id) or die("8.4.8: ".mysql_error());
			}
		break;
		case 10:
			// удаление элементов
			if ((int)$_POST["eid"] != 0 && (int)$_POST["block_id"] != 0)
				{
				$block_id = (int)$_POST["block_id"];
				$eid = (int)$_POST["eid"];
				mysql_query("delete from ".$prefix."_elements_data where element_id  = ".$eid) or die("8.4.8: ".mysql_error());
				mysql_query("delete from ".$prefix."_elements where element_id = ".$eid) or die("8.4.9: ".mysql_error());
			}
		break;
		case 11:
			// вставка новых страниц
			if ($_POST["p_name"] != "" && $_POST["p_url"] != "")
				{
				$name = mysql_real_escape_string($_POST["p_name"]);
				$url = mysql_real_escape_string($_POST["p_url"]);
				$type = (int)$_POST["p_type"];
				$parent = (int)$_POST["p_parent"];

				$max_page_order_query = mysql_query("select max(page_order) as max_page_order from ".$prefix."_pages") or die("11.1:".mysql_error());
				if ($arr_max_page = mysql_fetch_array($max_page_order_query))
					$order = $arr_max_page["max_page_order"] + 1;
				else
					$order = 1;

				// доделывать:
				// разделение по веб-сайтам, родительские страницы, типы страниц?
				mysql_query("insert into ".$prefix."_pages (page_id, parent_id, website_id, page_order, page_on) values ('', ".$parent.", 1, ".$order.", 0)") or die("11.2: ".mysql_error());
				$id = mysql_insert_id();
				$langs = mysql_query("select * from ".$prefix."_langs order by lang_order") or die("11.3: ".mysql_error());
				while ($arr_langs = mysql_fetch_array($langs))
					{
					mysql_query("insert into ".$prefix."_pages_data (page_id, page_title, page_url, lang_id)
					values (".$id.", '".$name."', '".$url."', ".(int)$arr_langs["lang_id"].")") or die("11.4: ".mysql_error());
				}
				if ((int)$type != 0)
					{
					// дублирование информации из образца
					$query = mysql_query("select * from ".$prefix."_blocks where page_id = ".(int)$type) or die("11.5: ".mysql_error());
					while ($arr_query = mysql_fetch_array($query))
						{
						// вставка блоков
						mysql_query("insert into ".$prefix."_blocks (page_id, parent_id, module_id, block_order)
						values (".$id.", ".$arr_query["parent_id"].", ".(int)$arr_query["module_id"].", ".$arr_query["block_order"].")") or die("11.6: ".mysql_error());
						$bid = mysql_insert_id();
						// определение новых родительских id
						$parents[$arr_query["block_id"]] = $bid;
						// вставка данных блоков
						mysql_query("insert into ".$prefix."_blocks_data (block_id, block_title, lang_id)
						select ".$bid.", block_title, lang_id from ".$prefix."_blocks_data where block_id = ".$arr_query["block_id"]) or die("11.8: ".mysql_error());
						// вставка новых аналогичных элементов из старых блоков
						$query1 = mysql_query("select * from ".$prefix."_elements where block_id = ".$arr_query["block_id"]) or die("11.9: ".mysql_error());
						while ($arr_query1 = mysql_fetch_array($query1))
							{
							mysql_query("insert into ".$prefix."_elements (block_id, element_symbolic, element_type, element_format, element_properties, element_order) values (".$bid.", '".$arr_query1["element_symbolic"]."', ".$arr_query1["element_type"].", '".$arr_query1["element_format"]."', '".$arr_query1["element_properties"]."', ".$arr_query1["element_order"].")") or die("11.10: ".mysql_error());
							$eid = mysql_insert_id();
							// вставка данных новых элементов
							mysql_query("insert into ".$prefix."_elements_data (element_id, element_title, lang_id)
							select ".$eid.", element_title, lang_id from ".$prefix."_elements_data where element_id = ".$arr_query1["element_id"]) or die("11.12: ".mysql_error());
							// вставка данных страницы-источника в элементы
							mysql_query("insert into ".$prefix."_real_data (element_id, element_data, element_row, element_order, lang_id)
							select ".$eid.", element_data, element_row, element_order, lang_id from ".$prefix."_real_data where element_id = ".$arr_query1["element_id"]) or die("11.13: ".mysql_error());
						}
					}
					// замена родительских id на новые
					$query = mysql_query("select distinct parent_id from ".$prefix."_blocks where parent_id != 0 and page_id = ".$id) or die("11.14: ".mysql_error());
					while ($arr_query = mysql_fetch_array($query))
						{
						mysql_query("update ".$prefix."_blocks set parent_id = ".(int)$parents[$arr_query["parent_id"]]." where page_id = ".$id." and parent_id = ".$arr_query["parent_id"]) or die("11.15: ".mysql_error());
					}
				}
				echo "<div class=\"dept40 lightgrey\" onclick=\"document.location='main.php?page_id=".$id."'\">".$name."</div>";
			}
		break;
		case 12:
		// редактирование свойств блока
			$bid = (int)$_POST["bid"];
			$mid = (int)$_POST["mid"];
			if (chdir($_SERVER["DOCUMENT_ROOT"]."/admin/modules") && $mid != "NULL")
				{
				$d = opendir(getcwd());
				while (($e = readdir($d)) != false)
					{
					if (substr($e,strlen($e)-4,4) == ".xml")
						{
						$fp = simplexml_load_file($e);
						if ($fp->attributes()->id == $mid)
							{
							// изменение свойств блока
							foreach ($fp->properties->property as $property)
								{
								$prop_name = (string)$property->id;
								$prop_val = $_POST["b_propval_".$bid."_".(string)$property->id];
								$slct = mysql_query("select * from ".$prefix."_blocks_properties where block_id = ".$bid." and b_property_name = '".$prop_name."'") or die("12.1: ".mysql_error());
								if (mysql_num_rows($slct) == 0)
									{
									mysql_query("INSERT into ".$prefix."_blocks_properties
									(block_id, b_property_name, b_property_value) values
									(".$bid.", '".$prop_name."', '".$prop_val."')") or die("12.2: ".mysql_error());
								}
								else
									{
									mysql_query("UPDATE ".$prefix."_blocks_properties
									SET b_property_value = '".$prop_val."'
									WHERE block_id = ".$bid." and b_property_name = '".$prop_name."'") or die("12.1: ".mysql_error());
								}
							}
						}
					}
				}
			}
		break;
		case 13:
		// редактирование свойств страницы
			if ((int)$_POST["page_id"] != 0 && (int)$_POST["lang_id"] != 0 && $_POST["p_name"] != "")
				{
				$pid = (int)$_POST["page_id"];
				$lang_id = (int)$_POST["lang_id"];
				$name = mysql_real_escape_string($_POST["p_name"]);
				$url = mysql_real_escape_string($_POST["p_url"]);
				$title = mysql_real_escape_string($_POST["p_title"]);
				$kw = mysql_real_escape_string($_POST["p_kw"]);
				$dscr = mysql_real_escape_string($_POST["p_dscr"]);
				mysql_query("update ".$prefix."_pages_data set
				page_title = '".$name."',
				page_url = '".$url."'
				where page_id = ".$pid." and lang_id = ".$lang_id) or die("13.1: ".mysql_error());
				$slct = mysql_query("select * from ".$prefix."_meta_words where page_id = ".$pid." and lang_id = ".$lang_id) or die("13.2: ".mysql_error());
				if (mysql_num_rows($slct) != 0)
					{
					mysql_query("update ".$prefix."_meta_words set
					meta_title = '".$title."',
					meta_keywords = '".$kw."',
					meta_description = '".$dscr."'
					where page_id = ".$pid." and lang_id = ".$lang_id) or die("13.3: ".mysql_error());
				}
				else
					{
					mysql_query("insert into ".$prefix."_meta_words (page_id, lang_id, meta_keywords, meta_description)
					values (".$pid.", ".$lang_id.", '".$kw."', '".$dscr."')") or die("13.4: ".mysql_error());
				}
			}
			else
				echo "Error: no data";
		break;
		case 14:
		// добавление языка
			// проверка данных
			if ($_POST["lang"] != "" && $_POST["shrt"] != "")
				{
				// берём данные
				$lang = mysql_real_escape_string($_POST["lang"]);
				$short = mysql_real_escape_string($_POST["shrt"]);
				// находим максимальный порядковый номер
				$slct = mysql_query("select max(lang_order) as morder from ".$prefix."_langs") or die("Error 14.2: ".mysql_error());
				if ($arr = mysql_fetch_array($slct))
					$order = $arr["morder"] + 1;
				else
					$order = 1;
				// вставляем основные данные
				mysql_query("insert into ".$prefix."_langs
				(lang_order, lang_short)
				values
				(".$order.", '".$short."')") or die("Error 14.1: ".mysql_error());
				// новый идентификатор
				$nlid = mysql_insert_id();
				// вставляем языковые данные
				$slct = mysql_query("select lang_id from ".$prefix."_langs") or die("Error 14.3: ".mysql_error());
				while ($arr = mysql_fetch_array($slct))
					{
					mysql_query("insert into ".$prefix."_lang_names
					(lang_id, lang_name, name_lang_id)
					values
					(".$nlid.", '".$lang."', ".$arr["lang_id"].")") or die("14.4: ".mysql_error());
				}
				// дублируем данные в нужные таблицы с новым языком
				mysql_query("insert into ".$prefix."_pages_data (page_id, lang_id, page_title, page_url) select page_id, ".$nlid.", page_title, page_url from ".$prefix."_pages_data where lang_id = 1") or die("14.10: ".mysql_error());
				mysql_query("insert into ".$prefix."_blocks_data (block_id, block_title, lang_id) select block_id, block_title, ".$nlid." from ".$prefix."_blocks_data where lang_id = 1") or die("14.11: ".mysql_error());
				mysql_query("insert into ".$prefix."_elements_data (element_id, lang_id, element_title) select element_id, ".$nlid.", element_title from ".$prefix."_elements_data where lang_id = 1") or die("14.12: ".mysql_error());
				mysql_query("insert into ".$prefix."_real_data (element_id, block_id, page_id, lang_id, element_data, element_row, element_order) select element_id, block_id, page_id, ".$nlid.", element_data, element_row, element_order from ".$prefix."_real_data where lang_id = 1") or die("14.13: ".mysql_error());
				// возвращаем идентификатор
				echo $nlid;
			}
			else
				echo "Error: no data given";
		break;
		case 15:
		// удаление языка
			if ((int)$_POST["lang_id"] != 0)
				{
				$lang_id = (int)$_POST["lang_id"];
				mysql_query("delete from ".$prefix."_langs
				where lang_id = ".$lang_id) or die("15.1: ".mysql_error());
				mysql_query("delete from ".$prefix."_pages_data where lang_id = ".$lang_id) or die("14.2: ".mysql_error());
				mysql_query("delete from ".$prefix."_blocks_data where lang_id = ".$lang_id) or die("14.3: ".mysql_error());
				mysql_query("delete from ".$prefix."_elements_data where lang_id = ".$lang_id) or die("14.4: ".mysql_error());
				mysql_query("delete from ".$prefix."_real_data where lang_id = ".$lang_id) or die("14.4: ".mysql_error());
			}
		break;
		case 16:
		// подгрузка данных из другого языка
			if ((int)$_POST["lang_id"] != 0 && (int)$_POST["new_lang_id"] != 0 && (int)$_POST["block_id"] != 0)
				{
				$lang_id = (int)$_POST["lang_id"];
				$new_lang_id = (int)$_POST["new_lang_id"];
				$block_id = (int)$_POST["block_id"];
				mysql_query("insert into ".$prefix."_real_data (element_id, block_id, page_id, element_data, element_row, element_order, lang_id)
				select element_id, block_id, page_id, element_data, element_row, element_order, ".$new_lang_id." from ".$prefix."_real_data where block_id = ".$block_id." and lang_id = ".$lang_id) or die("16.1: ".mysql_error());
			}
		break;
		case 17:
		// привязка модуля к выбору списочного элемента (4/4)
			if ((int)$_POST["eid"] != 0 && (int)$_POST["mid"] != 0)
				{
				$eid = (int)$_POST["eid"];
				$mid = (int)$_POST["mid"];
				mysql_query("update ".$prefix."_elements set element_properties = 'module_id=".$mid."' where element_id = ".$eid) or die("17.1: ".mysql_error());
			}
		break;
		case 18:
		// добавление новой опции (4/2)
		// доделать работу с языками здесь!
			if ((int)$_POST["field"] != 0 && $_POST["fitem"] != "")
				{
				$lang_id = 1;
				$field = (int)$_POST["field"];
				$fitem = mysql_real_escape_string($_POST["fitem"]);
				$query_p = mysql_query("select b.* from ".$prefix."_elements e left join ".$prefix."_blocks b on b.block_id = e.block_id where element_id = ".$field) or die("18.1: ".mysql_error());
				if ($arr_query_p = mysql_fetch_array($query_p))
					{
					$bid = $arr_query_p["block_id"];
					$pid = $arr_query_p["page_id"];
					$query_p = mysql_query("select * from ".$prefix."_real_data where element_id = ".$field) or die("18.2: ".mysql_error());
					if ($arr_query_p = mysql_fetch_array($query_p))
						{
						if ($arr_query_p["element_data"] != "")
							$newvalue = $arr_query_p["element_data"]."^".$fitem;
						else
							$newvalue = $fitem;
						mysql_query("update ".$prefix."_real_data set element_data = '".$newvalue."' where element_id = ".$field) or die("18.3: ".mysql_error());
					}
					else
						{
						$newvalue = $fitem;
						mysql_query("insert into ".$prefix."_real_data (element_id, block_id, page_id, element_data, element_row, element_order, lang_id) values (".$field.", ".$bid.", ".$pid.", '".$newvalue."', 1, 1, ".$lang_id.")") or die("18.4: ".mysql_error());
					}
				}
			}
		break;
		case 19:
		// удаление опции (4/2)
			if ((int)$_POST["field"] != 0 && (int)$_POST["fcnt"] != 0)
				{
				$field = (int)$_POST["field"];
				$fcnt = (int)$_POST["fcnt"];
				$query_p = mysql_query("select * from ".$prefix."_real_data where element_id = ".$field) or die("18.1: ".mysql_error());
				if ($arr_query_p = mysql_fetch_array($query_p))
					{
					if ($arr_query_p["element_data"] != "")
						{
						$fitems = explode("^", $arr_query_p["element_data"]);
						foreach ($fitems as $fcnt => $fitem)
							{
							$newvalue = str_replace("^".$value, "", $arr_query_p["element_data"]);
							mysql_query("update ".$prefix."_real_data set element_data = '".$newvalue."' where element_id = ".$field) or die("18.2: ".mysql_error());
						}
					}
				}
			}
		break;
		case 20:
		// перемещение блоков между страницами
			if ((int)$_POST["bid"] != 0 && (int)$_POST["to"] != 0)
				{
				$bid = (int)$_POST["bid"];
				$to = (int)$_POST["to"];
				mysql_query("update ".$prefix."_blocks set page_id = ".$to." where block_id = ".$bid) or die("20.1: ".mysql_error());
				mysql_query("update ".$prefix."_real_data set page_id = ".$to." where block_id = ".$bid) or die("20.2: ".mysql_error());
				mysql_query("update ".$prefix."_blocks set page_id = ".$to." where block_id in (select block_id from ".$prefix."_blocks where parent_id = ".$bid.")") or die("20.3: ".mysql_error());
				mysql_query("update ".$prefix."_real_data set page_id = ".$to." where block_id in (select block_id from ".$prefix."_blocks where parent_id = ".$bid.")") or die("20.4: ".mysql_error());
				print "!".$to;
			}
		break;
	}
}
function delsubs($del_dept_id)
	{
	global $prefix;
	
	$subdepts = mysql_query("select * from ".$prefix."_depts where parent_id = ".$del_dept_id) or die("Error 3: ".mysql_error());
	while ($arr_subdepts = mysql_fetch_array($subdepts))
		{
		delsubs($arr_subdepts["dept_id"]);
		$delete_dept = mysql_query("delete from ".$prefix."_dept_names where dept_id = ".$arr_subdepts["dept_id"]) or die("Error 3: ".mysql_error());
	}
	$delete_dept = mysql_query("delete from ".$prefix."_depts where parent_id = ".$del_dept_id) or die("Error 5: ".mysql_error());
}
?>
