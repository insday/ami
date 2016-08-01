<?
include "includes/connection.php";
include "includes/main_init.php";
include "includes/main_func.php";
include "includes/messages.php";
include "secure.php";

if ((int)$_POST["page_id"] != 0)
	$page_id = (int)$_POST["page_id"];
else
	$page_id = 1;

// print_r($_POST);

$parent_id = (int)$_POST["parent_id"];
if ($parent_id == 0)
	{
	$query = mysql_query("select * from ".$prefix."_blocks b left join ".$prefix."_elements e on e.block_id = b.block_id where (parent_id is NULL or parent_id = 0) and page_id = ".$page_id) or die("ERR1: ".mysql_error());
	while ($arr_query = mysql_fetch_array($query))
		{
		// echo "!".$_POST["element".$arr_query["element_id"]]."!";
		$type = $arr_query["element_type"];
		if ($type != 3 && $type != 4 && isset($_POST["element".$arr_query["element_id"]]) || $_POST["element".$arr_query["element_id"]] != "")
			{
			$block_id = $arr_query["block_id"];
			$replace_query = "replace into ".$prefix."_real_data (page_id, block_id, element_id, element_data, element_row, element_order, lang_id)
			values (".$page_id.", ".$block_id.", ".$arr_query["element_id"].", '".$_POST["element".$arr_query["element_id"]]."', 1, 0, ".$lang_id.")";
			mysql_query($replace_query) or die("ERR2: ".mysql_error());
		}
	}
}
else
	{
	$query2 = mysql_query("select e.*, max(element_row) as max_row, max(rd.element_order) as max_order
	from ".$prefix."_elements e
	left join ".$prefix."_real_data rd on rd.element_id = e.element_id and lang_id = ".$lang_id."
	where e.block_id = ".$parent_id."
	group by e.element_id
	order by e.element_order") or die("ERR3: ".mysql_error());
	$max_row = 1;
	$max_order = 1;
	while ($arr_query2 = mysql_fetch_array($query2))
		{
		$types[$arr_query2["element_id"]] = $arr_query2["element_type"];
		if ((int)$arr_query2["max_row"] >= $max_row)
			$max_row = (int)$arr_query2["max_row"] + 1;
		if ((int)$arr_query2["max_row"] >= $max_order)
			$max_order = (int)$arr_query2["max_order"];
	}
	// print "<hr>";
	// print_r($types);
	// print "<hr>";
	// print $max_row."!".$max_order;
	$insert = 0;
	foreach ($types as $field => $type)
		{
		if ($type == 3)
			$value = mysql_real_escape_string($_POST["pic".$field]);
		elseif ($type == 4)
			$value = mysql_real_escape_string($_POST["list".$field]);
		else
			$value = mysql_real_escape_string($_POST["element".$field]);
		if ($value != "")
			$insert = 1;
	}
	if ($insert == 1)
		{
		foreach ($types as $field => $type)
			{
			if ($type == 3)
				$value = mysql_real_escape_string($_POST["pic".$field]);
			elseif ($type == 4)
				$value = mysql_real_escape_string($_POST["list".$field]);
			else
				$value = mysql_real_escape_string($_POST["element".$field]);
			$insert_query = "insert into ".$prefix."_real_data (page_id, block_id, element_id, element_data, element_row, element_order, lang_id)
			values (".$page_id.", ".$parent_id.", ".$field.", '".$value."', ".$max_row.", ".($max_order + 1).", ".$lang_id.")";
			// print "INSERTION: ".$insert_query;
			mysql_query($insert_query) or die("ERR4: ".mysql_error());
		}
	}
	for ($i = 1; $i < $max_row; $i++)
		{
		foreach ($types as $field => $type)
			{
			unset($value);
			if ($type == 4)
				$value = mysql_real_escape_string($_POST["list".$i."_".$field]);
			elseif ($type == 5)
				{
				$value = 0;
				if ($_POST["element".$i."_".$field] == 1)
					$value = 1;
			}
			else
				$value = mysql_real_escape_string($_POST["element".$i."_".$field]);

			if ($type != 3 && $type != 4 && isset($value) || $value != "")
				{
				$slct = "select * from ".$prefix."_real_data where element_id = ".$field." and element_row = ".$i." and lang_id = ".$lang_id;
				$slct_q = mysql_query($slct) or die("ERR4: ".mysql_error());
				if (mysql_num_rows($slct_q) == 0 && $value != "")
					{
					$insert_query = "insert into ".$prefix."_real_data (page_id, block_id, element_id, element_data, element_row, element_order, lang_id)
					values (".$page_id.", ".$parent_id.", ".$field.", '".$value."', ".$i.", ".($max_order + 1).", ".$lang_id.")";
					// print "INSERTION 2 (type = ".$type.", value = '".$value."'): ".$insert_query."<br />";
					mysql_query($insert_query) or die("ERR4: ".mysql_error());
				}
				else
					{
					$update_query = "update ".$prefix."_real_data 
					set element_data = '".$value."'
					where page_id = ".$page_id." and block_id = ".$parent_id." and element_id = ".$field." and element_row = ".$i." and lang_id = ".$lang_id;
					// if ($type == 5)
						// print "UPDATE: ".$update_query."<hr>";
					mysql_query($update_query) or die("ERR5: ".mysql_error());
				}
			}
		}
	}
}
if ($parent_id != "")
	$add = "&block_id=".$parent_id;

header("Location: main.php?page_id=".$page_id.$add);
?>
