<?
include "includes/connection.php";
include "includes/main_init.php";
include "includes/main_func.php";
include "includes/messages.php";
include "secure.php";

if (isset($_POST["ids"]))
	{
	$bid = $_POST["bid"];
	$str_tmp = substr_replace($_POST["ids"], "", strrpos($_POST["ids"], "|"));
	$ids = explode("|", $str_tmp);
	echo $str_tmp;
	foreach ($ids as $sort => $id)
		{
		$query = "UPDATE ".$prefix."_real_data SET element_order = ".$sort." WHERE block_id = ".$bid." and element_row = ".intval($id);
		mysql_query($query) or die(mysql_error());
	}
}
?>